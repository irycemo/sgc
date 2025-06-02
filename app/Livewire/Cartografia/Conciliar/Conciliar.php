<?php

namespace App\Livewire\Cartografia\Conciliar;

use App\Models\Predio;
use Livewire\Component;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use App\Traits\Predios\CoordenadasTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Conciliar extends Component
{

    use CoordenadasTrait;

    public $tipoVialidades;
    public $tipoAsentamientos;
    public $nombres_asentamientos = [];
    public $tipos_asentamientos;
    public $tipos_vialidades;
    public $tipo_asentamiento;
    public $codigos_postales;

    public $region_catastral;
    public $municipio;
    public $zona_catastral;
    public $localidad;
    public $sector;
    public $manzana;
    public $predio_cc;
    public $edificio;
    public $departamento;
    public $oficina;
    public $tipo_predio;
    public $numero_registro;

    public $flag = false;

    public Predio $predio;

    protected function rules(){
        return [
            'predio.numero_registro' => 'required|numeric|min:1',
            'predio.region_catastral' => 'required|numeric|min:1',
            'predio.municipio' => 'required|numeric|min:1',
            'predio.localidad' => 'required|numeric|min:1',
            'predio.sector' => 'required|numeric|min:1',
            'predio.zona_catastral' => 'required|numeric|min:1,|same:predio.localidad',
            'predio.manzana' => 'required|numeric|min:0',
            'predio.predio' => 'required|numeric|min:1',
            'predio.edificio' => 'required|numeric|min:0',
            'predio.departamento' => 'required|numeric|min:0',
            'predio.tipo_predio' => 'required|numeric|min:1|max:2',
            'predio.oficina' => 'required|numeric|min:1',
            'predio.estado' => 'required',
            'predio.tipo_asentamiento' => 'required',
            'predio.nombre_asentamiento' => 'required',
            'predio.tipo_vialidad' => 'required',
            'predio.nombre_vialidad' => 'required',
            'predio.numero_exterior' => 'required',
            'predio.numero_exterior_2' => 'nullable',
            'predio.numero_interior' => 'nullable',
            'predio.numero_adicional_2' => 'nullable',
            'predio.numero_adicional' => 'nullable',
            'predio.codigo_postal' => 'required|numeric',
            'predio.lote_fraccionador' => 'nullable',
            'predio.manzana_fraccionador' => 'nullable',
            'predio.etapa_fraccionador' => 'nullable',
            'predio.nombre_predio'  => 'nullable',
            'predio.nombre_edificio' => 'nullable',
            'predio.clave_edificio' => 'nullable',
            'predio.departamento_edificio' => 'nullable',
            'predio.xutm' => 'nullable|string',
            'predio.yutm' => 'nullable|string',
            'predio.zutm' => 'nullable',
            'predio.lat' => 'required',
            'predio.lon' => 'required',
         ];
    }

    public function crearModeloVacio(){
        $this->predio =  Predio::make([
            'estado' => 16,
        ]);
    }

    public function updatedPredioNombreAsentamiento(){

        if($this->predio->nombre_asentamiento != "")
            $this->predio->tipo_asentamiento = $this->codigos_postales->where('nombre_asentamiento', $this->predio->nombre_asentamiento)->first()->tipo_asentamiento;
        else
            $this->predio->tipo_asentamiento = null;

    }

    public function buscarCuentaPredial(){

        try {

            $this->predio = Predio::where('numero_registro', $this->predio->numero_registro)
                                    ->where('tipo_predio', $this->predio->tipo_predio)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('oficina', $this->predio->oficina)
                                    ->firstOrFail();

            if($this->predio->status == 'bloqueado'){

                $this->dispatch('mostrarMensaje', ['error', "El predio se encuentra bloqueado."]);
                $this->crearModeloVacio();
                return;

            }

            $this->region_catastral = $this->predio->region_catastral;
            $this->municipio = $this->predio->municipio;
            $this->zona_catastral = $this->predio->zona_catastral;
            $this->localidad = $this->predio->localidad;

        } catch(ModelNotFoundException $e){

            $this->dispatch('mostrarMensaje', ['error', "No se encontro predio con la cuenta predial ingresada."]);

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function buscarClaveCatastral(){

        try {

            $this->predio = Predio::where('estado', 16)
                                    ->where('status', '!=', 'notificado')
                                    ->where('region_catastral', $this->predio->region_catastral)
                                    ->where('municipio', $this->predio->municipio)
                                    ->where('zona_catastral', $this->predio->zona_catastral)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('sector', $this->predio->sector)
                                    ->where('manzana', $this->predio->manzana)
                                    ->where('predio', $this->predio->predio)
                                    ->where('edificio', $this->predio->edificio)
                                    ->where('departamento', $this->predio->departamento)
                                    ->firstOrFail();

            if($this->predio->status == 'bloqueado'){

                $this->dispatch('mostrarMensaje', ['error', "El predio se encuentra bloqueado."]);
                $this->crearModeloVacio();
                return;

            }

        } catch(ModelNotFoundException $e){

            $this->dispatch('mostrarMensaje', ['error', "No se encontro predio con la cuenta predial ingresada."]);

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function validarDisponibilidad(){

        $predio = Predio::where('estado', 16)
                                    ->where('region_catastral', $this->region_catastral)
                                    ->where('municipio', $this->municipio)
                                    ->where('zona_catastral', $this->zona_catastral)
                                    ->where('localidad', $this->localidad)
                                    ->where('sector', $this->sector)
                                    ->where('manzana', $this->manzana)
                                    ->where('predio', $this->predio_cc)
                                    ->where('edificio', $this->edificio)
                                    ->where('departamento', $this->departamento)
                                    ->first();

        if($predio){

            $this->predio = $predio;

            $this->oficina = $predio->oficina;
            $this->localidad = $predio->localidad;
            $this->tipo_predio = $predio->tipo_predio;
            $this->numero_registro = $predio->numero_registro;
            $this->zona_catastral = $predio->zona_catastral;

            $this->flag = true;

            $this->dispatch('mostrarMensaje', ['error', "La clave catastral ya existe en el padrón, verifique."]);

            return true;

        }

    }

    public function conciliar(){

        $this->validate([
            'region_catastral' => 'required|numeric|min:1',
            'municipio' => 'required|numeric|min:1',
            'localidad' => 'required|numeric|min:1',
            'sector' => 'required|numeric|min:1',
            'zona_catastral' => 'required|numeric|min:1,|same:localidad',
            'manzana' => 'required|numeric|min:0',
            'predio_cc' => 'required|numeric|min:1',
            'edificio' => 'required|numeric|min:0',
            'departamento' => 'required|numeric|min:0',
            'predio.tipo_asentamiento' => 'required',
            'predio.nombre_asentamiento' => 'required',
            'predio.tipo_vialidad' => 'required',
            'predio.nombre_vialidad' => 'required',
            'predio.numero_exterior' => 'required',
            'predio.numero_exterior_2' => 'nullable',
            'predio.numero_interior' => 'nullable',
            'predio.numero_adicional_2' => 'nullable',
            'predio.numero_adicional' => 'nullable',
            'predio.codigo_postal' => 'required|numeric',
            'predio.lote_fraccionador' => 'nullable',
            'predio.manzana_fraccionador' => 'nullable',
            'predio.etapa_fraccionador' => 'nullable',
            'predio.nombre_predio'  => 'nullable',
            'predio.nombre_edificio' => 'nullable',
            'predio.clave_edificio' => 'nullable',
            'predio.departamento_edificio' => 'nullable',
            'predio.xutm' => 'nullable|string',
            'predio.yutm' => 'nullable|string',
            'predio.zutm' => 'nullable',
            'predio.lat' => 'required',
            'predio.lon' => 'required',
        ]);

        if($this->validarDisponibilidad()) return;

        try {

            $this->predio->region_catastral = $this->region_catastral;
            $this->predio->municipio = $this->municipio;
            $this->predio->zona_catastral = $this->zona_catastral;
            $this->predio->localidad = $this->localidad;
            $this->predio->sector = $this->sector;
            $this->predio->manzana = $this->manzana;
            $this->predio->predio = $this->predio_cc;
            $this->predio->edificio = $this->edificio;
            $this->predio->departamento = $this->departamento;
            $this->predio->oficina = $this->predio->oficina;
            $this->predio->tipo_predio = $this->predio->tipo_predio;
            $this->predio->numero_registro = $this->predio->numero_registro;

            $this->predio->save();

            $this->predio->audits()->latest()->first()->update(['tags' => 'Concilió predio']);

            $this->dispatch('mostrarMensaje', ['success', "La conciliación finalizó con éxito."]);

            $this->crearModeloVacio();

        } catch (\Throwable $th) {

            Log::error("Error al conciliar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        $this->tipoVialidades = Constantes::TIPO_VIALIDADES;

        $this->tipoAsentamientos = Constantes::TIPO_ASENTAMIENTO;

        $this->crearModeloVacio();

        $this->oficina = auth()->user()->oficina->oficina;

    }
    public function render()
    {
        return view('livewire.cartografia.conciliar.conciliar')->extends('layouts.admin');
    }
}
