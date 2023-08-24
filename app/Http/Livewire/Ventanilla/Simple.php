<?php

namespace App\Http\Livewire\Ventanilla;

use App\Models\Tramite;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Tramites\TramiteService;

class Simple extends Component
{

    public $servicio;
    public $tramite;

    public $adicionaTramite;
    public $tramitesAdicionados;
    public $tramiteAdicionadoSeleccionado;
    public $tramiteAdicionado;

    public $editar = false;

    public Tramite $modelo_editar;

    public $flags = [
        'tipo_de_tramite' => true,
        'tipo_de_servicio' => true,
        'cantidad' => true,
        'solicitante' => true,
        'observaciones' => true,
        'adiciona' => true,
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

        $this->tramite->load('predios.propietarios.persona', 'servicio');
    }

    public function updatedAdicionaTramite(){

        if(!$this->adicionaTramite){

            $this->reset(['tramiteAdicionadoSeleccionado', 'tramiteAdicionado']);

            $this->modelo_editar->adiciona = null;

        }else{

            $this->dispatchBrowserEvent('select2');

            $this->tramitesAdicionados = Tramite::with('predios.propietarios.persona')
                                                ->whereHas('servicio', function ($q) {
                                                    $q->where('nombre', $this->servicio['nombre']);
                                                })
                                                ->where('estado', 'pagado')
                                                ->get();


        }

    }

    public function updatedTramiteAdicionadoSeleccionado(){

        $this->tramiteAdicionado = json_decode($this->tramiteAdicionadoSeleccionado, true);

        if($this->tramiteAdicionado){

            $this->resetearInformacion();

        }

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

    public function updatedModeloEditarTipoServicio(){

        $this->modelo_editar->monto = $this->servicio[$this->modelo_editar->tipo_servicio] * $this->modelo_editar->cantidad;

        $this->updatedModeloEditarTipoTramite();

        if($this->modelo_editar->tipo_servicio == 'urgente'){

            if($this->servicio['urgente'] == 0){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "No hay servicio urgente para el servicio seleccionado."]);

                $this->modelo_editar->tipo_servicio = 'ordinario';

                $this->updatedModeloEditarTipoTramite();
            }

        }
        elseif($this->modelo_editar->tipo_servicio == 'extra_urgente'){

            if($this->servicio['extra_urgente'] == 0){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "No hay servicio extra urgente para el servicio seleccionado."]);

                $this->modelo_editar->tipo_servicio = 'ordinario';

                $this->updatedModeloEditarTipoTramite();
            }

        }

    }

    public function updatedModeloEditarCantidad(){

        if($this->modelo_editar->cantidad == '')
            $this->modelo_editar->cantidad = 1;

        $this->updatedModeloEditarTipoServicio();

    }

    public function resetearInformacion(){

        $this->modelo_editar->adiciona = $this->tramiteAdicionado['id'];

        $this->modelo_editar->solicitante = $this->tramiteAdicionado['solicitante'];

        $this->modelo_editar->cantidad = $this->tramiteAdicionado['cantidad'];

        $this->modelo_editar->observaciones = $this->tramiteAdicionado['observaciones'];

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

                $tramite = (new TramiteService($this->modelo_editar))->actualizarTramite();

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

        foreach($this->modelo_editar->predios as $predio){

            array_push($this->predios, $predio);

        }

        $this->editar = true;

    }

    public function mount(){

        $this->cambiarFlags($this->servicio);

    }

    public function render()
    {
        return view('livewire.ventanilla.simple');
    }
}
