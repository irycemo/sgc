<?php

namespace App\Traits\Predios;

use App\Models\Oficina;

trait UbicacionTrait
{

    public function updatedPredioOficina(){

        $oficina = Oficina::where('oficina', $this->predio->oficina)->first();

        $this->predio->municipio = $oficina?->municipio;
        $this->predio->region_catastral = $oficina?->region;
        $this->predio->zona_catastral = $this->predio->localidad;

    }

}
