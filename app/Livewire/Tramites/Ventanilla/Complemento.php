<?php

namespace App\Livewire\Tramites\Ventanilla;

use App\Models\Tramite;
use App\Traits\Tramties\Ventanilla\ComunTrait;
use Livewire\Component;

class Complemento extends Component
{

    use ComunTrait;

    public function buscarTramiteAdiciona(){

        $this->validate([
            'tramite_adiciona_año' => 'required',
            'tramite_adiciona_folio' => 'required',
            'tramite_adiciona_usuario' => 'required',
        ]);

        $this->tramiteAdicionado = Tramite::where('año', $this->tramite_adiciona_año)
                                        ->where('folio', $this->tramite_adiciona_folio)
                                        ->where('usuario', $this->tramite_adiciona_usuario)
                                        ->first();

        if(!$this->tramiteAdicionado){

            $this->dispatch('mostrarMensaje', ['warning', "No se encontro el trámite."]);

            $this->modelo_editar->ligado_a = null;

            return;

        }

        $this->modelo_editar->ligado_a = $this->tramiteAdicionado->id;

    }

    public function mount(){

        $this->cargaInicial($this->servicio);

        $this->tramite_adiciona_año = now()->format('Y');

    }


    public function render()
    {
        return view('livewire.tramites.ventanilla.complemento');
    }
}
