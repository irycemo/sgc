<?php

namespace App\Http\Controllers\Api\V1\Certificaciones;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Certificacion;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Certificaciones\CertificadoRegistroController;
use App\Traits\Certificaciones\GuardarEnS3Trait;

class GenerarCertificadoPdfController extends Controller
{

    use GuardarEnS3Trait;

    public function generarPdf(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $certificacion = Certificacion::find($validated['id']);

        if(! $certificacion){

            return response()->json([
                'error' => 'El certificado no existe.',
            ], 404);

        }

        try {

            if($certificacion->pdf){

                return response()->json([
                    'data' => [
                        'pdf' => Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_pdfs_certificaciones') . $certificacion->pdf->url, now()->addMinutes(10))
                    ]
                ], 200);

            }

            $pdf = (new CertificadoRegistroController())->reimprimirCertificado($certificacion);

            if(! $certificacion->pdf){

                $this->guardarEnS3($certificacion, $pdf);

            }

            $certificacion->refresh();

            return response()->json([
                'data' => [
                    'pdf' => Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_pdfs_certificaciones') . $certificacion->pdf->url, now()->addMinutes(10))
                ]
            ], 200);

        } catch (\Throwable $th) {

            Log::error(
                "Error al generar pdf desde Sistema Trámites en Línea.",
                [
                    'message' => $th->getMessage(),
                    'certificacion_id' => $request->get('id'),
                    'trace' => $th
                ]
            );

            return response()->json([
                'error' => 'Hubo un error al generar el pdf.',
            ], 500);

        }

    }

}
