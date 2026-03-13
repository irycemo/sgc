<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Servicio;
use Livewire\WithPagination;
use App\Models\FactorIncremento;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ValoresUnitariosRusticos;
use App\Models\ValoresUnitariosConstruccion;

class FactorIncrementos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $areas = [];

    public FactorIncremento $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.factor' => 'required|numeric',
            'modelo_editar.año' => 'required|numeric',
         ];
    }

    public function crearModeloVacio(){
        $this->modelo_editar = FactorIncremento::make();
    }

    public function abrirModalEditar(FactorIncremento $modelo){

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
                        'valor_aterior' => round($valor->valor),
                        'valor' => round($valor->valor * $this->modelo_editar->factor),
                    ]);

                }

                foreach($valores_unitarios_rusticos as $valor){

                    $valor->update([
                        'valor_aterior' => round($valor->valor),
                        'valor' => round($valor->valor * $this->modelo_editar->factor),
                    ]);

                }

                foreach($servicios as $servicio){

                    $servicio->update([
                        'ordinario' => round($servicio->ordinario * $this->modelo_editar->factor),
                        'urgente' => round($servicio->urgente * $this->modelo_editar->factor),
                        'extra_urgente' => round($servicio->extra_urgente * $this->modelo_editar->factor),
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

            $permiso = FactorIncremento::find($this->selected_id);

            $permiso->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "El factor de incremento se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar factor de incremento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    #[Computed]
    public function factores(){

        return FactorIncremento::select('id', 'año', 'factor', 'creado_por', 'actualizado_por', 'created_at', 'updated_at')
                                ->with('creadoPor:id,name', 'actualizadoPor:id,name')
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.admin.factor-incrementos')->extends('layouts.admin');
    }
}
