<?php

namespace App\Traits\Predios;

use App\Models\CuentaAsignada;
use App\Exceptions\GeneralException;

trait ValidarCuentaAsignada
{

    public function validarCuentaAsignada(){

        $cuenta = CuentaAsignada::where('localidad', $this->predio->localidad)
                                ->where('oficina', $this->predio->oficina)
                                ->where('tipo_predio', $this->predio->tipo_predio)
                                ->where('numero_registro', $this->predio->numero_registro)
                                ->where('asignado_a', auth()->id())
                                ->first();

        if(!$cuenta) throw new GeneralException("No tienes asignada la cuenta ingresada.");

        return $cuenta;

    }

}
