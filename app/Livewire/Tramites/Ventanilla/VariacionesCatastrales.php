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
    public $porcentaje;

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
            'modelo_editar.usuario_tramites_linea_id' => 'nullable',
            'modelo_editar.observaciones' => Rule::requiredIf($this->modelo_editar->tipo_tramite === "exento"),
            'modelo_editar.numero_oficio' => Rule::requiredIf(
                                                                $this->modelo_editar->solicitante == 'Oficialia de partes' ||
                                                                $this->modelo_editar->solicitante == 'Escrituración social'
                                                            ),
            'predios' => 'required'
        ];

    }

    public function agregarPredio(){

        if(count($this->predios)){

            $this->dispatch('mostrarMensaje', ['warning', "Solo es posible agregar 1 predio."]);

            return;

        }

        if($this->porcentaje){

            $monto =  $this->predio->valor_catastral * $this->porcentaje / 100;

        }else{

            $monto =  $this->predio->valor_catastral;

        }

        if($monto > $this->umas){

            $this->dispatch('mostrarMensaje', ['warning', "El valor catastral excede las 5000 umas."]);

            return;

        }

        $this->modelo_editar->cantidad = 1;

        $this->modelo_editar->monto = $monto;

        if($this->porcentaje){

            $this->modelo_editar->observaciones = 'Calificación de variación catastral del predio: ' . $this->predio->cuentaPredial() . ' conciderando el porcentaje: ' . $this->porcentaje  . '% del valor catastral: $' . number_format($this->predio->valor_catastral, 2);

        }

        $this->updatedModeloEditarTipoServicio();

        $this->predio = null;

    }

    public function mount(){

        $this->cargaInicial($this->servicio);

        $uma_actual = Uma::where('año', now()->format('Y'))->first();

        if(! $uma_actual){

            abort(403, 'No se tiene el valor de la Uma actual.');

        }

        $this->umas = $uma_actual->diario * 5000;

    }

    public function render()
    {
        return view('livewire.tramites.ventanilla.variaciones-catastrales');
    }
}
