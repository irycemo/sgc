<?php

namespace App\Services\Tramites;

use App\Models\Tramite;
use Barryvdh\DomPDF\Facade\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;


class OrdenPagoService{

    public function generarOrdenPago(Tramite $tramite)
    {

        $tramite->load('predios.propietarios.persona', 'servicio');

        $generatorPNG = new BarcodeGeneratorPNG();

        $pdf = Pdf::loadView('tramites.orden', compact('tramite', 'generatorPNG'));

        return $pdf;

    }

}