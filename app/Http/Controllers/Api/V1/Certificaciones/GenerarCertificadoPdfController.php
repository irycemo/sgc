<?php

namespace App\Http\Controllers\Api\V1\Certificaciones;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Certificacion;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Certificaciones\CertificadoRegistroController;

class GenerarCertificadoPdfController extends Controller
{

    public function generarPdf(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $certificacion = Certificacion::find($validated['id']);

        try {

            if($certificacion->pdf){

                return response()->json([
                    'data' => [
                        'pdf' => Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_pdfs_certificaciones') . $certificacion->pdf->url, now()->addMinutes(10))
                    ]
                ], 200);

            }

            $pdf = (new CertificadoRegistroController())->reimprimirCertificado($certificacion);

            return response()->json([
                'data' => [
                    'pdf' => base64_encode($pdf->stream())
                ]
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al generar pdf desde Sistema Trámites en Lína." . $th);

            return response()->json([
                'error' => 'Hubo un error al generar el pdf.',
            ], 500);

        }

    }

}
