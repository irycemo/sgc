<?php

namespace App\Http\Services\Tramites;


use App\Models\Tramite;
use App\Http\Services\Tramites\Strategies\Certificados;
use App\Http\Services\Tramites\Strategies\Reset;

class TramiteContext
{

    private TramitesStrategyInterface $strategy;

    public function __construct(string $categoria, Tramite $tramite)
    {

        $this->strategy = match($categoria){

            'Certificaciones catastrales' => new Certificados($tramite),
            default => new Reset(),

        };

    }

    public function cambiarFlags():array
    {
        return $this->strategy->cambiarFlags();
    }

    public function crearTramite($predios):Tramite
    {
        return $this->strategy->crearTramite($predios);
    }

    public function actualizarTramite($predios):Tramite
    {
        return $this->strategy->actualizarTramite($predios);
    }

    public function validaciones():array
    {
        return $this->strategy->validaciones();
    }

}
