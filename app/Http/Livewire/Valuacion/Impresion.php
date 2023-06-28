<?php

namespace App\Http\Livewire\Valuacion;

use App\Models\User;
use App\Models\Oficina;
use Livewire\Component;

class Impresion extends Component
{

    public $tramiteInspeccion;
    public $tramiteImpresion;
    public $formato = 0;
    public $autoridad_municipal;
    public $localidad;
    public $oficina;
    public $tipo;
    public $registro_inicio;
    public $registro_final;
    public $director;
    public $jefe_departamento;
    public $jefe_departamento_municipal;
    public $notificador;
    public $notificador_municipal;
    public $valuadores;
    public $valuador;
    public $valuador_municipal;
    public $ciudad;
    public $hora;
    public $dia;
    public $mes;
    public $año;
    public $nombre;
    public $calidad;

    protected function rules(){
        return [
            'tramiteInspeccion' => 'required',
            'tramiteImpresion' => 'required',
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo' => 'required',
            'registro_inicio' => 'nullable',
            'valuador' => 'required_if:formato,0',
            'notificador' => 'required_if:formato,0',
            'ciudad' => 'required',
            'hora' => 'required',
            'dia' => 'required',
            'año' => 'required',
            'mes' => 'required',
            'nombre' => 'required',
            'calidad' => 'required',
         ];
    }

    public function updatedLocalidad(){

        $this->updatedOficina();

    }

    public function updatedFormato(){

        if(!$this->formato)
            $this->oficina = 101;

    }

    public function updatedOficina(){

        $this->validate(['localidad' => 'required','oficina' => 'required']);

        $oficina = Oficina::where('oficina', $this->oficina)->where('localidad', $this->localidad)->first();

        if(!$oficina){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Oficina incorrecta."]);

            $this->oficina = null;

            return;

        }

        $this->autoridad_municipal = $oficina->autoridad_municipal;

        $this->jefe_departamento_municipal = $oficina->jefe_departamento;

        $this->notificador_municipal = $oficina->notificador;

        $this->valuador_municipal = $oficina->valuador_municipal;


    }

    public function imprimir(){

        $this->validate();

    }

    public function mount(){

        $this->oficina = auth()->user()->oficina;

        $this->director = User::where('status', 'activo')
                                    ->whereHas('roles', function($q){
                                        $q->where('name', 'Director');
                                    })
                                    ->first();

        $this->director = $this->director->name . ' ' . $this->director->ap_paterno . ' ' . $this->director->ap_materno;

        $this->jefe_departamento = User::where('status', 'activo')
                                            ->whereHas('roles', function($q){
                                                $q->where('name', 'Jefe de departamento');
                                            })
                                            ->where('area', 'Departamento de Valuación')
                                            ->first();

        $this->jefe_departamento = $this->jefe_departamento->name . ' ' . $this->jefe_departamento->ap_paterno . ' ' . $this->jefe_departamento->ap_materno;

        $this->valuadores = User::where('status', 'activo')
                                    ->where('valuador', 1)
                                    ->orderBy('name')
                                    ->get();

    }

    public function render()
    {
        return view('livewire.valuacion.impresion')->extends('layouts.admin');
    }
}
