<?php

namespace App\Livewire\GestionCatastral\Captura;

use Carbon\Carbon;
use App\Models\Uma;
use App\Models\Predio;
use App\Models\Notaria;
use App\Models\Oficina;
use Livewire\Component;
use App\Constantes\Constantes;
use App\Exceptions\GeneralException;
use Illuminate\Validation\Rule;
use App\Models\FactorIncremento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\Predios\ValidarSector;
use App\Traits\Predios\CoordenadasTrait;
use App\Traits\Predios\ValidarCuentaAsignada;
use App\Traits\Predios\ValidarDisponibilidad;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Captura extends Component
{

    use CoordenadasTrait;
    use ValidarSector;
    use ValidarDisponibilidad;
    use ValidarCuentaAsignada;

    public $tipos_asentamientos;
    public $nombres_asentamientos = [];
    public $tipos_vialidades;
    public $tipo_asentamiento;
    public $tipoVialidades;
    public $tipoAsentamientos;
    public $acciones_alta;
    public $acciones_baja;
    public $acciones_actualizacion;
    public $documentos;
    public $notarias;
    public $accion;
    public $actualizacion = true;
    public $modalIndexar = false;
    public $modalBaja = false;
    public $label = 'Número de documento';
    public $observaciones;

    public Predio $predio;

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
            'predio.lat' => 'required|numeric',
            'predio.lon' => 'required|numeric',
            'predio.superficie_judicial' => 'nullable|numeric',
            'predio.superficie_notarial' => 'nullable|numeric',
            'predio.valor_catastral' => 'required|numeric',
            'predio.superficie_total_construccion' => 'nullable|numeric',
            'predio.superficie_total_terreno' => 'required|numeric',
            'predio.documento_entrada' => Rule::requiredIf(!$this->actualizacion),
            'predio.declarante' => Rule::requiredIf(!$this->actualizacion),
            'predio.documento_numero' => Rule::requiredIf(!$this->actualizacion),
            'predio.fecha_efectos' => Rule::requiredIf(!$this->actualizacion),
            'accion' => 'required',
            'predio.observaciones' => 'nullable',
            'observaciones' => 'required',
         ];
    }

    public function crearModeloVacio(){
        $this->predio = Predio::make([
            'estado' => 16,
            'edificio' => 0,
            'departamento' => 0,
            'oficina' => auth()->user()->oficina->oficina,
            'municipio' => auth()->user()->oficina->municipio,
            'region_catastral' => auth()->user()->oficina->region,
        ]);
    }

    public function updatedPredioLocalidad(){

        $this->predio->zona_catastral = $this->predio->localidad;

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

        $this->crearModeloVacio();

        $this->reset(['accion', 'observaciones']);

        $this->predio->oficina = auth()->user()->oficina->oficina;

    }

    public function updatedPredioOficina(){

        $oficina = Oficina::where('oficina', $this->predio->oficina)->first();

        $this->predio->municipio = $oficina?->municipio;
        $this->predio->region_catastral = $oficina?->region;
        $this->predio->zona_catastral = $this->predio->localidad;

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

            if($this->predio->status == 'baja'){

                $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra dado de baja."]);

                $this->crearModeloVacio();

                return;

            }

            if($this->predio->status != 'activo'){

                $this->dispatch('mostrarMensaje', ['warning', "El predio no esta activo."]);

                $this->crearModeloVacio();

                return;

            }

            $this->dispatch('cargarPredioPadron', $this->predio->id);

        } catch(ModelNotFoundException $e){

            $this->dispatch('mostrarMensaje', ['warning', "El predio no existe."]);

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

            if($this->predio->status == 'bloqueado'){

                $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra bloqueado."]);

                $this->crearModeloVacio();

                return;

            }

            if($this->predio->status == 'baja'){

                $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra dado de baja."]);

                $this->crearModeloVacio();

                return;

            }

            if($this->predio->status != 'activo'){

                $this->dispatch('mostrarMensaje', ['warning', "El predio no esta activo."]);

                $this->crearModeloVacio();

                return;

            }

        } catch(ModelNotFoundException $e){

            $this->dispatch('mostrarMensaje', ['warning', "El predio no existe."]);

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "No se encontro predio con la clave catastral ingresada."]);

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

            DB::transaction(function () use($valor){

                $this->predio->valor_catastral = $valor;

                $this->predio->indexado_en = now();

                $this->predio->save();

                $this->predio->audits()->latest()->first()->update(['tags' => 'Indexó predio']);

                $this->dispatch('mostrarMensaje', ['success', "El valor del predio se indexó correctamente."]);

                $this->modalIndexar = false;

            });

        } catch (\Throwable $th) {

            Log::error("Error al indexar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function darDeBaja(){

        $this->validate([
            'accion' => 'required',
            'observaciones' => 'required'
        ]);

        try {

            DB::transaction(function () {

                $this->predio->update([
                    'status' => 'baja',
                    'actualizado_por' => auth()->id(),
                    'observaciones' => $this->predio->observaciones . '. ' . $this->observaciones
                ]);

                $this->predio->movimientos()->create([
                    'nombre' => $this->accion,
                    'fecha' => now()->toDateString(),
                    'descripcion' => $this->observaciones,
                    'creado_por' => auth()->id()
                ]);

                $this->predio->audits()->latest()->first()->update(['tags' => 'Dio de baja predio']);

                $this->dispatch('mostrarMensaje', ['success', "El predio se dió de baja correctamente."]);

                $this->modalBaja = false;

                $this->crearModeloVacio();

            });

        } catch (\Throwable $th) {

            Log::error("Error al dar de baja predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function validarTitulo(){

        $predio = Predio::whereIn('documento_entrada', ['TÍTULO DE PROPIEDAD PARCELARIO', 'TÍTULO DE PROPIEDAD SOLAR URBANO'])
                            ->where('documento_numero', $this->predio->documento_numero)
                            ->first();

        if($predio) throw new GeneralException("El título de propiedad ya esta registrado.");

    }

    public function revisarValorMinimo($valor){

        $uma = Uma::where('año', now()->format('Y'))->first();

        if($this->predio->tipo_predio == 1 && $this->predio->valor_catastral < $uma->minimo_urbano) return $uma->minimo_urbano;

        if($this->predio->tipo_predio == 2 && $this->predio->valor_catastral < $uma->minimo_rustico) return $uma->minimo_rustico;

        return ceil($valor);

    }

    public function crear(){

        $this->validate();

        try {

            $this->validarSector();

            $this->validarTitulo();

            $this->validarDisponibilidadPadron();

            DB::transaction(function () {

                $this->predio->creado_por = auth()->id();
                $this->predio->valor_catastral = $this->revisarValorMinimo($this->predio->valor_catastral);
                $this->predio->save();

                $this->predio->audits()->latest()->first()->update(['tags' => 'Dió de alta predio']);

                $this->predio->movimientos()->create([
                    'nombre' => $this->accion,
                    'fecha' => now()->toDateString(),
                    'descripcion' => $this->observaciones,
                    'creado_por' => auth()->id()
                ]);

                $this->dispatch('cargarPredioPadron', $this->predio->id);

                $this->dispatch('mostrarMensaje', ['success', "El predio se dió de alta correctamente."]);

                $this->reset(['accion', 'observaciones']);

                $this->actualizacion = true;

            });

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['error', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al crear predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function actualizarConColindancias(){

        $this->actualizar();

        $this->dispatch('guardarColindancias');

    }

    public function actualizar(){

        $this->validate();

        try {

            $this->validarSector();

            $this->validarTitulo();

            DB::transaction(function () {

                $this->predio->actualizado_por = auth()->id();
                $this->predio->valor_catastral = $this->revisarValorMinimo($this->predio->valor_catastral);
                $this->predio->save();

                $this->predio->audits()->latest()->first()->update(['tags' => 'Actualizo información del predio']);

                $this->predio->movimientos()->create([
                    'nombre' => $this->accion,
                    'fecha' => now()->toDateString(),
                    'descripcion' => $this->observaciones,
                    'creado_por' => auth()->id()
                ]);

            });

            $this->dispatch('mostrarMensaje', ['success', "El predio se actualizó correctamente."]);

            $this->reset(['accion', 'observaciones']);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function mount(){

        $this->acciones_alta = array_keys(Constantes::MOVIMIENTOS, 'ALTA');

        $this->acciones_baja = array_keys(Constantes::MOVIMIENTOS, 'BAJA');

        $this->acciones_actualizacion = array_keys(Constantes::MOVIMIENTOS, 'ACTUALIZACION');

        $this->tipoVialidades = Constantes::TIPO_VIALIDADES;

        $this->tipoAsentamientos = Constantes::TIPO_ASENTAMIENTO;

        $this->documentos = Constantes::DOCUMENTO_ENTRADA;

        $this->notarias = Notaria::all();

        $this->crearModeloVacio();

    }

    public function render()
    {
        return view('livewire.gestion-catastral.captura.captura')->extends('layouts.admin');
    }
}
