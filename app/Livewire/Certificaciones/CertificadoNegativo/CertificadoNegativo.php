<?php

namespace App\Livewire\Certificaciones\CertificadoNegativo;

use App\Models\Predio;
use App\Models\Persona;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Propietario;
use App\Constantes\Constantes;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Certificaciones\CertificadoNegativoController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CertificadoNegativo extends Component
{

    public $años;

    public $año;
    public $folio;
    public $usuario;

    public $oficina;

    public $tramite;
    public $predio;

    public $cadena;

    public $impresionDirector = false;

    public $nombre;
    public $ap_paterno;
    public $ap_materno;
    public $razon_social;

    public $predioFlag = false;
    public $tramiteFlag = false;

    public function updated($property, $value){

        $this->reset(['predio', 'tramiteFlag', 'predioFlag']);

        if(in_array($property, ['nombre', 'ap_paterno', 'ap_materno'])){

            $this->razon_social = null;

        }

        if($property == 'razon_social'){

            $this->reset(['nombre', 'ap_paterno', 'ap_materno']);

        }

        if($value == ''){

            $this->$property = null;

        }

        $this->$property = trim($this->$property);

    }

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

            if($this->tramite->servicio->clave_ingreso !== 'D923'){

                $this->dispatch('mostrarMensaje', ['error', "El trámite no corresponde a un certificado negativo de registro catastral."]);

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

            /* if($this->tramite->fecha_entrega >= now()){

                $this->dispatch('mostrarMensaje', ['error', "La fecha de entrega del trámite es: " . $this->tramite->fecha_entrega->format('d-m-Y')]);

                $this->reset('tramite');

                return;

            } */


        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no existe."]);

        } catch (\Throwable $th) {
            Log::error("Error al buscar tramite de certificado negativo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }


    }

    public function buscarPropietario(){

        $this->reset(['predioFlag', 'tramiteFlag', 'predio']);

        $this->validate([
            'nombre' => Rule::requiredIf($this->razon_social === null || $this->razon_social === ''),
            'ap_paterno' => Rule::requiredIf($this->razon_social === null || $this->razon_social === ''),
            'ap_materno' => Rule::requiredIf($this->razon_social === null || $this->razon_social === ''),
            'razon_social' => 'nullable'
        ]);

        $persona = Persona::when($this->nombre, fn($q) => $q->where('nombre', $this->nombre))
                                ->when($this->ap_paterno && $this->ap_paterno != '', fn($q) => $q->where('ap_paterno', $this->ap_paterno))
                                ->when($this->ap_materno && $this->ap_materno != '', fn($q) => $q->where('ap_materno', $this->ap_materno))
                                ->when($this->razon_social && $this->razon_social != '', fn($q) => $q->where('razon_social', $this->razon_social))
                                ->first();

        if($persona){

            $propietariosId = Propietario::select('propietarioable_id')
                                        ->where('propietarioable_type', 'App\Models\Predio')
                                        ->where('persona_id', $persona->id)
                                        ->get()
                                        ->toArray();

            dd($propietariosId);

            $this->predio = Predio::whereKey($propietariosId)->where('status', 'activo')->first();

            $this->predioFlag = true;

        }else{

            $this->tramiteFlag = true;

            $this->reset('predio');

        }

    }

    public function generarCertificado(){

       try {

            $pdf = null;

            DB::transaction(function () use (&$pdf){

                $this->tramite->update(['estado' => 'concluido']);

                $this->tramite->audits()->latest()->first()->update(['tags' => 'Finalizó trámite']);

                $nombre = trim($this->nombre . ' ' . $this->ap_paterno . ' ' . $this->ap_materno . $this->razon_social);

                $pdf = (new CertificadoNegativoController())->certificado($this->tramite, $nombre);

            });

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'certificado_negativo.pdf'
            );

       } catch (\Throwable $th) {

            Log::error("Error al imprimir certificado negativo usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

       }

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.certificaciones.certificado-negativo.certificado-negativo')->extends('layouts.admin');
    }

}
