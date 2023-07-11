<?php

namespace App\Http\Livewire\Admin;

use App\Http\Traits\ComponentesTrait;
use App\Models\ValoresUnitariosConstruccion as ModelsValoresUnitariosConstruccion;
use Livewire\Component;
use Livewire\WithPagination;

class ValoresunitariosConstruccion extends Component
{
    use ComponentesTrait;
    use WithPagination;

    public ModelsValoresUnitariosConstruccion $modelo_editar;

    public function crearModeloVacio(){
        return ModelsValoresUnitariosConstruccion::make();
    }

    public function render()
    {

        $valores = ModelsValoresUnitariosConstruccion::orderBy($this->sort, $this->direction)
                                                        ->paginate($this->pagination);

        return view('livewire.Admin.valores-unitarios-construccion',compact('valores'))->extends('layouts.admin');
    }
}
