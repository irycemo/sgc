<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Servicio;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;
use App\Models\ValoresUnitariosRusticos;
use App\Models\ValoresUnitariosConstruccion;
use App\Models\FactorIncremento as ModelsFactorIncremento;

class FactorIncremento extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $areas = [];

    public ModelsFactorIncremento $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.factor' => 'required|numeric',
            'modelo_editar.año' => 'required|numeric',
         ];
    }

    public function crearModeloVacio(){
        $this->modelo_editar = ModelsFactorIncremento::make();
    }

    public function abrirModalEditar(ModelsFactorIncremento $modelo){

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

                $valores_unitarios_construccion = ValoresUnitariosConstruccion::all();

                $valores_unitarios_rusticos = ValoresUnitariosRusticos::all();

                $servicios = Servicio::where('tipo', 'fija')->get();

                foreach($valores_unitarios_construccion as $valor){

                    $valor->update([
                        'valor_aterior' => ceil($valor->valor),
                        'valor' => ceil($valor->valor * $this->modelo_editar->factor),
                    ]);

                }

                foreach($valores_unitarios_rusticos as $valor){

                    $valor->update([
                        'valor_aterior' => ceil($valor->valor),
                        'valor' => ceil($valor->valor * $this->modelo_editar->factor),
                    ]);

                }

                foreach($servicios as $servicio){

                    $servicio->update([
                        'ordinario' => ceil($servicio->ordinario * $this->modelo_editar->factor),
                        'urgente' => ceil($servicio->urgente * $this->modelo_editar->factor),
                        'extra_urgente' => ceil($servicio->extra_urgente * $this->modelo_editar->factor),
                    ]);

                }

                $this->modelo_editar->creado_por = auth()->user()->id;
                $this->modelo_editar->save();

            });

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "El factor de incremento se creó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al crear factor de incremento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function actualizar(){

        $this->validate();

        try{

            $this->modelo_editar->actualizado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "El factor de incremento se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar factor de incremento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            $permiso = ModelsFactorIncremento::find($this->selected_id);

            $permiso->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "El factor de incremento se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar factor de incremento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function render()
    {

        $factores = ModelsFactorIncremento::with('creadoPor', 'actualizadoPor')
                                            ->orderBy($this->sort, $this->direction)
                                            ->paginate($this->pagination);

        return view('livewire.Admin.factor-incremento', compact('factores'))->extends('layouts.admin');
    }
}
