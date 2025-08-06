<?php

namespace App\Livewire\Certificaciones\CertificadoRegistro;

use App\Models\Tramite;
use Livewire\Component;
use App\Constantes\Constantes;
use App\Http\Controllers\Certificaciones\CertificadoRegistroController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public $cadena;

    public $impresionDirector = false;

    public $tipo_certificado;

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

            if(!in_array($this->tramite->servicio->clave_ingreso, ['DM31', 'DM34', 'D934', 'DM32'])){

                $this->dispatch('mostrarMensaje', ['warning', "El trámite no corresponde a un certificado de registro."]);

                $this->reset('tramite');

                return;

            }

            if($this->tramite->estado === 'concluido'){

                $this->dispatch('mostrarMensaje', ['warning', "El trámite esta concluido."]);

                $this->reset('tramite');

                return;

            }

            if($this->tramite->estado != 'pagado' && $this->tramite->estado != 'autorizado'){

                $this->dispatch('mostrarMensaje', ['warning', "El trámite no esta pagado."]);

                $this->reset('tramite');

                return;

            }

            if($this->tramite->estado !== 'autorizado' && $this->tramite->fecha_entrega >= now()){

                $this->dispatch('mostrarMensaje', ['warning', "La fecha de entrega del trámite es: " . $this->tramite->fecha_entrega->format('d-m-Y')]);

                $this->reset('tramite');

                return;

            }

            $this->tipo_certificado = mb_strtoupper($this->tramite->servicio->nombre, 'utf-8');

            if($this->tramite->predios()->count() === 1){

                $this->predio = $this->tramite->predios()->first();

                if($this->predio->status == 'bloqueado'){

                    $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra bloqueado."]);
                    $this->predio = null;
                    return;

                }

                $this->oficina = $this->predio->oficina;

                $this->predio->load('propietarios.persona', 'colindancias');

            }

            $this->reset(['folio', 'usuario']);


        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no existe."]);

        } catch (\Throwable $th) {
            Log::error("Error al buscar certificado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }


    }

    public function seleccionarPredio($id){

        $this->predio = $this->tramite->predios()->wherePivot('predio_id', $id)->wherePivot('estado', 'A')->first();

        if($this->predio){

            if($this->predio->status == 'bloqueado'){

                $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra bloqueado."]);
                $this->predio = null;
                return;

            }

            $this->oficina = $this->predio->oficina;

            $this->predio->load('propietarios.persona', 'colindancias');

        }

    }

    public function generarCertificado(){

        if($this->predio->sector === 88 || $this->predio->sector === 99){

            $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra en sector 88 o 99 es necesario conciliarlo."]);

            return;

        }

        try {

            $pdf = null;

            DB::transaction(function () use(&$pdf){

                $this->tramite->predios()->updateExistingPivot($this->predio->id, ['estado' => 'I']);

                $usados = $this->tramite->predios()->wherePivot('estado', 'I')->count();

                $this->tramite->update(['usados' => $usados]);

                $this->tramite->audits()->latest()->first()->update(['tags' => 'Generó certificado del predio ' . $this->predio->cuentaPredial()]);

                if($this->tramite->cantidad === $usados){

                    $this->tramite->update(['estado' => 'concluido']);

                    $this->tramite->audits()->latest()->first()->update(['tags' => 'Finalizó trámite']);

                }

                $pdf = (new CertificadoRegistroController())->certificado($this->tramite, $this->predio, $this->tipo_certificado);

            });

            $cuenta_predial = $this->predio->cuentaPredial();

            $this->reset('predio');

            $this->tramite->load('predios');

            return response()->streamDownload(
                fn () => print($pdf->output()),
                $cuenta_predial . '-certificado_de_registro.pdf'
            );

        } catch (\Throwable $th) {

            Log::error("Error al generar certificado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

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
