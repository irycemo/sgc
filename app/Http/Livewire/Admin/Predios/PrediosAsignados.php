<?php

namespace App\Http\Livewire\Admin\Predios;

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

    public AsignarCuenta $modelo_editar;

    public function crearModeloVacio(){
        return AsignarCuenta::make();
    }

    public function abrirModalReasignar(AsignarCuenta $modelo){

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->valuadores = User::whereNotNull('valuador')
                                    ->where('oficina', $this->modelo_editar->oficina)
                                    ->orderBy('ap_paterno')
                                    ->get();

        $this->modal = true;
    }

    public function reasignar(){

        try {

            $this->modelo_editar->update(['valuador' => $this->valuador]);

            $this->reset(['valuador', 'modal']);

            $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Reasigno valuador']);

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "Se reasigno la cuenta con éxito."]);

        } catch (\Throwable $th) {
            Log::error("Error al reasignar valuador por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function mount(){

        $this->modelo_editar = $this->crearModeloVacio();

    }

    public function render()
    {

        $predios = AsignarCuenta::with('actualizadoPor', 'valuadorAsignado', 'creadoPor')
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.Admin.predios.predios-asignados', compact('predios'))->extends('layouts.admin');
    }
}
