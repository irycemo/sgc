<?php

namespace App\Livewire\Certificaciones\CertificadoRegistro;

use App\Constantes\Constantes;
use Illuminate\Support\Facades\Storage;
use App\Jobs\Certificaciones\GenerarCertificadoRegistroJob;
use App\Exceptions\GeneralException;
use App\Models\Tramite;
use App\Services\Tramites\TramiteService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CertificadoRegistro extends Component
{

    public $años;
    public $director;

    public $año;
    public $folio;
    public $usuario;

    public $oficina;

    public $tramite;
    public $predio;

    public $impresionObservaciones = false;

    // Estado de la generación asíncrona
    public ?string $estado = null;        // 'generando' | 'listo' | 'error'
    public ?string $claveProceso = null;  // clave de cache compartida con el job
    public ?string $urlDescarga = null;   // URL firmada de S3 (30 min)
    public ?string $mensajeError = null;

    public function buscarTramite(){

        $this->reset(['tramite', 'predio', 'estado', 'claveProceso', 'urlDescarga', 'mensajeError']);

        $this->validate([
            'año' => 'required',
            'folio' => 'required',
            'usuario' => 'required',
        ]);

        try {

            $this->tramite = Tramite::with('predios')
                                        ->where('año', $this->año)
                                        ->where('folio', $this->folio)
                                        ->where('usuario', $this->usuario)
                                        ->firstOrFail();

            if(! in_array($this->tramite->servicio->clave_ingreso, ['DM32', 'DM31', 'D774'])){

                $this->rechazar("El trámite no corresponde a un certificado de registro.");

                return;

            }

            if($this->tramite->estado === 'concluido'){

                $this->rechazar("El trámite está concluido.");

                return;

            }

            if($this->tramite->estado != 'pagado' && $this->tramite->estado != 'autorizado'){

                (new TramiteService($this->tramite))->procesarPago();

            }

            if($this->tramite->tipo_tramite !== 'exento'){

                if($this->tramite->estado !== 'autorizado' && $this->tramite->fecha_entrega >= now()){

                    $this->rechazar("La fecha de entrega del trámite es: " . $this->tramite->fecha_entrega->format('d-m-Y'));

                    return;

                }

            }

            $activos = $this->tramite->predios->filter(fn($predio) => $predio->pivot->estado === 'A');

            if($activos->count() === 1){

                $this->seleccionarPredio($activos->first()->id);
            }

            $this->reset(['folio', 'usuario']);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no esta pagado."]);

            $this->reset('tramite');

        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no existe."]);

        } catch (\Throwable $th) {
            Log::error("Error al buscar certificado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }


    }

    public function seleccionarPredio($id){

        if(! $this->tramite){

            return;
        }

        $predio = $this->tramite->predios()->wherePivot('predio_id', $id)->wherePivot('estado', 'A')->first();

        if(! $predio){

            return;
        }

        if($predio->status == 'bloqueado'){

            $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra bloqueado."]);

            $this->predio = null;

            return;
        }

        $this->predio = $predio;

        $this->predio->load('propietarios.persona', 'colindancias');

        $this->reset(['estado', 'claveProceso', 'urlDescarga', 'mensajeError']);

    }

    public function generarCertificado(){

        if(! $this->tramite || ! $this->predio){

            $this->dispatch('mostrarMensaje', ['warning', "Busque el trámite y seleccione un predio."]);

            return;
        }

        if(! in_array(auth()->user()->clave, [1, 15, 16, 8])){

            if(in_array($this->predio->sector, [88, 99])){

                $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra en sector 88 o 99 es necesario conciliarlo."]);

                return;
            }
        }

        $this->claveProceso = 'certificado_registro_' . $this->tramite->id . '_' . $this->predio->id;

        $actual = Cache::get($this->claveProceso);

        if($actual && $actual['status'] === 'procesando'){

            $this->estado = 'generando';

            $this->reset('predio');

            $this->dispatch('mostrarMensaje', ['warning', "Ya existe un proceso activo para generar este certificado."]);

            return;

        }

        $this->estado = 'generando';
        $this->urlDescarga = null;
        $this->mensajeError = null;

        Cache::put($this->claveProceso, ['status' => 'procesando'], now()->addMinutes(30));

        try {

            GenerarCertificadoRegistroJob::dispatch(
                $this->tramite,
                $this->predio,
                auth()->user(),
                $this->impresionObservaciones,
                $this->claveProceso
            );

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

            $this->estado = 'error';

            $this->mensajeError = 'No fue posible iniciar el proceso. Intenta de nuevo.';

            return;

        }

        $this->reset(['predio', 'impresionObservaciones']);

    }

    public function consultarEstado(){

        if($this->estado !== 'generando' || ! $this->claveProceso){

            return;
        }

        $actual = Cache::get($this->claveProceso);

        if(! $actual){

            // Todavía en proceso (o el worker aún no publicó el estado).
            return;

        }

        if($actual['status'] === 'listo'){

            $this->tramite->refresh();

            $this->estado = 'listo';

            $this->urlDescarga = Storage::disk('s3')->temporaryUrl(
                $actual['s3_path'],
                now()->addMinutes(30),
                [
                    'ResponseContentType' => 'application/pdf',
                    'ResponseContentDisposition' => 'attachment; filename="' . $actual['filename'] . '"',
                ]
            );

            return;

        }

        if($actual['status'] === 'error'){

            $this->estado = 'error';

            $this->mensajeError = $actual['mensaje'] ?? 'No fue posible generar el certificado.';

        }

    }

    public function nuevoCertificado(){

        $this->reset([
            'tramite', 'predio', 'folio', 'usuario',
            'impresionObservaciones', 'estado', 'claveProceso',
            'urlDescarga', 'mensajeError',
        ]);

        $this->año = now()->format('Y');

    }

    private function rechazar(string $mensaje): void
    {

        $this->dispatch('mostrarMensaje', ['warning', $mensaje]);

        $this->reset('tramite');

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.certificaciones.certificado-registro.certificado-registro')->extends('layouts.admin');
    }

}
