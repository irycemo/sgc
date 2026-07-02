<?php

namespace App\Http\Controllers\Api\V1\Traslados;

use App\Http\Controllers\Controller;
use App\Models\Traslado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EliminarTraslado extends Controller
{

    public function eliminarTraslado(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $traslado = Traslado::find($validated['id']);

        if(! $traslado){

            return response()->json([
                'error' => 'No se encontro el traslado.',
            ], 404);

        }

        try {

            DB::transaction(function () use($traslado){

                foreach($traslado->rechazos as $rechazo){

                    $rechazo->delete();

                }

                $traslado->delete();

            });

        } catch (\Throwable $th) {

            Log::error("Error al ingresar información de aviso desde Sistema Trámites en Lína." . $th);

            return response()->json([
                'error' => 'Hubo un error al ingresar la información.',
            ], 500);

        }

        return response()->json([], 201);

    }

}
