<?php

namespace App\Livewire\Admin;

use App\Models\Persona;
use Livewire\Component;

class ConciliarPersona extends Component
{

    public $nombre;
    public $ap_paterno;
    public $ap_materno;
    public $razon_social;

    public $personas = [];

    public function buscarPersonas(){

        $this->personas = Persona::where('nombre', $this->nombre)
                                    ->where('ap_paterno', $this->ap_paterno)
                                    ->where('ap_materno', $this->ap_materno)
                                    ->where('razon_social', $this->razon_social)
                                    ->get();

    }

    public function render()
    {
        return view('livewire.admin.conciliar-persona');
    }
}
