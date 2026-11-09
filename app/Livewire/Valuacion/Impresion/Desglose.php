<?php

namespace App\Livewire\Valuacion\Impresion;

use App\Constantes\Constantes;
use Illuminate\Support\Facades\Storage;
use App\Jobs\Certificaciones\GenerarNotificacionDesgloseJob;
use Illuminate\Support\Facades\Cache;
use App\Enums\Tramites\AvaluoPara;
use App\Exceptions\GeneralException;
use App\Traits\Valuacion\ImpresionTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Desglose extends Component
{

    use ImpresionTrait;

    public $localidad_padre;
    public $oficina_padre;
    public $tipo_padre;
    public $registro_padre;
    public $predio_padre;

    public ?string $estadoProceso = null;        // 'generando' | 'listo' | 'error'
    public ?string $claveProceso = null;  // clave de cache compartida con el job
    public ?string $urlDescarga = null;   // URL firmada de S3 (30 min)
    public ?string $mensajeError = null;

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

    public function imprimir(){

        $this->validate();

        try {

            $this->validaciones();


        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

            return;

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

            return;

        }

        $this->claveProceso = 'notificacion_valor_catastral_' . $this->tramite_inspeccion->id;

        $actual = Cache::get($this->claveProceso);

        if($actual && $actual['status'] === 'procesando'){

            $this->estadoProceso = 'generando';

            $this->reset('predio');

            $this->dispatch('mostrarMensaje', ['warning', "Ya existe un proceso activo para generar esta notificación."]);

            return;

        }

        $this->estadoProceso = 'generando';
        $this->urlDescarga = null;
        $this->mensajeError = null;

        Cache::put($this->claveProceso, ['status' => 'procesando'], now()->addMinutes(30));

        try {

            $avaluo_ids = $this->avaluos->pluck('id')->toArray();

            GenerarNotificacionDesgloseJob::dispatch($avaluo_ids, $this->tramite_inspeccion, $this->tramite_desglose, $this->predio_padre, auth()->user(), $this->claveProceso);

        } catch (\Throwable $th) {

            Log::error(
                "Error al generar certificado",
                [
                    'message' => $th->getMessage(),
                    'user' => auth()->user()->name,
                    'trace' => $th
                ]
            );

            Cache::forget($this->claveProceso);

            $this->estadoProceso = 'error';

            $this->mensajeError = 'No fue posible iniciar el proceso. Intenta de nuevo.';

            return;

        }

    }

    public function consultarEstado(){

        if($this->estadoProceso !== 'generando' || ! $this->claveProceso){

            return;
        }

        $actual = Cache::get($this->claveProceso);

        if(! $actual){

            // Todavía en proceso (o el worker aún no publicó el estado).
            return;

        }

        if($actual['status'] === 'listo'){

            $this->estadoProceso = 'listo';

            if(app()->isProduction()){


                $this->urlDescarga = Storage::disk('s3')->temporaryUrl(
                    $actual['s3_path'],
                    now()->addMinutes(30),
                    [
                        'ResponseContentType' => 'application/pdf',
                        'ResponseContentDisposition' => 'attachment; filename="' . $actual['filename'] . '"',
                    ]
                );

            }else{

                $this->urlDescarga = Storage::disk('certificaciones')->url(
                    $actual['filename'],
                    [
                        'ResponseContentType' => 'application/pdf',
                        'ResponseContentDisposition' => 'attachment; filename="' . $actual['filename'] . '"',
                    ]
                );
            }

            return;

        }

        if($actual['status'] === 'error'){

            $this->estadoProceso = 'error';

            $this->mensajeError = $actual['mensaje'] ?? 'No fue posible generar el certificado.';

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
        return view('livewire.valuacion.impresion.desglose');
    }

}
