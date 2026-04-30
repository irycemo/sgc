<?php

namespace App\Traits\Predios;

use App\Exceptions\GeneralException;
use App\Models\ManzanaAsignada;

trait ValidarManzanaAsignada
{

    public function validarManzanaAsignada(){

        $cuenta = ManzanaAsignada::where('municipio', $this->predio->municipio)
                                    ->where('zona', $this->predio->zona)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('sector', $this->predio->sector)
                                    ->where('manzana', $this->predio->manzana)
                                    ->where('asignado_a', auth()->id())
                                    ->first();

        if(!$cuenta) throw new GeneralException("No tienes asignada la manzana ingresada.");

    }

}
