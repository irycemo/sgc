<?php

namespace App\Livewire\Valuacion\Impresion;

use App\Models\Predio;
use Livewire\Component;
use App\Constantes\Constantes;
use Illuminate\Validation\Rule;
use App\Enums\Tramites\AvaluoPara;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Traits\Valuacion\ImpresionTrait;
use App\Http\Controllers\Certificaciones\NotificacionValorCatastralController;

class Fusion extends Component
{

    use ImpresionTrait;

    protected function rules(){
        return [
            'inspeccion_año' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_folio' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_usuario' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'localidad' => 'required',
            'tipo' => Rule::requiredIf($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO),
            'registro_inicio' => ['required', 'lte:registro_final'],
            'registro_final' => ['required', 'gte:registro_inicio'],
            'predios_cuentas.*' => 'nullable',
            'predios_cuentas.*.localidad' => 'nullable|numeric',
            'predios_cuentas.*.oficina' => 'nullable|numeric',
            'predios_cuentas.*.tipo_predio' => 'nullable|numeric',
            'predios_cuentas.*.numero_registro' => 'required|numeric'
         ];
    }

    public function imprimir(){

        $this->validate();

        try {

            $this->validaciones();

            $this->buscarPrediosFusionantes();

            $pdf = null;

            DB::transaction(function () use (&$pdf){

                foreach ($this->avaluos as $avaluo) {

                    $avaluo->update([
                        'tramite_inspeccion' => $this->tramite_inspeccion?->id,
                        'actualizado_por' => auth()->id(),
                        'estado' => 'impreso'
                    ]);

                    $avaluo->predioAvaluo->update(['status' => 'impreso']);

                    $avaluo->audits()->latest()->first()->update(['tags' => 'Imprimió avalúo', 'tramite_id' => $this->tramite_inspeccion?->id]);

                }

                if(!auth()->user()->hasRole('Convenio municipal')) $this->actualizarTramites();

                $avaluo_ids = $this->avaluos->pluck('id');

                $pdf = (new NotificacionValorCatastralController())->fusion($avaluo_ids, $this->tramite_inspeccion, $this->predios_fusionantes->pluck('id'));

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

    public function buscarPrediosFusionantes(){

        $this->predios_fusionantes = Predio::where('localidad', $this->localidad)
                                    ->where('oficina', $this->oficina)
                                    ->where('tipo_predio', $this->tipo)
                                    ->whereBetween('numero_registro', [$this->registro_inicio, $this->registro_final])
                                    ->get();

        if(count($this->predios_cuentas)){

            $predios_extra = Predio::where('localidad', $this->localidad)
                                    ->where('oficina', $this->oficina)
                                    ->where('tipo_predio', $this->tipo)
                                    ->whereIn('numero_registro', collect($this->predios_cuentas)->pluck('numero_registro'))
                                    ->get();

            $this->predios_fusionantes = $this->predios_fusionantes->merge($predios_extra);

        }

        $superficie_total = 0;

        $this->tramite_inspeccion->predios()->detach();

        foreach ($this->predios_fusionantes as $predio) {

            if($predio->status != 'activo'){

                throw new GeneralException('El predio ' . $predio->cuentaPredial() . ' no esta activo.');

            }

            if(!$predio->superficie_total_terreno){

                throw new GeneralException('El predio ' . $predio->cuentaPredial() . ' no tiene superficie de terreno, debe ser capturada.');

            }else{

                $superficie_total = $superficie_total + $predio->superficie_total_terreno;

            }

            $this->tramite_inspeccion->predios()->attach($predio->id);

        }

        if($this->avaluos->first()->predioAvaluo->superficie_total_terreno > $superficie_total){

            throw new GeneralException('La superficie de terreno del avalúo no puede ser mayor a la suma de las superficies de los predios (' . $superficie_total .').');

        }

        if($this->predios_fusionantes->count() <= 1){

            throw new GeneralException('Los predios fusionantes deben se mas de uno.');

        }

        $predio_resultante = $this->predios_fusionantes->sortBy('numero_registro')->first();

        if(! $this->avaluos->where('predio', $predio_resultante->id)->first()){

            throw new GeneralException('El predio ' . $predio_resultante->cuentaPredial() . ' no tiene un avalúo nuevo.');

        }

        if($this->avaluos->count() > 1){

            throw new GeneralException('Solo el predio ' . $predio_resultante->cuentaPredial() . ' debe contar con un avalúo, borrar los avalúos nuevos del resto de los predios.');

        }

        if($this->avaluos->first()->predio != $predio_resultante->id){

            throw new GeneralException('El avalúo debe ser del predio mas antiguo.');

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
        return view('livewire.valuacion.impresion.fusion');
    }
}
