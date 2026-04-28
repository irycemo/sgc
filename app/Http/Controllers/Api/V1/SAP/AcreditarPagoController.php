<?php

namespace App\Http\Controllers\Api\V1\SAP;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Certificaciones\CertificadoRegistroController;
use App\Http\Controllers\Controller;
use App\Models\Tramite;
use App\Models\Traslado;
use App\Services\Tramites\TramiteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AcreditarPagoController extends Controller
{


    public function acreditarPago(Request $request){

        $validated = $request->validate(['linea_captura' => 'required']);

        try {

            retry(5, function() use ($validated){

                DB::transaction(function () use($validated){

                    $tramite = Tramite::where('linea_de_captura', $validated['linea_captura'])->first();

                    if(!$tramite) throw new GeneralException('El trámite no existe');

                    (new TramiteService($tramite))->procesarPago();

                    if(in_array($tramite->servicio->clave_ingreso, ['DM32', 'DM32', 'D774'])){

                        $this->generarCertificadosElectronicos($tramite);

                    }

                });

                return response()->json([
                    'result' => 'success',
                ], 200);

            });

        } catch (GeneralException $ex) {

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

                (new CertificadoRegistroController())->certificado($tramite, $predio, $tipo_certificado, auth()->user());

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
