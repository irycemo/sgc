<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Predio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\PredioConsultaRequest;

class ConsultaPredioController extends Controller
{

    public function __invoke(PredioConsultaRequest $request)
    {

        try {

            $predio = Predio::where('localidad', $request->localidad)
                                ->where('oficina', $request->oficina)
                                ->where('tipo_predio', $request->tipo_predio)
                                ->where('numero_registro', $request->numero_registro)
                                ->firstOrFail();

                                info($predio);

            $data = [
                'estado' => $predio->estado,
                'region_catastral' => $predio->region_catastral,
                'municipio' => $predio->municipio,
                'zona_catastral' => $predio->zona_catastral,
                'localidad' => $predio->localidad,
                'sector' => $predio->sector,
                'manzana' => $predio->manzana,
                'predio' => $predio->predio,
                'edificio' => $predio->edificio,
                'departamento' => $predio->departamento,
            ];

            return response()->json([
                'data' => $data,
            ], 200);

        } catch (\Throwable $th) {

            Log::error("No se encontro predio con la cuenta predial solicitada");

            return response()->json([
                'result' => 'error',
            ], 500);

        }

    }
}
