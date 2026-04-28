<?php

namespace App\Livewire\Cartografia\AsignarManzana;

use App\Models\Predio;
use Livewire\Component;

class AsignarManzana extends Component
{

    public $municipio;
    public $zona;
    public $localidad;
    public $sector;
    public $observaciones;
    public $lat;
    public $lon;
    public $valuadores;

    public $manzanas_disponibles = [];
    public $manzanas_ocupadas = [];

    public function buscarManzanas(){

        $this->validate([
            'municipio' => 'required|numeric',
            'zona' => 'required|numeric',
            'localidad' => 'required|numeric',
            'sector' => 'required|numeric',
        ]);

        $predios = Predio::where('municipio', $this->municipio)
                            ->where('zona', $this->zona)
                            ->where('localidad', $this->localidad)
                            ->where('sector', $this->sector)
                            ->get();

        for ($i=1; $i < 99; $i++) {

            if($predios->where('manzana', $i)->first()){

                array_push($this->manzanas_ocupadas, $i);

            }else{

                array_push($this->manzanas_disponibles, $i);

            }

        }


    }

    public function asignarManzana(){


    }

    public function mount(){


    }

    public function render()
    {
        return view('livewire.cartografia.asignar-manzana.asignar-manzana')->extends('layouts.admin');
    }

}
