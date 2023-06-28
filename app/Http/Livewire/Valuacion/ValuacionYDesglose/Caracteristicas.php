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
            'avaluo.clasificacion_zona' => 'nullable',
            'avaluo.construccion_dominante' => 'nullable',
            'avaluo.agua' => 'nullable',
            'avaluo.drenaje' => 'nullable',
            'avaluo.pavimento' => 'nullable',
            'avaluo.energia_electrica' => 'nullable',
            'avaluo.alumbrado_publico' => 'nullable',
            'avaluo.banqueta' => 'nullable',
            'avaluo.cimentacion' => 'nullable',
            'avaluo.estructura' => 'nullable',
            'avaluo.muros' => 'nullable',
            'avaluo.entrepiso' => 'nullable',
            'avaluo.techo' => 'nullable',
            'avaluo.plafones' => 'nullable',
            'avaluo.vidrieria' => 'nullable',
            'avaluo.lambrines' => 'nullable',
            'avaluo.pisos' => 'nullable',
            'avaluo.herreria' => 'nullable',
            'avaluo.pintura' => 'nullable',
            'avaluo.carpinteria' => 'nullable',
            'avaluo.recubrimiento_especial' => 'nullable',
            'avaluo.aplanados' => 'nullable',
            'avaluo.hidraulica' => 'nullable',
            'avaluo.sanitaria' => 'nullable',
            'avaluo.electrica' => 'nullable',
            'avaluo.gas' => 'nullable',
            'avaluo.especiales' => 'nullable',
            'predio' => 'required'
         ];
    }

    protected $messages = [
        'predio.required' => '. Primero debe cargar el avaluo'
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
