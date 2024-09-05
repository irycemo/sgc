<?php

namespace App\Livewire\GestionCatastral\RevisionTraslados;

use App\Models\User;
use Livewire\Component;
use App\Models\Traslado;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;

class RevisionTraslados extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public Traslado $modelo_editar;

    public $estado = 'cerrado';
    public $modalReasignar = false;

    public $fiscales = [];
    public $fiscal;

    public function crearModeloVacio(){
        $this->modelo_editar =  Traslado::make();
    }

    public function abrirModalReasignar(Traslado $traslado){

        $this->modelo_editar = $traslado;

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

    public function reasignarFiscal(){

        try {

            $this->modelo_editar->actualizado_por = auth()->id();
            $this->modelo_editar->save();

            $this->modalReasignar = false;

            $this->dispatch('mostrarMensaje', ['success', "Se reasigno el fiscal con éxito."]);

        } catch (\Throwable $th) {
            Log::error("Error al crear permiso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    public function render()
    {


        if(auth()->user()->hasRole('Administrador')){

            $traslados = Traslado::with('actualizadoPor', 'asignadoA', 'predio')
                                ->when($this->estado, fn($q, $estado) => $q->where('estado', $estado))
                                ->where('entidad_nombre', 'LIKE', '%' . $this->search . '%')
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);


        }else{

            $traslados = Traslado::with('actualizadoPor', 'asignadoA', 'predio')
                                ->when($this->estado, fn($q, $estado) => $q->where('estado', $estado))
                                ->where('entidad_nombre', 'LIKE', '%' . $this->search . '%')
                                ->where('asignado_a', auth()->id())
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);


        }


        return view('livewire.gestion-catastral.revision-traslados.revision-traslados', compact('traslados'))->extends('layouts.admin');
    }
}
