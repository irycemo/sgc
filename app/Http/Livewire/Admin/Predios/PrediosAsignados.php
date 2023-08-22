<?php

namespace App\Http\Livewire\Admin\Predios;

use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\ComponentesTrait;
use App\Models\AsignarCuenta;

class PrediosAsignados extends Component
{

    use WithPagination;
    use ComponentesTrait;

    use WithPagination;
    use ComponentesTrait;

    public AsignarCuenta $modelo_editar;

    public function crearModeloVacio(){
        return AsignarCuenta::make();
    }

    public function render()
    {

        $predios = AsignarCuenta::with('actualizadoPor', 'valuadorAsignado')
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.Admin.predios.predios-asignados', compact('predios'))->extends('layouts.admin');
    }
}
