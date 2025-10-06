<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use App\Models\ValoresUnitariosConstruccion as Model;

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

    public function render()
    {

        $valores = Model::when($this->tipo && $this->tipo != '', function($q){
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

        return view('livewire.admin.valores-unitarios-construccion',compact('valores'))->extends('layouts.admin');
    }
}
