<?php

namespace App\Livewire\Comun;

use App\Models\Avaluo;
use App\Models\Predio;
use Livewire\Component;
use App\Models\Propietario;
use Livewire\Attributes\On;
use App\Models\PredioAvaluo;
use Illuminate\Support\Facades\Log;

class Propietarios extends Component
{

    public $predio;
    public $avaluo_id;
    public $editar_propietarios = true;
    public $modal_porcentajes = false;
    public $propietario;
    public $porcentaje_propiedad = 0;
    public $porcentaje_nuda = 0;
    public $porcentaje_usufructo = 0;

    protected $listeners = ['refresh'];

    #[On('cargarPredio')]
    public function cargarPredioAvaluo($id){

        $this->predio = PredioAvaluo::with('propietarios.persona')->find($id);

        if($this->predio->avaluo->predio){

            $this->editar_propietarios = false;

        }

        $this->dispatch('cargarModelo', [get_class($this->predio), $this->predio->id]);

    }

    #[On('cargarPredioPadron')]
    public function cargarPredioPadron($id){

        $this->predio = Predio::with('propietarios.persona')->find($id);

        $this->dispatch('cargarModelo', [get_class($this->predio), $this->predio->id]);

    }

    public function abrirModalPorcentajes(Propietario $modelo){

        $this->propietario = $modelo;

        $this->modal_porcentajes = true;

        $this->porcentaje_propiedad = $this->propietario->porcentaje_propiedad;
        $this->porcentaje_nuda = $this->propietario->porcentaje_nuda;
        $this->porcentaje_usufructo = $this->propietario->porcentaje_usufructo;

    }

    public function atualizarPorcentajes(){

        $this->validate([
            'porcentaje_propiedad' => 'nullable|numeric|min:0|max:100',
            'porcentaje_nuda' => 'nullable|numeric|min:0|max:100',
            'porcentaje_usufructo' => 'nullable|numeric|min:0|max:100',
        ]);

        try {

            $this->propietario->update([
                'porcentaje_propiedad' => $this->porcentaje_propiedad,
                'porcentaje_nuda' => $this->porcentaje_nuda,
                'porcentaje_usufructo' => $this->porcentaje_usufructo,
            ]);

            $this->predio->touch();

            $this->predio->audits()->latest()->first()?->update(['tags' => 'Actualizó porcentajes de propiedad']);

            $this->predio->refresh();

            $this->predio->load('propietarios.persona');

            $this->modal_porcentajes = false;

        } catch (\Throwable $th) {

            Log::error("Error al actualizar porcentajes de propiedad por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function refresh(){

        $this->predio->load('propietarios.persona');

    }

    public function borrarActor(Propietario $propietario){

        try {

            $persona_id = $propietario->persona_id;

            $propietario->delete();

            $this->dispatch('mostrarMensaje', ['success', "La información se eliminó con éxito."]);

            $this->predio->touch();

            $this->predio->audits()->latest()->first()?->update(['tags' => 'Borro propietario  persona_id:' . $persona_id]);

            $this->predio->refresh();

            $this->predio->load('propietarios.persona');

        } catch (\Throwable $th) {

            Log::error("Error al borrar propietario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        if($this->avaluo_id){

            $avaluo = Avaluo::with('predioAvaluo')->find($this->avaluo_id);

            $this->cargarPredioAvaluo($avaluo->predio_avaluo);

        }

    }

    public function render()
    {
        return view('livewire.comun.propietarios');
    }
}
