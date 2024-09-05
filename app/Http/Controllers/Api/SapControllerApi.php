<?php

namespace App\Http\Controllers\Api;

use App\Models\Tramite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\SapActualizarPagoRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SapControllerApi extends Controller
{

     public function __invoke(SapActualizarPagoRequest $request){

        try {

            DB::transaction(function () use($request){

                $tramite = Tramite::where('linea_de_captura', $request->linea_de_captura)->first();

                $tramite->update([
                    'estado' => 'pagado',
                    'fecha_pago' => now()->toDateString(),
                    'folio_pago' => $request->folio_pago
                ]);

                if($tramite->tipo_tramite == 'complemento'){

                    $tramiteAdiciona = Tramite::find($tramite->adiciona);

                    if(!$tramiteAdiciona)
                        throw new ModelNotFoundException("No se encontro el trámite al que adiciona.");

                    $tramiteAdiciona->update([
                        'tipo_servicio' => $tramite->tipo_servicio
                    ]);

                }

                return response()->json([
                    'result' => 'success',
                ], 200);

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualizar estado del trámite desde SAP " . $th);

            return response()->json([
                'result' => 'error',
            ], 500);
        }


     }

}
