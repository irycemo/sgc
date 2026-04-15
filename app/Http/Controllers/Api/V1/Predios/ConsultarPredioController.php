<?php

namespace App\Http\Controllers\Api\V1\Predios;

use App\Http\Controllers\Controller;
use App\Http\Requests\PredioConsultaRequest;
use App\Http\Resources\PredioPropietarioColindanciaResource;
use App\Http\Resources\PredioPropietariosResource;
use App\Models\Predio;

class ConsultarPredioController extends Controller
{

    public function consultarCuentaPredial(PredioConsultaRequest $request)
    {

        $validated = $request->validated();

        $predio = Predio::with('colindancias','propietarios.persona')
                            ->where('localidad', $validated['localidad'])
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

        return (new PredioPropietarioColindanciaResource($predio))->response()->setStatusCode(200);

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

    public function consultarPredioTramite(PredioConsultaRequest $request)
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

        if(in_array($predio->sector, [88, 99])){

            return response()->json([
                'error' => "El predio " . $predio->cuentaPredial() . " se encuentra en sector 88 0 99 es necesario conciliarlo, comuníquese al departamento de cartografía.",
            ], 401);

        }

        return (new PredioPropietariosResource($predio))->response()->setStatusCode(200);

    }

}
