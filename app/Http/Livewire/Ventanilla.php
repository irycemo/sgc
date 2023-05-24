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
    public $localidad;
    public $oficina;
    public $tipo;
    public $registro;
    public $importe_base;
    public $editar = false;
    public $angulo;

    public Tramite $modelo_editar;

    public $certificados_historia = [
        'Certificado de historia catastral hasta 5 movimientos',
        'Certificado de historia catastral de 6 a 10 movimientos',
        'Certificado de historia catastral de 11 a 15 movimientos',
        'Certificado de historia catastral de mas de 15 movimientos'
    ];

    public $flags = [
        'flag_tipo_de_tramite' => false,
        'flag_tipo_de_servicio' => false,
        'cantidad' => false,
        'importe_base' => false,
        'solicitante' => false,
        'predios' => false,
        'observaciones' => false,
        'adiciona' => false,
        'angulo' => false
    ];

    protected function rules(){

        return [
            'modelo_editar.tipo_tramite' => 'required',
            'modelo_editar.servicio_id' => 'required',
            'modelo_editar.solicitante' => 'required',
            'modelo_editar.monto' => 'required',
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
        'registro' => 'número de registro',
        'tramiteAdicionaSelected' => 'trámite adiciona'
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

            $this->modelo_editar->adiciona = null;

            $this->updatedTramiteAdiciona();

        }else{

            $this->dispatchBrowserEvent('select2');

            if(in_array($this->servicio['nombre'], $this->certificados_historia)){

                $this->tramitesAdiciones = Tramite::with('predios.propietarios.persona')
                                                    ->whereHas('servicio', function ($q) {
                                                        $q->where('nombre', 'Certificado de historia catastral');
                                                    })
                                                    ->whereHas('predios', function ($q) {
                                                        $q->where('oficina', auth()->user()->oficina);
                                                    })
                                                    ->where('estado', 'pagado')
                                                    ->where('parcial_usados', 0)
                                                    ->get();

            }else{

                $this->tramitesAdiciones = Tramite::with('predios.propietarios.persona')
                                                    ->whereHas('servicio', function ($q) {
                                                        $q->where('nombre', $this->servicio['nombre']);
                                                    })
                                                    ->where('estado', 'pagado')
                                                    ->where('parcial_usados', 0)
                                                    ->get();

            }
        }

        $this->updatedModeloEditarTipoTramite();

    }

    public function updatedTramiteAdiciona(){

        $this->tramiteAdicionaSelected = json_decode($this->tramiteAdiciona, true);

        if($this->tramiteAdicionaSelected){

            $this->modelo_editar->adiciona = $this->tramiteAdicionaSelected['id'];

            $this->modelo_editar->solicitante = $this->tramiteAdicionaSelected['solicitante'];

            foreach($this->tramiteAdicionaSelected['predios'] as $predio){

                array_push($this->predios, $predio);

            }

        }

        $this->updatedModeloEditarCantidad();

    }

    public function updatedCategoriaSelect(){

        if($this->categoria_select == ""){

            $this->resetearTodo($borrado = true);

            return;

        }

        $this->categoria = json_decode($this->categoria_select, true);

        $this->servicios = Servicio::where('categoria_servicio_id', $this->categoria['id'])->where('estado', 'activo')->get();

        $this->resetearTodo($borrado = true);

    }

    public function updatedServicioSelect(){

        if($this->servicio_select == ""){

            $this->resetearTodo($borrado = true);

            return;

        }

        $this->resetearTodo($borrado = true);

        $this->servicio = json_decode($this->servicio_select, true);

        $this->modelo_editar->servicio_id = $this->servicio['id'];

        $this->modelo_editar->monto = $this->servicio[$this->modelo_editar->tipo_servicio] * $this->modelo_editar->cantidad;

        $context = new TramiteContext($this->categoria['nombre'], $this->modelo_editar);

        $this->flags = $context->cambiarFlags();

        $this->updatedModeloEditarTipoServicio();

    }

    public function updatedModeloEditarTipoTramite(){


        if($this->modelo_editar->tipo_tramite == 'exento'){

            if(!auth()->user()->can('Trámite excento')){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "No tiene permiso para elaborar trámites exentos."]);

                $this->modelo_editar->tipo_tramite = 'normal';

                return;

            }

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

        }elseif($this->modelo_editar->tipo_tramite == 'parcial'){

            if(!$this->tramiteAdicionaSelected){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Para el parcial es necesario seleccione el tramite al que adiciona."]);

                $this->modelo_editar->tipo_tramite = 'normal';

                $this->updatedModeloEditarTipoTramite();

            }

        }elseif($this->modelo_editar->tipo_tramite == 'porcentaje'){

            if($this->servicio['porcentaje'] == 0){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El servicio no aplica para porcentaje."]);

                $this->modelo_editar->tipo_tramite = 'normal';

                $this->updatedModeloEditarTipoTramite();

            }

        }

    }

    public function updatedModeloEditarTipoServicio(){

        $this->modelo_editar->monto = $this->servicio[$this->modelo_editar->tipo_servicio] * $this->modelo_editar->cantidad;

        $this->updatedModeloEditarTipoTramite();

        if($this->modelo_editar->tipo_servicio == 'urgente'){

            if($this->modelo_editar->monto == 0){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "No hay servicio urgente para el servicio seleccionado."]);

                $this->modelo_editar->tipo_servicio = 'ordinario';

                $this->updatedModeloEditarTipoTramite();
            }

        }
        elseif($this->modelo_editar->tipo_servicio == 'extra_urgente'){

            if($this->modelo_editar->monto == 0){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "No hay servicio extra urgente para el servicio seleccionado."]);

                $this->modelo_editar->tipo_servicio = 'ordinario';

                $this->updatedModeloEditarTipoTramite();
            }

        }

    }

    public function updatedModeloEditarCantidad(){

        if($this->modelo_editar->cantidad == ''){
            $this->modelo_editar->cantidad = 1;
        }

        if($this->servicio['id'] == 37){

            $aux = $this->modelo_editar->cantidad - 1;

            if($this->modelo_editar->adiciona){

                $this->modelo_editar->monto = $this->modelo_editar->servicio->ordinario * $this->modelo_editar->cantidad * 0.1;

                return;

            }elseif($this->modelo_editar->cantidad > 1){

                $this->modelo_editar->monto = $this->modelo_editar->servicio->ordinario * $aux * 0.1 + $this->modelo_editar->servicio->ordinario;

            }

        }else{

            $this->modelo_editar->monto = $this->servicio[$this->modelo_editar->tipo_servicio] * $this->modelo_editar->cantidad;

        }

    }

    public function updatedImporteBase(){

        if($this->importe_base == '')
            return;

        if($this->servicio['id'] == 108){

            $this->modelo_editar->monto = (float)$this->servicio['porcentaje'] / 100 * $this->importe_base ;

        }

    }

    public function updatedAngulo(){

        if($this->angulo == 'min')
            $this->modelo_editar->monto = $this->servicio['ordinario'] * 1.2;
        elseif($this->angulo == 'max')
            $this->modelo_editar->monto = $this->servicio['ordinario'] * 1.5;
        else
            $this->modelo_editar->monto = $this->servicio['ordinario'];
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

        $this->tramite = Tramite::with('predios.propietarios.persona', 'servicio')
                                    ->where('folio', $this->tramite_folio)
                                    ->whereIn('estado', ['pagado', 'nuevo'])
                                    ->first();

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

        $this->flags['flag_tipo_de_tramite'] = false;
        $this->flags['flag_tipo_de_servicio'] = false;
        $this->flags['cantidad'] = false;
        $this->flags['adiciona'] = false;

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
            Log::error("Error al actualizar trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', $th->getMessage()]);
        }

    }

    public function crear(){

        $context = new TramiteContext($this->categoria['nombre'], $this->modelo_editar);

        $this->validate(array_merge($this->rules(), $context->validaciones()));

        try {

            DB::transaction(function () use ($context){

                $tramite = $context->crearTramite($this->predios);

                $this->resetearTodo($borrado = true);

                $this->categoria_select = null;
                $this->servicio_select = null;

                $this->dispatchBrowserEvent('imprimir_recibo', ['tramite' => $tramite->id]);

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El trámite se creó con éxito."]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al crear trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', $th->getMessage()]);
        }


    }

    public function reimprimir(){

        $this->dispatchBrowserEvent('imprimir_recibo', ['tramite' => $this->tramite->id]);

    }

    public function mount(){

        $this->modelo_editar = $this->crearModeloVacio();

        array_push($this->fields, 'adicionaTramite', 'tramite', 'predios', 'predio', 'localidad', 'oficina', 'tipo', 'registro', 'flags', 'editar', 'tramiteAdicionaSelected', 'tramiteAdiciona', 'importe_base', 'angulo');

        $this->categorias = CategoriaServicio::orderBy('nombre')->get();

    }

    public function render()
    {
        return view('livewire.ventanilla')->extends('layouts.admin');
    }
}
