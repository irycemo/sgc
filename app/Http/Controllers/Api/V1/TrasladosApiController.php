<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Tramite;
use App\Models\Traslado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\TrasladoRequest;
use App\Exceptions\TrasladoServiceException;
use App\Http\Services\Traslados\TrasladoService;

class TrasladosApiController extends Controller
{

    public function ingresarTraslado(TrasladoRequest $request){

        $validated = $request->validated();

        $traslado = Traslado::where('aviso_stl', $validated['aviso_id'])->first();

        if(!$traslado){

            $traslado = Traslado::make();

            $traslado->estado = 'cerrado';
            $traslado->aviso_id = $validated['tramite_aviso'];
            $traslado->predio_id = $validated['predio'];
            $traslado->aviso_stl = $validated['aviso_id'];
            $traslado->certificado_id = $validated['tramite_certificado'];
            $traslado->avaluo_spe = $validated['avaluo_id'];
            $traslado->entidad_nombre = $validated['entidad_nombre'];
            $traslado->entidad_stl = $validated['entidad_id'];

            try {

                DB::transaction(function () use($traslado, $validated){

                    $traslado->asignado_a = (new TrasladoService)->asignarTraslado($validated['predio']);
                    $traslado->save();

                    Tramite::find($validated['tramite_aviso'])->update(['estado' => 'concluido']);

                });

                return response()->json([
                    'mensaje' => "Ingresado correctamente.",
                ], 200);

            } catch (TrasladoServiceException $th) {

                Log::error("Error al crear trasalado por el Sistema de trámties en linea" . $th);

                return response()->json([
                    'error' => $th->getMessage(),
                ], 404);

            } catch (\Throwable $th) {

                Log::error("Error al crear traslado por el Sistema de trámties en linea" . $th);

                return response()->json([
                    'error' => "No se pudo ingresar el traslado.",
                ], 500);

            }

        }else{

            $traslado->update(['estado' => 'cerrado']);

            return response()->json([
                'error' => "Reactivación exitosa.",
            ], 200);

        }

    }

}
