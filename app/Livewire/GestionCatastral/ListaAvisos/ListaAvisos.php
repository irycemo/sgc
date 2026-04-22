<?php

namespace App\Livewire\GestionCatastral\ListaAvisos;

use App\Models\Oficina;
use App\Models\Traslado;
use App\Models\User;
use App\Traits\ComponentesTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ListaAvisos extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public Traslado $modelo_editar;

    public $estado = '';
    public $modalReasignar = false;
    public $modalRechazos = false;

    public $fiscales = [];
    public $fiscal;
    public $oficinas;
    public $oficina;

    public $filters = [
        'localidad' => '',
        'oficina' => '',
        'tipo' => '',
        'registro' => '',
        'año_aviso' => '',
        'folio_aviso' => '',
        'usuario_aviso' => '',
        'usuario_asignado' => '',
    ];

    protected function rules(){
        return [];
    }

    public function updatedFilters() { $this->resetPage(); }

    public function crearModeloVacio(){
        $this->modelo_editar =  Traslado::make();
    }

    public function abrirModalRechazos(Traslado $traslado){

        $this->modelo_editar = $traslado;

        $this->modelo_editar->load('rechazos.creadoPor');

        $this->modalRechazos = true;

    }

    public function reasignarFiscal(Traslado $traslado){

        try {

            $traslado->asignado_a = auth()->id();
            $traslado->actualizado_por = auth()->id();
            $traslado->save();

            $traslado->audits()->latest()->first()->update(['tags' => 'Reasignó aviso']);

            $this->dispatch('mostrarMensaje', ['success', "Se reasigno el fiscal con éxito."]);

        } catch (\Throwable $th) {
            Log::error("Error al reasignar fiscal por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
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
                                ->when($this->filters['usuario_asignado'] && $this->filters['usuario_asignado'] != '', fn($q) => $q->where('asignado_a', $this->filters['usuario_asignado']))
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

            return Traslado::select('id','estado','año_aviso', 'folio_aviso', 'usuario_aviso', 'predio_id', 'entidad_nombre', 'asignado_a', 'actualizado_por', 'created_at', 'updated_at')
                                ->with('actualizadoPor:id,name', 'asignadoA:id,name', 'predio:id,localidad,oficina,tipo_predio,numero_registro')
                                ->withCount(['rechazos'])
                                ->when($this->estado && $this->estado != '', fn($q, $estado) => $q->where('estado', $this->estado))
                                ->when($this->filters['usuario_asignado'] && $this->filters['usuario_asignado'] != '', fn($q) => $q->where('asignado_a', $this->filters['usuario_asignado']))
                                ->where('entidad_nombre', 'LIKE', '%' . $this->search . '%')
                                /* ->where('oficina_id', auth()->user()->oficina_id) */
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

        $this->fiscales = User::whereHas('roles', function($q){
                                    $q->where('name', 'Fiscal');
                                })
                                ->orderBy('name')
                                ->get();

    }

    public function render()
    {
        return view('livewire.gestion-catastral.lista-avisos.lista-avisos')->extends('layouts.admin');
    }
}
