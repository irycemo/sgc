<?php

namespace App\Livewire\Cartografia\AsignarManzana;

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

    public function buscarManzanas(){


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
