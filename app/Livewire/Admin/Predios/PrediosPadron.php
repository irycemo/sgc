<?php

namespace App\Livewire\Admin\Predios;

use App\Models\Predio;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\ComponentesTrait;

class PrediosPadron extends Component
{

    use WithPagination;
    use ComponentesTrait;

    use WithPagination;
    use ComponentesTrait;

    public Predio $modelo_editar;

    public $filters = [
        'localidad' => '',
        'oficina' => '',
        'tipo' => '',
        'registro' => '',
    ];

    public function updatedFilters() { $this->resetPage(); }

    public function crearModeloVacio(){
        return Predio::make();
    }

    public function render()
    {

        $predios = Predio::with('actualizadoPor')
                            ->when($this->filters['localidad'], fn($q, $localidad) => $q->where('localidad', $localidad))
                            ->when($this->filters['oficina'], fn($q, $oficina) => $q->where('oficina', $oficina))
                            ->when($this->filters['tipo'], fn($q, $tipo) => $q->where('tipo_predio', $tipo))
                            ->when($this->filters['registro'], fn($q, $registro) => $q->where('numero_registro', $registro))
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.Admin.predios.predios-padron', compact('predios'))->extends('layouts.admin');

    }
}
