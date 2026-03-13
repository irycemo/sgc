<?php

namespace App\Http\Controllers\Api\V1\Traslados;

use App\Models\Traslado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RechazoResource;

class ConsultarRechazosController extends Controller
{

    public function consultarRechazos(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $traslado = Traslado::find($validated['id']);

        if(!$traslado){

            return response()->json([
                'error' => "No se encontraron resultados.",
            ], 404);

        }

        $traslado->load('rechazos.creadoPor');

        return RechazoResource::collection($traslado->rechazos)->response()->setStatusCode(200);

    }

}
