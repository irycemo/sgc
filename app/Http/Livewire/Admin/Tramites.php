<?php

namespace App\Http\Livewire\Admin;

use App\Models\Predio;
use App\Models\Tramite;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;

class Tramites extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $predios = [];
    public $predio;
    public $localidad;
    public $oficina;
    public $tipo;
    public $registro;

    public Tramite $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.solicitante' => 'required|string',
            'modelo_editar.observaciones' => 'nullable',
            'modelo_editar.estado' => 'required',
            'predios' => 'nullable'
         ];
    }

    protected $validationAttributes  = [

    ];

    public function crearModeloVacio(){
        return Tramite::make();
    }

    public function abrirModalEditar(Tramite $modelo){

        $this->resetearTodo();
        $this->modal = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        if($this->modelo_editar->predios->count()){

            $this->modelo_editar->load('predios.propietarios.persona');

            foreach($this->modelo_editar->predios as $predio){

                array_push($this->predios, $predio);

            }

        }

    }

    public function actualizar(){

        $this->validate();

        try{

            $this->modelo_editar->actualizado_por = auth()->user()->id;
            $this->modelo_editar->save();

            if($this->predios){

                foreach($this->predios as $predio){

                    $this->modelo_editar->predios()->attach($predio['id']);

                }

            }

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El trámite se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function buscarPredio(){

        $this->validate([
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo' => 'required',
            'registro' => 'required'
        ]);

        $this->predio = Predio::with('propietarios.persona')
                                ->where('localidad', $this->localidad)
                                ->where('oficina', $this->oficina)
                                ->where('tipo_predio', $this->tipo)
                                ->where('numero_registro', $this->registro)
                                ->first();

        if(!$this->predio){
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La cuenta predial no esta registrada."]);
            return;
        }

    }

    public function agregarPredio(){

        $colection = collect($this->predios);

        if($colection->contains('id', $this->predio->id))
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La cuenta predial ya esta agregada."]);
        else
            array_push($this->predios, $this->predio->toArray());

        $this->predio = null;

    }

    public function quitarPredio($id){

        $a = null;

        foreach ($this->predios as $k => $val) {

            if ($val['id'] == $id) {

                $a = $k;

            }

        }

        unset($this->predios[$a]);

    }

    public function mount(){

        $this->modelo_editar = $this->crearModeloVacio();

        array_push($this->fields, 'predios', 'predio', 'localidad', 'oficina', 'tipo', 'registro');

    }

    public function render()
    {

        $tramites = Tramite::with('creadoPor', 'actualizadoPor', 'servicio.categoria', 'predios')
                            ->where('solicitante', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('folio', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('tipo_servicio', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('tipo_tramite', 'LIKE', '%' . $this->search . '%')
                            ->orWhere(function($q){
                                return $q->whereHas('creadoPor', function($q){
                                    return $q->where('name', 'LIKE', '%' . $this->search . '%');
                                });
                            })
                            ->orWhere(function($q){
                                return $q->whereHas('servicio', function($q){
                                    return $q->where('nombre', 'LIKE', '%' . $this->search . '%');
                                });
                            })
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);


        return view('livewire.Admin.tramites', compact('tramites'))->extends('layouts.admin');
    }
}
