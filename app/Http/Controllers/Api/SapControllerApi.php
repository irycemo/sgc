<?php

namespace App\Http\Controllers\Api;

use App\Models\Tramite;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\SapActualizarPagoRequest;

class SapControllerApi extends Controller
{

     public function __invoke(SapActualizarPagoRequest $request){

        try {

            $tramite = Tramite::where('folio', $request->folio)->first();

            $tramite->update([
                'estado' => 'pagado',
                'fecha_pago' => now()->toDateString(),
                'folio_pago' => $request->folio_pago
            ]);

            return response()->json([
                'result' => 'success',
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar estado del trámite desde SAP " . $th);

            return response()->json([
                'result' => 'error',
            ], 500);
        }


     }

}
