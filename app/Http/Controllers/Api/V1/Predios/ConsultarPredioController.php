<?php

namespace App\Http\Controllers\Api\V1\Predios;

use App\Models\Predio;
use App\Http\Controllers\Controller;
use App\Http\Requests\PredioConsultaRequest;
use App\Http\Resources\PredioPropietarioColindanciaResource;
use App\Http\Resources\PredioPropietariosResource;

class ConsultarPredioController extends Controller
{

    public function consultarCuentaPredial(PredioConsultaRequest $request)
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

        if($predio->status === 'bloqueado'){

            return response()->json([
                'error' => "El predio esta bloqueado.",
            ], 401);

        }

        $predio->load('propietarios.persona');

        return (new PredioPropietariosResource($predio))->response()->setStatusCode(200);

    }

    public function consultarPredio(PredioConsultaRequest $request){

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

        if($predio->status === 'bloqueado'){

            return response()->json([
                'error' => "El predio esta bloqueado.",
            ], 401);

        }

        $predio->load('propietarios.persona', 'colindancias');

        return (new PredioPropietarioColindanciaResource($predio))->response()->setStatusCode(200);

    }

    public function consultarCuentaPredialRpp(PredioConsultaRequest $request)
    {

        $validated = $request->validated();

        $predio = Predio::where('localidad', $validated['localidad'])
                            ->where('oficina', $validated['oficina'])
                            ->where('tipo_predio', $validated['tipo_predio'])
                            ->where('numero_registro', $validated['numero_registro'])
                            ->first();

        if(!$predio){

            return response()->json([
                'error' => "No se encontró el predio.",
            ], 404);

        }

        if($predio->status === 'bloqueado'){

            return response()->json([
                'error' => "El predio esta bloqueado.",
            ], 401);

        }

        return (new PredioCompletoResource($predio))->response()->setStatusCode(200);

    }

}
