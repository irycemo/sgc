<?php

namespace App\Http\Controllers\Api\V1\Requerimientos;

use App\Models\Requerimiento;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequerimientoRequest;
use App\Http\Resources\RequerimientoResource;

class CrearRequerimientoController extends Controller
{

    public function crearRequerimiento(RequerimientoRequest $request){

        $validated = $request->validated();

        info($validated);

        try {

            $requerimiento = Requerimiento::create([
                'requerimientoable_type' => 'App\Models\Certificacion',
                'requerimientoable_id' => $validated['certificacion_id'],
                'descripcion' => $validated['observacion'],
                'creado_por' => 11,
                'usuario_stl' => $validated['usuario'],
                'estado' => 'nuevo',
                'archivo_url' => $validated['archivo_url'] ?? null,
            ]);

            return (new RequerimientoResource($requerimiento))->response()->setStatusCode(200);

        } catch (GeneralException $ex) {

            return response()->json([
                'error' => $ex->getMessage(),
            ], 500);

        }catch (\Throwable $th) {

            Log::error("Error al crear requerimiento por el Sistema de trámites en línea" . $th);

            return response()->json([
                'error' => "No se pudo crear el requerimiento.",
            ], 500);

        }

    }

}
