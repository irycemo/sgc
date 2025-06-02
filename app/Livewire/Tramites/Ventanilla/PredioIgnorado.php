<?php

namespace App\Livewire\Tramites\Ventanilla;

use App\Models\PredioAvaluo;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Traits\Tramties\Ventanilla\ComunTrait;

class PredioIgnorado extends Component
{

    use ComunTrait;

    public $predio_avaluo;

    public $region_catastral;
    public $municipio;
    public $zona_catastral;
    public $sector;
    public $localidad;
    public $predio;
    public $manzana;
    public $edificio;
    public $departamento;

    protected function rules(){

        return [
            'modelo_editar.tipo_tramite' => 'required',
            'modelo_editar.servicio_id' => 'required',
            'modelo_editar.solicitante' => 'required',
            'modelo_editar.nombre_solicitante' => 'required',
            'modelo_editar.monto' => 'required',
            'modelo_editar.tipo_servicio' => 'required',
            'modelo_editar.cantidad' => 'required|numeric',
            'modelo_editar.predio_avaluo' => Rule::requiredIf($this->servicio['nombre'] == 'Inscripción o registro de predios ignorados'),
            'modelo_editar.adiciona' => 'required_if:adicionaTramite,true',
            'modelo_editar.observaciones' => Rule::requiredIf($this->modelo_editar->tipo_tramite === "exento"),
            'modelo_editar.numero_oficio' => Rule::requiredIf(
                                                                $this->modelo_editar->solicitante == 'Oficialia de partes' ||
                                                                $this->modelo_editar->solicitante == 'Escrituración social'
                                                            ),
            ];

    }

    public function buscarPredio(){

        $this->validate([
            'region_catastral' => 'required',
            'municipio' => 'required',
            'zona_catastral' => 'required',
            'sector' => 'required',
            'localidad' => 'required',
            'predio' => 'required',
            'manzana' => 'required',
            'edificio' => 'required',
            'departamento' => 'required',
        ]);

        $this->predio_avaluo = PredioAvaluo::where('estado', 16)
                                    ->where('region_catastral', $this->region_catastral)
                                    ->where('municipio', $this->municipio)
                                    ->where('zona_catastral', $this->zona_catastral)
                                    ->where('sector', $this->sector)
                                    ->where('localidad', $this->localidad)
                                    ->where('predio', $this->predio)
                                    ->where('manzana', $this->manzana)
                                    ->where('edificio', $this->edificio)
                                    ->where('departamento', $this->departamento)
                                    ->first();

        if(!$this->predio_avaluo){

            $this->dispatch('mostrarMensaje', ['warning', 'No existe el predio con la clave catastral ingresada.']);

            return;
        }

        if(!$this->predio_avaluo->valor_catastral){

            $this->dispatch('mostrarMensaje', ['warning', 'El predio no tiene valor catastral.']);

            return;
        }

        $this->modelo_editar->monto = (float)$this->servicio['porcentaje'] / 100 * $this->predio_avaluo->valor_catastral;

        $this->modelo_editar->predio_avaluo = $this->predio_avaluo->id;

        $this->dispatch('mostrarMensaje', ['success', 'Se cargo correctamente el 2% del valor del predio.']);

    }

    public function mount(){

        $this->cargaInicial($this->servicio);

    }

    public function render()
    {
        return view('livewire.tramites.ventanilla.predio-ignorado');
    }
}
