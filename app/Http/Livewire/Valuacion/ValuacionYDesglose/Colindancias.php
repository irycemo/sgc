<?php

namespace App\Http\Livewire\Valuacion\ValuacionYDesglose;

use Livewire\Component;
use App\Models\PredioAvaluo;
use App\Http\Constantes\Constantes;
use App\Models\Colindancia;
use Illuminate\Support\Facades\Log;

class Colindancias extends Component
{
    public PredioAvaluo $predio;

    public $medidas = [];
    public $vientos;

    protected $listeners = ['cargarPredio'];

    protected function rules(){
        return [
            'medidas.*' => 'required',
            'medidas.*.viento' => 'required|string',
            'medidas.*.longitud' => 'required|numeric|min:1',
            'medidas.*.descripcion' => 'required|string',
            'predio' => 'required'
         ];
    }

    protected $validationAttributes  = [
        'medidas.*.viento' => 'viento',
        'medidas.*.longitud' => 'longitud',
        'medidas.*.descripcion' => 'descripción',
    ];

    protected $messages = [
        'predio.required' => '. Primero debe cargar el avaluo'
    ];

    public function cargarPredio($id){

        $this->predio = PredioAvaluo::with('colindancias', 'avaluo')->find($id);

        $this->medidas[] = ['viento' => null, 'longitud' => null, 'descripcion' => null, 'id' => null];

        foreach ($this->predio->colindancias as $colindancia) {

            $this->medidas[] = [
                'id' => $colindancia->id,
                'viento' => $colindancia->viento,
                'longitud' => $colindancia->longitud,
                'descripcion' => $colindancia->descripcion,
            ];

        }

    }

    public function agregarMedida(){

        $this->medidas[] = ['viento' => null, 'longitud' => null, 'descripcion' => null, 'id' => null];

    }

    public function borrarMedida($index){

        $this->validate(['predio' => 'required']);

        try {

            $this->predio->colindancias()->where('id', $this->medidas[$index]['id'])->delete();

        } catch (\Throwable $th) {
            Log::error("Error al borrar colindancia por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);
        }

        unset($this->medidas[$index]);

        $this->medidas = array_values($this->medidas);

    }

    public function guardar(){

        $this->validate();

        try {

            foreach ($this->medidas as $medida) {

                if($medida['id'] == null){

                    $this->predio->colindancias()->create([
                        'viento' => $medida['viento'],
                        'longitud' => $medida['longitud'],
                        'descripcion' => $medida['descripcion'],
                    ]);

                }else{

                    Colindancia::find($medida['id'])->update([
                        'viento' => $medida['viento'],
                        'longitud' => $medida['longitud'],
                        'descripcion' => $medida['descripcion'],
                    ]);

                }

            }

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "Las colindacias se guardaron con éxito"]);

        } catch (\Throwable $th) {
            Log::error("Error al crear medidas por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function mount(){

        $this->vientos = Constantes::VIENTOS;

        $this->medidas = [
            ['viento' => null, 'longitud' => null, 'descripcion' => null, 'id' => null]
        ];

    }

    public function render()
    {
        return view('livewire.valuacion.valuacion-y-desglose.colindancias');
    }
}
