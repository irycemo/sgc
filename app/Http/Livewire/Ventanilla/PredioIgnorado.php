<?php

namespace App\Http\Livewire\Ventanilla;

use App\Models\Avaluo;
use App\Models\Tramite;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Tramites\TramiteService;
use App\Models\PredioAvaluo;

class PredioIgnorado extends Component
{

    public $servicio;
    public $tramite;

    public $adicionaTramite;
    public $tramitesAdicionados;
    public $tramiteAdicionadoSeleccionado;
    public $tramiteAdicionado;

    public $region_catastral;
    public $municipio;
    public $zona_catastral;
    public $sector;
    public $localidad;
    public $predio;
    public $manzana;
    public $edificio;
    public $departamento;

    public $editar = false;

    public Tramite $modelo_editar;

    public $flags = [
        'tipo_de_tramite' => true,
        'tipo_de_servicio' => true,
        'cantidad' => true,
        'solicitante' => true,
        'observaciones' => true,
    ];

    protected $listeners = [
        'cambioServicio' => 'cambiarFlags',
        'cargarTramite' => 'cargarTramite'
    ];

    protected function rules(){

        return [
            'modelo_editar.tipo_tramite' => 'required',
            'modelo_editar.servicio_id' => 'required',
            'modelo_editar.solicitante' => 'required',
            'modelo_editar.monto' => 'required',
            'modelo_editar.tipo_servicio' => 'required',
            'modelo_editar.cantidad' => 'required|numeric',
            'modelo_editar.adiciona' => 'required_if:adicionaTramite,true',
            'modelo_editar.observaciones' => Rule::requiredIf($this->modelo_editar->tipo_tramite === "exento"),
        ];

    }

    protected $validationAttributes  = [
        'modelo_editar.adiciona' => 'trámite',
        'tramiteAdicionadoSeleccionado' => 'trámite adiciona'
    ];

    public function crearModeloVacio(){
        return Tramite::make([
                                'cantidad' => 1,
                                'tipo_servicio' => 'ordinario',
                                'tipo_tramite' => 'normal'
                            ]);
    }

    public function cargarTramite(Tramite $tramtie){

        $this->tramite = $tramtie;

        $this->tramite->load('servicio');

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

            if($this->tramiteAdicionado){

                $this->modelo_editar->monto = abs($this->modelo_editar->monto - (float)$this->tramiteAdicionado['monto']);

                $this->resetearInformacion();

            }else{

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Para el complemento es necesario seleccione el tramite al que adiciona."]);

                $this->modelo_editar->tipo_tramite = 'normal';

                $this->updatedModeloEditarTipoTramite();

            }

        }elseif($this->modelo_editar->tipo_tramite == 'normal'){

            $this->modelo_editar->monto = $this->servicio[$this->modelo_editar->tipo_servicio] * $this->modelo_editar->cantidad;

        }

    }

    public function buscarPredio(){

        $this->validate([
            'region_catastral' => 'required',
            'municipio' => 'required',
            'zona_catastral' => 'required',
            'sector' => 'required',
            'localidad' => 'required',
            'predio' => 'required',
            'manzana' => 'required',
            'edificio' => 'required',
            'departamento' => 'required',
        ]);

        $predio = PredioAvaluo::where('estado', 16)
                                    ->where('region_catastral', $this->region_catastral)
                                    ->where('municipio', $this->municipio)
                                    ->where('zona_catastral', $this->zona_catastral)
                                    ->where('sector', $this->sector)
                                    ->where('localidad', $this->localidad)
                                    ->where('predio', $this->predio)
                                    ->where('manzana', $this->manzana)
                                    ->where('edificio', $this->edificio)
                                    ->where('departamento', $this->departamento)
                                    ->first();

        if(!$predio){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', 'No existe el predio con la clave catastral ingresada.']);

            return;
        }

        if(!$predio->valor_catastral){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', 'El predio no tiene valor catastral.']);

            return;
        }

        $this->modelo_editar->monto = (float)$this->servicio['porcentaje'] / 100 * $predio->valor_catastral;

        $this->modelo_editar->observaciones =
                'Clave catastral: 16-' .
                $this->region_catastral . '-' .
                $this->municipio . '-' .
                $this->zona_catastral . '-' .
                $this->sector . '-' .
                $this->localidad . '-' .
                $this->predio . '-' .
                $this->manzana . '-' .
                $this->edificio . '-' .
                $this->departamento;

        $this->dispatchBrowserEvent('mostrarMensaje', ['success', 'Se cargo correctamente el 2% del valor del predio.']);

    }

    public function cambiarFlags($servicio){

        $this->resetearTodo();

        $this->servicio = $servicio;

        $this->modelo_editar = $this->crearModeloVacio();

        $this->modelo_editar->servicio_id = $this->servicio['id'];

        $this->updatedModeloEditarTipoTramite();

    }

    public function resetearTodo(){

        $this->reset([
            'tramite',
            'adicionaTramite',
            'tramitesAdicionados',
            'tramiteAdicionadoSeleccionado',
            'tramiteAdicionado',
            'flags',
            'editar'
        ]);
    }

    public function crear(){

        $this->validate();

        try {

            DB::transaction(function () {

                $tramite = (new TramiteService($this->modelo_editar))->crearTramite();

                $this->resetearTodo();

                $this->dispatchBrowserEvent('imprimir_recibo', ['tramite' => $tramite->id]);

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El trámite se creó con éxito."]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al crear trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', $th->getMessage()]);
        }

        $this->emitUp('reset');

    }

    public function actualizar(){

        $this->validate();

        try {

            DB::transaction(function () {

                $tramite = (new TramiteService($this->modelo_editar))->actualizarTramite($this->predios);

                $this->resetearTodo();

                $this->dispatchBrowserEvent('imprimir_recibo', ['tramite' => $tramite->id]);

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El trámite se actualizó con éxito."]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al actualizar trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', $th->getMessage()]);
        }

        $this->emitUp('reset');

    }

    public function editar(){

        if($this->modelo_editar->isNot($this->tramite))
            $this->modelo_editar = $this->tramite;

        $this->reset(['tramite']);

        $this->servicio = $this->modelo_editar->servicio;

        $this->flags['tipo_de_tramite'] = false;
        $this->flags['tipo_de_servicio'] = false;
        $this->flags['cantidad'] = false;
        $this->flags['adiciona'] = false;

        $this->editar = true;

    }

    public function mount(){

        $this->cambiarFlags($this->servicio);

    }

    public function render()
    {
        return view('livewire.ventanilla.predio-ignorado');
    }
}
