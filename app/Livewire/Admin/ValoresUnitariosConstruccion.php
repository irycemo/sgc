<?php

namespace App\Livewire\Admin;

use App\Models\ValoresUnitariosConstruccion as Model;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ValoresUnitariosConstruccion extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public Model $modelo_editar;

    public $tipo;
    public $uso;
    public $categoria;
    public $calidad;

    public function crearModeloVacio(){
        return Model::make();
    }

    #[Computed]
    public function valores(){

        return Model::select('id', 'tipo', 'uso', 'estado', 'calidad', 'valor', 'valor_aterior')
                        ->when($this->tipo && $this->tipo != '', function($q){
                            $q->where('tipo', $this->tipo);
                        })
                        ->when($this->uso && $this->uso != '', function($q){
                            $q->where('uso', $this->uso);
                        })
                        ->when($this->categoria && $this->categoria != '', function($q){
                            $q->where('estado', $this->categoria);
                        })
                        ->when($this->calidad && $this->calidad != '', function($q){
                            $q->where('calidad', $this->calidad);
                        })
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);
    }

    public function render()
    {
        return view('livewire.admin.valores-unitarios-construccion')->extends('layouts.admin');
    }
}
