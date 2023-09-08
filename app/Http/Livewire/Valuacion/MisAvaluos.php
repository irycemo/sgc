<?php

namespace App\Http\Livewire\Valuacion;

use App\Models\Avaluo;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;

class MisAvaluos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $roles;
    public $areas_adscripcion;

    public Avaluo $modelo_editar;
    public $role;

    protected function rules(){
        return [
         ];
    }

    protected $validationAttributes  = [

    ];

    public function crearModeloVacio(){
        return Avaluo::make();
    }

    public function abrirModalEditar(Avaluo $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function borrar(){

        try{

            $usuario = Avaluo::find($this->selected_id);

            $usuario->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El usuario se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function mount(){

        $this->modelo_editar = $this->crearModeloVacio();

        array_push($this->fields, 'role');

    }

    public function render()
    {

        $avaluos = Avaluo::with('predio.propietarios.persona', 'creadoPor', 'actualizadoPor')
                            ->where('asignado_a', auth()->user()->id)
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.valuacion.mis-avaluos', compact('avaluos'))->extends('layouts.admin');
    }
}
