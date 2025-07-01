<?php

namespace App\Http\Controllers\Api\V1\Tramites;

use App\Models\Tramite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Resources\TramiteResource;
use App\Services\Tramites\TramiteService;
use App\Http\Requests\CrearTramiteRequest;

class CrearTramiteController extends Controller
{

    public function crearTramite(CrearTramiteRequest $request){

        $validated = $request->validated();

        $tramite = Tramite::make();

        $tramite->tipo_tramite = 'normal';
        $tramite->tipo_servicio = $validated['tipo_servicio'];
        $tramite->servicio_id = $validated['servicio_id'];
        $tramite->solicitante = $validated['solicitante'];
        $tramite->nombre_solicitante = $validated['nombre_solicitante'];
        $tramite->monto = $validated['monto'];
        $tramite->cantidad = $validated['cantidad'];
        $tramite->usuario_tramites_linea_id = $validated['usuario_tramites_linea_id'];

        $nuevo_tramite = null;

        try {

            DB::transaction(function () use($tramite, $validated, &$nuevo_tramite){

                $nuevo_tramite = (new TramiteService($tramite))->crear($validated['predios']);

            }, 10);

            return (new TramiteResource($nuevo_tramite))->response()->setStatusCode(200);

        } catch (GeneralException $ex) {

            return response()->json([
                'error' => $ex->getMessage(),
            ], 500);

        }catch (\Throwable $th) {

            Log::error("Error al crear trámite por el Sistema de trámites en línea" . $th);

            return response()->json([
                'error' => "No se pudo crear el trámite.",
            ], 500);

        }

    }

}
