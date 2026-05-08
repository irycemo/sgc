<?php

namespace App\Livewire\Consultas\Reportes;

use Livewire\Component;

class Reportes extends Component
{

    public $area;

    public $verAvisos;
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

            $this->verAvisos = false;
            $this->verTramites = true;
            $this->verUsuarios = false;
            $this->verCertificaciones = false;
            $this->verEscrituracionSocial = false;

        }elseif($this->area == 'usuarios'){

            $this->verAvisos = false;
            $this->verTramites = false;
            $this->verUsuarios = true;
            $this->verCertificaciones = false;
            $this->verEscrituracionSocial = false;

        }elseif($this->area == 'certificaciones'){

            $this->verAvisos = false;
            $this->verTramites = false;
            $this->verUsuarios = false;
            $this->verCertificaciones = true;
            $this->verEscrituracionSocial = false;

        }elseif($this->area == 'escrituracion_social'){

            $this->verAvisos = false;
            $this->verTramites = false;
            $this->verUsuarios = false;
            $this->verCertificaciones = false;
            $this->verEscrituracionSocial = true;

        }elseif($this->area == 'avisos'){

            $this->verAvisos = true;
            $this->verTramites = false;
            $this->verUsuarios = false;
            $this->verCertificaciones = false;
            $this->verEscrituracionSocial = false;

        }

    }

    public function render()
    {
        return view('livewire.consultas.reportes.reportes')->extends('layouts.admin');
    }
}
