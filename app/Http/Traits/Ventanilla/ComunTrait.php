<?php

namespace App\Http\Traits\Ventanilla;

use App\Models\Predio;
use App\Models\Tramite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Tramites\TramiteService;

trait ComunTrait
{

    public $servicio;
    public $tramite;

    public $adicionaTramite;
    public $tramitesAdicionados;
    public $tramiteAdicionadoSeleccionado;
    public $tramiteAdicionado;

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
        'tipo_de_servicio' => true,
        'cantidad' => true,
        'solicitante' => true,
        'nombre_solicitante' => false,
        'predios' => true,
        'observaciones' => true,
        'adiciona' => true,
        'numero_oficio' => false,
        'dependencias' => false,
        'notarias' => false,
        'avaluo_para' => true
    ];

    public function getListeners()
    {
        return $this->listeners + [
            'cambioServicio' => 'cambiarFlags',
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
    ];

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

    public function buscarPredio(){

        $this->validate([
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo' => 'required',
            'registro' => 'required'
        ]);

        if($this->modelo_editar->servicio_id == 64 && $this->tipo != 2){

            $this->dispatch('mostrarMensaje', ['error', "El predio no es rustico."]);
            return;

        }

        if($this->modelo_editar->servicio_id == 65 && $this->tipo != 1){

            $this->dispatch('mostrarMensaje', ['error', "El predio no es urbano."]);
            return;

        }

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

        if($this->predio->bloqueadoActivo()){

            $this->dispatch('mostrarMensaje', ['error', "El predio se encuentra bloqueado."]);
            $this->predio = null;
            return;
        }

    }

    public function agregarPredio(){

        if(in_array($this->servicio['id'], [45, 46, 64, 65])  && count($this->predios) == 1){

            $this->dispatch('mostrarMensaje', ['error', "Solo es posible agregar 1 predio al servicio."]);

            return;

        }

        if($this->editar && count($this->predios) >= $this->modelo_editar->cantidad){

            $this->dispatch('mostrarMensaje', ['error', "Solo es posible agregar " . $this->modelo_editar->cantidad . " predios."]);

            return;

        }

        $colection = collect($this->predios);

        if($colection->contains('id', $this->predio->id))
            $this->dispatch('mostrarMensaje', ['error', "La cuenta predial ya esta agregada."]);
        else
            array_push($this->predios, $this->predio->toArray());

        $this->predio = null;

        $this->modelo_editar->cantidad = count($this->predios);

        $this->updatedModeloEditarTipoServicio();

    }

    public function quitarPredio($id){

        $a = null;

        foreach ($this->predios as $k => $val) {

            if ($val['id'] == $id) {

                $a = $k;

            }

        }

        unset($this->predios[$a]);

        if(!$this->editar)
            $this->modelo_editar->cantidad = count($this->predios);

        $this->updatedModeloEditarTipoServicio();

    }

    public function validar(){

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

}
