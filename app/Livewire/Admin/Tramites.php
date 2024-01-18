<?php

namespace App\Livewire\Admin;

use App\Http\Constantes\Constantes;
use App\Models\Predio;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Servicio;
use Livewire\WithPagination;
use App\Http\Traits\WithCache;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;

class Tramites extends Component
{

    use WithPagination;
    use WithCache;
    use ComponentesTrait;

    public $predios = [];
    public $predio;
    public $localidad;
    public $oficina;
    public $tipo;
    public $registro;
    public $modalVer = false;
    public $año;
    public $años;

    public $filters = [
        'search' => '',
        'año' => '',
        'folio' => '',
        'estado' => '',
        'tipoTramite' => '',
        'servicio' => '',
    ];

    public $servicios;

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

    public function updatedFilters() { $this->resetPage(); }

    public function crearModeloVacio(){
        $this->modelo_editar = Tramite::make();
    }

    public function abrirModalEditar(Tramite $modelo){

        $this->useCachedRows();

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

        $this->useCache = false;

    }

    public function abrirModalVer(Tramite $modelo){

        $this->useCachedRows();

        $this->resetearTodo();
        $this->modalVer = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;


        $this->useCache = false;

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

            $this->dispatch('mostrarMensaje', ['success', "El trámite se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function buscarPredio(){

        $this->useCachedRows();

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
            $this->dispatch('mostrarMensaje', ['error', "La cuenta predial no esta registrada."]);
            return;
        }

        $this->useCache = false;

    }

    public function agregarPredio(){

        $this->useCachedRows();

        $colection = collect($this->predios);

        if($colection->contains('id', $this->predio->id))
            $this->dispatch('mostrarMensaje', ['error', "La cuenta predial ya esta agregada."]);
        else
            array_push($this->predios, $this->predio->toArray());

        $this->predio = null;

        $this->useCache = false;

    }

    public function quitarPredio($id){

        $this->useCachedRows();

        $a = null;

        foreach ($this->predios as $k => $val) {

            if ($val['id'] == $id) {

                $a = $k;

            }

        }

        unset($this->predios[$a]);

        $this->useCache = false;

    }

    public function getRowsQueryProperty(){

        return Tramite::query()
                ->with('servicio', 'creadoPor', 'actualizadoPor')
                ->when($this->filters['search'], fn($q, $search) => $q->where('solicitante', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['año'], fn($q, $año) => $q->where('año', $año))
                ->when($this->filters['folio'], fn($q, $folio) => $q->where('folio', $folio))
                ->when($this->filters['estado'], fn($q, $estado) => $q->where('estado', $estado))
                ->when($this->filters['tipoTramite'], fn($q, $tipoTramite) => $q->where('tipo_tramite', $tipoTramite))
                ->when($this->filters['servicio'], fn($q, $servicio) => $q->where('servicio_id', $servicio))
                ->orderBy($this->sort, $this->direction);

    }

    public function getRowsProperty(){

        return $this->cache(function(){

            return $this->rowsQuery->paginate($this->pagination);

        });

    }

    public function mount(){

        $this->crearModeloVacio();

        array_push($this->fields, 'predios', 'predio', 'localidad', 'oficina', 'tipo', 'registro');

        $this->servicios = Servicio::select('id', 'nombre')->orderBy('nombre')->get();

        $this->años = Constantes::AÑOS;

    }

    public function render()
    {
        return view('livewire.Admin.tramites', [
            'tramites' => $this->rows
        ])->extends('layouts.admin');
    }
}
