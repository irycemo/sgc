<?php

namespace App\Livewire\Tramites\Ventanilla;

use App\Models\Tramite;
use App\Traits\Tramties\Ventanilla\ComunTrait;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Complemento extends Component
{

    use ComunTrait;

    protected function rules(){

        return [
            'modelo_editar.tipo_tramite' => 'required',
            'modelo_editar.servicio_id' => 'required',
            'modelo_editar.solicitante' => 'required',
            'modelo_editar.nombre_solicitante' => 'required',
            'modelo_editar.monto' => 'required',
            'modelo_editar.tipo_servicio' => 'required',
            'modelo_editar.cantidad' => 'required|numeric',
            'modelo_editar.ligado_a' => 'required',
            'modelo_editar.observaciones' => Rule::requiredIf($this->modelo_editar->tipo_tramite === "exento"),
            'modelo_editar.numero_oficio' => Rule::requiredIf(
                                                                $this->modelo_editar->solicitante == 'Oficialia de partes' ||
                                                                $this->modelo_editar->solicitante == 'Escrituración social'
                                                            ),
        ];

    }

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

        $this->flags['adiciona'] = true;

    }


    public function render()
    {
        return view('livewire.tramites.ventanilla.complemento');
    }
}
