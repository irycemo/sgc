<?php

namespace App\Livewire\GestionCatastral\Requerimientos;

use App\Models\Oficina;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Requerimiento;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Requerimientos extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public Requerimiento $modelo_editar;

    public $oficina;
    public $oficinas;

    public $estado = '';
    public $modalReasignar = false;
    public $modalRechazos = false;

    public $observacion;

    public $filters = [
        'estado' => '',
    ];

    protected function rules(){
        return [
            'observacion' => 'required'
         ];
    }

    public function crearModeloVacio(){
        $this->modelo_editar =  Requerimiento::make();
    }

    public function abrirModalRequerimiento(Requerimiento $requerimiento){

        $this->modelo_editar = $requerimiento;

        $this->modelo_editar->load('requerimientos.creadoPor');

        $this->modal = true;

    }

    public function responder(){

        $this->validate();

        try {

            DB::transaction(function (){

                Requerimiento::create([
                    'requerimientoable_id' => $this->oficina,
                    'requerimientoable_type' => 'App\Models\Oficina',
                    'descripcion' => $this->observacion,
                    'creado_por' => auth()->id(),
                    'estado' => $string ?? 'respuesta',
                    'requerimiento_id' => $this->modelo_editar->id
                ]);

                foreach ($this->modelo_editar->requerimientos as $requerimiento) {

                    if($requerimiento->estado == 'nuevo'){

                        $requerimiento->update(['estado' => 'atendido']);

                    }

                }

            });

            $this->dispatch('mostrarMensaje', ['success', "El requerimiento ha sido atendido."]);

            $this->reset(['modal','observacion']);

        } catch (\Throwable $th) {

            Log::error("Error atender requerimiento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function finalizar(){

        try {

            DB::transaction(function () {

                $this->modelo_editar->update(['estado' => 'finalizado']);

                foreach ($this->modelo_editar->requerimientos as $requerimiento) {

                    $requerimiento->update(['estado' => 'finalizado']);

                }

            });

            $this->dispatch('mostrarMensaje', ['success', "El requerimiento ha sido atendido."]);

            $this->reset(['modal','observacion']);

        } catch (\Throwable $th) {

            Log::error("Error atender requerimiento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    #[Computed]
    public function requerimientos(){

        if(auth()->user()->hasRole(['Administrador', 'Jefe de departamento'])){

            return Requerimiento::with('creadoPor:id,name')
                                ->where('requerimientoable_id', $this->oficina)
                                ->where('requerimientoable_type', 'App\Models\Oficina')
                                ->whereNull('requerimiento_id')
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);


        }else{

            return Requerimiento::with('creadoPor:id,name')
                                ->where('requerimientoable_id', auth()->user()->oficina_id)
                                ->where('requerimientoable_type', 'App\Models\Oficina')
                                ->whereNull('requerimiento_id')
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);


        }

    }

    public function mount(){

        $this->oficina = request()->query('oficina');

        $this->oficinas = Oficina::select('id', 'nombre')->orderBy('nombre')->get();

        $this->crearModeloVacio();

    }

    public function render()
    {
        return view('livewire.gestion-catastral.requerimientos.requerimientos')->extends('layouts.admin');
    }

}
