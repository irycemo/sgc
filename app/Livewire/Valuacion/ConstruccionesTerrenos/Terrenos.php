<?php

namespace App\Livewire\Valuacion\ConstruccionesTerrenos;

use App\Models\Terreno;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PredioAvaluo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ValoresUnitariosRusticos;

class Terrenos extends Component
{

    public $predio;

    public $terrenos = [];
    public $valores_rusticos;

    public $porcentajeDemerito;

    protected function rules(){
        return [
            'predio' => 'required',
            'terrenos.*' => 'required',
            'terrenos.*.superficie' => 'required|numeric',
            'terrenos.*.valor_unitario' => 'required|numeric',
            'terrenos.*.demerito' => 'nullable|numeric|min:0',
         ];
    }

    protected $validationAttributes  = [
        'terrenos.*.superficie' => 'superficie',
        'terrenos.*.valor_unitario' => 'valor unitario',
    ];

    #[On('cargarPredio')]
    public function cargarPredio($id){

        $this->reset('terrenos');

        $this->predio = PredioAvaluo::with('avaluo')->find($id);

        foreach ($this->predio->terrenos as $terreno) {

            $this->terrenos[] = [
                'id' => $terreno->id,
                'superficie' => $terreno->superficie,
                'valor_unitario' => $terreno->valor_unitario,
                'demerito' => $terreno->demerito,
                'valor_demeritado' => $terreno->valor_demeritado,
                'valor_terreno' => $terreno->valor_terreno
            ];

        }

        $this->porcentajeDemerito = null;

        if(!$this->predio->avaluo->agua)
            $this->porcentajeDemerito = 5;
        if(!$this->predio->avaluo->drenaje)
            $this->porcentajeDemerito = $this->porcentajeDemerito + 5;
        if(!$this->predio->avaluo->pavimento)
            $this->porcentajeDemerito = $this->porcentajeDemerito + 5;
        if(!$this->predio->avaluo->energia_electrica)
            $this->porcentajeDemerito = $this->porcentajeDemerito + 5;
        if(!$this->predio->avaluo->alumbrado_publico)
            $this->porcentajeDemerito = $this->porcentajeDemerito + 5;
        if(!$this->predio->avaluo->banqueta)
            $this->porcentajeDemerito = $this->porcentajeDemerito + 5;

        foreach ($this->terrenos as $terreno) {

            $terreno['demerito'] = $this->porcentajeDemerito;

        }

        if(count($this->terrenos) == 0) $this->agregarTerreno();

    }

    public function updatedTerrenos($value, $index){

        $this->validate(['predio' => 'required']);

        $i = explode('.', $index);

        if(isset($this->terrenos[$i[0]]['demerito']) && $this->terrenos[$i[0]]['demerito'] == 0){

            $this->terrenos[$i[0]]['valor_demeritado'] = 0;

        }

        if(isset($this->terrenos[$i[0]]['superficie']) && isset($this->terrenos[$i[0]]['valor_unitario']) && isset($this->terrenos[$i[0]]['demerito']) && $this->terrenos[$i[0]]['demerito'] != 0){

            $this->terrenos[$i[0]]['valor_demeritado'] = (float)$this->terrenos[$i[0]]['valor_unitario'] - (float)$this->terrenos[$i[0]]['valor_unitario'] * (float)$this->terrenos[$i[0]]['demerito'] / 100;

            if($this->predio->tipo_predio == 2){

                $this->terrenos[$i[0]]['valor_terreno'] = (float)$this->terrenos[$i[0]]['superficie'] * (float)$this->terrenos[$i[0]]['valor_demeritado'] / 10000;

            }else{

                $this->terrenos[$i[0]]['valor_terreno'] = (float)$this->terrenos[$i[0]]['superficie'] * (float)$this->terrenos[$i[0]]['valor_demeritado'];
            }


        }elseif(isset($this->terrenos[$i[0]]['superficie']) && isset($this->terrenos[$i[0]]['valor_unitario'])){

            $this->terrenos[$i[0]]['valor_terreno'] = (float)$this->terrenos[$i[0]]['superficie'] * (float)$this->terrenos[$i[0]]['valor_unitario'];

            if($this->predio->tipo_predio == 2)
                $this->terrenos[$i[0]]['valor_terreno'] = $this->terrenos[$i[0]]['valor_terreno'] / 10000;

        }

    }

    public function agregarTerreno(){

        $this->terrenos[] = ['superficie' => null, 'valor_unitario' => null, 'demerito' => $this->porcentajeDemerito, 'id' => null , 'valor_demeritado' => null, 'valor_terreno' => null];

    }

    public function borrarTerreno($index){

        $this->validate(['predio' => 'required']);

        try {

            if($this->terrenos[$index]['id'] != null)
                $this->predio->terrenos()->where('id', $this->terrenos[$index]['id'])->delete();

        } catch (\Throwable $th) {
            Log::error("Error al borrar terreno por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

        unset($this->terrenos[$index]);

        $this->terrenos = array_values($this->terrenos);

    }

    public function guardarTerrenos(){

        if($this->predio?->avaluo?->estado == 'notificado'){

            $this->dispatch('mostrarMensaje', ['error', "No puedes modificar un avalúo notificado."]);

            return;

        }

        $this->validate();

        try {

            DB::transaction(function () {

                $sum = 0;

                $sum2 = 0;

                foreach ($this->terrenos as $key => $terreno) {

                    if($terreno['id'] == null){

                        $aux = $this->predio->terrenos()->create([
                            'superficie' => $terreno['superficie'],
                            'valor_unitario' => $terreno['valor_unitario'],
                            'demerito' => $terreno['demerito'],
                            'valor_demeritado' => $terreno['valor_demeritado'],
                            'valor_terreno' => $terreno['valor_terreno'],
                        ]);

                        $this->terrenos[$key]['id'] = $aux->id;

                    }else{

                        Terreno::find($terreno['id'])->update([
                            'superficie' => $terreno['superficie'],
                            'valor_unitario' => $terreno['valor_unitario'],
                            'demerito' => $terreno['demerito'],
                            'valor_demeritado' => $terreno['valor_demeritado'],
                            'valor_terreno' => $terreno['valor_terreno'],
                        ]);

                    }

                    $sum = $sum + (float)$terreno['valor_terreno'];

                    $sum2 = $sum2 + (float)$terreno['superficie'];

                }

                $this->predio->update([
                    'superficie_terreno' => $sum2,
                    'valor_total_terreno' => $sum
                ]);

                $this->dispatch('mostrarMensaje', ['success', "Los terrenos se guardaron con éxito"]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al guardar terrenos por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function mount(){

        $this->terrenos = [
            ['superficie' => null, 'valor_unitario' => null, 'demerito' => null, 'id' => null, 'valor_demeritado' => null, 'valor_terreno' => null]
        ];

        $this->valores_rusticos = ValoresUnitariosRusticos::all();

    }

    public function render()
    {
        return view('livewire.valuacion.construcciones-terrenos.terrenos');
    }
}
