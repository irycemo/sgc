<?php

namespace App\Livewire\Valuacion\Impresion;

use App\Constantes\Constantes;
use App\Enums\Tramites\AvaluoPara;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Certificaciones\NotificacionValorCatastralController;
use App\Jobs\Certificaciones\GenerarImagenVerificacionJob;
use App\Models\Avaluo;
use App\Models\Certificacion;
use App\Models\Predio;
use App\Traits\Valuacion\ImpresionTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

class DesgloseCambioRegimen extends Component
{

    use ImpresionTrait;

    public $localidad;
    public $oficina;
    public $tipo_padre;
    public $registro_padre;
    public $predio_padre;
    public $radio;
    public $avaluo;
    public $registro_nuevo;

    public function updatedRadio(){

        $this->reset(['localidad', 'tipo_padre', 'predio_padre', 'avaluo', 'tipo', 'registro_inicio', 'registro_final', 'predios_cuentas', 'registro_nuevo']);

    }

    public function buscarPredioCambioRegimen()
    {

        $this->predio_padre = Predio::where('localidad', $this->localidad)
                                        ->where('oficina', $this->oficina)
                                        ->where('tipo_predio', 2)
                                        ->where('numero_registro', $this->registro_padre)
                                        ->first();

        $this->validarPredio();

        $this->avaluo = Avaluo::withWhereHas('predioAvaluo', function($q){
                                    $q->where('localidad', $this->localidad)
                                        ->where('oficina', $this->oficina)
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

    public function imprimirCambioRegimen(){

        $this->validate([
            'inspeccion_año' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_folio' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_usuario' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_año' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_folio' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_usuario' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'localidad' => 'required|numeric',
            'oficina' => 'required|numeric',
            'tipo_padre' => 'required|numeric',
            'registro_padre' => 'required|numeric',
            'registro_nuevo' => 'required|numeric',
        ]);

        try {

            $this->validarTramites();

            if($this->avaluo_para == 10 && $this->tramite_desglose->cantidad > 1){

                throw new GeneralException('El trámite de desglose tiene una cantidad mayor a 1.');

            }

            $this->buscarPredioCambioRegimen();

            $pdf = retry(5, function() {

                return DB::transaction(function () {

                    $this->avaluo->update([
                        'tramite_inspeccion' => $this->tramite_inspeccion?->id,
                        'tramite_desglose' => $this->tramite_desglose?->id,
                        'actualizado_por' => auth()->id(),
                        'estado' => 'impreso'
                    ]);

                    $this->avaluo->predioAvaluo->update(['status' => 'impreso']);

                    $this->avaluo->audits()->latest()->first()->update(['tags' => 'Imprimió avalúo', 'tramite_id' => $this->tramite_inspeccion?->id]);

                    if(!auth()->user()->hasRole('Convenio municipal')) $this->actualizarTramiteDesglose();

                    $this->tramite_inspeccion->predios()->detach();

                    $this->tramite_inspeccion->predios()->attach($this->predio_padre->id);

                    return (new NotificacionValorCatastralController())->desglose([$this->avaluo->id], $this->tramite_inspeccion, $this->tramite_desglose, $this->predio_padre->id);

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

    public function imprimirDesglose(){

        $this->validate([
            'inspeccion_año' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_folio' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_usuario' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_año' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_folio' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_usuario' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'localidad' => 'required',
            'tipo' => Rule::requiredIf($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO),
            'registro_inicio' => ['required', 'lte:registro_final'],
            'registro_final' => ['required', 'gte:registro_inicio'],
            'registro_padre' => 'required',
            'predios_cuentas.*' => 'nullable',
            'predios_cuentas.*.localidad' => 'nullable|numeric',
            'predios_cuentas.*.oficina' => 'nullable|numeric',
            'predios_cuentas.*.tipo_predio' => 'nullable|numeric',
            'predios_cuentas.*.numero_registro' => 'required|numeric'
        ]);

        try {

            $this->validaciones();

            $pdf = retry(5, function() {

                return DB::transaction(function (){

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

                    if(! $this->tramite_inspeccion->predios()->where('predio_id', $this->predio_padre->id)->first()){

                        $this->tramite_inspeccion->predios()->attach($this->predio_padre->id);

                    }

                    $avaluo_ids = $this->avaluos->pluck('id');

                    return (new NotificacionValorCatastralController())->desglose($avaluo_ids, $this->tramite_inspeccion, $this->tramite_desglose, $this->predio_padre->id);

                });

            });

            $certificacion = Certificacion::where('tramite_id', $this->tramite_inspeccion->id)->where('estado', 'activo')->first();

            GenerarImagenVerificacionJob::dispatch($certificacion->id);

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
        return view('livewire.valuacion.impresion.desglose-cambio-regimen');
    }

}
