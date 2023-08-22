<?php

namespace App\Http\Livewire\Admin\Predios;

use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\ComponentesTrait;
use App\Models\PredioAvaluo;

class PrediosAvaluos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    use WithPagination;
    use ComponentesTrait;

    public PredioAvaluo $modelo_editar;

    public function crearModeloVacio(){
        return PredioAvaluo::make();
    }

    public function render()
    {

        $predios = PredioAvaluo::with('actualizadoPor', 'avaluo')
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.admin.predios.predios-avaluos', compact('predios'))->extends('layouts.admin');

    }
}
