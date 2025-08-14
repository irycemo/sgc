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

class Desglose extends Component
{

    use ImpresionTrait;

    public $localidad_padre;
    public $oficina_padre;
    public $tipo_padre;
    public $registro_padre;
    public $predio_padre;

    protected function rules(){
        return [
            'inspeccion_año' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_folio' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_usuario' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_año' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_folio' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_usuario' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'localidad' => 'required',
            'tipo' => Rule::requiredIf($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO),
            'registro_inicio' => Rule::requiredIf($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO),
            'registro_final' => Rule::requiredIf($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO),
            'registro_inicio' => ['required', 'lte:registro_final'],
            'registro_final' => ['required', 'gte:registro_inicio'],
            'registro_padre' => 'required',
            'predios_cuentas.*' => 'nullable',
            'predios_cuentas.*.localidad' => 'nullable|numeric',
            'predios_cuentas.*.oficina' => 'nullable|numeric',
            'predios_cuentas.*.tipo_predio' => 'nullable|numeric',
            'predios_cuentas.*.numero_registro' => 'required|numeric'
         ];
    }

    public function validarPredioPadre(){

        if(!$this->predio_padre){

            throw new GeneralException('El predio padre no existe.');

        }

        if($this->predio_padre->estado === 'bloqueado'){

            throw new GeneralException('El predio padre esta bloqueado.');

        }

        if(!$this->predio_padre->superficie_total_terreno){

            throw new GeneralException('El predio padre no tiene superficie de terreno.');

        }

        $superficie_terreno = 0;

        foreach ($this->avaluos as $avaluo) {

            if($avaluo->predioAvaluo->numero_registro == $this->predio_padre->numero_registro) continue;

            $superficie_terreno += $avaluo->predioAvaluo->superficie_total_terreno;

        }

        if($this->predio_padre->superficie_total_terreno < $superficie_terreno){

            throw new GeneralException('La suma de la superfice de terreno de los avalúos es mayor a la superficie del predio padre.');

        }

    }

    public function imprimir(){

        $this->validate();

        try {

            $this->validaciones();

            $this->validarPredioPadre();

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

                $this->tramite_inspeccion->predios()->attach($this->predio_padre->id);

                $avaluo_ids = $this->avaluos->pluck('id');

                $pdf = (new NotificacionValorCatastralController())->desglose($avaluo_ids, $this->tramite_inspeccion, $this->tramite_desglose, $this->predio_padre->id);

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

    }

    public function render()
    {
        return view('livewire.valuacion.impresion.desglose');
    }

}
