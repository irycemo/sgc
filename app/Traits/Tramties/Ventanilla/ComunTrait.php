<?php

namespace App\Traits\Tramties\Ventanilla;

use App\Exceptions\GeneralException;
use App\Models\Tramite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Tramites\TramiteService;

trait ComunTrait
{

    public $años;

    public $servicio;
    public $tramite;

    public $adicionaTramite;
    public $tramitesAdicionados;
    public $tramiteAdicionadoSeleccionado;
    public $tramiteAdicionado;
    public $tramite_adiciona_año;
    public $tramite_adiciona_folio;
    public $tramite_adiciona_usuario;

    public $predios = [];
    public $predio;
    public $localidad;
    public $oficina;
    public $tipo;
    public $registro;

    public $solicitantes;
    public $dependencias;
    public $notarias;
    public $notaria;

    public $editar = false;

    public Tramite $modelo_editar;

    public $flags = [
        'tipo_de_tramite' => true,
        'tipo_de_servicio' => false,
        'cantidad' => true,
        'solicitante' => true,
        'nombre_solicitante' => false,
        'predios' => true,
        'observaciones' => true,
        'adiciona' => false,
        'numero_oficio' => false,
        'dependencias' => false,
        'notarias' => false,
        'avaluo_para' => true
    ];

    public function getListeners()
    {
        return $this->listeners + [
            'cambioServicio' => 'cargaInicial',
            'cargarTramite' => 'cargarTramite'
        ];
    }

    protected $validationAttributes  = [
        'modelo_editar.adiciona' => 'trámite',
        'tipo' => 'tipo de predio',
        'registro' => 'número de registro',
        'tramiteAdicionadoSeleccionado' => 'trámite adiciona',
        'modelo_editar.numero_oficio' => 'número de oficio',
        'modelo_editar.nombre_solicitante' => 'nombre del solicitante',
        'modelo_editar.predio_avaluo' => 'clave catastral',
        'modelo_editar.ligado_a' => 'trámite',
    ];

    public function crearModeloVacio(){
        $this->modelo_editar = Tramite::make([
                                'cantidad' => 1,
                                'tipo_servicio' => 'ordinario',
                                'tipo_tramite' => 'normal'
                            ]);
    }

    public function cargarTramite(Tramite $tramtie){

        $this->tramite = $tramtie;

        $this->tramite->load('predios.propietarios.persona', 'servicio');
    }

    public function updatedNotaria(){

        if($this->notaria == ""){

            $this->reset(['notaria']);

            $this->modelo_editar->numero_notaria = null;
            $this->modelo_editar->nombre_notario = null;
            $this->modelo_editar->nombre_solicitante = null;

            return;

        }

        $notaria = json_decode($this->notaria);

        $this->modelo_editar->numero_notaria = $notaria->numero;
        $this->modelo_editar->nombre_notario = $notaria->notario;
        $this->modelo_editar->nombre_solicitante = $notaria->numero . ' ' .$notaria->notario;

    }

    public function validarPago(){

        try {

            DB::transaction(function () {

                (new TramiteService($this->tramite))->procesarPago();

                $this->resetearTodo();

                $this->dispatch('reset');

                $this->dispatch('mostrarMensaje', ['success', "El trámite se valido con éxito."]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al validar trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', $th->getMessage()]);
        }

    }

    public function updatedModeloEditarSolicitante(){

        $this->modelo_editar->nombre_solicitante = null;
        $this->modelo_editar->nombre_notario = null;
        $this->modelo_editar->numero_notaria = null;
        $this->notaria = null;

        $this->flags['nombre_solicitante'] = false;
        $this->flags['dependencias'] = false;
        $this->flags['notarias'] = false;
        $this->flags['numero_oficio'] = false;

        if($this->modelo_editar->solicitante == 'Usuario'){

            $this->flags['nombre_solicitante'] = true;

        }elseif($this->modelo_editar->solicitante == 'Notaría'){

            $this->flags['notarias'] = true;

        }elseif($this->modelo_editar->solicitante == 'Oficialia de partes' || $this->modelo_editar->solicitante == 'Escrituración social'){

            if(!auth()->user()->can('Trámite exento')){

                $this->dispatch('mostrarMensaje', ['warning', "No tiene permiso para elaborar trámites exentos."]);

                $this->modelo_editar->tipo_tramite = 'normal';

                $this->modelo_editar->solicitante = '';

                return;

            }

            $this->flags['dependencias'] = true;
            $this->flags['numero_oficio'] = true;
            $this->modelo_editar->tipo_tramite = 'exento';

        }else{

            $this->modelo_editar->nombre_solicitante = $this->modelo_editar->solicitante;

        }

    }

    public function updatedModeloEditarTipoTramite(){

        if($this->modelo_editar->tipo_tramite == 'exento'){

            if(!auth()->user()->can('Trámite exento')){

                $this->dispatch('mostrarMensaje', ['warning', "No tiene permiso para elaborar trámites exentos."]);

                $this->modelo_editar->tipo_tramite = 'normal';

                return;

            }

            $this->modelo_editar->monto = 0;

            $this->flags['numero_oficio'] = true;

        }elseif($this->modelo_editar->tipo_tramite == 'normal'){

            $this->flags['numero_oficio'] = false;

            $this->modelo_editar->numero_oficio = null;

            $this->modelo_editar->monto = $this->servicio[$this->modelo_editar->tipo_servicio] * $this->modelo_editar->cantidad;

        }

    }

    public function updatedModeloEditarTipoServicio(){

        $this->updatedModeloEditarTipoTramite();

        if($this->modelo_editar->tipo_servicio == 'urgente'){

            if($this->servicio['urgente'] == 0){

                $this->dispatch('mostrarMensaje', ['error', "No hay servicio urgente para el servicio seleccionado."]);

                $this->modelo_editar->tipo_servicio = 'ordinario';

                $this->updatedModeloEditarTipoTramite();
            }

        }
        elseif($this->modelo_editar->tipo_servicio == 'extra_urgente'){

            if($this->servicio['extra_urgente'] == 0){

                $this->dispatch('mostrarMensaje', ['error', "No hay servicio extra urgente para el servicio seleccionado."]);

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

    public function cargaInicial($servicio){

        $this->servicio = $servicio;

        $this->resetearTodo();

        $this->crearModeloVacio();

        $this->modelo_editar->servicio_id = $this->servicio['id'];

        $this->oficina = auth()->user()->oficina->oficina;

        $this->updatedModeloEditarTipoTramite();

    }

    public function resetearTodo(){

        $this->reset([
            'adicionaTramite',
            'tramitesAdicionados',
            'tramiteAdicionadoSeleccionado',
            'tramiteAdicionado',
            'predios',
            'predio',
            'localidad',
            'oficina',
            'tipo',
            'registro',
            'flags',
            'editar'
        ]);

        if(in_array($this->servicio['clave_ingreso'], ['D924', 'D925', 'D926', 'D927'])){

            $this->flags['adiciona'] = true;

        }

        if(in_array($this->servicio['clave_ingreso'], ['D914', 'D727' , 'D729'])){

            $this->tipo = 1;

        }

        if(in_array($this->servicio['clave_ingreso'], ['D726', 'D728'])){

            $this->tipo = 2;

        }

    }

    public function crear(){

        $this->validate();

        try {

            DB::transaction(function () {

                $tramite = (new TramiteService($this->modelo_editar))->crear($this->predios);

                $this->js('window.open(\' '. route('tramites.orden', $tramite) . '\', \'_blank\');');

                $this->resetearTodo();

                $this->dispatch('reset');

                $this->dispatch('mostrarMensaje', ['success', "El trámite se creó con éxito."]);

            });

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['error', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al crear trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', $th->getMessage()]);

        }


    }

    public function editarTramite(){

        if($this->modelo_editar->isNot($this->tramite))
            $this->modelo_editar = $this->tramite;

        $this->reset(['tramite']);

        $this->servicio = $this->modelo_editar->servicio;

        foreach ($this->modelo_editar->predios as $predio) {

            array_push($this->predios, $predio->toArray());

        }

    }

}
