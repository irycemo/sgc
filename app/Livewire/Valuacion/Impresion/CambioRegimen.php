<?php

namespace App\Livewire\Valuacion\Impresion;

use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\Oficina;
use Livewire\Component;
use App\Constantes\Constantes;
use Illuminate\Validation\Rule;
use App\Enums\Tramites\AvaluoPara;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Traits\Valuacion\ImpresionTrait;
use App\Http\Controllers\Certificaciones\NotificacionValorCatastralController;

class CambioRegimen extends Component
{

    use ImpresionTrait;

    public $localidad_origen;
    public $oficina_origen;
    public $tipo_origen = 2;
    public $registro_origen;
    public $predio_origen;

    public $tipo_nuevo = 1;
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

        $this->predio_padre = Predio::where('localidad', $this->localidad_origen)
                                        ->where('oficina', $this->oficina_origen)
                                        ->where('tipo_predio', 2)
                                        ->where('numero_registro', $this->registro_origen)
                                        ->first();

        $this->validarPredio();

        $this->avaluo = Avaluo::withWhereHas('predioAvaluo', function($q){
                                    $q->where('localidad', $this->localidad_origen)
                                        ->where('oficina', $this->oficina_origen)
                                        ->where('tipo_predio', 1)
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

            $pdf = null;

            DB::transaction(function () use (&$pdf){

                $this->avaluo->update([
                    'tramite_inspeccion' => $this->tramite_inspeccion?->id,
                    'tramite_desglose' => $this->tramite_desglose?->id,
                    'actualizado_por' => auth()->id(),
                    'estado' => 'impreso'
                ]);

                $this->avaluo->predioAvaluo->update(['status' => 'impreso']);

                $this->avaluo->audits()->latest()->first()->update(['tags' => 'Imprimió avalúo', 'tramite_id' => $this->tramite_inspeccion?->id]);

                if(!auth()->user()->hasRole('Convenio municipal')) $this->actualizarTramites();

                $this->tramite_inspeccion->predios()->attach($this->predio_padre->id);

                $pdf = (new NotificacionValorCatastralController())->desglose([$this->avaluo->id], $this->tramite_inspeccion, $this->tramite_desglose, $this->predio_padre->id);

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

        $this->oficina_origen = auth()->user()->oficina->oficina;

        $this->años = Constantes::AÑOS;

        $this->inspeccion_año  = now()->format('Y');

        $this->desglose_año = now()->format('Y');

        $this->lista_avaluo_para = AvaluoPara::cases();

    }

    public function render()
    {
        return view('livewire.valuacion.impresion.cambio-regimen');
    }
}
