<?php

namespace App\Http\Controllers\Api\V1\SAP;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Models\Tramite;
use App\Services\Tramites\TramiteService;
use App\Traits\Api\Certificados\GenerarCertificadosAutomaticosTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AcreditarPagoController extends Controller
{

    use GenerarCertificadosAutomaticosTrait;

    public function acreditarPago(Request $request){

        $validated = $request->validate(['linea_captura' => 'required']);

        try {

            retry(5, function() use ($validated){

                DB::transaction(function () use($validated){

                    $tramite = Tramite::where('linea_de_captura', $validated['linea_captura'])->first();

                    if(!$tramite) throw new GeneralException('El trámite no existe');

                    (new TramiteService($tramite))->procesarPago();

                    if(in_array($tramite->servicio->clave_ingreso, ['DM32', 'DM31'])){

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

}
