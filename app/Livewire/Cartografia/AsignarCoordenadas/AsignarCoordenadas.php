<?php

namespace App\Livewire\Cartografia\AsignarCoordenadas;

use App\Models\Predio;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Services\Coordenadas\Coordenadas;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AsignarCoordenadas extends Component
{

    public Predio $predio;

    protected function rules(){

        return [
            'predio.xutm' => 'nullable|string',
            'predio.yutm' => 'nullable|string',
            'predio.zutm' => 'nullable',
            'predio.lat' => 'required|numeric',
            'predio.lon' => 'required|numeric',
            'predio.localidad' => 'required|numeric',
            'predio.oficina' => 'required|numeric',
            'predio.tipo_predio' => 'required|numeric',
            'predio.numero_registro' => 'required|numeric'
        ];

    }

    public function crearModeloVacio(){
        $this->predio = Predio::make([
            'estado' => 16,
            'edificio' => 0,
            'departamento' => 0
        ]);
    }

    public function updated($value){

        if(in_array($value, ['predio.xutm', 'predio.yutm','predio.zutm', 'predio.lat', 'predio.lon']))
            $this->convertirCoordenadas();

    }

    public function convertirCoordenadas(){

        if($this->predio->xutm && $this->predio->yutm && $this->predio->zutm){

            $ll = (new Coordenadas())->utm2ll($this->predio->xutm, $this->predio->yutm, $this->predio->zutm, true);

            if(!$ll['success']){

                $this->dispatch('mostrarMensaje', ['error', $ll['msg']]);

                return;

            }else{

                $this->predio->lat = $ll['attr']['lat'];
                $this->predio->lon = $ll['attr']['lon'];

            }


        }elseif($this->predio->lat && $this->predio->lon){

            $ll = (new Coordenadas())->ll2utm($this->predio->lat, $this->predio->lon);

            if(!$ll['success']){

                $this->dispatch('mostrarMensaje', ['error', $ll['msg']]);

                return;

            }else{

                if((float)$ll['attr']['zone'] < 13 || (float)$ll['attr']['zone'] > 14){

                    $this->dispatch('mostrarMensaje', ['error', "Las coordenadas no corresponden a una zona válida."]);

                    $this->predio->lat = null;
                    $this->predio->lon = null;

                    return;

                }

                $this->predio->xutm = strval($ll['attr']['x']);
                $this->predio->yutm = strval($ll['attr']['y']);
                $this->predio->zutm = $ll['attr']['zone'];

            }

        }


    }

    public function buscarCuentaPredial(){

        try {

            $this->predio = Predio::where('numero_registro', $this->predio->numero_registro)
                                    ->where('tipo_predio', $this->predio->tipo_predio)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('oficina', $this->predio->oficina)
                                    ->firstOrFail();

            if($this->predio->status == 'bloqueado'){

                $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra bloqueado."]);
                $this->crearModeloVacio();
                return;

            }

        } catch(ModelNotFoundException $e){

            $this->dispatch('mostrarMensaje', ['warning', "No se encontro predio con la cuenta predial ingresada."]);

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function asignarCoordenadas(){

        $this->validate();

        try {

            $this->predio->save();

            $this->predio->audits()->latest()->first()->update(['tags' => 'Asignó coordenadas']);

            $this->dispatch('mostrarMensaje', ['success', "Las coordenadas se actualizaron con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al asignar coordenadas predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function resetearCoordenadas(){

        $this->reset([
            'predio.xutm',
            'predio.yutm',
            'predio.zutm',
            'predio.lat' ,
            'predio.lon' ,
        ]);

    }

    public function mount(){

        $this->crearModeloVacio();

    }

    public function render()
    {
        return view('livewire.cartografia.asignar-coordenadas.asignar-coordenadas')->extends('layouts.admin');
    }
}
