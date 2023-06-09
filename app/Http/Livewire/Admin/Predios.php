<?php

namespace App\Http\Livewire\Admin;

use App\Models\Predio;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\ComponentesTrait;

class Predios extends Component
{

    use WithPagination;
    use ComponentesTrait;

    use WithPagination;
    use ComponentesTrait;

    public Predio $modelo_editar;

    public function crearModeloVacio(){
        return Predio::make();
    }

    public function render()
    {

        $predios = Predio::with('actualizadoPor')
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.Admin.predios', compact('predios'))->extends('layouts.admin');

    }
}
