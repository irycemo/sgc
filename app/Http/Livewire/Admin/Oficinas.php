<?php

namespace App\Http\Livewire\Admin;

use App\Models\Oficina;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;

class Oficinas extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public Oficina $modelo_editar;
    public $cabeceras;

    protected function rules(){
        return [
            'modelo_editar.oficina' => 'required|numeric',
            'modelo_editar.municipio' => 'required|numeric',
            'modelo_editar.localidad' => 'required|numeric',
            'modelo_editar.nombre' => 'required|string',
            'modelo_editar.ubicacion' => 'required',
            'modelo_editar.titular' => 'required',
            'modelo_editar.email' => 'required|email',
            'modelo_editar.telefonos' => 'required',
            'modelo_editar.autoridad_municipal' => 'required',
            'modelo_editar.valuador_municipal' => 'required',
            'modelo_editar.cabecera' => 'nullable',
         ];
    }

    protected $validationAttributes  = [
        'modelo_editar.autoridad_municipal' => 'autoridad municipal',
        'modelo_editar.valuador_municipal' => 'valuador municipal'
    ];

    public function crearModeloVacio(){
        return Oficina::make();
    }

    public function abrirModalEditar(Oficina $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function crear(){

        $this->validate();

        try {

            DB::transaction(function () {

                $this->modelo_editar->creado_por = auth()->user()->id;
                $this->modelo_editar->save();

                $this->resetearTodo();

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "La oficina se creó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al crear oficina por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
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

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "La oficina se actualizó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualizar oficina por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function borrar(){

        try{

            $usuario = Oficina::find($this->selected_id);

            $usuario->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "La oficina se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar oficina por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function mount(){

        $this->cabeceras = Oficina::whereNull('cabecera')->orderBy('nombre')->get();

        $this->modelo_editar = $this->crearModeloVacio();

    }

    public function render()
    {

        $oficinas = Oficina::with('creadoPor', 'actualizadoPor', 'cabeceraMunicipal')
                                ->where('municipio', 'LIKE', '%'. $this->search . '%')
                                ->orWhere('oficina', 'LIKE', '%'. $this->search . '%')
                                ->orWhere('localidad', 'LIKE', '%'. $this->search . '%')
                                ->orWhere('nombre', 'LIKE', '%'. $this->search . '%')
                                ->orWhere('ubicacion', 'LIKE', '%'. $this->search . '%')
                                ->orWhere('titular', 'LIKE', '%'. $this->search . '%')
                                ->orWhere('email', 'LIKE', '%'. $this->search . '%')
                                ->orWhere('telefonos', 'LIKE', '%'. $this->search . '%')
                                ->orWhere('autoridad_municipal', 'LIKE', '%'. $this->search . '%')
                                ->orWhere('valuador_municipal', 'LIKE', '%'. $this->search . '%')
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);

        return view('livewire.Admin.oficinas', compact('oficinas'))->extends('layouts.admin');
    }
}
