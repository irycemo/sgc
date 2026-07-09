<?php

namespace App\Http\Controllers\Api\V1\Predios;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActualizarEsHabitacionalRequest;
use App\Models\Predio;

class ActualizarEsHabitacionalController extends Controller
{

    public function actualizarEsHabitacional(ActualizarEsHabitacionalRequest $request)
    {

        $validated = $request->validated();

        $predio = Predio::where('localidad', $validated['localidad'])
                            ->where('oficina', $validated['oficina'])
                            ->where('tipo_predio', $validated['tipo_predio'])
                            ->where('numero_registro', $validated['numero_registro'])
                            ->first();

        if(!$predio){

            return response()->json([
                'error' => "No se encontraron resultados.",
            ], 404);

        }

        $predio->update([
            'es_habitacional' => $validated['es_habitacional'],
            'actualizado_por' => auth()->id()
        ]);

        return response()->json([], 201);

    }

}
