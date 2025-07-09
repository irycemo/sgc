<?php

namespace App\Livewire\Comun\Consultas;

use App\Models\Certificacion;
use Livewire\Component;

class CertificacionesConsulta extends Component
{

    public $predio_id;
    public $certificaciones;

    public function mount(){

        $this->certificaciones = Certificacion::where('predio_id', $this->predio_id)
                                                    ->where('estado', 'activo')
                                                    ->get();

    }

    public function render()
    {
        return view('livewire.comun.consultas.certificaciones-consulta');
    }
}
