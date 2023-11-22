<?php

namespace App\Http\Controllers\Valuacion;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\PredioAvaluo;
use Illuminate\Support\Facades\Storage;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class AvaluosController extends Controller
{
    public function imprime($collection, $tramiteInspeccion, $tramiteAvaluo, $ciudad = null, $hora = null, $dia = null, $mes = null, $año = null, $nombre = null, $calidad = null, $director, $jefeDepartamento, $valuador, $valuador_municipal, $autoridad_municipal)
    {

        $qr = $this->generadorQr();

        if($collection->count() > 1){

            $oMerger = PDFMerger::init();

            foreach ($collection as $predio) {

                $pdf = Pdf::loadView('avaluos.avaluo', compact('qr', 'predio', 'tramiteInspeccion', 'tramiteAvaluo', 'ciudad', 'hora', 'dia', 'mes', 'año', 'nombre', 'calidad', 'director', 'jefeDepartamento', 'valuador', 'valuador_municipal', 'autoridad_municipal'));

                $pdf->render();

                $dom_pdf = $pdf->getDomPDF();

                $canvas = $dom_pdf->get_canvas();

                $canvas->page_text(280, 810, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

                $pdf = $dom_pdf->output();

                Storage::put('avaluos_pdf/'. $tramiteInspeccion->folio . '-' .$predio->avaluo->folio . '.pdf', $pdf);

                $oMerger->addPDF(Storage::path('avaluos_pdf/'. $tramiteInspeccion->folio . '-' .$predio->avaluo->folio . '.pdf'), 'all');

            }

            $oMerger->merge();

            Storage::put('avaluos_pdf/' . $tramiteInspeccion->folio .'.pdf', $oMerger->output());

            return 'app/avaluos_pdf/' . $tramiteInspeccion->folio .'.pdf';

        }else{

            $predio = $collection->first();

            $pdf = Pdf::loadView('avaluos.avaluo', compact('qr', 'predio', 'tramiteInspeccion', 'tramiteAvaluo', 'ciudad', 'hora', 'dia', 'mes', 'año', 'nombre', 'calidad', 'director', 'jefeDepartamento', 'valuador', 'valuador_municipal', 'autoridad_municipal'));

            $pdf->render();

            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->get_canvas();

            $canvas->page_text(280, 810, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

            $pdf = $dom_pdf->output();

            Storage::put('avaluos_pdf/'. $tramiteInspeccion->folio . '-' . $collection->first()->avaluo->folio . '.pdf', $pdf);

            return 'app/avaluos_pdf/'. $tramiteInspeccion->folio . '-' . $collection->first()->avaluo->folio . '.pdf';

        }

    }

    public function generadorQr(){

        $result = Builder::create()
                            ->writer(new PngWriter())
                            ->writerOptions([])
                            ->data('https://irycem.michoacan.gob.mx/')
                            ->encoding(new Encoding('UTF-8'))
                            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                            ->size(100)
                            ->margin(0)
                            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
                            ->labelText('Escanea para verificar')
                            ->labelFont(new NotoSans(7))
                            ->labelAlignment(new LabelAlignmentCenter())
                            ->validateResult(false)
                            ->build();

        return $result->getDataUri();
    }

    public function test($id){

        $predio = PredioAvaluo::find($id);

        $qr = $this->generadorQr();

        $pdf = Pdf::loadView('avaluos.avaluo', compact('qr', 'predio'));

        $pdf->render();

        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(280, 810, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('documento.pdf');
    }

}
