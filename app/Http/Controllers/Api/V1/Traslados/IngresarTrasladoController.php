<?php

namespace App\Http\Controllers\Api\V1\Traslados;


use App\Models\Predio;
use App\Models\Oficina;
use App\Models\Traslado;
use App\Models\Certificacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Requests\IngresarRevisionAvisoRequest;
use App\Http\Requests\IngresarAvisoAclaratorioRequest;
use App\Services\Asignacion\AsignacionTrasladosService;

class IngresarTrasladoController extends Controller
{

    public function ingresarRevisionAviso(IngresarRevisionAvisoRequest $request){

        $validated = $request->validated();

        $certificacion = Certificacion::find($validated['certificacion_id']);

        try {

            $traslado = null;

            DB::transaction(function () use ($validated, $certificacion, &$traslado){

                $traslado = Traslado::firstOrCreate(
                                        [
                                            'predio_id' => $validated['predio_id'],
                                            'tramite_aviso' => $validated['tramite_aviso'],
                                            'certificacion_id' => $validated['certificacion_id'],
                                            'avaluo_spe' => $validated['avaluo_spe'],
                                            'aviso_stl' => $validated['aviso_stl'],
                                            'entidad_stl' => $validated['entidad_stl'],
                                            'entidad_nombre' => $validated['entidad_nombre'],
                                        ],
                                        [
                                            'estado' => 'cerrado',
                                            'tipo' => 'revision',
                                            'predio_id' => $validated['predio_id'],
                                            'tramite_aviso' => $validated['tramite_aviso'],
                                            'certificacion_id' => $validated['certificacion_id'],
                                            'oficina_id' => $certificacion->oficina_id,
                                            'avaluo_spe' => $validated['avaluo_spe'],
                                            'aviso_stl' => $validated['aviso_stl'],
                                            'entidad_stl' => $validated['entidad_stl'],
                                            'entidad_nombre' => $validated['entidad_nombre'],
                                            'asignado_a' => (new AsignacionTrasladosService())->obtenerUsuariosTraslado($certificacion->oficina_id, $validated['predio_id'])
                                        ]
                                    );

                $traslado->update(['estado' => 'cerrado']);

            });

        } catch (GeneralException $ex) {

            return response()->json([
                'error' => $ex->getMessage(),
            ], 404);

        } catch (\Throwable $th) {

            Log::error("Error al ingresar información de aviso aclaratorio desde Sistema Trámites en Lína." . $th);

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

    public function ingresarAvisoAclaratorio(IngresarAvisoAclaratorioRequest $request){

        $validated = $request->validated();

        $predio = Predio::find($validated['predio_id']);

        $oficina = Oficina::where('oficina', $predio->oficina)->where('localidad', $predio->localidad)->first();

        try {

            $traslado = null;

            DB::transaction(function () use ($validated, $oficina, &$traslado){

                $traslado = Traslado::firstOrCreate(
                                        [
                                            'predio_id' => $validated['predio_id'],
                                            'tramite_aviso' => $validated['tramite_aviso'],
                                            'aviso_stl' => $validated['aviso_stl'],
                                            'entidad_stl' => $validated['entidad_stl'],
                                            'entidad_nombre' => $validated['entidad_nombre'],
                                        ],
                                        [
                                            'estado' => 'cerrado',
                                            'tipo' => 'aclaratorio',
                                            'predio_id' => $validated['predio_id'],
                                            'tramite_aviso' => $validated['tramite_aviso'],
                                            'aviso_stl' => $validated['aviso_stl'],
                                            'entidad_stl' => $validated['entidad_stl'],
                                            'oficina_id' => $oficina->id,
                                            'entidad_nombre' => $validated['entidad_nombre'],
                                            'asignado_a' => (new AsignacionTrasladosService())->obtenerUsuariosTraslado($oficina->id, $validated['predio_id'])
                                        ]
                                    );

                $traslado->update(['estado' => 'cerrado']);

            });

        } catch (GeneralException $ex) {

            return response()->json([
                'error' => $ex->getMessage(),
            ], 404);

        } catch (\Throwable $th) {

            Log::error("Error al ingresar información de aviso aclaratorio desde Sistema Trámites en Lína." . $th);

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
