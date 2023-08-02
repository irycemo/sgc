<?php

namespace App\Http\Livewire\Valuacion\ValuacionYDesglose;

use App\Models\Avaluo;
use Livewire\Component;
use App\Models\PredioAvaluo;
use App\Http\Constantes\Constantes;
use Illuminate\Support\Facades\Log;

class Caracteristicas extends Component
{

    public PredioAvaluo $predio;
    public Avaluo $avaluo;

    public $zonas;
    public $construcciones;
    public $cimentaciones;
    public $estructuras;
    public $muros;
    public $entrepisos;
    public $techos;
    public $plafones;
    public $vidrieria;
    public $lambrines;
    public $pisos;
    public $herreria;
    public $pintura;
    public $carpinteria;
    public $aplanados;
    public $rec_especial;
    public $hidraulica;
    public $sanitaria;
    public $electrica;
    public $gas;
    public $especiales;

    protected $listeners = ['cargarPredio'];

    protected function rules(){
        return [
            'avaluo.clasificacion_zona' => 'required',
            'avaluo.construccion_dominante' => 'required',
            'avaluo.agua' => 'nullable',
            'avaluo.drenaje' => 'nullable',
            'avaluo.pavimento' => 'nullable',
            'avaluo.energia_electrica' => 'nullable',
            'avaluo.alumbrado_publico' => 'nullable',
            'avaluo.banqueta' => 'nullable',
            'avaluo.cimentacion' => 'required',
            'avaluo.estructura' => 'required',
            'avaluo.muros' => 'required',
            'avaluo.entrepiso' => 'required',
            'avaluo.techo' => 'required',
            'avaluo.plafones' => 'required',
            'avaluo.vidrieria' => 'required',
            'avaluo.lambrines' => 'required',
            'avaluo.pisos' => 'required',
            'avaluo.herreria' => 'required',
            'avaluo.pintura' => 'required',
            'avaluo.carpinteria' => 'required',
            'avaluo.recubrimiento_especial' => 'required',
            'avaluo.aplanados' => 'required',
            'avaluo.hidraulica' => 'required',
            'avaluo.sanitaria' => 'required',
            'avaluo.electrica' => 'required',
            'avaluo.gas' => 'required',
            'avaluo.especiales' => 'required',
            'predio' => 'required'
         ];
    }

    protected $messages = [
        'predio.required' => '. Primero debe cargar el avaluo',

    ];

    protected $validationAttributes  = [
        'avaluo.clasificacion_zona' => 'clasificación de la zona',
        'avaluo.construccion_dominante' => 'tipo de construcción dominante'
    ];

    public function cargarPredio($id){

        $this->predio = PredioAvaluo::with('avaluo')->find($id);

        $this->avaluo = $this->predio->avaluo;

    }

    public function guardar(){

        $this->validate();

        try {

            $this->avaluo->actualizado_por = auth()->user()->id;
            $this->avaluo->save();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "Las caracteristicas se guardaron con éxito"]);

            $this->emit('cargarPredio', $this->predio->id);

        } catch (\Throwable $th) {
            Log::error("Error al crear caracteristicas por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function mount(){

        $this->zonas = Constantes::CLASIFICACION_ZONA;

        $this->construcciones = Constantes::CONSTRUCCION_DOMINANTE;

        $this->cimentaciones = Constantes::CIMENTACION;

        $this->estructuras = Constantes::ESTRUCTURAS;

        $this->muros = Constantes::MUROS;

        $this->entrepisos = Constantes::ENTREPISOS;

        $this->techos = Constantes::TECHOS;

        $this->plafones = Constantes::PLAFONES;

        $this->vidrieria = Constantes::VIDRIERIA;

        $this->lambrines = Constantes::LAMBRINES;

        $this->pisos = Constantes::PISOS;

        $this->herreria = Constantes::HERRERIA;

        $this->pintura = Constantes::PINTURA;

        $this->carpinteria = Constantes::CARPINTERIA;

        $this->aplanados = Constantes::APLANADOS;

        $this->rec_especial = Constantes::RECUBRIMIENTO_ESPECIAL;

        $this->hidraulica = Constantes::HIDRAULICA;

        $this->sanitaria = Constantes::SANITARIA;

        $this->electrica = Constantes::ELECTRICA;

        $this->gas = Constantes::GAS;

        $this->especiales = Constantes::ESPECIALES;

    }

    public function render()
    {
        return view('livewire.valuacion.valuacion-y-desglose.caracteristicas');
    }
}
