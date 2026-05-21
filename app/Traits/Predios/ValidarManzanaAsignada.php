<?php

namespace App\Traits\Predios;

use App\Exceptions\GeneralException;
use App\Models\ManzanaAsignada;
use App\Models\Predio;

trait ValidarManzanaAsignada
{

    public function validarManzanaAsignada():void
    {

        if($this->predio->manzana === 0) return;

        $manzana_en_padron = Predio::where('municipio', $this->predio->municipio)
                                    ->where('zona_catastral', $this->predio->zona_catastral)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('sector', $this->predio->sector)
                                    ->where('manzana', $this->predio->manzana)
                                    ->count();

        if($manzana_en_padron->count()) return;

        $cuenta = ManzanaAsignada::where('municipio', $this->predio->municipio)
                                    ->where('zona', $this->predio->zona_catastral)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('sector', $this->predio->sector)
                                    ->where('manzana', $this->predio->manzana)
                                    ->where('asignado_a', auth()->id())
                                    ->first();

        if(!$cuenta) throw new GeneralException("No tienes asignada la manzana ingresada.");

    }

    public function validarManzanaAsignadaNoBindings(int $municipio, int $zona_catastral, int $localidad, int $sector, int $manzana, int $user_id):void
    {

        $manzana_en_padron = Predio::where('municipio', $municipio)
                                    ->where('zona_catastral', $zona_catastral)
                                    ->where('localidad', $localidad)
                                    ->where('sector', $sector)
                                    ->where('manzana', $manzana)
                                    ->count();

        if($manzana_en_padron > 0) return;

        if($manzana === 0) return;

        $cuenta = ManzanaAsignada::where('municipio', $municipio)
                                    ->where('zona', $zona_catastral)
                                    ->where('localidad', $localidad)
                                    ->where('sector', $sector)
                                    ->where('manzana', $manzana)
                                    ->where('asignado_a', $user_id)
                                    ->first();

        if(!$cuenta) throw new GeneralException("No tienes asignada la manzana ingresada.");

    }

}
