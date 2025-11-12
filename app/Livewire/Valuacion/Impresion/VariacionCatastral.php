<?php

namespace App\Livewire\Valuacion\Impresion;

use App\Models\Tramite;
use Livewire\Component;
use App\Constantes\Constantes;
use Illuminate\Validation\Rule;
use App\Enums\Tramites\AvaluoPara;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Traits\Valuacion\ImpresionTrait;
use App\Http\Controllers\Certificaciones\NotificacionValorCatastralController;

class VariacionCatastral extends Component
{

    use ImpresionTrait;

    protected function rules(){
        return [
            'inspeccion_año' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_folio' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_usuario' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'localidad' => 'required',
            'tipo' => Rule::requiredIf($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO->value),
            'registro_inicio' => ['nullable', Rule::requiredIf($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO->value), Rule::when('registro_final' != null, 'lte:registro_final')],
            'registro_final' => ['nullable', Rule::requiredIf($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO->value), Rule::when('registro_inicio' != null, 'gte:registro_inicio')],
            'numero_registro' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO->value)
         ];
    }

    public function updatedRegistroInicio(){

        $this->registro_final = $this->registro_inicio;

    }

    public function validarTramites(){

        if($this->avaluo_para != AvaluoPara::VARIACION_VIVIENDA->value){

            $this->tramite_inspeccion = Tramite::where('año', $this->inspeccion_año)
                                                ->where('folio', $this->inspeccion_folio)
                                                ->where('usuario', $this->inspeccion_usuario)
                                                ->first();

            if(!$this->tramite_inspeccion) throw new GeneralException('El trámite de inspección ocular no existe.');

            if(!$this->tramite_inspeccion->avaluo_para) throw new GeneralException('El trámite ingresado para inspección ocular no corresponde a una inspección ocular.');

            if($this->tramite_inspeccion->estado != 'pagado') throw new GeneralException('El trámite de inspección ocular no esta pagado o ha sido concluido.');

            if($this->tramite_inspeccion->avaluo_para->value != $this->avaluo_para) throw new GeneralException('El trámite de inspección ocular no corresponde a un avalúo para ' . $this->lista_avaluo_para[$this->avaluo_para - 1]->label());

        }else{

            $this->tramite_inspeccion = Tramite::where('año', $this->inspeccion_año)
                                                ->where('folio', $this->inspeccion_folio)
                                                ->where('usuario', $this->inspeccion_usuario)
                                                ->first();

            if(!$this->tramite_inspeccion) throw new GeneralException('El trámite de variación catastral no existe.');

            if($this->tramite_inspeccion->estado != 'pagado') throw new GeneralException('El trámite de variación catastral no esta pagado o ha sido concluido.');

            if($this->tramite_inspeccion->servicio->clave_ingreso != 'DM27') throw new GeneralException('El trámite no corresponde a una variación catastral');

        }

        $this->tramite_inspeccion->avaluo_para = AvaluoPara::VARIACION_VIVIENDA;

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

                    if($this->tramite_inspeccion->avaluo_para === AvaluoPara::CAMBIO_REGIMEN){

                        $this->tramite_inspeccion->predios()->attach($this->avaluos->first()->predio);

                    }

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

        $this->lista_avaluo_para = AvaluoPara::cases();

        $this->desglose_año = now()->format('Y');

        $this->inspeccion_año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.valuacion.impresion.variacion-catastral');
    }
}
