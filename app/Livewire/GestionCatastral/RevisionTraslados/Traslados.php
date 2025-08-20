<?php

namespace App\Livewire\GestionCatastral\RevisionTraslados;

use App\Models\User;
use App\Models\Oficina;
use Livewire\Component;
use App\Models\Traslado;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;

class Traslados extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public Traslado $modelo_editar;

    public $estado = 'cerrado';
    public $modalReasignar = false;
    public $modalRechazos = false;

    public $fiscales = [];
    public $fiscal;
    public $oficinas;
    public $oficina;

    protected function rules(){
        return [
            'modelo_editar.asignado_a' => 'required'
         ];
    }

    protected $validationAttributes  = [
        'modelo_editar.asignado_a' => 'fiscal'
    ];

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

    public function abrirModalRechazos(Traslado $traslado){

        $this->modelo_editar = $traslado;

        $this->modelo_editar->load('rechazos.creadoPor');

        $this->modalRechazos = true;

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

    #[Computed]
    public function traslados(){

        if(auth()->user()->hasRole(['Administrador', 'Jefe de departamento'])){

            return Traslado::with('actualizadoPor', 'asignadoA', 'predio')
                                ->when($this->estado, fn($q, $estado) => $q->where('estado', $estado))
                                ->when($this->oficina, function($q) {
                                    $q->whereHas('predio', function($q) {
                                        $q->where('oficina', $this->oficina);
                                    });
                                })
                                ->where('entidad_nombre', 'LIKE', '%' . $this->search . '%')
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);


        }else{

            return Traslado::with('actualizadoPor', 'asignadoA', 'predio')
                                ->when($this->estado, fn($q, $estado) => $q->where('estado', $estado))
                                ->where('entidad_nombre', 'LIKE', '%' . $this->search . '%')
                                ->where('asignado_a', auth()->id())
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);


        }

    }

    public function mount(){

        $this->crearModeloVacio();

        $this->oficinas = Oficina::select('id', 'nombre', 'oficina')->where('cabecera', null)->orderBy('oficina')->get();

    }

    public function render()
    {
        return view('livewire.gestion-catastral.revision-traslados.traslados')->extends('layouts.admin');
    }
}
