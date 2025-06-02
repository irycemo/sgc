<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use App\Models\ValoresUnitariosRusticos as Model;

class ValoresUnitariosRusticos extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public Model $modelo_editar;

    public function crearModeloVacio(){
        return Model::make();
    }

    public function render()
    {

        $valores = Model::orderBy($this->sort, $this->direction)->paginate($this->pagination);

        return view('livewire.admin.valores-unitarios-rusticos',compact('valores'))->extends('layouts.admin');

    }
}
