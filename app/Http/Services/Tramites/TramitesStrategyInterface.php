<?php

namespace App\Http\Services\Tramites;

use App\Models\Tramite;

interface TramitesStrategyInterface
{

    public function cambiarFlags();

    public function crearTramite(array $predios);

    public function actualizarTramite(array $predios);

    public function validaciones();

}
