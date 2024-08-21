<?php

namespace App\Livewire\GestionCatastral\Captura;

use App\Models\Predio;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Constantes\Constantes;
use Illuminate\Support\Facades\Log;

class DeterminacionValor extends Component
{

    public $predio;
    public $predio_id;

    public $acciones_padron;
    public $observaciones;

    protected function rules(){
        return [
            'predio.superficie_terreno' => 'required|numeric',
            'predio.superficie_construccion' => 'nullable|numeric',
            'predio.superficie_judicial' => 'nullable|numeric',
            'predio.superficie_notarial' => 'nullable|numeric',
            'predio.valor_catastral' => 'required|numeric',
            'observaciones' => 'nullable'
        ];
    }

    #[On('cargarPredio')]
    public function cargarPredio($id){

        $this->predio = Predio::with('propietarios.persona')->find($id);

    }

    public function guardar(){

        if(!$this->predio->getKey()){

            $this->dispatch('mostrarMensaje', ['error', "Primero debe cargar el predio."]);

            return;

        }

        try {

            $this->predio->actualizado_por = auth()->id();
            $this->predio->observaciones = $this->observaciones . '. ' . $this->observaciones;
            $this->predio->save();

            $this->predio->audits()->latest()->first()->update(['tags' => 'Actualizó superficies/valor catastral']);

            $this->dispatch('mostrarMensaje', ['success', "La información se guardó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar propietario en pase a folio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        $this->acciones_padron = Constantes::ACCIONES_PADRON;

        if($this->predio_id)
            $this->predio = Predio::find($this->predio_id);
        else
            $this->predio = Predio::make();

    }

    public function render()
    {
        return view('livewire.gestion-catastral.captura.determinacion-valor');
    }
}
