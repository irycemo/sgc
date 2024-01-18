<?php

namespace App\Livewire\Admin\Predios;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AsignarCuenta;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;

class PrediosAsignados extends Component
{

    use WithPagination;
    use ComponentesTrait;

    use WithPagination;
    use ComponentesTrait;

    public $valuadores;
    public $valuador;
    public $modal = false;

    public $valuadoresAsignados;

    public AsignarCuenta $modelo_editar;

    public $filters = [
        'localidad' => '',
        'oficina' => '',
        'tipo' => '',
        'registro' => '',
        'valuador' => ''
    ];

    public function updatedFilters() { $this->resetPage(); }

    public function crearModeloVacio(){
        return AsignarCuenta::make();
    }

    public function abrirModalReasignar(AsignarCuenta $modelo){

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->valuadores = User::whereNotNull('valuador')
                                    ->whereHas('oficina', function($q){
                                        $q->where('oficina', $this->modelo_editar->oficina);
                                    })
                                    ->orderBy('ap_paterno')
                                    ->get();

        $this->modal = true;
    }

    public function reasignar(){

        try {

            $this->modelo_editar->update(['valuador' => $this->valuador]);

            $this->reset(['valuador', 'modal']);

            $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Reasigno valuador']);

            $this->dispatch('mostrarMensaje', ['success', "Se reasigno la cuenta con éxito."]);

        } catch (\Throwable $th) {
            Log::error("Error al reasignar valuador por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function mount(){

        $this->modelo_editar = $this->crearModeloVacio();

        $this->valuadoresAsignados = User::whereNotNull('valuador')->orderBy('ap_paterno')->get();

    }

    public function render()
    {

        $predios = AsignarCuenta::with('actualizadoPor', 'valuadorAsignado', 'creadoPor')
                                    ->when($this->filters['localidad'], fn($q, $localidad) => $q->where('localidad', $localidad))
                                    ->when($this->filters['oficina'], fn($q, $oficina) => $q->where('oficina', $oficina))
                                    ->when($this->filters['tipo'], fn($q, $tipo) => $q->where('tipo_predio', $tipo))
                                    ->when($this->filters['registro'], fn($q, $registro) => $q->where('numero_registro', $registro))
                                    ->when($this->filters['valuador'], function($q, $valuador){
                                        $q->WhereHas('valuadorAsignado', function($q) use($valuador){
                                            $q->where('id', $valuador);
                                        });
                                    })
                                    ->orderBy($this->sort, $this->direction)
                                    ->paginate($this->pagination);

        return view('livewire.Admin.predios.predios-asignados', compact('predios'))->extends('layouts.admin');
    }
}
