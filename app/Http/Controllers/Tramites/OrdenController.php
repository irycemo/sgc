<?php

namespace App\Http\Controllers\Tramites;

use App\Models\Tramite;
use App\Http\Controllers\Controller;
use App\Services\Tramites\OrdenPagoService;

class OrdenController extends Controller
{

    public function __invoke(Tramite $tramite){

        $pdf = (new OrdenPagoService())->generarOrdenPago($tramite);

        return $pdf->stream('orden_' . $tramite->folio . '.pdf');

    }
}
