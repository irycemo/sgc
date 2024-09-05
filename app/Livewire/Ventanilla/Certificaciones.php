<?php

namespace App\Livewire\Ventanilla;

use App\Models\Notaria;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Dependencia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Tramites\TramiteService;
use App\Http\Traits\Ventanilla\ComunTrait;

class Certificaciones extends Component
{

    use ComunTrait;

    public $certificados_historia = [
        'Certificado de historia catastral hasta 5 movimientos',
        'Certificado de historia catastral de 6 a 10 movimientos',
        'Certificado de historia catastral de 11 a 15 movimientos',
        'Certificado de historia catastral de mas de 15 movimientos'
    ];

    protected function rules(){

        return [
            'modelo_editar.tipo_tramite' => 'required',
            'modelo_editar.servicio_id' => 'required',
            'modelo_editar.solicitante' => 'required',
            'modelo_editar.nombre_solicitante' => 'required',
            'modelo_editar.monto' => 'required',
            'modelo_editar.tipo_servicio' => 'required',
            'modelo_editar.cantidad' => 'required|numeric',
            'modelo_editar.adiciona' => 'required_if:adicionaTramite,true',
            'modelo_editar.observaciones' => Rule::requiredIf($this->modelo_editar->tipo_tramite === "exento"),
            'modelo_editar.numero_oficio' => Rule::requiredIf($this->modelo_editar->solicitante == 'Oficialia de partes' ||
                                                                $this->modelo_editar->solicitante == 'Escrituración social'),
         ];

    }

    public function validaciones():array
    {

        if($this->modelo_editar->servicio->nombre == 'Certificado negativo catastral'){

            return [

                'predios' => 'nullable',
                'modelo_editar.cantidad' => 'numeric|max:1'

            ];

        }elseif($this->modelo_editar->servicio->nombre == 'Certificado de historia catastral'){

            return [

                'predios' => 'required|array|max:1',
                'modelo_editar.cantidad' => 'numeric|max:1'

            ];

        }elseif(in_array($this->modelo_editar->servicio->nombre, $this->certificados_historia)){

            return [

                'predios' => 'nullable',
                'tramiteAdicionado' => 'required',
                'modelo_editar.adiciona' => 'required'
            ];

        }else{

            return [

                'predios' => 'required|array',

            ];

        }

    }

    public function crearModeloVacio(){
        return Tramite::make([
                                'cantidad' => 1,
                                'tipo_servicio' => 'ordinario',
                                'tipo_tramite' => 'normal'
                            ]);
    }

    public function updatedAdicionaTramite(){

        if(!$this->adicionaTramite){

            $this->reset(['tramiteAdicionadoSeleccionado', 'tramiteAdicionado']);

            $this->modelo_editar->adiciona = null;

            /* $this->updatedTramiteAdiciona(); */

        }else{

            $this->dispatch('select2');

            if(in_array($this->servicio['nombre'], $this->certificados_historia)){

                $this->tramitesAdicionados = Tramite::with('predios.propietarios.persona')
                                                    ->whereHas('servicio', function ($q) {
                                                        $q->where('nombre', 'Certificado de historia catastral');
                                                    })
                                                    ->when(!auth()->user()->hasRole('Administrador'), function($q){
                                                        $q->whereHas('predios', function ($q) {
                                                            $q->where('oficina', auth()->user()->oficina->oficina);
                                                        });
                                                    })
                                                    ->where('estado', 'pagado')
                                                    ->whereNull('parcial_usado')
                                                    ->get();

            }else{

                $this->tramitesAdicionados = Tramite::with('predios.propietarios.persona')
                                                    ->whereHas('servicio', function ($q) {
                                                        $q->where('nombre', $this->servicio['nombre']);
                                                    })
                                                    ->where('estado', 'pagado')
                                                    ->get();

            }
        }

        /* $this->updatedModeloEditarTipoTramite(); */

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

                $this->dispatch('mostrarMensaje', ['error', "No tiene permiso para elaborar trámites exentos."]);

                $this->modelo_editar->tipo_tramite = 'normal';

                return;

            }

            $this->modelo_editar->monto = 0;

        }elseif($this->modelo_editar->tipo_tramite == 'complemento'){

            if($this->tramiteAdicionado){

                $this->modelo_editar->monto = abs($this->modelo_editar->monto - (float)$this->tramiteAdicionado['monto']);

                $this->resetearInformacion();

            }else{

                $this->dispatch('mostrarMensaje', ['error', "Para el complemento es necesario seleccione el tramite al que adiciona."]);

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

            $this->flags['dependencias'] = true;
            $this->flags['numero_oficio'] = true;

        }elseif($this->modelo_editar->solicitante == "S.T.A.S.P.E."){

            $this->modelo_editar->nombre_solicitante = $this->modelo_editar->solicitante;
            $this->modelo_editar->tipo_servicio = "extra_urgente";

        }else{

            $this->modelo_editar->nombre_solicitante = $this->modelo_editar->solicitante;

        }

        $this->updatedModeloEditarTipoServicio();

    }

    public function resetearInformacion(){

        $this->reset(['predios', 'predio', 'localidad', 'tipo', 'registro']);

        $this->modelo_editar->adiciona = $this->tramiteAdicionado['id'];

        $this->modelo_editar->solicitante = $this->tramiteAdicionado['solicitante'];

        $this->modelo_editar->nombre_solicitante = $this->tramiteAdicionado['nombre_solicitante'];

        $this->modelo_editar->cantidad = $this->tramiteAdicionado['cantidad'];

        $this->modelo_editar->observaciones = $this->tramiteAdicionado['observaciones'];

        foreach($this->tramiteAdicionado['predios'] as $predio){

            array_push($this->predios, $predio);

        }

        $this->modelo_editar->cantidad = count($this->predios);

    }

    public function cambiarFlags($servicio){

        $this->resetearTodo();

        $this->servicio = $servicio;

        if($servicio['nombre'] == 'Certificado negativo catastral'){

            $this->flags['predios'] = false;

        }elseif(in_array($servicio['nombre'], $this->certificados_historia)){

            $this->flags['predios'] = false;

            $this->flags['solicitante'] = false;

        }elseif($servicio['nombre'] == 'Certificado de historia catastral'){

            $this->flags['adiciona'] = false;

        }

        $this->modelo_editar = $this->crearModeloVacio();

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
    }

    public function crear(){

        $this->validate(array_merge($this->rules(), $this->validaciones()));

        try {

            DB::transaction(function () {

                $tramite = (new TramiteService($this->modelo_editar))->crearTramite($this->predios);

                if(in_array($this->servicio['nombre'], $this->certificados_historia)){

                    $tramite->adicionaA->update(['parcial_usado' => $tramite->id]);

                }

                $this->dispatch('imprimir_recibo', ['tramite' => $tramite->id]);

                $this->resetearTodo();

                $this->dispatch('reset');

                $this->dispatch('mostrarMensaje', ['success', "El trámite se creó con éxito."]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al crear trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', $th->getMessage()]);
        }

    }

    public function actualizar(){

        $this->validate(array_merge($this->rules(), $this->validaciones()));

        try {

            DB::transaction(function () {

                (new TramiteService($this->modelo_editar))->actualizarTramite($this->predios);

                $this->resetearTodo();

                $this->dispatch('mostrarMensaje', ['success', "El trámite se actualizó con éxito."]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al actualizar trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', $th->getMessage()]);
        }

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

        $this->solicitantes = Constantes::SOLICITANTES;

        $this->dependencias = Dependencia::orderBy('nombre')->get();

        $this->notarias = Notaria::orderBy('numero')->get();

        $this->cambiarFlags($this->servicio);

    }

    public function render()
    {
        return view('livewire.ventanilla.certificaciones');
    }
}
