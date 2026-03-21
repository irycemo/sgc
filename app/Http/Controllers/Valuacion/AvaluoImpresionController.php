<?php

namespace App\Http\Controllers\Valuacion;

use App\Http\Controllers\Controller;
use App\Models\Avaluo;
use App\Models\Certificacion;
use App\Traits\Certificaciones\GeneradorQRTrait;
use Barryvdh\DomPDF\Facade\Pdf;

class AvaluoImpresionController extends Controller
{

    use GeneradorQRTrait;

    public function generarAvaluo(Avaluo $avaluo){

        $predio = $avaluo->predioAvaluo;

        $predio->load('propietarios.persona');

        $certificacion = Certificacion::where('tramite_id', $avaluo->tramite_inspeccion)->first();

        $qr = $this->generadorQr('verificacion_avaluo', $avaluo->uuid);

        $pdf = Pdf::loadView('avaluos.avaluo', [
            'predio' => $predio,
            'certificacion' => $certificacion,
            'qr' => $qr
        ]);

        $pdf->render();

        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(480, 745, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

        $canvas->page_text(35, 745, "Avalúo: " . $predio->avaluo->año . "-" . $predio->avaluo->folio . "-" . $predio->avaluo->usuario , null, 10, array(1, 1, 1));

        return $pdf;

    }

}
