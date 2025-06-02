<?php

namespace App\Livewire\Tramites\Ventanilla;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Enums\Tramites\AvaluoPara;
use App\Traits\Tramties\Ventanilla\ComunTrait;

class InspeccionOcular extends Component
{

    use ComunTrait;

    public $lista_avaluo_para;

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
            'modelo_editar.avaluo_para' => 'required',
            'modelo_editar.observaciones' => Rule::requiredIf($this->modelo_editar->tipo_tramite === "exento"),
            'modelo_editar.numero_oficio' => Rule::requiredIf(
                                                                $this->modelo_editar->solicitante == 'Oficialia de partes' ||
                                                                $this->modelo_editar->solicitante == 'Escrituración social'
                                                            ),
            ];

    }

    public function mount(){

        $this->lista_avaluo_para = AvaluoPara::cases();

        $this->cargaInicial($this->servicio);

    }

    public function render()
    {
        return view('livewire.tramites.ventanilla.inspeccion-ocular');
    }
}
