<?php

namespace App\Livewire\GestionCatastral\RevisionTraslados;

use App\Http\Traits\ComponentesTrait;
use App\Models\Traslado;
use Livewire\Component;
use Livewire\WithPagination;

class RevisionTraslados extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public Traslado $modelo_editar;

    public function crearModeloVacio(){
        $this->modelo_editar =  Traslado::make();
    }

    public function render()
    {

        $traslados = Traslado::with('actualizadoPor', 'asignadoA', 'predio')
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);


        return view('livewire.gestion-catastral.revision-traslados.revision-traslados', compact('traslados'))->extends('layouts.admin');
    }
}
