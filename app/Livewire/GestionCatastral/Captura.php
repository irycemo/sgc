<?php

namespace App\Livewire\GestionCatastral;


use Carbon\Carbon;
use App\Models\Predio;
use App\Models\Notaria;
use App\Models\Oficina;
use Livewire\Component;
use App\Models\CodigoPostal;
use Illuminate\Validation\Rule;
use App\Models\FactorIncremento;
use App\Http\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Coordenadas\Coordenadas;

class Captura extends Component
{

    public $tipoVialidades;
    public $tipoAsentamientos;
    public $acciones_padron;
    public $documentos;
    public $notarias;
    public $acccion;

    public $actualizacion = false;
    public $modalIndexar = false;
    public $modalBaja = false;
    public $label = 'Número de documento';

    public Predio $predio;
    public $observaciones;

    public $tipos_asentamientos;
    public $nombres_asentamientos = [];
    public $tipos_vialidades;
    public $tipo_asentamiento;
    public $codigos_postales;

    protected function rules(){
        return [
            'predio.numero_registro' => 'required|numeric|min:1',
            'predio.region_catastral' => 'required|numeric|min:1',
            'predio.municipio' => 'required|numeric|min:1',
            'predio.localidad' => 'required|numeric|min:1',
            'predio.sector' => 'required|numeric|min:1',
            'predio.zona_catastral' => 'required|numeric|min:1,|same:predio.localidad',
            'predio.manzana' => 'required|numeric|min:1',
            'predio.predio' => 'required|numeric|min:1',
            'predio.edificio' => 'required|numeric|min:0',
            'predio.departamento' => 'required|numeric|min:0',
            'predio.tipo_predio' => 'required|numeric|min:1|max:2',
            'predio.oficina' => 'required|numeric|min:1',
            'predio.estado' => 'required',
            'predio.tipo_asentamiento' => 'required',
            'predio.nombre_asentamiento' => 'required',
            'predio.tipo_vialidad' => 'required',
            'predio.nombre_vialidad' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'predio.numero_exterior' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'predio.numero_exterior_2' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'predio.numero_interior' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'predio.numero_adicional_2' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'predio.numero_adicional' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'predio.codigo_postal' => 'required|numeric',
            'predio.lote_fraccionador' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'predio.manzana_fraccionador' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'predio.etapa_fraccionador' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'predio.nombre_predio'  => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'predio.nombre_edificio' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'predio.clave_edificio' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'predio.departamento_edificio' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'predio.xutm' => 'nullable|string',
            'predio.yutm' => 'nullable|string',
            'predio.zutm' => 'nullable',
            'predio.lat' => 'required',
            'predio.lon' => 'required',
            'predio.documento_entrada' => Rule::requiredIf(!$this->actualizacion),
            'predio.declarante' => Rule::requiredIf(!$this->actualizacion),
            'predio.documento_numero' => Rule::requiredIf(!$this->actualizacion),
            'predio.fecha_efectos' => Rule::requiredIf(!$this->actualizacion),
            'predio.origen' => 'required',
            'predio.observaciones' => 'required_if:modalBaja, true|regex:/^[a-zA-Z0-9\s]+$/'
         ];
    }

    public function crearModeloVacio(){
        return Predio::make([
            'estado' => 16,
        ]);
    }

    public function updatedPredioDocumentoEntrada($value){

        if(in_array($value, ['TÍTULO DE PROPIEDAD PARCELARIO','TÍTULO DE PROPIEDAD SOLAR URBANO'])){

            $this->label = 'Número de titulo';

        }elseif(in_array($value, ['ESCRITURA PÚBLICA', 'ESCRITURA PRIVADA'])){

            $this->label = 'Número de escritura';

        }else{

            $this->label = 'Número de documento';

        }

    }

    public function updatedActualizacion(){

        $this->predio = $this->crearModeloVacio();

        $this->predio->oficina = auth()->user()->oficina->oficina;

    }

    public function updatedPredioCodigoPostal(){

        $this->reset('predio.nombres_asentamientos', 'predio.nombre_asentamiento', 'nombres_asentamientos');

        $this->codigos_postales = CodigoPostal::where('codigo', $this->predio->codigo_postal)->get();

        if($this->codigos_postales->count()){

            foreach ($this->codigos_postales as $codigo) {

                array_push($this->nombres_asentamientos, $codigo->nombre_asentamiento);
            }

        }

    }

    public function updatedPredioNombreAsentamiento(){

        if($this->predio->nombre_asentamiento != "")
            $this->predio->tipo_asentamiento = $this->codigos_postales->where('nombre_asentamiento', $this->predio->nombre_asentamiento)->first()->tipo_asentamiento;
        else
            $this->predio->tipo_asentamiento = null;

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

            $this->predio = Predio::where('estado', '!=', 'notificado')
                                    ->where('numero_registro', $this->predio->numero_registro)
                                    ->where('tipo_predio', $this->predio->tipo_predio)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('oficina', $this->predio->oficina)
                                    ->firstOrFail();

            if($this->predio->bloqueadoActivo()){

                $this->dispatch('mostrarMensaje', ['error', "El predio se encuentra bloqueado."]);
                $this->predio = $this->crearModeloVacio();
                return;

            }

            if($this->predioInactivo()) return;

            $this->dispatch('cargarPredio', id: $this->predio->id, flag: true);

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "No se encontro predio con la cuenta predial ingresada."]);

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

            if($this->predio->bloqueadoActivo()){

                $this->dispatch('mostrarMensaje', ['error', "El predio se encuentra bloqueado."]);
                $this->predio = $this->crearModeloVacio();
                return;

            }

            if($this->predioInactivo()) return;

            $this->dispatch('cargarPredio', $this->predio->id);

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "No se encontro predio con la clave catastral ingresada."]);

        }

    }

    public function predioInactivo(){

        if($this->predio->status != 'activo'){

            $this->dispatch('mostrarMensaje', ['error', "El predio no esta activo."]);

            $this->predio = $this->crearModeloVacio();

            return true;

        }

    }

    public function indexar(){

        if(intval(Carbon::parse($this->predio->indexado_en)->format('Y')) == intval(now()->format('Y'))){

            $this->modalIndexar = false;

            $this->dispatch('mostrarMensaje', ['warning', "El valor catastral del predio ya ha sido indexado al año actual."]);

            return;

        }

        $factores = FactorIncremento::orderBy('año')->get();

        $valor = $this->predio->valor_catastral;

        $año = Carbon::parse($this->predio->fecha_efectos)->format('Y');

        foreach($factores as $factor){

            if($factor->año >= intval($año)){


                $valor = $valor * $factor->factor;

            }

        }

        try {

            $this->predio->valor_catastral = $valor;

            $this->predio->indexado_en = now();

            $this->predio->save();

            $this->predio->audits()->latest()->first()->update(['tags' => 'Indexó predio']);

            $this->dispatch('mostrarMensaje', ['success', "El valor del predio se indexó correctamente."]);

            $this->modalIndexar = false;

        } catch (\Throwable $th) {

            Log::error("Error al indexar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function darDeBaja(){

        $this->validate([
            'predio.origen' => 'required',
            'observaciones' => 'required'
        ]);

        try {

            $this->predio->update([
                'status' => 'baja',
                'actualizado_por' => auth()->id(),
                'observaciones' => $this->predio->observaciones . '. ' . $this->observaciones
            ]);

            $this->predio->audits()->latest()->first()->update(['tags' => 'Dio de baja predio']);

            $this->dispatch('mostrarMensaje', ['success', "El predio se dió de baja correctamente."]);

            $this->modalBaja = false;

            $this->predio = $this->crearModeloVacio();

        } catch (\Throwable $th) {

            Log::error("Error al dar de baja predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function validarDisponibilidad(){

        $predioCompleto = Predio::where('estado', $this->predio->estado)
                                    ->where('region_catastral', $this->predio->region_catastral)
                                    ->where('municipio', $this->predio->municipio)
                                    ->where('zona_catastral', $this->predio->zona_catastral)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('sector', $this->predio->sector)
                                    ->where('manzana', $this->predio->manzana)
                                    ->where('predio', $this->predio->predio)
                                    ->where('edificio', $this->predio->edificio)
                                    ->where('departamento', $this->predio->departamento)
                                    ->where('oficina', $this->predio->oficina)
                                    ->where('tipo_predio', $this->predio->tipo_predio)
                                    ->where('numero_registro', $this->predio->numero_registro)
                                    ->first();

        if(!$predioCompleto){

            $cuentaPredial = Predio::where('localidad', $this->predio->localidad)
                                        ->where('oficina', $this->predio->oficina)
                                        ->where('tipo_predio', $this->predio->tipo_predio)
                                        ->where('numero_registro', $this->predio->numero_registro)
                                        ->first();

            if($cuentaPredial){

                $this->dispatch('mostrarMensaje', ['error', "La cuenta predial ya existe en el padrón con otra clave catastral, verifique."]);

                return true;

            }

            $claveCatastral = Predio::where('status', '!=', 'notificado')
                                        ->where('estado', $this->predio->estado)
                                        ->where('region_catastral', $this->predio->region_catastral)
                                        ->where('municipio', $this->predio->municipio)
                                        ->where('zona_catastral', $this->predio->zona_catastral)
                                        ->where('localidad', $this->predio->localidad)
                                        ->where('sector', $this->predio->sector)
                                        ->where('manzana', $this->predio->manzana)
                                        ->where('predio', $this->predio->predio)
                                        ->where('edificio', $this->predio->edificio)
                                        ->where('departamento', $this->predio->departamento)
                                        ->first();

            if($claveCatastral){

                $this->dispatch('mostrarMensaje', ['error', "La clave catastral ya existe en el padrón con otra cuenta predial, verifique."]);

                return true;

            }

        }

    }

    public function validarSector(){

        $oficina = Oficina::where('localidad', $this->predio->localidad)
                            ->where('oficina', $this->predio->oficina)
                            ->first();

        if(!$oficina){

            $this->dispatch('mostrarMensaje', ['error', "No se encontraron oficinas con los datos ingresados."]);

            return true;

        }

        $sectores = json_decode($oficina->sectores, true);

        if(!$sectores){

            $this->dispatch('mostrarMensaje', ['error', "La zona no tiene sectores."]);

            return true;

        }

        if(!in_array($this->predio->sector, $sectores)){

            $this->dispatch('mostrarMensaje', ['error', "El sector no corresponde a la zona."]);

            return true;

        }

    }

    public function crear(){

        $this->validate();

        if($this->validarDisponibilidad() || $this->validarSector()) return;

        try {

            $this->predio->creado_por = auth()->id();
            $this->predio->save();

            $this->predio->audits()->latest()->first()->update(['tags' => 'Dió de alta predio']);

            $this->dispatch('cargarPredio', id:$this->predio->id, flag:true);

            $this->dispatch('mostrarMensaje', ['success', "El predio se dió de alta correctamente."]);

        } catch (\Throwable $th) {

            Log::error("Error al crear predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function actualizar(){

        $this->validate();

        if($this->validarDisponibilidad() || $this->validarSector()) return;

        try {

            $this->predio->actualizado_por = auth()->id();
            $this->predio->save();

            $this->predio->audits()->latest()->first()->update(['tags' => 'Actualizo información de identificación']);

            $this->dispatch('mostrarMensaje', ['success', "El predio se actualizó correctamente."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function mount(){

        $this->acciones_padron = Constantes::ACCIONES_PADRON;

        $this->tipoVialidades = Constantes::TIPO_VIALIDADES;

        $this->tipoAsentamientos = Constantes::TIPO_ASENTAMIENTO;

        $this->documentos = Constantes::DOCUMENTO_ENTRADA;

        $this->notarias = Notaria::all();

        $this->predio = $this->crearModeloVacio();

        $this->predio->oficina = auth()->user()->oficina->oficina;

    }

    public function render()
    {
        return view('livewire.gestion-catastral.captura')->extends('layouts.admin');
    }
}
