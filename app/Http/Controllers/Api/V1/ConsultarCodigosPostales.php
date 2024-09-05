<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CodigoPostalResource;
use App\Models\CodigoPostal;
use Illuminate\Http\Request;

class ConsultarCodigosPostales extends Controller
{

    public function __invoke(Request $request)
    {

        $validated = $request->validate(['codigo' => 'required|numeric']);

        $codigos = CodigoPostalResource::collection(CodigoPostal::where('codigo', $validated['codigo'])->get());

        if(!$codigos->count()){

            return response()->json([
                'error' => "No se encontraron resultados con el código postal.",
            ], 404);

        }

        return response()->json([
            'data' => $codigos,
        ], 200);

    }

}
