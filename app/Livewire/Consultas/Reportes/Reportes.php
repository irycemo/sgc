<?php

namespace App\Livewire\Consultas\Reportes;

use Livewire\Component;

class Reportes extends Component
{

    public $area;

    public $verTramites;
    public $verUsuarios;
    public $verCertificaciones;
    public $verEscrituracionSocial;

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

        if($this->area == 'tramites'){

            $this->verTramites = true;
            $this->verUsuarios = false;
            $this->verCertificaciones = false;
            $this->verEscrituracionSocial = false;

        }elseif($this->area == 'usuarios'){

            $this->verTramites = false;
            $this->verUsuarios = true;
            $this->verCertificaciones = false;
            $this->verEscrituracionSocial = false;

        }elseif($this->area == 'certificaciones'){

            $this->verTramites = false;
            $this->verUsuarios = false;
            $this->verCertificaciones = true;
            $this->verEscrituracionSocial = false;

        }elseif($this->area == 'escrituracion_social'){

            $this->verTramites = false;
            $this->verUsuarios = false;
            $this->verCertificaciones = false;
            $this->verEscrituracionSocial = true;

        }

    }

    public function render()
    {
        return view('livewire.consultas.reportes.reportes')->extends('layouts.admin');
    }
}
