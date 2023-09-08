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

    public $seleccionados = [];
    public $paginaSeleccionada = false;

    public Avaluo $modelo_editar;

    public function crearModeloVacio(){
        return Avaluo::make();
    }

    public function updatedPaginaSeleccionada($value){

        if($value){



        }else{

            $this->seleccionados = [];

        }

    }

    public function eliminar(){

        try{

            $avaluos = Avaluo::whereKey($this->seleccionados);

            foreach ($avaluos as $avaluo) {

                $avaluo->predio->delete();

                $avaluo->delete();

            }

            $this->resetearTodo($borrado = true);

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "La información seleccionada se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al avaluos usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function mount(){

        $this->modelo_editar = $this->crearModeloVacio();

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
