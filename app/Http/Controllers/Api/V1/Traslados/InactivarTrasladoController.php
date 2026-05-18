<?php

namespace App\Http\Controllers\Api\V1\Traslados;

use App\Models\Traslado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class InactivarTrasladoController extends Controller
{

    public function inactivarTraslado(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $traslado = Traslado::find($validated['id']);

        if(! $traslado){

            return response()->json([
                'error' => 'No se encontro el traslado.',
            ], 204);

        }

        try {

            $traslado->update([
                'estado' => 'nuevo',
                'avaluo_spe' => null,
                'actualizado_por' => auth()->id()
            ]);

        } catch (\Throwable $th) {

            Log::error("Error al ingresar información de aviso desde Sistema Trámites en Lína." . $th);

            return response()->json([
                'error' => 'Hubo un error al ingresar la información.',
            ], 500);

        }

        return response()->json([
            'data' => [
                'traslado_id' => $traslado->id
            ]
        ], 200);

    }

}
