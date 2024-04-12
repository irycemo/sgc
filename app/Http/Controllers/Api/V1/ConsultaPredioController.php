<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Predio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PredioConsultaRequest;

class ConsultaPredioController extends Controller
{

    public function consultarCuentaPredial(PredioConsultaRequest $request)
    {

        $validated = $request->validated();

        $predio = Predio::where('localidad', $validated['localidad'])
                            ->where('oficina', $validated['oficina'])
                            ->where('tipo_predio', $validated['tipo_predio'])
                            ->where('numero_registro', $validated['numero_registro'])
                            ->first();

        if($predio->status === 'bloqueado'){

            return response()->json([
                'error' => "El predio esta bloqueado.",
            ], 401);

        }

        if(!$predio){

            return response()->json([
                'error' => "No se encontraron resultados.",
            ], 404);

        }

        $data = [
            'id' => $predio->id,
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
            'oficina' => $predio->oficina,
            'tipo_predio' => $predio->tipo_predio,
            'numero_registro' => $predio->numero_registro,
        ];

        return response()->json([
            'data' => $data,
        ], 200);

    }

    public function consultarPredio(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $predio = Predio::find($validated['id']);

        if(!$predio){

            return response()->json([
                'error' => "No se encontraron resultados.",
            ], 404);

        }

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
            'oficina' => $predio->oficina,
            'tipo_predio' => $predio->tipo_predio,
            'numero_registro' => $predio->numero_registro,
        ];

        return response()->json([
            'data' => $data,
        ], 200);

    }
}
