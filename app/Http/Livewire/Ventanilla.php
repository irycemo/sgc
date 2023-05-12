<?php

namespace App\Http\Livewire;

use App\Models\Predio;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Servicio;
use Illuminate\Validation\Rule;
use App\Models\CategoriaServicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;
use App\Http\Services\Tramites\TramiteContext;

class Ventanilla extends Component
{

    use ComponentesTrait;

    public $tramitesAdiciones = [];
    public $adicionaTramite = false;
    public $tramiteAdiciona;
    public $tramiteAdicionaSelected;
    public $tramite;
    public $tramite_folio;
    public $categorias;
    public $categoria_select;
    public $categoria;
    public $servicios = [];
    public $servicio_select;
    public $servicio;
    public $predios = [];
    public $predio;
    public $localidad = 39;
    public $oficina = 33;
    public $tipo = 2;
    public $registro = 65;
    public $importe_base;
    public $editar = false;

    public $flags = [
        'flag_tipo_de_tramite' => false,
        'flag_tipo_de_servicio' => false,
        'cantidad' => false,
        'importe_base' => false,
        'solicitante' => false,
        'predios' => false,
        'observaciones' => false,
        'adiciona' => false,
    ];

    public Tramite $modelo_editar;

    protected function rules(){

        return [
            'modelo_editar.tipo_tramite' => 'required',
            'modelo_editar.servicio_id' => 'required',
            'modelo_editar.solicitante' => 'required',
            'modelo_editar.monto' => 'required',
            'modelo_editar.parcial_usados' => 'nullable',
            'modelo_editar.tipo_servicio' => 'required',
            'modelo_editar.cantidad' => 'required|numeric|min:1',
            'modelo_editar.adiciona' => 'required_if:adicionaTramite,true',
            'modelo_editar.observaciones' => Rule::requiredIf($this->modelo_editar->tipo_tramite === "exento"),
         ];

    }

    protected $validationAttributes  = [
        'modelo_editar.servicio_id' => 'servicio',
        'modelo_editar.tipo_servicio' => 'tipo de servicio',
        'modelo_editar.adiciona' => 'trámite',
        'tipo' => 'tipo de predio',
        'registro' => 'número de registro'
    ];

    public function crearModeloVacio(){
        return Tramite::make([
                                'cantidad' => 1,
                                'tipo_servicio' => 'ordinario',
                                'tipo_tramite' => 'normal'
                            ]);
    }

    public function updatedAdicionaTramite(){

        if(!$this->adicionaTramite){

            $this->reset(['tramiteAdicionaSelected', 'tramiteAdiciona']);

            $this->updatedTramiteAdiciona();

        }else{

            $this->dispatchBrowserEvent('select2');

        }

        $this->updatedModeloEditarTipoTramite();
    }

    public function updatedTramiteAdiciona(){

        $this->tramiteAdicionaSelected = json_decode($this->tramiteAdiciona, true);

        if($this->tramiteAdicionaSelected)
            $this->modelo_editar->adiciona = $this->tramiteAdicionaSelected['id'];


    }

    public function updatedCategoriaSelect(){

        if($this->categoria_select == ""){

            $this->resetearTodo($borrado = true);

            return;

        }

        $this->categoria = json_decode($this->categoria_select, true);

        $this->servicios = Servicio::where('categoria_servicio_id', $this->categoria['id'])->get();

        $this->resetearTodo($borrado = true);

    }

    public function updatedServicioSelect(){

        if($this->servicio_select == ""){

            $this->resetearTodo($borrado = true);

            return;

        }

        $this->resetearTodo();

        $this->servicio = json_decode($this->servicio_select, true);

        $this->modelo_editar->servicio_id = $this->servicio['id'];

        $this->modelo_editar->monto = $this->servicio[$this->modelo_editar->tipo_servicio] * $this->modelo_editar->cantidad;

        $context = new TramiteContext($this->categoria['nombre'], $this->modelo_editar);

        $this->flags = $context->cambiarFlags();

        $this->updatedModeloEditarTipoServicio();

    }

    public function updatedModeloEditarTipoTramite(){


        if($this->modelo_editar->tipo_tramite == 'exento'){

            $this->modelo_editar->monto = 0;

        }elseif($this->modelo_editar->tipo_tramite == 'complemento'){

            if($this->tramiteAdicionaSelected){

                $monto = abs($this->modelo_editar->monto - (float)$this->tramiteAdicionaSelected['monto']);

                $this->modelo_editar->monto = $monto;

            }else{

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Para el complemento es necesario seleccione el tramite al que adiciona."]);

                $this->modelo_editar->tipo_tramite = 'normal';

                $this->updatedModeloEditarTipoTramite();

            }

        }elseif($this->modelo_editar->tipo_tramite == 'normal'){

            $this->modelo_editar->monto = $this->servicio[$this->modelo_editar->tipo_servicio] * $this->modelo_editar->cantidad;

        }

    }

    public function updatedModeloEditarTipoServicio(){

        $this->modelo_editar->monto = $this->servicio[$this->modelo_editar->tipo_servicio] * $this->modelo_editar->cantidad;

        $this->updatedModeloEditarTipoTramite();

    }

    public function updatedModeloEditarCantidad(){

        if($this->modelo_editar->cantidad == ''){
            $this->modelo_editar->cantidad = 1;
        }

        $this->modelo_editar->monto = $this->servicio[$this->modelo_editar->tipo_servicio] * $this->modelo_editar->cantidad;

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

    public function buscarTramite(){

        $this->resetearTodo($borrado = true);

        $this->categoria = null;

        $this->tramite = Tramite::with('predios.propietarios.persona', 'servicio')->where('folio', $this->tramite_folio)->first();

        if(!$this->tramite)
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "No se encontro el trámite."]);

        $this->tramite_folio = null;

    }

    public function editar(){

        if($this->modelo_editar->isNot($this->tramite))
            $this->modelo_editar = $this->tramite;

        $this->reset(['tramite']);

        $this->categoria = $this->modelo_editar->servicio->categoria;

        $this->categoria_select = json_encode($this->categoria);

        $this->servicio = $this->modelo_editar->servicio;

        $this->servicios = Servicio::where('categoria_servicio_id', $this->categoria['id'])->get();

        $this->servicio_select = json_encode($this->servicio);

        $context = new TramiteContext($this->modelo_editar->servicio->categoria->nombre, $this->modelo_editar);

        $this->flags = $context->cambiarFlags();

        foreach($this->modelo_editar->predios as $predio){

            array_push($this->predios, $predio);

        }


        $this->editar = true;

    }

    public function actualizar(){

        $context = new TramiteContext($this->categoria->nombre, $this->modelo_editar);

        $this->validate(array_merge($this->rules(), $context->validaciones()));

        try {

            DB::transaction(function () use ($context){

                $tramite = $context->actualizarTramite($this->modelo_editar, $this->predios);

                $this->resetearTodo($borrado = true);

                $this->categoria = null;
                $this->categoria_select = null;

                $this->dispatchBrowserEvent('imprimir_recibo', ['tramite' => $tramite->id]);

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El trámite se actualizó con éxito."]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al actualizar trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    public function crear(){

        $context = new TramiteContext($this->categoria['nombre'], $this->modelo_editar);

        $this->validate(array_merge($this->rules(), $context->validaciones()));

        try {

            DB::transaction(function () use ($context){

                $tramite = $context->crearTramite($this->predios);

                $this->resetearTodo($borrado = true);

                $this->categoria = null;
                $this->categoria_select = null;

                $this->dispatchBrowserEvent('imprimir_recibo', ['tramite' => $tramite->id]);

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El trámite se creó con éxito."]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al crear trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }


    }

    public function reimprimir(){

        $this->dispatchBrowserEvent('imprimir_recibo', ['tramite' => $this->tramite->id]);

    }

    public function mount(){

        $this->modelo_editar = $this->crearModeloVacio();

        array_push($this->fields, 'adicionaTramite', 'tramite', 'predios', 'predio', 'localidad', 'oficina', 'tipo', 'registro', 'flags', 'editar', 'tramiteAdicionaSelected', 'tramiteAdiciona');

        $this->categorias = CategoriaServicio::orderBy('nombre')->get();

        $this->tramitesAdiciones = Tramite::all();

    }

    public function render()
    {
        return view('livewire.ventanilla')->extends('layouts.admin');
    }
}
