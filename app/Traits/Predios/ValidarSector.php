<?php

namespace App\Traits\Predios;

use App\Models\Oficina;
use App\Exceptions\GeneralException;

trait ValidarSector
{

    public function validarSector(){

        $oficina = Oficina::where('localidad', $this->predio->localidad)
                            ->where('oficina', $this->predio->oficina)
                            ->first();

        if(!$oficina){

            throw new GeneralException("No se encontraron oficinas con los datos ingresados.");

        }

        $sectores = json_decode($oficina->sectores, true);

        if(is_null($sectores)){

            throw new GeneralException("La oficina no tiene sectores.");

        }

        if(!in_array($this->predio->sector, $sectores)){

            throw new GeneralException("El sector no corresponde a la zona.");

        }

        if($oficina->municipio != $this->predio->municipio){

            throw new GeneralException("El municipio no corresponde a la oficina.");

        }

    }

}
