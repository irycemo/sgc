<?php

namespace App\Livewire\Tramites\Ventanilla;

use App\Traits\Tramties\Ventanilla\ComunTrait;
use App\Traits\Tramties\Ventanilla\PrediosTrait;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Completo extends Component
{

    use ComunTrait;
    use PrediosTrait;

    protected function rules(){

        return [
            'modelo_editar.tipo_tramite' => 'required',
            'modelo_editar.servicio_id' => 'required',
            'modelo_editar.solicitante' => 'required',
            'modelo_editar.nombre_solicitante' => 'required',
            'modelo_editar.monto' => 'required',
            'modelo_editar.tipo_servicio' => 'required',
            'modelo_editar.cantidad' => 'required|numeric',
            'modelo_editar.adiciona' => 'required_if:adicionaTramite,true',
            'modelo_editar.observaciones' => Rule::requiredIf($this->modelo_editar->tipo_tramite === "exento"),
            'modelo_editar.numero_oficio' => Rule::requiredIf(
                                                                $this->modelo_editar->solicitante == 'Oficialia de partes' ||
                                                                $this->modelo_editar->solicitante == 'Escrituración social'
                                                            ),
            'predios' => 'required'
        ];

    }

    public function updatedAdicionaTramite(){

        return;

        $this->modelo_editar->adiciona = null;

        if(!$this->adicionaTramite){

            $this->reset(['tramiteAdicionadoSeleccionado', 'tramiteAdicionado', 'flags']);

            $this->modelo_editar->adiciona = null;
            $this->modelo_editar->tipo_tramite = 'normal';

        }else{

            $this->reset('flags');

        }

    }

    public function mount(){

        $this->cargaInicial($this->servicio);

    }

    public function render()
    {
        return view('livewire.tramites.ventanilla.completo');
    }
}
