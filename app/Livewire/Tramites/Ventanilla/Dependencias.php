<?php

namespace App\Livewire\Tramites\Ventanilla;

use App\Models\Dependencia;
use App\Traits\ComponentesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Dependencias extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $permisos;

    public Dependencia $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.nombre' => 'required'
         ];
    }

    public function crearModeloVacio(){
        $this->modelo_editar = Dependencia::make();
    }

    public function abrirModalEditar(Dependencia $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function guardar(){

        $this->validate();

        try {

            DB::transaction(function () {

                $this->modelo_editar->creado_por = auth()->user()->id;
                $this->modelo_editar->save();

                $this->resetearTodo();

                $this->dispatch('mostrarMensaje', ['success', "La dependencia se creó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al crear dependencia por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function actualizar(){

        $this->validate();

        try{

            DB::transaction(function () {

                $this->modelo_editar->actualizado_por = auth()->user()->id;
                $this->modelo_editar->save();

                $this->resetearTodo();

                $this->dispatch('mostrarMensaje', ['success', "La dependencia se actualizó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualzar dependencia por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            $dependencia = Dependencia::find($this->selected_id);

            $dependencia->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La dependencia se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar dependencia por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    #[Computed]
    public function dependencias(){

        return Dependencia::select('id','nombre', 'creado_por', 'actualizado_por', 'created_at', 'updated_at')
                        ->with('creadoPor:id,name', 'actualizadoPor:id,name')
                        ->where('nombre', 'LIKE', '%' . $this->search . '%')
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.tramites.ventanilla.dependencias')->extends('layouts.admin');
    }

}
