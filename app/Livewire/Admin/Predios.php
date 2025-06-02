<?php

namespace App\Livewire\Admin;

use App\Models\Predio;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;

class Predios extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public Predio $modelo_editar;

    public $modal = false;

    public $observaciones;

    public $filters = [
        'localidad' => '',
        'oficina' => '',
        'tipo' => '',
        'registro' => '',
    ];

    public function updatedFilters() { $this->resetPage(); }

    public function abrirModal(Predio $predio){

        $this->modelo_editar = $predio;

        $this->modal = true;

    }

    public function bloquear(){

        $this->validate(['observaciones' => 'required']);

        if($this->modelo_editar->status == 'bloqueado'){

            $this->modelo_editar->bloqueos()->where('estado', 'activo')->first()->update([
                'estado'=> 'inactivo',
                'observaciones_desbloqueo' => $this->observaciones,
                'actualizado_por' => auth()->id()
            ]);

            $this->modelo_editar->update(['status' => 'activo']);

            $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Desbloqueo predio']);

        }else{

            $this->modelo_editar->bloqueos()->create([
                'estado'=> 'activo',
                'observaciones_bloqueo' => 'Se bloquea por motivo: ' . $this->observaciones,
                'creado_por' => auth()->id()
            ]);

            $this->modelo_editar->update(['status' => 'bloqueado']);

            $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Bloquea predio']);

        }


        $this->reset('modal', 'observaciones');

    }

    public function crearModeloVacio(){
        $this->modelo_editar = Predio::make();
    }

    #[Computed]
    public function predios(){

        return Predio::with('actualizadoPor')
                        ->when($this->filters['localidad'], fn($q, $localidad) => $q->where('localidad', $localidad))
                        ->when($this->filters['oficina'], fn($q, $oficina) => $q->where('oficina', $oficina))
                        ->when($this->filters['tipo'], fn($q, $tipo) => $q->where('tipo_predio', $tipo))
                        ->when($this->filters['registro'], fn($q, $registro) => $q->where('numero_registro', $registro))
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.admin.predios')->extends('layouts.admin');
    }
}
