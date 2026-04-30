<?php

namespace App\Traits\Predios;

use App\Exceptions\GeneralException;
use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\PredioAvaluo;

trait ValidarDisponibilidad
{

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

        if($predioCompleto){

            throw new GeneralException("El predio ya existe en el padrón, verifique.");

        }else{

            $cuentaPredial = Predio::where('localidad', $this->predio->localidad)
                                        ->where('oficina', $this->predio->oficina)
                                        ->where('tipo_predio', $this->predio->tipo_predio)
                                        ->where('numero_registro', $this->predio->numero_registro)
                                        ->first();

            if($cuentaPredial){

                throw new GeneralException("La cuenta predial ya existe en el padrón con otra clave catastral, verifique.");

            }

            $claveCatastral = Predio::where('estado', $this->predio->estado)
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

                throw new GeneralException("La clave catastral ya existe en el padrón con otra cuenta predial, verifique.");

            }

        }

        $predioCompletoAvaluo = PredioAvaluo::where('status', 'activo')
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
                                                ->where('oficina', $this->predio->oficina)
                                                ->where('tipo_predio', $this->predio->tipo_predio)
                                                ->where('oficina', $this->predio->oficina)
                                                ->where('tipo_predio', $this->predio->tipo_predio)
                                                ->where('numero_registro', $this->predio->numero_registro)
                                                ->first();

        if($predioCompletoAvaluo){

            throw new GeneralException("El predio ya existe en avaluos, verifique.");

        }else{

            $cuentaPredialAvaluo = PredioAvaluo::where('status', 'activo')
                                                ->where('localidad', $this->predio->localidad)
                                                ->where('oficina', $this->predio->oficina)
                                                ->where('tipo_predio', $this->predio->tipo_predio)
                                                ->where('numero_registro', $this->predio->numero_registro)
                                                ->first();

            if($cuentaPredialAvaluo){

                throw new GeneralException("La cuenta predial ya existe en avaluos con otra clave catastral, verifique.");

            }

            $claveCatastralAvaluo = PredioAvaluo::where('status', 'activo')
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

            if($claveCatastralAvaluo){

                throw new GeneralException("La clave catastral ya existe en avaluos con otra cuenta predial, verifique.");

            }

        }

    }

    public function validarDisponibilidadPredioIgnorado(){

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

        if($predioCompleto){

            throw new GeneralException("El predio ya existe en el padrón, verifique.");

        }else{

            $claveCatastral = Predio::where('estado', $this->predio->estado)
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

                throw new GeneralException("La clave catastral ya existe en el padrón con otra cuenta predial, verifique.");

            }

        }

        $predioCompletoAvaluo = PredioAvaluo::where('status', 'activo')
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
                                                ->where('oficina', $this->predio->oficina)
                                                ->where('tipo_predio', $this->predio->tipo_predio)
                                                ->where('numero_registro', $this->predio->numero_registro)
                                                ->first();

        if($predioCompletoAvaluo){

            throw new GeneralException("El predio ya existe en avaluos, verifique.");

        }else{

            $claveCatastralAvaluo = PredioAvaluo::where('status', 'activo')
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

            if($claveCatastralAvaluo){

                throw new GeneralException("La clave catastral ya existe en avaluos con otra cuenta predial, verifique.");

            }

        }

    }

    public function validarDisponibilidadPadron(){

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

        if($predioCompleto){

            throw new GeneralException("El predio ya existe en el padrón, verifique.");

        }else{

            $cuentaPredial = Predio::where('localidad', $this->predio->localidad)
                                        ->where('oficina', $this->predio->oficina)
                                        ->where('tipo_predio', $this->predio->tipo_predio)
                                        ->where('numero_registro', $this->predio->numero_registro)
                                        ->first();

            if($cuentaPredial){

                throw new GeneralException("La cuenta predial ya existe en el padrón con otra clave catastral, verifique.");

            }

            $claveCatastral = Predio::where('estado', $this->predio->estado)
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

                throw new GeneralException("La clave catastral ya existe en el padrón con otra cuenta predial, verifique.");

            }

        }

    }

    public function validarDisponibilidadPredioAvaluo(int $region_catastral, int $municipio, int $zona_catastral, int $localidad, int $sector, int $manzana, int $predio, int $edificio, int $departamento, int $oficina, int $tipo_predio, int $numero_registro){

        $predioCompletoAvaluo = PredioAvaluo::where('status', 'activo')
                                    ->where('estado', 16)
                                    ->where('region_catastral', $region_catastral)
                                    ->where('municipio', $municipio)
                                    ->where('zona_catastral', $zona_catastral)
                                    ->where('localidad', $localidad)
                                    ->where('sector', $sector)
                                    ->where('manzana', $manzana)
                                    ->where('predio', $predio)
                                    ->where('edificio', $edificio)
                                    ->where('departamento', $departamento)
                                    ->where('oficina', $oficina)
                                    ->where('tipo_predio', $tipo_predio)
                                    ->where('numero_registro', $numero_registro)
                                    ->first();

        if($predioCompletoAvaluo){

            $avaluo = Avaluo::where('predio_avaluo', $predioCompletoAvaluo->id)->where('estado', 'nuevo')->first();

            if($avaluo){

                throw new GeneralException("Ya existe en un avaluo del predio " . $predioCompletoAvaluo->cuentaPredial());
            }

        }

    }

}
