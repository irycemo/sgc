<?php

namespace App\Livewire\Consultas\Historico;

use App\Models\Historico as Model;
use Livewire\Component;

class Historico extends Component
{

    public $localidad;
    public $oficina;
    public $tipo_predio;
    public $numero_registro;

    public $movimientos = [];

    protected function rules(){

        return [
            'localidad' => 'required|numeric',
            'oficina' => 'required|numeric',
            'tipo_predio' => 'required|numeric',
            'numero_registro' => 'required|numeric'
        ];

    }

    public function buscarCuentaPredial(){

        $this->validate();

        $this->movimientos = Model::where('localidad', $this->localidad)
                                        ->where('oficina', $this->oficina)
                                        ->where('tipo_predio', $this->tipo_predio)
                                        ->where('numero_registro', $this->numero_registro)
                                        ->orderBy('consecutivo_movimiento', 'desc')
                                        ->get();

    }

    public function render()
    {
        return view('livewire.consultas.historico.historico')->extends('layouts.admin');
    }
}
