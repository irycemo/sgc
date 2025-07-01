<?php

namespace App\Http\Controllers\Api\V1\SAP;

use App\Exceptions\GeneralException;
use App\Models\Tramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Certificaciones\CertificadoRegistroController;
use App\Models\Traslado;

class AcreditarPagoController extends Controller
{


    public function acreditarPago(Request $request){

        $validated = $request->validate(['linea_captura' => 'required']);

        try {

            DB::transaction(function () use($validated){

                $tramite = Tramite::where('linea_de_captura', $validated['linea_captura'])->first();

                if(!$tramite) throw new GeneralException('El trámite no existe');

                $tramite->update([
                    'estado' => 'pagado',
                    'fecha_pago' => now()->toDateString(),
                ]);

                if($tramite->servicio->clave_ingreso == 'DM34'){

                    $this->generarCertificadosElectronicos($tramite);

                }

                return response()->json([
                    'result' => 'success',
                ], 200);

            });

        } catch (GeneralException $ex) {

            Log::error("Error al validar linea de captura desde pago en línea" . $ex->getMessage());

            return response()->json([
                'result' => 'error',
            ], 500);

        } catch (\Throwable $th) {

            Log::error("Error al validar linea de captura desde pago en línea" . $th);

            return response()->json([
                'result' => 'error',
            ], 500);

        }

     }

     public function generarCertificadosElectronicos($tramite){

        foreach ($tramite->predios as $predio) {

            $traslado = Traslado::where('estado', 'operado')->where('predio_id', $predio->id)->first();

            if($traslado){

                $tipo_certificado = mb_strtoupper($tramite->servicio->nombre, 'utf-8');

                (new CertificadoRegistroController())->certificado($tramite, $predio, $tipo_certificado);

                $tramite->predios()->updateExistingPivot($predio->id, ['estado' => 'I']);

                $usados = $tramite->predios()->wherePivot('estado', 'I')->count();

                $tramite->update(['usados' => $usados]);

                if($tramite->cantidad === $usados){

                    $tramite->update(['estado' => 'concluido']);

                }

            }

        }

    }

}
