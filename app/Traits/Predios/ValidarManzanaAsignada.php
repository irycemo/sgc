<?php

namespace App\Traits\Predios;

use App\Exceptions\GeneralException;
use App\Models\ManzanaAsignada;

trait ValidarManzanaAsignada
{

    public function validarManzanaAsignada():void
    {

        if($this->predio->manzana === 0) return;

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
