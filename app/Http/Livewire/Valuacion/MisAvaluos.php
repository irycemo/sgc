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
    public $todosSelecionados = false;
    public $modal = false;

    public Avaluo $modelo_editar;

    public function crearModeloVacio(){
        return Avaluo::make();
    }

    public function updatedSeleccionados(){

        $this->todosSelecionados = false;

        $this->paginaSeleccionada = false;

    }

    public function updatedPaginaSeleccionada($value){

        if($value){

            $this->seleccionados = $this->avaluos->pluck('id')->map(fn ($id) => (string) $id);

        }else{

            $this->seleccionados = [];

        }

    }

    public function eliminar(){

        try{

            DB::transaction(function () {

                $avaluos = Avaluo::whereKey($this->seleccionados);

                foreach ($avaluos as $avaluo) {

                    if($avaluo->estado == 'notificado'){

                        $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El avalúo con folio " . $avaluo->folio . ' no se puede eliminar, esta notificado.']);

                        return;

                    }

                    $avaluo->predio->delete();

                    $avaluo->delete();

                }

                $this->resetearTodo($borrado = true);

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "La información seleccionada se eliminó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al avaluos usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function mount(){

        $this->modelo_editar = $this->crearModeloVacio();

    }

    public function getAvaluosQueryProperty(){

        return Avaluo::with('predio.propietarios.persona', 'creadoPor', 'actualizadoPor')
                        ->where('asignado_a', auth()->user()->id)
                        ->orderBy($this->sort, $this->direction);

    }

    public function getAvaluosProperty(){

        return $this->avaluosQuery->paginate($this->pagination);

    }

    public function render()
    {

        if($this->todosSelecionados){

            $this->seleccionados = $this->avaluos->pluck('id')->map(fn ($id) => (string) $id);

        }

        return view('livewire.valuacion.mis-avaluos', ['avaluos' => $this->avaluos])->extends('layouts.admin');
    }
}
