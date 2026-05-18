<?php

namespace App\Jobs\Certificaciones;

use App\Enums\Certificaciones\CertificacionesEnum;
use App\Models\Certificacion;
use App\Traits\Certificaciones\CrearImagenTrait;
use App\Traits\Certificaciones\GeneradorQRTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class GenerarImagenVerificacionJob implements ShouldQueue
{
    use Queueable;
    use GeneradorQRTrait;
    use CrearImagenTrait;

    public $certificacion;
    public $qr;
    public $object;

    public function __construct(public int $certificacion_id)
    {}

    public function handle(): void
    {

        try {

            $this->certificacion = Certificacion::findOrFail($this->certificacion_id);

            $this->object = json_decode($this->certificacion->cadena_original);

            $this->qr = $this->generadorQr('verificacion_certificacion', $this->certificacion->uuid);

            $this->crearImagenConMarcaDeAgua($this->object, $this->qr, $this->certificacion);

        } catch (\Throwable $th) {

            Log::error("Error en job imagen con marca de agua. " . $th);

            throw $th;

        }

    }

    public function matchCertificacion(){

        if($this->certificacion->tipo == CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL){

            return Pdf::loadView('certificaciones.notificacion_valor_catastral', [
                'datos_control' => $this->object->datos_control,
                'avaluos' => $this->object->avaluos,
                'qr' => $this->qr,
                'certificacion' => $this->certificacion
            ]);

        }elseif($this->certificacion->tipo == CertificacionesEnum::CERTIFICADO_NEGATIVO){

            return Pdf::loadView('certificaciones.certificado_negativo', [
                'datos_control' => $this->object->datos_control,
                'qr' => $this->qr,
                'certificacion' => $this->certificacion
            ]);

        }elseif($this->certificacion->tipo == CertificacionesEnum::CERTIFICADO_HISTORIA){

            return Pdf::loadView('certificaciones.certificado_historia', [
                'datos_control' => $this->object->datos_control,
                'qr' => $this->qr,
                'predio' => $this->object->predio,
                'certificacion' => $this->certificacion
            ]);

        }elseif($this->certificacion->tipo == CertificacionesEnum::CERTIFICADO_REGISTRO){

            return Pdf::loadView('certificaciones.certificado_registro', [
                'datos_control' => $this->object->datos_control,
                'qr' => $this->qr,
                'predio' => $this->object->predio,
                'certificacion' => $this->certificacion
            ]);

        }elseif($this->certificacion->tipo == CertificacionesEnum::CEDULA_CATASTRAL){

            return Pdf::loadView('certificaciones.cedula_actualizacion', [
                'datos_control' => $this->object->datos_control,
                'qr' => $this->qr,
                'predio' => $this->object->predio,
                'ultimo_movimiento' => $this->object->ultimo_movimiento,
                'certificacion' => $this->certificacion
            ]);

        }

    }

}
