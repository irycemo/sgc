<?php

namespace App\Livewire\Valuacion\Impresion;

use Livewire\Component;
use App\Constantes\Constantes;
use Illuminate\Validation\Rule;
use App\Enums\Tramites\AvaluoPara;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Traits\Valuacion\ImpresionTrait;
use App\Http\Controllers\Certificaciones\NotificacionValorCatastralController;

class PredioIgnorado extends Component
{

    use ImpresionTrait;

    public $localidad;
    public $oficina;
    public $tipo;
    public $registro;
    public $predio;

    protected function rules(){
        return [
            'inspeccion_año' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_folio' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_usuario' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'localidad' => 'required|numeric',
            'oficina' => 'required|numeric',
            'tipo' => 'required|numeric',
            'numero_registro' => 'required|numeric',
         ];
    }

    public function imprimir(){

        $this->validate();

        try {

            $this->validaciones();

            $pdf = null;

            DB::transaction(function () use (&$pdf){

                foreach ($this->avaluos as $avaluo) {

                    $avaluo->update([
                        'tramite_inspeccion' => $this->tramite_inspeccion->id,
                        'actualizado_por' => auth()->id(),
                        'estado' => 'impreso'
                    ]);

                    $avaluo->predioAvaluo->update(['status' => 'impreso']);

                    $avaluo->audits()->latest()->first()->update(['tags' => 'Imprimió avalúo', 'tramite_id' => $this->tramite_inspeccion?->id]);

                }

                if(!auth()->user()->hasRole('Convenio municipal')) $this->actualizarTramites();

                $avaluo_ids = $this->avaluos->pluck('id');

                $pdf = (new NotificacionValorCatastralController())->general($avaluo_ids, $this->tramite_inspeccion);

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

        $this->oficina = auth()->user()->oficina->oficina;

        $this->años = Constantes::AÑOS;

        $this->inspeccion_año  = now()->format('Y');

        $this->desglose_año = now()->format('Y');

        $this->lista_avaluo_para = AvaluoPara::cases();

    }

    public function render()
    {
        return view('livewire.valuacion.impresion.predio-ignorado');
    }
}
