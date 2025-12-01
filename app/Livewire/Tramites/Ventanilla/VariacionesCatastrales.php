<?php

namespace App\Livewire\Tramites\Ventanilla;

use App\Models\Uma;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Traits\Tramties\Ventanilla\ComunTrait;
use App\Traits\Tramties\Ventanilla\PrediosTrait;

class VariacionesCatastrales extends Component
{

    use ComunTrait;
    use PrediosTrait;

    public $umas;

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

    public function agregarPredio(){

        if($this->editar && count($this->predios) >= $this->modelo_editar->cantidad){

            $this->dispatch('mostrarMensaje', ['warning', "Solo es posible agregar " . $this->modelo_editar->cantidad . " predios."]);

            return;

        }

        $colection = collect($this->predios);

        $suma_valor_catastral = $colection->sum('valor_catastral') + $this->predio->valor_catastral;

        if($suma_valor_catastral > $this->umas){

            $this->dispatch('mostrarMensaje', ['warning', "El valor catastral excede las 5000 umas."]);

            return;

        }

        if($colection->contains('id', $this->predio->id)){

            $this->dispatch('mostrarMensaje', ['warning', "La cuenta predial ya esta agregada."]);

        }else{

            array_push($this->predios, $this->predio->toArray());

        }

        $this->predio = null;

        $this->modelo_editar->cantidad = 1;

        $this->updatedModeloEditarTipoServicio();

    }

    public function mount(){

        $this->cargaInicial($this->servicio);

        $this->umas = Uma::where('año', now()->format('Y'))->first()->diario * 5000;

    }

    public function render()
    {
        return view('livewire.tramites.ventanilla.variaciones-catastrales');
    }
}
