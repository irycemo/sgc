<?php

namespace App\Livewire\Cartografia\AsignarManzana;

use App\Models\ManzanaAsignada;
use App\Models\Predio;
use App\Models\User;
use App\Traits\Predios\CoordenadasTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AsignarManzana extends Component
{

    use CoordenadasTrait;

    public $municipio;
    public $zona;
    public $localidad;
    public $sector;
    public $observaciones;
    public $lat;
    public $lon;
    public $valuadores;
    public $valuador;
    public $predio;

    public $manzanas_disponibles = [];
    public $manzanas_ocupadas = [];
    public $manzanas_seleccionadas = [];

    protected function rules(){
        return [
            'predio.lat' => 'nullable',
            'predio.lon' => 'nullable',
            'predio.xutm' => 'nullable',
            'predio.yutm' => 'nullable',
            'predio.zutm' => 'nullable'
        ];

    }

    public function buscarManzanas(){

        $this->reset(['manzanas_disponibles', 'manzanas_ocupadas']);

        $this->validate([
            'municipio' => 'required|numeric',
            'zona' => 'required|numeric',
            'localidad' => 'required|numeric',
            'sector' => 'required|numeric',
        ]);

        $predios = Predio::where('municipio', $this->municipio)
                            ->where('zona_catastral', $this->zona)
                            ->where('localidad', $this->localidad)
                            ->where('sector', $this->sector)
                            ->get();

        for ($i=1; $i <= 99; $i++) {

            if($predios->where('manzana', $i)->first()){

                array_push($this->manzanas_ocupadas, $i);

            }else{

                array_push($this->manzanas_disponibles, $i);

            }

        }


    }

    public function agregarManzana($seleccionada){

        if(in_array($seleccionada, $this->manzanas_seleccionadas)) return;

        $manzana_asignada = ManzanaAsignada::where('municipio', $this->municipio)
                                                ->where('zona', $this->zona)
                                                ->where('localidad', $this->localidad)
                                                ->where('sector', $this->sector)
                                                ->where('manzana', $seleccionada)
                                                ->first();

        if($manzana_asignada){

            $this->dispatch('mostrarMensaje', ['success', "La manzana esta asignada a: " . $manzana_asignada->asignadoA->name]);

            return;

        }

        array_push($this->manzanas_seleccionadas, $seleccionada);

    }

    public function quitarManzana($index){

        unset($this->manzanas_seleccionadas[$index]);

        $this->manzanas_seleccionadas = array_values($this->manzanas_seleccionadas);

    }

    public function asignarManzanas(){

        $this->validate([
            'manzanas_seleccionadas' => 'required|array|min:1',
            'valuador' => 'required'
        ]);

        try {

            DB::transaction(function () {

                foreach ($this->manzanas_seleccionadas as $manzana) {

                    ManzanaAsignada::create([
                        'municipio' => $this->municipio,
                        'zona' => $this->zona,
                        'localidad' => $this->localidad,
                        'sector' => $this->sector,
                        'manzana' => $manzana,
                        'lon' => $this->predio->lon,
                        'lat' => $this->predio->lat,
                        'xutm' => $this->predio->xutm,
                        'yutm' => $this->predio->xutm,
                        'zutm' => $this->predio->zutm,
                        'asignado_a' => $this->valuador,
                        'observaciones' => $this->observaciones,
                        'creado_por' => auth()->id(),
                    ]);

                }

            });

            $this->reset(['municipio', 'zona', 'localidad', 'sector', 'lon', 'lat', 'observaciones', 'manzanas_seleccionadas', 'manzanas_seleccionadas', 'manzanas_ocupadas', 'manzanas_disponibles']);

            $this->dispatch('mostrarMensaje', ['success', "Se realizó la asignación exitosamente."]);

        } catch (\Throwable $th) {

            Log::error("Error al asignar manzanas usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        $this->valuadores = User::where('estado', 'activo')
                                    ->where('valuador', true)
                                    ->orderBy('name')
                                    ->get();

        $this->predio = Predio::make();

    }

    public function render()
    {
        return view('livewire.cartografia.asignar-manzana.asignar-manzana')->extends('layouts.admin');
    }

}
