<?php

namespace App\Traits\Certificaciones;

use App\Models\Certificacion;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

trait GuardarEnS3Trait
{

    private function guardarEnS3(Certificacion $certificacion, $pdf): void
    {

        $filename = $certificacion->tipo->label() . '-' . $certificacion->año .'-' . $certificacion->folio . '_' . now()->format('Ymd_His') . '.pdf';

        $clave = config('services.ses.ruta_pdfs_certificaciones') . $filename;

        Storage::disk('s3')->put(
            $clave,
            $pdf->output(),
            [
                'ContentType' => 'application/pdf',
                'ContentDisposition' => 'attachment; filename="' . $filename . '"',
            ]
        );

        File::create([
                'fileable_type' => Certificacion::class,
                'fileable_id' => $certificacion->id,
                'url' => $filename,
                'descripcion' => 'pdf',
            ]);

    }

}
