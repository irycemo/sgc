<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tramite;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Picqer\Barcode\BarcodeGeneratorPNG;

class TramiteController extends Controller
{

    public function orden(Tramite $tramite){

        $tramite->load('predios.propietarios.persona', 'servicio');

        $generatorPNG = new BarcodeGeneratorPNG();

        $pdf = Pdf::loadView('tramites.orden', compact('tramite', 'generatorPNG'));

        return $pdf->stream('orden_' . $tramite->folio . '.pdf');

    }
}
