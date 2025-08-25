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

class General extends Component
{

    use ImpresionTrait;

    protected function rules(){
        return [
            'inspeccion_año' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_folio' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_usuario' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_año' => Rule::requiredIf(in_array($this->avaluo_para, [6, 9]) && !auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_folio' => Rule::requiredIf(in_array($this->avaluo_para, [6, 9]) && !auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_usuario' => Rule::requiredIf(in_array($this->avaluo_para, [6, 9]) && !auth()->user()->hasRole(['Convenio municipal'])),
            'localidad' => 'required',
            'tipo' => Rule::requiredIf($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO),
            'registro_inicio' => Rule::requiredIf($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO),
            'registro_final' => Rule::requiredIf($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO),
            'region_catastral' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'municipio' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'zona_catastral' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'sector' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'manzana' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'predio' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'edificio' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'departamento' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'registro_inicio' => ['nullable', 'lte:registro_final'],
            'registro_final' => ['nullable', 'gte:registro_inicio']
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
                        'tramite_inspeccion' => $this->tramite_inspeccion?->id,
                        'tramite_desglose' => $this->tramite_desglose?->id,
                        'actualizado_por' => auth()->id(),
                        'estado' => 'impreso'
                    ]);

                    $avaluo->predioAvaluo->update(['status' => 'impreso']);

                    $avaluo->audits()->latest()->first()->update(['tags' => 'Imprimió avalúo', 'tramite_id' => $this->tramite_inspeccion?->id]);

                }

                if(!auth()->user()->hasRole('Convenio municipal')) $this->actualizarTramites();

                $avaluo_ids = $this->avaluos->pluck('id');

                $pdf = (new NotificacionValorCatastralController())->general($avaluo_ids, $this->tramite_inspeccion, $this->tramite_desglose);

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

        $this->lista_avaluo_para = AvaluoPara::cases();

        $this->desglose_año = now()->format('Y');

        $this->inspeccion_año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.valuacion.impresion.general');
    }
}
