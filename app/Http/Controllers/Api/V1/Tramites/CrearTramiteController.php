<?php

namespace App\Http\Controllers\Api\V1\Tramites;

use App\Models\Tramite;
use App\Models\Servicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\TramiteResource;
use App\Services\Tramites\TramiteService;
use App\Http\Requests\CrearTramiteRequest;
use App\Http\Requests\CrearTramiteRefrendoRequest;
use App\Mail\EnviarTramiteMail;

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

    public function crearTramiteRefrendo(CrearTramiteRefrendoRequest $request){

        $validated = $request->validated();

        $tramite = Tramite::make();

        $servicio_refrendo = Servicio::where('clave_ingreso', 'D922')->first();

        $tramite->año = now()->year;
        $tramite->usuario = 10;
        $tramite->usuario = (Tramite::where('año', now()->year)->where('usuario', 10)->max('folio') ?? 0) + 1;
        $tramite->tipo_tramite = 'normal';
        $tramite->tipo_servicio = 'ordinario';
        $tramite->servicio_id = $servicio_refrendo->id;
        $tramite->solicitante = 'Perito externo';
        $tramite->nombre_solicitante = $validated['solicitante'] . ' Clave: ' . $validated['clave'];
        $tramite->monto = $servicio_refrendo->ordinario;
        $tramite->cantidad = 1;
        $tramite->creado_por = 10;

        $nuevo_tramite = null;

        $tramite_existente = Tramite::where('año', now()->year)
                                    ->where('estado', 'nuevo')
                                    ->where('solicitante', 'Perito externo')
                                    ->where('nombre_solicitante',  $validated['solicitante'] . ' Clave: ' . $validated['clave'])
                                    ->where('creado_por', 10)
                                    ->first();

        if($tramite_existente){

            return response()->json([
                'error' => "Ya ha hecho una solicitud, la información se hizó llegar mediante correo electrónico.",
            ], 500);

        }

        try {

            DB::transaction(function () use($tramite, $validated, &$nuevo_tramite){

                $nuevo_tramite = (new TramiteService($tramite))->crear();

                $titulo = 'Se envia trámite de refrendo anual de la autorización de perito valuador';

                Mail::to($validated['email'])->send(new EnviarTramiteMail($titulo, $nuevo_tramite));

            }, 5);

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
