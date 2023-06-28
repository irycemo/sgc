<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;
use App\Models\FactorIncremento as ModelsFactorIncremento;

class FactorIncremento extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $areas = [];

    public ModelsFactorIncremento $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.factor' => 'required',
            'modelo_editar.ano' => 'required',
         ];
    }

    public function crearModeloVacio(){
        return ModelsFactorIncremento::make();
    }

    public function abrirModalEditar(ModelsFactorIncremento $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function crear(){

        $this->validate();

        try {

            $this->modelo_editar->creado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El factor de incremento se creó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al crear factor de incremento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function actualizar(){

        $this->validate();

        try{

            $this->modelo_editar->actualizado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El factor de incremento se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar factor de incremento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            $permiso = ModelsFactorIncremento::find($this->selected_id);

            $permiso->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El factor de incremento se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar factor de incremento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function render()
    {

        $factores = ModelsFactorIncremento::orderBy($this->sort, $this->direction)
                                            ->paginate($this->pagination);

        return view('livewire.admin.factor-incremento', compact('factores'))->extends('layouts.admin');
    }
}
