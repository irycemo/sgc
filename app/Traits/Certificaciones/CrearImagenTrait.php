<?php

namespace App\Traits\Certificaciones;

use App\Enums\Certificaciones\CertificacionesEnum;
use Imagick;
use App\Models\File;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

trait CrearImagenTrait
{

    public function crearImagenConMarcaDeAgua($object, $qr, $certificacion){

        $pdf = $this->matchCertificacion($certificacion, $object, $qr);

        $pdf->render();

        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(480, 745, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

        $canvas->page_text(35, 745, $certificacion->tipo->label() . '-' . $certificacion->año .'-' . $certificacion->folio, null, 9, array(1, 1, 1));

        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $w = $canvas->get_width();
            $h = $canvas->get_height();

            $canvas->image(public_path('storage/img/watermark.png'), 0, 0, $w, $h, $resolution = "normal");

        });

        $nombre = Str::random(40);

        $nombreFinal = $nombre . '.pdf';

        Storage::disk('certificaciones')->put($nombreFinal, $pdf->output());

        $pdfImagen = new \Spatie\PdfToImage\Pdf('certificaciones/' . $nombreFinal);

        $all = new Imagick();

        for ($i=1; $i <= $pdfImagen->pageCount(); $i++) {

            $nombre_img = $nombre . '_' . $i . '.jpg';

            $pdfImagen->selectPage($i)->save('certificaciones/'. $nombre_img);

            $im = new Imagick(Storage::disk('certificaciones')->path($nombre_img));

            $all->addImage($im);

            unlink('certificaciones/' . $nombre_img);

        }

        $all->resetIterator();
        $combined = $all->appendImages(true);
        $combined->setImageFormat("jpg");

        if(app()->isProduction()){

            Storage::disk('s3')->put(config('services.ses.ruta_certificaciones') . $nombre . '.jpg', $combined);

        }else{

            file_put_contents("certificaciones/" . $nombre . '.jpg', $combined);

        }

        File::create([
            'fileable_id' => $certificacion->id,
            'fileable_type' => 'App\Models\Certificacion',
            'descripcion' => 'certificacion',
            'url' => $nombre . '.jpg'
        ]);

        unlink('certificaciones/' . $nombreFinal);

    }

    public function matchCertificacion($certificacion, $object, $qr){

        if($certificacion->tipo == CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL){

            return Pdf::loadView('certificaciones.notificacion_valor_catastral', [
                'datos_control' => $object->datos_control,
                'avaluos' => $object->avaluos,
                'qr' => $qr,
                'certificacion' => $certificacion
            ]);

        }elseif($certificacion->tipo == CertificacionesEnum::CERTIFICADO_NEGATIVO){

            return Pdf::loadView('certificaciones.certificado_negativo', [
                'datos_control' => $object->datos_control,
                'qr' => $qr,
                'certificacion' => $certificacion
            ]);

        }elseif($certificacion->tipo == CertificacionesEnum::CERTIFICADO_HISTORIA){

            return Pdf::loadView('certificaciones.certificado_historia', [
                'datos_control' => $object->datos_control,
                'qr' => $qr,
                'predio' => $object->predio,
                'certificacion' => $certificacion
            ]);

        }elseif($certificacion->tipo == CertificacionesEnum::CERTIFICADO_REGISTRO){

            return Pdf::loadView('certificaciones.certificado_registro', [
                'datos_control' => $object->datos_control,
                'qr' => $qr,
                'predio' => $object->predio,
                'certificacion' => $certificacion
            ]);

        }elseif($certificacion->tipo == CertificacionesEnum::CEDULA_CATASTRAL){

            return Pdf::loadView('certificaciones.cedula_actualizacion', [
                'datos_control' => $object->datos_control,
                'qr' => $qr,
                'predio' => $object->predio,
                'ultimo_movimiento' => $object->ultimo_movimiento,
                'certificacion' => $certificacion
            ]);

        }

    }

}
