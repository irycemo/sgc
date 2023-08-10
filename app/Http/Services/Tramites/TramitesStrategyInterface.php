<?php

namespace App\Http\Services\Tramites;

interface TramitesStrategyInterface
{

    public function cambiarFlags();

    public function crearTramite(array $predios);

    public function actualizarTramite(array $predios);

    public function validaciones();

}
