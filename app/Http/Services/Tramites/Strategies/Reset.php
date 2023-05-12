<?php

namespace App\Http\Services\Tramites\Strategies;

use App\Models\Tramite;
use App\Exceptions\TramiteNoRegistradoException;
use App\Http\Services\Tramites\TramitesStrategyInterface;

class Reset implements TramitesStrategyInterface{

    public $tramite;

    public function __construct(Tramite $tramite)
    {
        $this->tramite = $tramite;
    }

    public function cambiarFlags(){

        return [
            'flag_tipo_de_tramite' => false,
            'flag_tipo_de_servicio' => false,
            'cantidad' => false,
            'importe_base' => false,
            'solicitante' => false,
            'predios' => false,
            'observaciones' => false,
            'adiciona' => false,
        ];

    }

    public function crearTramite($predios){

        throw new TramiteNoRegistradoException('El trámite no esta registrado en TramitesContexto. ' . 'Servicio id: ' . $this->tramite->id_servicio);

        return $this->tramite;

    }

    public function actualizarTramite($predios){

        throw new TramiteNoRegistradoException('El trámite no esta registrado en TramitesContexto. ' . 'Servicio id: ' . $this->tramite->id_servicio);

        return $this->tramite;

    }

    public function validaciones(){

        return [

        ];

    }

}
