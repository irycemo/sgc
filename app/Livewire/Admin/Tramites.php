<?php

namespace App\Livewire\Admin;

use App\Models\Predio;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Servicio;
use Livewire\WithPagination;
use App\Models\Certificacion;
use App\Constantes\Constantes;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
    public $años;

    public $tramties_con_predio = ['DM31', 'DM34', 'D727', 'D728', 'D729', 'D730'];

    public $filters = [
        'search' => '',
        'año' => '',
        'folio' => '',
        'usuario' => '',
        'estado' => '',
        'tipoTramite' => '',
        'servicio' => '',
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

    public function abrirModalVer(Tramite $modelo){

        $this->resetearTodo();
        $this->modalVer = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

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

        try {

            $this->modelo_editar->predios()->attach($this->predio->id);

            $this->modelo_editar->load('predios');

            $this->reset(['predio', 'localidad', 'oficina', 'tipo', 'registro']);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar permisos usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function reactivarPredio($id){

        try {

            DB::transaction(function () use ($id){

                $certificacion = Certificacion::where('tramite_id', $this->modelo_editar->id)->where('predio_id', $id)->first();

                if($certificacion){

                    $certificacion->update(['estado' => 'cancelado']);

                }

                $this->modelo_editar->predios()->updateExistingPivot($id, ['estado' => 'A']);

                if($this->modelo_editar->estado === 'concluido') $this->modelo_editar->update(['estado' => 'pagado']);

                $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Reactivó cuenta predial']);

                $this->modelo_editar->load('predios');

                $this->dispatch('mostrarMensaje', ['warning', "La cuenta predial se reactivó con éxito, si tenia un certificado este ha sido cancelado."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualizar permisos usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function quitarPredio($id){

        try {

            DB::transaction(function () use ($id){

                $certificacion = Certificacion::where('tramite_id', $this->modelo_editar->id)->where('predio_id', $id)->first();

                if($certificacion){

                    $certificacion->update([
                        'estado' => 'cancelado',
                        'actualizado_por' => auth()->id(),
                        'observaciones' => 'Reemplazo'
                    ]);

                }

                $this->modelo_editar->predios()->detach($id);

                $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Eliminó cuenta predial']);

                $this->modelo_editar->load('predios');

                $this->dispatch('mostrarMensaje', ['warning', "La cuenta predial se eliminó con éxito, si tenia un certificado este ha sido cancelado."]);

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

    #[Computed]
    public function tramites(){

        return  Tramite::query()
                        ->select('id', 'año', 'folio', 'usuario', 'estado', 'servicio_id', 'cantidad', 'monto', 'fecha_entrega', 'fecha_pago', 'tipo_tramite', 'tipo_servicio', 'nombre_solicitante', 'creado_por', 'actualizado_por', 'created_at', 'updated_at')
                        ->with('servicio', 'creadoPor', 'actualizadoPor')
                        ->when($this->filters['search'], fn($q, $search) => $q->where('nombre_solicitante', 'LIKE', '%' . $search . '%'))
                        ->when($this->filters['año'], fn($q, $año) => $q->where('año', $año))
                        ->when($this->filters['folio'], fn($q, $folio) => $q->where('folio', $folio))
                        ->when($this->filters['usuario'], fn($q, $usuario) => $q->where('usuario', $usuario))
                        ->when($this->filters['estado'], fn($q, $estado) => $q->where('estado', $estado))
                        ->when($this->filters['tipoTramite'], fn($q, $tipoTramite) => $q->where('tipo_tramite', $tipoTramite))
                        ->when($this->filters['servicio'], fn($q, $servicio) => $q->where('servicio_id', $servicio))
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);

    }

    public function mount(){

        $this->crearModeloVacio();

        array_push($this->fields, 'predios', 'predio', 'localidad', 'oficina', 'tipo', 'registro', 'modalVer');

        $this->servicios = Servicio::select('id', 'nombre')->orderBy('nombre')->get();

        $this->años = Constantes::AÑOS;

        $this->filters['año'] = now()->format('Y');

        $this->oficina = auth()->user()->oficina->oficina;

    }

    public function render()
    {
        return view('livewire.admin.tramites')->extends('layouts.admin');
    }
}
