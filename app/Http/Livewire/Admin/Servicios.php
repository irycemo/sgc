<?php

namespace App\Http\Livewire\Admin;

use App\Models\Uma;
use Livewire\Component;
use App\Models\Servicio;
use Livewire\WithPagination;
use App\Models\CategoriaServicio;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;

class Servicios extends Component
{
    use WithPagination;
    use ComponentesTrait;

    public $categorias;

    public Servicio $modelo_editar;
    public $flag_uma = false;
    public $flag_fija = false;

    protected function rules(){
        return [
            'modelo_editar.nombre' => 'required',
            'modelo_editar.tipo' => 'required',
            'modelo_editar.estado' => 'required',
            'modelo_editar.umas' => 'numeric|nullable|min:0',
            'modelo_editar.ordinario' => 'required|numeric|nullable',
            'modelo_editar.urgente' => 'numeric|nullable|min:0',
            'modelo_editar.extra_urgente' => 'numeric|nullable|min:0',
            'modelo_editar.categoria_servicio_id' => 'required',
            'modelo_editar.porcentaje' => 'numeric|nullable|min:0',
            'modelo_editar.clave_ingreso' => 'required|string',
         ];
    }

    protected $validationAttributes  = [
        'modelo_editar.clave_ingreso' => 'clave de ingreso',
    ];

    public function crearModeloVacio(){
        return Servicio::make();
    }

    public function updatedModeloEditarOrdinario(){

        $this->checarTipo();
    }

    public function updatedModeloEditarUmas(){

        $this->checarTipo();
    }

    public function updatedModeloEditarTipo(){

        $this->checarTipo();
    }

    public function abrirModalEditar(Servicio $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function checarTipo(){

        if($this->modelo_editar->tipo == 'uma'){

            $uma = Uma::orderBy('año', 'desc')->first();

            $this->modelo_editar->ordinario = $uma->diario * $this->modelo_editar->umas;

            $this->modelo_editar->ordinario = ceil($this->modelo_editar->ordinario);

            $this->modelo_editar->urgente = ceil($this->modelo_editar->ordinario * 2);

            $this->modelo_editar->extra_urgente = ceil($this->modelo_editar->ordinario * 3);

            $this->modelo_editar->fija = null;

            $this->modelo_editar->porcentaje = null;

        }elseif($this->modelo_editar->tipo == 'fija'){

            $this->modelo_editar->umas = null;

            $this->modelo_editar->porcentaje = null;

            $this->modelo_editar->ordinario = ceil($this->modelo_editar->ordinario);

            $this->modelo_editar->urgente = ceil($this->modelo_editar->ordinario * 2);

            $this->modelo_editar->extra_urgente = ceil($this->modelo_editar->ordinario * 3);

        }else{

            $this->modelo_editar->umas = null;

            $this->modelo_editar->fija = null;

            $this->modelo_editar->ordinario = 0;

            $this->modelo_editar->urgente = 0;

            $this->modelo_editar->extra_urgente = 0;

        }

    }

    public function crear(){

        $this->validate();

        try {

            $this->modelo_editar->creado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El servicio se creó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al crear servicio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
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

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El servicio se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar servicio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            $servicio = Servicio::find($this->selected_id);

            $servicio->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El servicio se elimino con exito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar servicio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function mount(){

        $this->modelo_editar = $this->crearModeloVacio();

        $this->categorias = CategoriaServicio::orderBy('nombre')->get();

    }

    public function render()
    {

        $servicios = Servicio::with('categoria', 'creadoPor', 'actualizadoPor')
                                ->where('nombre', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('tipo', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('umas', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('estado', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('ordinario', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('clave_ingreso', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('urgente', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('extra_urgente', 'LIKE', '%' . $this->search . '%')
                                ->orWhere(function($q){
                                    return $q->whereHas('categoria', function($q){
                                        return $q->where('nombre', 'LIKE', '%' . $this->search . '%');
                                    });
                                })
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);


        return view('livewire.Admin.servicios', compact('servicios'))->extends('layouts.admin');
    }
}
