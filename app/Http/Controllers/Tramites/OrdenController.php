<?php

namespace App\Http\Controllers\Tramites;

use App\Models\Tramite;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Picqer\Barcode\BarcodeGeneratorPNG;

class OrdenController extends Controller
{

    public function __invoke(Tramite $tramite){

        $tramite->load('predios.propietarios.persona', 'servicio');

        $generatorPNG = new BarcodeGeneratorPNG();

        $pdf = Pdf::loadView('tramites.orden', compact('tramite', 'generatorPNG'));

        return $pdf->stream('orden_' . $tramite->folio . '.pdf');

    }
}
