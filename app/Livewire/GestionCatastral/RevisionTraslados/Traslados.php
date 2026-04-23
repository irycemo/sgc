<?php

namespace App\Livewire\GestionCatastral\RevisionTraslados;

use App\Models\Oficina;
use App\Models\Traslado;
use App\Models\User;
use App\Services\SistemaTramitesLinea\SistemaTramitesLineaService;
use App\Traits\ComponentesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Traslados extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public Traslado $modelo_editar;

    public $estado = '';
    public $modalReasignar = false;
    public $modalRechazos = false;
    public $modal_revertir = false;
    public $flag_operado = false;
    public $flag_rechazado = false;
    public $flag_autorizado = false;

    public $fiscales = [];
    public $fiscal;
    public $oficinas;
    public $oficina;

    public $observaciones;

    public $filters = [
        'localidad' => '',
        'oficina' => '',
        'tipo' => '',
        'registro' => '',
        'año_aviso' => '',
        'folio_aviso' => '',
        'usuario_aviso' => '',
    ];

    protected function rules(){
        return [
            'modelo_editar.asignado_a' => 'required'
         ];
    }

    protected $validationAttributes  = [
        'modelo_editar.asignado_a' => 'fiscal'
    ];

    public function updatedFilters() { $this->resetPage(); }

    public function crearModeloVacio(){
        $this->modelo_editar =  Traslado::make();
    }

    public function abrirModalReasignar(Traslado $traslado){

        $this->modelo_editar = $traslado;

        $this->modelo_editar->load('rechazos.creadoPor');

        $this->fiscales = User::whereHas('oficina', function($q) {
                                    $q->where('oficina', $this->modelo_editar->predio->oficina);
                                })
                                ->when($this->modelo_editar->predio->oficina == 101, function($q){
                                    $q->whereHas('roles', function($q){
                                        $q->where('name', 'Fiscal');
                                    });
                                })
                                ->get();

        $this->modalReasignar = true;

    }

    public function abrirModalRechazos(Traslado $traslado){

        $this->modelo_editar = $traslado;

        $this->modelo_editar->load('rechazos.creadoPor');

        $this->modalRechazos = true;

    }

    public function abrirModalRevertir(Traslado $traslado, $estado){

        $this->reset(['flag_operado', 'flag_autorizado', 'flag_rechazado']);

        if($estado === 'operado'){

            $this->flag_operado = true;

        }elseif($estado === 'rechazo'){

            $this->flag_rechazado = true;

        }elseif($estado === 'autorizado'){

            $this->flag_autorizado = true;

        }

        $this->modelo_editar = $traslado;

        $this->modelo_editar->load('rechazos.creadoPor');

        $this->modal_revertir = true;

    }

    public function reasignarFiscal(){

        $this->validate();

        try {

            $this->modelo_editar->actualizado_por = auth()->id();
            $this->modelo_editar->save();

            $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Reasignó aviso']);

            $this->modalReasignar = false;

            $this->dispatch('mostrarMensaje', ['success', "Se reasigno el fiscal con éxito."]);

        } catch (\Throwable $th) {
            Log::error("Error al reasignar fiscal por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    public function revertirOperado(){

        $this->validate(['observaciones' => 'required']);

        try {

            DB::transaction(function () {

                $this->modelo_editar->update([
                    'estado' => 'autorizado',
                    'actualizado_por' => auth()->id()
                ]);

                $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Revistiro operación de aviso']);

                (new SistemaTramitesLineaService())->revertirAviso($this->modelo_editar->aviso_stl, $this->observaciones);

            });

            $this->modal_revertir = false;

            $this->dispatch('mostrarMensaje', ['success', "Se revirtio a esto autorizado con éxito."]);

        } catch (\Throwable $th) {
            Log::error("Error al revertir a autorizado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    public function revertirRechazo(){

        $this->validate(['observaciones' => 'required']);

        try {

            DB::transaction(function () {

                $this->modelo_editar->update([
                    'estado' => 'cerrado',
                    'actualizado_por' => auth()->id()
                ]);

                $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Revirtió rechazo de aviso']);

                (new SistemaTramitesLineaService())->revertirRechazo($this->modelo_editar->aviso_stl, $this->observaciones);

            });

            $this->modal_revertir = false;

            $this->dispatch('mostrarMensaje', ['success', "Se revirtio a esto cerrado con éxito."]);

        } catch (\Throwable $th) {
            Log::error("Error al revertir rechazo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    public function revertirAutorizado(){

        $this->validate(['observaciones' => 'required']);

        try {

            DB::transaction(function () {

                $this->modelo_editar->update([
                    'estado' => 'cerrado',
                    'actualizado_por' => auth()->id()
                ]);

                $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Revirtió autorización de aviso']);

                (new SistemaTramitesLineaService())->revertirAutorizado($this->modelo_editar->aviso_stl, $this->observaciones);

            });

            $this->modal_revertir = false;

            $this->dispatch('mostrarMensaje', ['success', "Se revirtio a esto cerrado con éxito."]);

        } catch (\Throwable $th) {
            Log::error("Error al revertir autorizado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    #[Computed]
    public function traslados(){

        if(auth()->user()->hasRole(['Administrador', 'Jefe de departamento'])){

            return Traslado::select('id','estado', 'año_aviso', 'folio_aviso', 'usuario_aviso', 'predio_id', 'entidad_nombre', 'asignado_a', 'actualizado_por', 'created_at', 'updated_at')
                                ->with('actualizadoPor:id,name', 'asignadoA:id,name', 'predio:id,localidad,oficina,tipo_predio,numero_registro')
                                ->withCount(['rechazos'])
                                ->when($this->estado && $this->estado != '', fn($q, $estado) => $q->where('estado', $this->estado))
                                ->when($this->oficina, function($q) {
                                    $q->whereHas('predio', function($q) {
                                        $q->select('id','oficina')->where('oficina', $this->oficina);
                                    });
                                })
                                ->when($this->oficina, function($q) {
                                    $q->whereHas('predio', function($q) {
                                        $q->where('oficina', $this->oficina);
                                    });
                                })
                                ->when($this->filters['localidad'], function($q, $localidad){
                                    $q->WhereHas('predio', function($q) use($localidad){
                                        $q->where('localidad', $localidad);
                                    });
                                })
                                ->when($this->filters['oficina'], function($q, $oficina){
                                    $q->WhereHas('predio', function($q) use($oficina){
                                        $q->where('oficina', $oficina);
                                    });
                                })
                                ->when($this->filters['tipo'], function($q, $t_predio){
                                    $q->WhereHas('predio', function($q) use($t_predio){
                                        $q->where('tipo_predio', $t_predio);
                                    });
                                })
                                ->when($this->filters['registro'], function($q, $registro){
                                    $q->WhereHas('predio', function($q) use($registro){
                                        $q->where('numero_registro', $registro);
                                    });
                                })
                                ->when($this->filters['año_aviso'], function($q, $año_aviso){
                                    $q->WhereHas('predio', function($q) use($año_aviso){
                                        $q->where('año_aviso', $año_aviso);
                                    });
                                })
                                ->when($this->filters['folio_aviso'], function($q, $folio_aviso){
                                    $q->WhereHas('predio', function($q) use($folio_aviso){
                                        $q->where('folio_aviso', $folio_aviso);
                                    });
                                })
                                ->when($this->filters['usuario_aviso'], function($q, $usuario_aviso){
                                    $q->WhereHas('predio', function($q) use($usuario_aviso){
                                        $q->where('usuario_aviso', $usuario_aviso);
                                    });
                                })
                                ->where('entidad_nombre', 'LIKE', '%' . $this->search . '%')
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);


        }else{

            return Traslado::select('id','estado', 'año_aviso', 'folio_aviso', 'usuario_aviso', 'predio_id', 'entidad_nombre', 'asignado_a', 'actualizado_por', 'created_at', 'updated_at')
                                ->with('actualizadoPor:id,name', 'asignadoA:id,name', 'predio:id,localidad,oficina,tipo_predio,numero_registro')
                                ->withCount(['rechazos'])
                                ->when($this->estado && $this->estado != '', fn($q, $estado) => $q->where('estado', $this->estado))
                                ->where('entidad_nombre', 'LIKE', '%' . $this->search . '%')
                                ->where('asignado_a', auth()->id())
                                ->when($this->oficina, function($q) {
                                    $q->whereHas('predio', function($q) {
                                        $q->where('oficina', $this->oficina);
                                    });
                                })
                                ->when($this->filters['localidad'], function($q, $localidad){
                                    $q->WhereHas('predio', function($q) use($localidad){
                                        $q->where('localidad', $localidad);
                                    });
                                })
                                ->when($this->filters['oficina'], function($q, $oficina){
                                    $q->WhereHas('predio', function($q) use($oficina){
                                        $q->where('oficina', $oficina);
                                    });
                                })
                                ->when($this->filters['tipo'], function($q, $t_predio){
                                    $q->WhereHas('predio', function($q) use($t_predio){
                                        $q->where('tipo_predio', $t_predio);
                                    });
                                })
                                ->when($this->filters['registro'], function($q, $registro){
                                    $q->WhereHas('predio', function($q) use($registro){
                                        $q->where('numero_registro', $registro);
                                    });
                                })
                                ->when($this->filters['año_aviso'], function($q, $año_aviso){
                                    $q->WhereHas('predio', function($q) use($año_aviso){
                                        $q->where('año_aviso', $año_aviso);
                                    });
                                })
                                ->when($this->filters['folio_aviso'], function($q, $folio_aviso){
                                    $q->WhereHas('predio', function($q) use($folio_aviso){
                                        $q->where('folio_aviso', $folio_aviso);
                                    });
                                })
                                ->when($this->filters['usuario_aviso'], function($q, $usuario_aviso){
                                    $q->WhereHas('predio', function($q) use($usuario_aviso){
                                        $q->where('usuario_aviso', $usuario_aviso);
                                    });
                                })
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);


        }

    }

    public function mount(){

        $this->estado = request()->query('estado');

        $this->crearModeloVacio();

        $this->oficinas = Oficina::select('id', 'nombre', 'oficina')->where('cabecera', null)->orderBy('oficina')->get();

        $this->sort = 'created_at';

        $this->direction = 'asc';


    }

    public function render()
    {
        return view('livewire.gestion-catastral.revision-traslados.traslados')->extends('layouts.admin');
    }

}
