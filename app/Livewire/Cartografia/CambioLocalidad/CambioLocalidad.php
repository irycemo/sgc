<?php

namespace App\Livewire\Cartografia\CambioLocalidad;

use App\Models\Predio;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Traits\Predios\ValidarSector;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CambioLocalidad extends Component
{

    use ValidarSector;

    public Predio $predio;
    public $predio_nuevo;
    public $localidad;
    public $oficina;
    public $tipo_predio;
    public $numero_registro;

    protected function rules(){

        return [
            'localidad' => 'required|numeric',
            'oficina' => 'required|numeric',
            'tipo_predio' => 'required|numeric',
            'numero_registro' => 'required|numeric',
            'predio_nuevo.numero_registro' => 'required|numeric|min:1',
            'predio_nuevo.region_catastral' => 'required|numeric|min:1',
            'predio_nuevo.municipio' => 'required|numeric|min:1',
            'predio_nuevo.localidad' => 'required|numeric|min:1',
            'predio_nuevo.sector' => 'required|numeric|min:1',
            'predio_nuevo.zona_catastral' => 'required|numeric|min:1,|same:predio.localidad',
            'predio_nuevo.manzana' => 'required|numeric|min:1',
            'predio_nuevo.predio' => 'required|numeric|min:1',
            'predio_nuevo.edificio' => 'required|numeric|min:0',
            'predio_nuevo.departamento' => 'required|numeric|min:0',
            'predio_nuevo.tipo_predio' => 'required|numeric|min:1|max:2',
            'predio_nuevo.oficina' => 'required|numeric|min:1',
            'predio_nuevo.estado' => 'required',
            'predio_nuevo.tipo_asentamiento' => 'required',
            'predio_nuevo.nombre_asentamiento' => 'required',
            'predio_nuevo.tipo_vialidad' => 'required',
            'predio_nuevo.nombre_vialidad' => 'required',
            'predio_nuevo.numero_exterior' => 'required',
            'predio_nuevo.numero_exterior_2' => 'nullable',
            'predio_nuevo.numero_interior' => 'nullable',
            'predio_nuevo.numero_adicional_2' => 'nullable',
            'predio_nuevo.numero_adicional' => 'nullable',
            'predio_nuevo.codigo_postal' => 'required|numeric',
            'predio_nuevo.lote_fraccionador' => 'nullable',
            'predio_nuevo.manzana_fraccionador' => 'nullable',
            'predio_nuevo.etapa_fraccionador' => 'nullable',
            'predio_nuevo.nombre_predio'  => 'nullable',
            'predio_nuevo.nombre_edificio' => 'nullable',
            'predio_nuevo.clave_edificio' => 'nullable',
            'predio_nuevo.departamento_edificio' => 'nullable',
            'predio_nuevo.xutm' => 'nullable|string',
            'predio_nuevo.yutm' => 'nullable|string',
            'predio_nuevo.zutm' => 'nullable',
            'predio_nuevo.lat' => 'required|numeric',
            'predio_nuevo.lon' => 'required|numeric',
            'predio_nuevo.uso_1' => 'nullable',
            'predio_nuevo.uso_2' => 'nullable',
            'predio_nuevo.uso_3' => 'nullable',
            'predio_nuevo.superficie_judicial' => 'nullable|numeric',
            'predio_nuevo.superficie_notarial' => 'nullable|numeric',
            'predio_nuevo.valor_catastral' => 'required|numeric',
            'predio_nuevo.valor_total_terreno' => 'required|numeric',
            'predio_nuevo.valor_total_construccion' => 'required|numeric',
            'predio_nuevo.superficie_total_construccion' => 'nullable|numeric',
            'predio_nuevo.superficie_total_terreno' => 'required|numeric',
            'predio_nuevo.documento_entrada' => 'nullable',
            'predio_nuevo.declarante' => 'nullable',
            'predio_nuevo.documento_numero' => 'nullable',
            'predio_nuevo.fecha_efectos' => 'nullable',
            'predio_nuevo.observaciones' => 'nullable',
        ];

    }

    public function buscarCuentaPredial(){

        try {

            $this->predio = Predio::where('localidad', $this->localidad)
                                    ->where('oficina', $this->oficina)
                                    ->where('tipo_predio', $this->tipo_predio)
                                    ->where('numero_registro', $this->numero_registro)
                                    ->firstOrFail();

            if($this->predio->status == 'bloqueado'){

                $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra bloqueado."]);
                return;

            }

            $this->predio_nuevo = $this->predio->replicate();

        } catch(ModelNotFoundException $e){

            $this->dispatch('mostrarMensaje', ['warning', "No se encontro predio con la cuenta predial ingresada."]);

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function cambiarLocalidad(){

        try {

            $this->validarDisponibilidadPadron();

            $this->validarSector($this->predio_nuevo->localidad, $this->predio_nuevo->oficina, $this->predio_nuevo->municipio, $this->predio->sector);

            DB::transaction(function () {

                $this->predio_nuevo->save();

                $this->procesarRelaciones();

                $this->predio->update(['status' => 'baja']);

                $this->predio->movimientos()->create([
                    'nombre' => 'Baja',
                    'fecha' => now()->toDateString(),
                    'descripcion' => 'Se da de baja por cambio de localidad dando origen al predio: ' . $this->predio_nuevo->cuentaPredial(),
                    'creado_por' => auth()->id()
                ]);

                $this->predio_nuevo->movimientos()->create([
                    'nombre' => 'Alta',
                    'fecha' => now()->toDateString(),
                    'descripcion' => 'Se da de alta por cambio de localidad con predio origen: ' . $this->predio->cuentaPredial(),
                    'creado_por' => auth()->id()
                ]);

                $this->dispatch('mostrarMensaje', ['success', 'El cambio de localidad se hizo con éxito.']);

                $this->crearModeloVacio();

                $this->reset('predio_nuevo');

            });

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al hacer cambio de localidad por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function validarDisponibilidadPadron(){

        $predioCompleto = Predio::where('estado', $this->predio_nuevo->estado)
                                    ->where('region_catastral', $this->predio_nuevo->region_catastral)
                                    ->where('municipio', $this->predio_nuevo->municipio)
                                    ->where('zona_catastral', $this->predio_nuevo->zona_catastral)
                                    ->where('localidad', $this->predio_nuevo->localidad)
                                    ->where('sector', $this->predio_nuevo->sector)
                                    ->where('manzana', $this->predio_nuevo->manzana)
                                    ->where('predio', $this->predio_nuevo->predio)
                                    ->where('edificio', $this->predio_nuevo->edificio)
                                    ->where('departamento', $this->predio_nuevo->departamento)
                                    ->where('oficina', $this->predio_nuevo->oficina)
                                    ->where('tipo_predio', $this->predio_nuevo->tipo_predio)
                                    ->where('numero_registro', $this->predio_nuevo->numero_registro)
                                    ->first();

        if($predioCompleto){

            throw new GeneralException("El predio ya existe en el padrón, verifique.");

        }else{

            $cuentaPredial = Predio::where('localidad', $this->predio_nuevo->localidad)
                                        ->where('oficina', $this->predio_nuevo->oficina)
                                        ->where('tipo_predio', $this->predio_nuevo->tipo_predio)
                                        ->where('numero_registro', $this->predio_nuevo->numero_registro)
                                        ->first();

            if($cuentaPredial){

                throw new GeneralException("La cuenta predial ya existe en el padrón con otra clave catastral, verifique.");

            }

            $claveCatastral = Predio::where('estado', $this->predio_nuevo->estado)
                                        ->where('region_catastral', $this->predio_nuevo->region_catastral)
                                        ->where('municipio', $this->predio_nuevo->municipio)
                                        ->where('zona_catastral', $this->predio_nuevo->zona_catastral)
                                        ->where('localidad', $this->predio_nuevo->localidad)
                                        ->where('sector', $this->predio_nuevo->sector)
                                        ->where('manzana', $this->predio_nuevo->manzana)
                                        ->where('predio', $this->predio_nuevo->predio)
                                        ->where('edificio', $this->predio_nuevo->edificio)
                                        ->where('departamento', $this->predio_nuevo->departamento)
                                        ->first();

            if($claveCatastral){

                throw new GeneralException("La clave catastral ya existe en el padrón con otra cuenta predial, verifique.");

            }

        }

    }

    public function procesarRelaciones(){

        /* Propietarios */
        foreach($this->predio->propietarios as $propietario){

            $this->predio_nuevo->propietarios()->create([
                'persona_id' => $propietario->persona_id,
                'tipo' => $propietario->tipo,
                'porcentaje_propiedad' => $propietario->porcentaje_propiedad,
                'porcentaje_nuda' => $propietario->porcentaje_nuda,
                'porcentaje_usufructo' => $propietario->porcentaje_usufructo,
            ]);

        }

        /* Colindancias */
        foreach($this->predio->colindancias as $colindancia){

            $this->predio_nuevo->colindancias()->create([
                'viento' => $colindancia['viento'],
                'longitud' => $colindancia['longitud'],
                'descripcion' => $colindancia['descripcion'],
            ]);

        }

        /* Construcciones */
        foreach($this->predio->construcciones as $construccion){

            $this->predio_nuevo->construcciones()->create([
                'referencia' => $construccion['referencia'],
                'valor_unitario' => $construccion['valor_unitario'],
                'niveles' => $construccion['niveles'],
                'superficie' => $construccion['superficie'],
                'uso' => $construccion['uso'],
                'tipo' => $construccion['tipo'],
                'calidad' => $construccion['calidad'],
                'estado' => $construccion['estado'],
                'valor_construccion' => (float)$construccion['valor_unitario'] * (float)$construccion['superficie']
            ]);

        }

        /* Terrenos */
        foreach($this->predio->terrenos as $terreno){

            $this->predio_nuevo->terrenos()->create([
                'superficie' => $terreno['superficie'],
                'valor_unitario' => $terreno['valor_unitario'],
                'demerito' => $terreno['demerito'],
                'valor_demeritado' => $terreno['valor_demeritado'],
                'valor_terreno' => $terreno['valor_terreno'],
            ]);

        }

        /* Terrenos en común */
        foreach($this->predio->terrenosComun as $terrenoComun){

            $this->predio_nuevo->terrenosComun()->create([
                'area_terreno_comun' => $terrenoComun['area_terreno_comun'],
                'indiviso_terreno' => $terrenoComun['indiviso_terreno'],
                'valor_unitario' => $terrenoComun['valor_unitario'],
                'valor_terreno_comun' => $terrenoComun['valor_terreno_comun'],
                'superficie_proporcional' => $terrenoComun['superficie_proporcional'],
            ]);

        }

        /* Construcciones en común */
        foreach($this->predio->construccionesComun as $construccionComun){

            $this->predio_nuevo->construccionesComun()->create([
                'area_comun_construccion' => $construccionComun['area_comun_construccion'],
                'indiviso_construccion' => $construccionComun['indiviso_construccion'],
                'valor_clasificacion_construccion' => $construccionComun['valor_clasificacion_construccion'],
                'valor_construccion_comun' => $construccionComun['valor_construccion_comun'],
            ]);

        }

    }

    public function crearModeloVacio(){
        $this->predio = Predio::make([
            'estado' => 16,
            'edificio' => 0,
            'departamento' => 0
        ]);
    }

    public function mount(){

        $this->crearModeloVacio();

    }

    public function render()
    {
        return view('livewire.cartografia.cambio-localidad.cambio-localidad')->extends('layouts.admin');
    }

}
