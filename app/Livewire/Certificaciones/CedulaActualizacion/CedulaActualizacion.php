<?php

namespace App\Livewire\Certificaciones\CedulaActualizacion;

use App\Constantes\Constantes;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Certificaciones\CedulaActualizcacionController;
use App\Models\Oficina;
use App\Models\Tramite;
use App\Services\Tramites\TramiteService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CedulaActualizacion extends Component
{

    public $años;
    public $director;

    public $año;
    public $folio;
    public $usuario;

    public $oficina;

    public $tramite;
    public $predio;

    public $cadena;

    public $impresionDirector = false;

    public function buscarTramite(){

        $this->validate([
            'año' => 'required',
            'folio' => 'required',
            'usuario' => 'required',
        ]);

        try {

            $this->reset('predio');

            $this->tramite = Tramite::with('predios')
                                        ->where('año', $this->año)
                                        ->where('folio', $this->folio)
                                        ->where('usuario', $this->usuario)
                                        ->firstOrFail();

            if(!in_array($this->tramite->servicio->clave_ingreso, ['D727', 'D726'])){

                $this->dispatch('mostrarMensaje', ['warning', "El trámite no corresponde a una cédula de actualización."]);

                $this->reset('tramite');

                return;

            }

            if($this->tramite->estado === 'concluido'){

                $this->dispatch('mostrarMensaje', ['warning', "El trámite esta concluido."]);

                $this->reset('tramite');

                return;

            }

            if($this->tramite->estado != 'pagado'){

                (new TramiteService($this->tramite))->procesarPago();

            }

            $this->predio = $this->tramite->predios()->first();

            if($this->predio?->status == 'bloqueado'){

                $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra bloqueado."]);

                $this->predio = null;

                return;

            }

            $this->oficina = Oficina::where('oficina', $this->predio->oficina)->first()->oficina;

            $this->reset(['folio', 'usuario']);


        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no esta pagado."]);

            $this->reset('tramite');

        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no existe."]);

        } catch (\Throwable $th) {
            Log::error("Error al buscar cedula por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }


    }

    public function generarCedula(){

        if($this->predio->sector === 88 || $this->predio->sector === 99){

            $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra en sector 88 o 99 es necesario conciliarlo."]);

            return;

        }

        $pdf = retry(3, function() {

            return DB::transaction(function (){

                $this->tramite->predios()->updateExistingPivot($this->predio->id, ['estado' => 'I']);

                $usados = $this->tramite->predios()->wherePivot('estado', 'I')->count();

                $this->tramite->update(['usados' => $usados]);

                $this->tramite->audits()->latest()->first()->update(['tags' => 'Generó cédula de actualización del predio ' . $this->predio->cuentaPredial()]);

                if($this->tramite->cantidad === $usados){

                    $this->tramite->update(['estado' => 'concluido']);

                    $this->tramite->audits()->latest()->first()->update(['tags' => 'Finalizó trámite']);

                }

                return (new CedulaActualizcacionController())->cedula($this->tramite, $this->predio, auth()->user());

            });

        });

        $cuenta_predial = $this->predio->cuentaPredial();

        $this->reset('predio');

        $this->tramite->load('predios');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $cuenta_predial . '-cedula_actualizacion.pdf'
        );

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.certificaciones.cedula-actualizacion.cedula-actualizacion')->extends('layouts.admin');
    }
}
