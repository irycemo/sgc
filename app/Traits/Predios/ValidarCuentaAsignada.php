<?php

namespace App\Traits\Predios;

use App\Models\CuentaAsignada;
use App\Exceptions\GeneralException;

trait ValidarCuentaAsignada
{

    public function validarCuentaAsignada():CuentaAsignada
    {

        $cuenta = CuentaAsignada::where('localidad', $this->predio->localidad)
                                ->where('oficina', $this->predio->oficina)
                                ->where('tipo_predio', $this->predio->tipo_predio)
                                ->where('numero_registro', $this->predio->numero_registro)
                                ->where('asignado_a', auth()->id())
                                ->first();

        if(!$cuenta) throw new GeneralException("No tienes asignada la cuenta ingresada.");

        return $cuenta;

    }

    public function validarCuentaAsignadaNoBindings(int $localidad, int $oficina, int $tipo_predio, int $numero_registro, int $user_id):CuentaAsignada
    {

        $cuenta = CuentaAsignada::where('localidad', $localidad)
                                ->where('oficina', $oficina)
                                ->where('tipo_predio', $tipo_predio)
                                ->where('numero_registro', $numero_registro)
                                ->where('asignado_a', $user_id)
                                ->first();

        if(!$cuenta) throw new GeneralException("No tienes asignada la cuenta ingresada.");

        return $cuenta;

    }

}
