<?php

namespace App\Livewire\GestionCatastral\RevisionTraslados;

use App\Http\Constantes\Constantes;
use Livewire\Component;
use App\Models\Traslado;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class RevisarTraslado extends Component
{

    public Traslado $traslado;

    public $aviso;

    public $avaluo;

    public $rechazos;
    public $rechazo;
    public $observaciones;
    public $modalRechazar = false;
    public $modalAutorizar = false;

    public function seleccionarMotivo($key){

        $this->rechazo['key'] = $key;
        $this->rechazo['value'] = $this->rechazos[$key];

    }

    public function rechazarTraslado(){

        $this->validate(['observaciones' => 'required']);

        try {

            $response = Http::acceptJson()
                                ->withToken(env('SISTEMA_TRAMITES_EN_LINEA_TOKEN'))
                                ->withQueryParameters([
                                    'oficina_sgc' => auth()->user()->oficina->oficina,
                                    'aviso_id' => $this->traslado->aviso_stl,
                                    'entidad_id' => $this->traslado->entidad_stl,
                                    'observacion' => "<p>" . $this->rechazo['key'] . "</p><p>Observaciones:</p><p>" . $this->observaciones . "</p>"
                                ])
                                ->get(env('SISTEMA_TRAMITES_EN_LINEA_RECHAZAR_AVISO'));

            if($response->status() === 200){

                $this->traslado->update(['estado' => 'rechazado', 'actualizado_por' => auth()->id()]);

                return redirect()->route('revision_traslados');

            }else{

                $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

                return true;

            }

        } catch (\Throwable $th) {

            Log::error("Error al rechazar aviso en Sistema de Trámties en línea por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function autorizarTraslado(){

        $this->validate(['observaciones' => 'nullable']);

        try {

            $response = Http::acceptJson()
                                ->withToken(env('SISTEMA_TRAMITES_EN_LINEA_TOKEN'))
                                ->withQueryParameters([
                                    'aviso_id' => $this->traslado->aviso_stl,
                                    'observaciones' => $this->observaciones
                                ])
                                ->get(env('SISTEMA_TRAMITES_EN_LINEA_AUTORIZAR_AVISO'));

            if($response->status() === 200){

                $this->traslado->update(['estado' => 'autorizado', 'actualizado_por' => auth()->id()]);

                return redirect()->route('revision_traslados');

            }else{

                $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

                return true;

            }

        } catch (\Throwable $th) {

            Log::error("Error al autorizar aviso en Sistema de Trámties en línea por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function mount(){

        try {

            $response = Http::acceptJson()
                                ->withToken(env('SISTEMA_TRAMITES_EN_LINEA_TOKEN'))
                                ->withQueryParameters([
                                    'id' => $this->traslado->aviso_stl
                                ])
                                ->get(env('SISTEMA_TRAMITES_EN_LINEA_CONSULTAR_AVISO'));


            $data = json_decode($response, true);

            if($response->status() === 200){

                $this->aviso = $data['data'];

            }elseif($response->status() === 404){

                $this->dispatch('mostrarMensaje', ['error', $data['error']]);

                return true;

            }else{

                $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

                return true;

            }

        } catch (\Throwable $th) {

            abort(500, message:"Error al conectar con Sistema de Trámties en Línea");
            Log::error("Error al consultar aviso en Sistema de Trámties en línea por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

        }

        try {

            $response = Http::acceptJson()
                                ->withToken(env('SISTEMA_PERITOS_EXTERNOS_TOKEN'))
                                ->withQueryParameters([
                                    'id' => $this->traslado->avaluo_spe
                                ])
                                ->get(env('SISTEMA_PERITOS_EXTERNOS_CONSULTAR_AVALUO'));


            $data = json_decode($response, true);

            if($response->status() === 200){

                $this->avaluo = $data['data'];

            }elseif($response->status() === 404){

                $this->dispatch('mostrarMensaje', ['error', $data['error']]);

                return true;

            }else{

                Log::error("Error al consultar avalúo de aviso en cierre por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $response);

                $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

                return true;

            }

        } catch (\Throwable $th) {

            abort(500, message:"Error al conectar con Sistema de Peritos Externos");
            Log::error("Error al consultar avaluo en Sistema de Peritos Externos por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

        }

        $this->traslado->load('predio.propietarios.persona');

        $this->rechazos = Constantes::RECHAZOS_AVISOS;

    }

    public function render()
    {
        return view('livewire.gestion-catastral.revision-traslados.revisar-traslado')->extends('layouts.admin');
    }
}
