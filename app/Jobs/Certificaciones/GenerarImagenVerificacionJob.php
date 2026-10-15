<?php

namespace App\Jobs\Certificaciones;

use App\Models\Certificacion;
use App\Traits\Certificaciones\CrearImagenTrait;
use App\Traits\Certificaciones\GeneradorQRTrait;
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

}
