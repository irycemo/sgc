<?php

namespace App\Http\Services\Tramites\Strategies;

use App\Models\Tramite;
use App\Exceptions\TramiteNoRegistradoException;
use App\Http\Services\Tramites\TramitesStrategyInterface;

class Reset implements TramitesStrategyInterface{

    public function __construct(public Tramite $tramite){}

    public function cambiarFlags():array
    {

        return [
            'flag_tipo_de_tramite' => false,
            'flag_tipo_de_servicio' => false,
            'cantidad' => false,
            'importe_base' => false,
            'solicitante' => false,
            'predios' => false,
            'observaciones' => false,
            'adiciona' => false,
            'angulo' => false
        ];

    }

    public function crearTramite($predios):Tramite
    {

        throw new TramiteNoRegistradoException('El trámite no esta registrado en TramitesContexto. ' . 'Servicio id: ' . $this->tramite->id_servicio);

        return $this->tramite;

    }

    public function actualizarTramite($predios):Tramite
    {

        throw new TramiteNoRegistradoException('El trámite no esta registrado en TramitesContexto. ' . 'Servicio id: ' . $this->tramite->id_servicio);

        return $this->tramite;

    }

    public function validaciones():array
    {

        return [

        ];

    }

}
