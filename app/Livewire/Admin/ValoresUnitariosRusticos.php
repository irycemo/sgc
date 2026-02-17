<?php

namespace App\Livewire\Admin;

use App\Models\ValoresUnitariosRusticos as Model;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ValoresUnitariosRusticos extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public Model $modelo_editar;

    public function crearModeloVacio(){
        return Model::make();
    }

    #[Computed]
    public function valores(){

        return Model::select('id', 'concepto', 'valor', 'valor_aterior')
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);
    }

    public function render()
    {
        return view('livewire.admin.valores-unitarios-rusticos')->extends('layouts.admin');
    }
}
