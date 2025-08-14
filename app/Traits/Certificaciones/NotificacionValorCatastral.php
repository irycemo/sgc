<?php

namespace App\Traits\Certificaciones;

use App\Models\Avaluo;

trait NotificacionValorCatastral{

    public function avaluos($avaluos){

        $avaluos_procesados = collect();

        foreach($avaluos as $avaluo){

            $item = (object)[];

            $item->folio = $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario;
            $item->cuenta_predial = $avaluo->predioAvaluo->cuentaPredial();
            $item->clave_catastral = $avaluo->predioAvaluo->claveCatastral();
            $item->propietario = $avaluo->predioAvaluo->primerPropietario();
            $item->valor_catastral = $avaluo->predioAvaluo->valor_catastral;

            $avaluos_procesados->push($item);

        }

        return $avaluos_procesados;

    }

}