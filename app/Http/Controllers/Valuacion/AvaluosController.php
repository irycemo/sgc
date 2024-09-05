<?php

namespace App\Http\Controllers\Valuacion;

use App\Models\User;
use App\Models\Oficina;
use App\Models\Tramite;
use App\Models\PredioAvaluo;
use App\Models\Certificacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use PhpCfdi\Credentials\Credential;
use App\Http\Controllers\Controller;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Font\NotoSans;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

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

    public function generadorQr()
    {

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

    public function teste($id)
    {

        $cadena = null;

        $predios = PredioAvaluo::with('avaluo.asignadoA')->whereIn('id', [2])->get();

        foreach($predios as $predio){

            $cadena = 'Folio avalúo:' . ':' . $predio->avaluo->año . '-' . $predio->avaluo->folio . '|' . 'Cuenta predial: ' . $predio->cuentaPredial() . '|' . 'Clave catastral: ' . $predio->claveCatastral() . '|' . 'Propietario: ' . $predio->primerPropietario();

        }

        $qr = $this->generadorQr();

        $formatter = new NumeroALetras();

        $numero_avaluos_letra = $formatter->toWords($predios->count());

        $tramiteInspeccion = Tramite::where('año', '2024')->where('folio', 31332140)->where('usuario', 1)->first();

        $tramiteAvaluo = Tramite::where('año', '2024')->where('folio', 31332141)->where('usuario', 1)->first();

        $cadena = $cadena . '|' . 'Trámite de inspección: ' . $tramiteInspeccion->año . '-' . $tramiteInspeccion->folio . '-'. $tramiteInspeccion->usuario . '|' . 'Recibo: ' . $tramiteInspeccion->folio_pago;

        if($tramiteAvaluo){

            $cadena = $cadena . '|' . 'Trámite de avalúo: ' . $tramiteAvaluo->año . '-' . $tramiteAvaluo->folio . '-'. $tramiteAvaluo->usuario  . '|' . 'Recibo: ' . $tramiteAvaluo->folio_pago;

        }

        $cadena = $cadena . '|' . 'Valuador: ' . $predio->avaluo->asignadoA->nombreCompleto();

        $director = User::with('efirma')->where('status', 'activo')
                                ->whereHas('roles', function($q){
                                    $q->where('name', 'Director');
                                })
                                ->first();

        $jefe_departamento = User::with('efirma')->where('status', 'activo')
                                            ->whereHas('roles', function($q){
                                                $q->where('name', 'Jefe de departamento');
                                            })
                                            ->where('area', 'Departamento de Valuación')
                                            ->first();

        $fielDirector = Credential::openFiles(Storage::disk('efirma')->path($director->efirma->cer), Storage::disk('efirma')->path($director->efirma->key), $director->efirma->contraseña);

        $fielJefe = Credential::openFiles(Storage::disk('efirma')->path($jefe_departamento->efirma->cer), Storage::disk('efirma')->path($jefe_departamento->efirma->key), $jefe_departamento->efirma->contraseña);

        $firmaDirector = $fielDirector->sign($cadena);

        $firmaJefe = $fielJefe->sign($cadena);

        $fechaImpresion = now()->format('d-m-Y H:i:s');

        $certificacion = Certificacion::create([
            'año' => now()->format('Y'),
            'folio' => (Certificacion::where('año', now()->format('Y'))->where('documento', 'NOTIFICACIÓN DE VALOR CATASTRAL')->max('folio') ?? 0) + 1,
            'documento' => 'NOTIFICACIÓN DE VALOR CATASTRAL',
            'cadena_originial' => $cadena,
            'cadena_encriptada' => base64_encode($firmaDirector),
            'estado' => 'activo',
            'oficina_id' => Oficina::where('oficina', $predio->oficina)->first()->id,
            'tramite_id' => $tramiteInspeccion->id,
            'creado_por' => auth()->id(),
            'actualizado_por' => auth()->id()
        ]);

        $pdf = Pdf::loadView('avaluos.notificacion', [
            'predios' => $predios,
            'numero_avaluos_letra' => $numero_avaluos_letra,
            'tramiteInspeccion' => $tramiteInspeccion,
            'tramiteAvaluo' => $tramiteAvaluo,
            'director' => $director->nombreCompleto(),
            'jefe_departamento' => $jefe_departamento->nombreCompleto(),
            'firmaDirector' => base64_encode($firmaDirector),
            'firmaJefe' => base64_encode($firmaJefe),
            'qr' => $qr,
            'certificacion' => $certificacion,
            'fecha_impresion' => $fechaImpresion,
            'impreso_por' => auth()->user()->nombreCompleto()
        ]);

        $pdf->render();

        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(480, 794, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

        /* $pdf = $dom_pdf->output(); */

        return $pdf->stream('documento.pdf');
    }

}
