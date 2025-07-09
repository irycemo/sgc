<?php

namespace App\Livewire\Comun\Consultas;

use App\Models\Predio;
use Livewire\Component;

class ArchivoConsulta extends Component
{

    public $predio_id;
    public Predio $predio;

    public function mount(){

        $this->predio = Predio::find($this->predio_id);

    }

    public function render()
    {
        return view('livewire.comun.consultas.archivo-consulta');
    }
}
