<?php

namespace App\Livewire\Admin;

use App\Constantes\Constantes;
use App\Enums\Tramites\AvaluoPara;
use App\Exceptions\GeneralException;
use App\Models\Certificacion;
use App\Models\Predio;
use App\Models\Servicio;
use App\Models\Tramite;
use App\Models\Traslado;
use App\Services\Tramites\TramiteService;
use App\Traits\ComponentesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

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
    public $modalVer = false;
    public $modalObservaciones = false;
    public $modalAcreditar = false;
    public $años;
    public $predio_id;
    public $observaciones;
    public $lista_avaluo_para;
    public $referencia_pago;
    public $fecha_pago;

    public $tramties_con_predio = ['DM31', 'DM34', 'DM32', 'DM35', 'DM30', 'D774', 'D729', 'D728', 'DÑ34', 'DÑ33'];

    public $filters = [
        'search' => '',
        'año' => '',
        'folio' => '',
        'usuario' => '',
        'estado' => '',
        'tipoTramite' => '',
        'servicio' => '',
        'localidad' => '',
        'p_oficina' => '',
        't_predio' => '',
        'registro' => '',
        'estado' => '',
        'linea_captura' => ''
    ];

    public $servicios;

    public Tramite $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.nombre_solicitante' => 'required|string',
            'modelo_editar.observaciones' => 'nullable',
            'predios' => 'nullable'
         ];
    }

    protected $validationAttributes  = [
        'modelo_editar.nombre_solicitante' => 'nombre del solicitante',
        'modelo_editar.numero_oficio' => 'número de oficio',
    ];

    public function updatedFilters() { $this->resetPage(); }

    public function crearModeloVacio(){
        $this->modelo_editar = Tramite::make();
    }

    public function updatedModal(){

        if(!$this->modal){

            $this->resetearTodo();

        }

    }

    public function abrirModalEditar(Tramite $modelo){

        $this->resetearTodo();
        $this->modal = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function abrirModalAcreditar(Tramite $modelo){

        $this->resetearTodo();

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->validarPago();

        $modelo->refresh();

        if(!$modelo->fecha_pago)
            $this->modalAcreditar = true;

    }

    public function abrirModalVer(Tramite $modelo){

        $this->resetearTodo();
        $this->modalVer = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function abrirModalObservacions($id){

        $this->modal = false;

        $this->resetearTodo();

        $this->predio_id = $id;

        $this->modalObservaciones = true;

    }

    public function actualizar(){

        $this->validate();

        try{

            $this->modelo_editar->actualizado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Actualizó información']);

            $this->resetearTodo();

            $this->dispatch('mostrarMensaje', ['success', "El trámite se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
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
            $this->dispatch('mostrarMensaje', ['warning', "La cuenta predial no esta registrada."]);
            return;
        }

    }

    public function agregarPredio(){

        if($this->modelo_editar->cantidad === $this->modelo_editar->predios()->count()){

            $this->dispatch('mostrarMensaje', ['warning', "El trámite ya tiene la cantidad de predios por la que se pagó."]);

            return;

        }

        if($this->modelo_editar->predios()->where('predio_id', $this->predio->id)->first()){

            $this->dispatch('mostrarMensaje', ['warning', "El predio ya esta agregado."]);

            return;

        }

        try {

            $this->modelo_editar->predios()->attach($this->predio->id);

            $this->modelo_editar->load('predios');

            $this->reset(['predio', 'localidad', 'oficina', 'tipo', 'registro']);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar permisos usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function reactivarPredio(){

        try {

            DB::transaction(function (){

                $certificacion = Certificacion::where('tramite_id', $this->modelo_editar->id)->where('predio_id', $this->predio_id)->first();

                if($certificacion){

                    $traslado = Traslado::where(['certificacion_id' => $certificacion->id])->first();

                    if($traslado){

                        throw new GeneralException('El certificado esta ligado a un aviso no es posible reactivarlo.');

                    }

                    $certificacion->update([
                        'estado' => 'cancelado',
                        'observaciones' => $this->observaciones,
                        'actualizado_por' => auth()->id()
                    ]);

                    $certificacion->audits()->latest()->first()->update(['tags' => 'Canceló certificación']);

                }

                $this->modelo_editar->predios()->updateExistingPivot($this->predio_id, ['estado' => 'A']);

                if($this->modelo_editar->estado === 'concluido') $this->modelo_editar->update(['estado' => 'pagado']);

                $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Reactivó cuenta predial']);

                $this->modelo_editar->load('predios');

                $this->dispatch('mostrarMensaje', ['warning', "La cuenta predial se reactivó con éxito, si tenia un certificado este ha sido cancelado."]);

            });

            $this->modalObservaciones = false;

            $this->modal = true;

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar permisos usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function quitarPredio($id){

        try {

            DB::transaction(function () use ($id){

                $this->modelo_editar->predios()->detach($id);

                if($this->modelo_editar->audits()->count()){

                    $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Eliminó cuenta predial']);

                }

                $this->modelo_editar->load('predios');

                $this->dispatch('mostrarMensaje', ['warning', "La cuenta predial se eliminó con éxito."]);

            });


        } catch (\Throwable $th) {

            Log::error("Error al agregar predio a trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function reimprimir(Tramite $tramite){

        $this->js('window.open(\' '. route('tramites.orden', $tramite) . '\', \'_blank\');');

    }

    public function simularPago(){

        try {

            $this->modelo_editar->update([
                'estado' => 'pagado',
                'fecha_pago'  => now()->toDateString(),
                'orden_de_pago'  => '300082157991',
            ]);

            $this->dispatch('mostrarMensaje', ['success', "El pago se simuló con éxito."]);

            $this->resetearTodo();

        } catch (\Throwable $th) {

            Log::error("Error al simular pago de trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function borrar(){

        try{

            $tramite = Tramite::find($this->selected_id);

            if($tramite->estado != 'nuevo'){

                $this->dispatch('mostrarMensaje', ['error', "El trámite no se puede eliminar."]);

                return;

            }

            if($tramite->fecha_pago){

                $this->dispatch('mostrarMensaje', ['error', "El trámite tiene un pago registrado no puede ser borrado."]);

                return;

            }

            if($tramite->predios()->count()){

                $tramite->predios()->detach();

            }

            $tramite->delete();

            $this->modalBorrar = false;

            $this->dispatch('mostrarMensaje', ['success', "El trámite se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function validarPago(){

        try {

            DB::transaction(function () {

                (new TramiteService($this->modelo_editar))->procesarPago();

                $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Validó pago']);

                $this->dispatch('mostrarMensaje', ['success', "El trámite se validó con éxito."]);

                $this->resetearTodo($borrado = true);

            });

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al validar el trámite: " . $this->modelo_editar->año . '-' . $this->modelo_editar->numero_control . '-' . $this->modelo_editar->usuario . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);
            $this->resetearTodo();
        }

    }

    public function acreditarPago(){

        $this->validate(
        [
            'referencia_pago' => 'required|numeric',
            'fecha_pago' => 'required|date|before:tomorrow'
        ],
        [],
        [
            'referencia_pago' => 'referencia de pago',
            'fecha_pago' => 'fecha de pago',
        ]);

        try {

            $this->modelo_editar->update([
                'estado' => 'pagado',
                'documento_de_pago' => $this->referencia_pago,
                'fecha_pago' => $this->fecha_pago,
                'fecha_entrega' => $this->calcularFechaEntrega,
                'actualizado_por' => auth()->id()
            ]);

            $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Acreditó pago manualmente']);

            $this->dispatch('mostrarMensaje', ['success', "El trámite acreditó con éxito. Guardar la documentación que acredita el pago."]);

            $this->resetearTodo();

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al acreditar trámite  por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function calcularFechaEntrega()
    {

        if(in_array($this->modelo_editar->servicio->clave_ingreso, ['D774', 'DM32'])){

            $actual = now();

            return $actual->toDateString();

        }elseif($this->modelo_editar->servicio->nombre == 'Certificado de historia catastral'){

            $actual = $this->modelo_editar->fecha_pago;

            for ($i=0; $i < 9; $i++) {

                $actual->addDays(1);

                while($actual->isWeekend()){

                    $actual->addDay();

                }

            }

            return $actual->toDateString();

        }elseif($this->modelo_editar->tipo_servicio == 'ordinario'){

            $actual = $this->modelo_editar->fecha_pago;

            for ($i=0; $i < 2; $i++) {

                $actual->addDays(1);

                while($actual->isWeekend()){

                    $actual->addDay();

                }

            }

            return $actual->toDateString();

        }

    }

    #[Computed]
    public function tramites(){

        $predio = null;

        if(! empty($this->filters['localidad']) && ! empty($this->filters['p_oficina']) && ! empty($this->filters['t_predio']) && ! empty($this->filters['registro'])){

            $predio = Predio::where('localidad', $this->filters['localidad'])
                                ->where('oficina', $this->filters['p_oficina'])
                                ->where('tipo_predio', $this->filters['t_predio'])
                                ->where('numero_registro', $this->filters['registro'])
                                ->first();

        }

        return  Tramite::query()
                        ->select('id', 'año', 'folio', 'usuario', 'estado', 'documento_de_pago', 'servicio_id', 'cantidad', 'monto', 'fecha_entrega', 'fecha_pago', 'tipo_tramite', 'tipo_servicio', 'nombre_solicitante', 'creado_por', 'actualizado_por', 'created_at', 'updated_at')
                        ->with('servicio:id,nombre', 'creadoPor:id,name', 'actualizadoPor:id,name')
                        ->when(! empty($this->filters['search']), fn($q) => $q->where('nombre_solicitante', 'LIKE', '%' . $this->filters['search'] . '%'))
                        ->when(! empty($this->filters['año']), fn($q) => $q->where('año', $this->filters['año']))
                        ->when(! empty($this->filters['folio']), fn($q) => $q->where('folio', $this->filters['folio']))
                        ->when(! empty($this->filters['usuario']), fn($q) => $q->where('usuario', $this->filters['usuario']))
                        ->when(! empty($this->filters['estado']), fn($q) => $q->where('estado', $this->filters['estado']))
                        ->when(! empty($this->filters['tipoTramite']), fn($q, $tipoTramite) => $q->where('tipo_tramite', $tipoTramite))
                        ->when(! empty($this->filters['servicio']), fn($q, $servicio) => $q->where('servicio_id', $servicio))
                        ->when(! empty($this->filters['linea_captura']) && strlen($this->filters['linea_captura']) == 20, fn($q, $servicio) =>  $q->where('linea_de_captura', $this->filters['linea_captura']))
                        ->when($predio, function($q) use ($predio){
                            $q->whereHas('predios', function($q) use ($predio){
                                $q->where('predio_id', $predio->id);
                            });
                        })
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);

    }

    public function mount(){

        $this->crearModeloVacio();

        array_push($this->fields, 'predios', 'predio', 'localidad', 'oficina', 'tipo', 'registro', 'modalVer', 'modalAcreditar', 'referencia_pago', 'fecha_pago');

        $this->servicios = Servicio::select('id', 'nombre')->where('estado', 'activo')->orderBy('nombre')->get();

        $this->años = Constantes::AÑOS;

        $this->filters['año'] = now()->format('Y');

        $this->oficina = auth()->user()->oficina->oficina;

        $this->lista_avaluo_para = AvaluoPara::cases();

    }

    public function render()
    {
        return view('livewire.admin.tramites')->extends('layouts.admin');
    }

}
