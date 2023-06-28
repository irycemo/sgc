<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\ComponentesTrait;
use App\Models\ValoresUnitariosRusticos as ModelsValoresUnitariosRusticos;

class ValoresUnitariosRusticos extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public ModelsValoresUnitariosRusticos $modelo_editar;

    public function crearModeloVacio(){
        return ModelsValoresUnitariosRusticos::make();
    }

    public function render()
    {

        $valores = ModelsValoresUnitariosRusticos::orderBy($this->sort, $this->direction)
                                                        ->paginate($this->pagination);

        return view('livewire.admin.valores-unitarios-rusticos',compact('valores'))->extends('layouts.admin');

    }
}
