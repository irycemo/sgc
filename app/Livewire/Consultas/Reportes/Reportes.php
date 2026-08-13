<?php

namespace App\Livewire\Consultas\Reportes;

use Livewire\Component;

class Reportes extends Component
{

    public $area;

    public $flags = [
        'Avisos' => false,
        'Tramites' => false,
        'Usuarios' => false,
        'Certificaciones' => false,
        'EscrituracionSocial' => false,
        'Recaudacion' => false,
        'Sat' => false,
    ];

    protected function rules(){
        return [
            'fecha1' => 'required|date',
            'fecha2' => 'required|date|after:date1',
         ];
    }

    protected $messages = [
        'fecha1.required' => "La fecha inicial es obligatoria.",
        'fecha2.required' => "La fecha final es obligatoria.",
    ];

    public function updatedArea(){

        $this->reset('flags');

        $this->flags[$this->area] = true;

    }

    public function render()
    {
        return view('livewire.consultas.reportes.reportes')->extends('layouts.admin');
    }
}
