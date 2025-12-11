<?php

namespace App\Http\Controllers\Api\V1\Requerimientos;

use Illuminate\Http\Request;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequerimientoRequest;
use App\Http\Resources\RequerimientoResource;
use App\Http\Requests\RequerimientoOficinaRequest;
use App\Http\Requests\ConsultarRequerimientosOficinaRequest;
use App\Http\Requests\ResponderRequeriminetoRequest;

class CrearRequerimientoController extends Controller
{

    /* Certificados */
    public function crearRequerimiento(RequerimientoRequest $request){

        $validated = $request->validated();

        try {

            $requerimiento = null;

            DB::transaction(function () use ($validated, &$requerimiento){

                $requerimientos = Requerimiento::where('requerimientoable_type', 'App\Models\Certificacion')
                                                    ->where('requerimientoable_id', $validated['certificacion_id'])
                                                    ->where('estado', 'finalizado')
                                                    ->get();

                $requerimientos->each->update(['estado' => 'nuevo']);

                $requerimiento = Requerimiento::create([
                    'requerimientoable_type' => 'App\Models\Certificacion',
                    'requerimientoable_id' => $validated['certificacion_id'],
                    'descripcion' => $validated['observacion'],
                    'creado_por' => 11,
                    'usuario_stl' => $validated['usuario'],
                    'estado' => 'nuevo',
                    'archivo_url' => $validated['archivo_url'] ?? null,
                ]);

            });

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

    public function crearRequerimientoOficina(RequerimientoOficinaRequest $request){

        $validated = $request->validated();

        try {

            $requerimiento = null;

            DB::transaction(function () use ($validated, &$requerimiento){

                $requerimiento = Requerimiento::create([
                    'requerimientoable_type' => 'App\Models\Oficina',
                    'requerimientoable_id' => $validated['oficina_id'],
                    'descripcion' => $validated['observacion'],
                    'creado_por' => 11,
                    'usuario_stl' => $validated['usuario'],
                    'estado' => 'nuevo',
                    'archivo_url' => $validated['archivo_url'] ?? null,
                    'entidad_stl' => $validated['entidad_id']
                ]);

            });

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

    public function consultarRequerimientosOficina(ConsultarRequerimientosOficinaRequest $request){

        $validated = $request->validated();

        $requerimientos = Requerimiento::with('creadoPor:id,name')
                            ->where('requerimientoable_id', $validated['oficina_id'])
                            ->where('requerimientoable_type', 'App\Models\Oficina')
                            ->whereNull('requerimiento_id')
                            ->where('entidad_stl', $validated['entidad_id'])
                            ->orderBy('id', 'desc')
                            ->get();

        return RequerimientoResource::collection($requerimientos)->response()->setStatusCode(200);

    }

    public function consultarRequerimiento(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $requerimientos = Requerimiento::with('requerimientos.creadoPor')->find($validated['id'])->requerimientos;

        return RequerimientoResource::collection($requerimientos)->response()->setStatusCode(200);

    }

    public function responderRequerimiento(ResponderRequeriminetoRequest $request){

        $validated = $request->validated();

        try {

            $requerimiento = null;

            DB::transaction(function () use ($validated, &$requerimiento){

                $requerimiento = Requerimiento::create([
                    'requerimientoable_id' => $validated['oficina_id'],
                    'requerimientoable_type' => 'App\Models\Oficina',
                    'descripcion' => $validated['observacion'],
                    'creado_por' => 11,
                    'estado' => 'nuevo',
                    'usuario_stl' => $validated['usuario'],
                    'requerimiento_id' => $validated['requerimiento_id'],
                    'archivo_url' => $validated['archivo_url'] ?? null,
                    'entidad_stl' => $validated['entidad_id']
                ]);

                Requerimiento::find($validated['requerimiento_id'])->update(['estado' => 'nuevo']);

            });

            return (new RequerimientoResource($requerimiento))->response()->setStatusCode(200);

        } catch (GeneralException $ex) {

            return response()->json([
                'error' => $ex->getMessage(),
            ], 500);

        }catch (\Throwable $th) {

            Log::error("Error al reponder requerimiento por el Sistema de trámites en línea" . $th);

            return response()->json([
                'error' => "No se pudo crear la respuesta.",
            ], 500);

        }

    }

}
