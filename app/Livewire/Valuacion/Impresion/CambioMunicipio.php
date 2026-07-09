<?php

namespace App\Livewire\Valuacion\Impresion;

use App\Constantes\Constantes;
use App\Enums\Tramites\AvaluoPara;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Certificaciones\NotificacionValorCatastralController;
use App\Models\Avaluo;
use App\Models\Predio;
use App\Traits\Valuacion\ImpresionTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\Oficina;

class CambioMunicipio extends Component
{

    use ImpresionTrait;

    public $localidad_origen;
    public $oficina_origen;
    public $tipo_origen;
    public $registro_origen;
    public $predio_origen;

    public $localidad_nuevo;
    public $oficina_nuevo;
    public $tipo_nuevo;
    public $registro_nuevo;
    public $predio_padre;
    public $avaluo;

    protected function rules(){
        return [
            'inspeccion_año' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_folio' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_usuario' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_año' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_folio' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_usuario' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'localidad_origen' => 'required|numeric',
            'oficina_origen' => 'required|numeric',
            'tipo_origen' => 'required|numeric',
            'registro_origen' => 'required|numeric',
            'tipo_nuevo' => 'required|numeric',
            'registro_nuevo' => 'required|numeric',
         ];
    }

    public function updatedOficinaOrigen(){

        $this->validate(['localidad_origen' => 'required','oficina_origen' => 'required']);

        $oficina = Oficina::where('oficina', $this->oficina_origen)->where('localidad', $this->localidad_origen)->first();

        if(!$oficina){

            $this->dispatch('mostrarMensaje', ['warning', "La localidad no correspoonde a la oficina."]);

            $this->reset(['localidad_origen']);

            return;

        }

    }

    public function updatedLocalidadOrigen(){

        $this->updatedOficinaOrigen();

    }

    public function buscarPredios()
    {

        $this->avaluo = Avaluo::withWhereHas('predioAvaluo', function($q){
                                    $q->where('localidad', $this->localidad_nuevo)
                                        ->where('oficina', $this->oficina_nuevo)
                                        ->where('tipo_predio', $this->tipo_nuevo)
                                        ->where('numero_registro', $this->registro_nuevo);
                                })
                                ->where('estado', '!=', 'notificado')
                                ->first();

        if(!$this->avaluo){

            throw new GeneralException('No se encontro avalúo del nuevo predio.');

        }

        $this->revisarAvaluoCompleto($this->avaluo);

    }

    public function imprimir(){

        $this->validate();

        try {

            $this->validarTramites();

            $this->buscarPredios();

            $pdf = retry(5, function() {

                return DB::transaction(function () {

                    $this->avaluo->update([
                        'tramite_inspeccion' => $this->tramite_inspeccion?->id,
                        'tramite_desglose' => $this->tramite_desglose?->id,
                        'actualizado_por' => auth()->id(),
                        'estado' => 'impreso'
                    ]);

                    $this->avaluo->predioAvaluo->update(['status' => 'impreso']);

                    $this->avaluo->refresh();

                    $this->avaluo->audits()->latest()->first()->update(['tags' => 'Imprimió avalúo', 'tramite_id' => $this->tramite_inspeccion?->id]);

                    if(!auth()->user()->hasRole('Convenio municipal')) $this->actualizarTramites();

                    /* $this->tramite_inspeccion->predios()->attach($this->predio_padre->id); */

                    return (new NotificacionValorCatastralController())->general([$this->avaluo->id], $this->tramite_inspeccion);

                });

            });

            $this->resetarTodo();

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'notificacion_de_valor_catastral.pdf'
            );


        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al imprimir notificación de avalúo usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        $this->oficina_nuevo = auth()->user()->oficina->oficina;

        $this->años = Constantes::AÑOS;

        $this->inspeccion_año  = now()->format('Y');

        $this->desglose_año = now()->format('Y');

        $this->lista_avaluo_para = AvaluoPara::cases();

    }

    public function render()
    {
        return view('livewire.valuacion.impresion.cambio-municipio');
    }
}
