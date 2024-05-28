<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Predio;
use App\Models\Tramite;
use Illuminate\Http\Request;
use App\Models\Certificacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\TramiteRequest;
use App\Http\Requests\CertificacionRequest;
use App\Http\Requests\CrearCertificadoRequest;
use App\Http\Resources\CertificacionResource;
use App\Http\Services\Certificaciones\CertificacionesService;

class CertificacionesApiControlller extends Controller
{

    public function generarCertificado(CrearCertificadoRequest $request){

        $validated = $request->validated();

        $tramite = Tramite::where('año', $validated['año'])
                                ->where('folio', $validated['folio'])
                                ->where('usuario', 11)
                                ->where('usuario_tramites_linea_id', $validated['entidad'])
                                ->first();

        if(!$tramite){

            return response()->json([
                'error' => "Trámite no existe.",
            ], 404);

        }

        $certificacion = Certificacion::where('estado', 'activo')
                                        ->where('tramite_id', $tramite->id)
                                        ->where('predio_id', $validated['predio'])
                                        ->first();

        if(!$certificacion){

            try {

                $predio = Predio::find($validated['predio']);

                if($predio->traslados()->count()){

                    $certificacion = null;

                    DB::transaction(function () use($validated, $tramite, $predio, &$certificacion){

                        $certificacion = (new CertificacionesService($predio, $tramite, $validated['nombre_entidad']))->generar();

                        $tramite->predios()->updateExistingPivot($predio->id, ['estado' => 'I']);

                        $usados = $tramite->predios()->wherePivot('estado', 'I')->count();

                        if($tramite->cantidad === $usados){

                            $tramite->update(['estado' => 'concluido']);

                            $tramite->audits()->latest()->first()->update(['tags' => 'Finalizó trámite']);

                        }else{

                            $tramite->update(['usados' => $usados]);

                        }

                    });

                    return (new CertificacionResource($certificacion))->response()->setStatusCode(200);

                }else{

                    return response()->json([
                        'error' => "Elaboración pendiente.",
                    ], 404);

                }

            } catch (\Throwable $th) {
                Log::error("Error al generar certificación desde Sistema de Trámites en Línea" . $th);
            }

        }else{

            if($certificacion->estado === 'caducado'){

                return response()->json([
                    'error' => "Certificado caducado.",
                ], 404);

            }

            return (new CertificacionResource($certificacion))->response()->setStatusCode(200);

        }

    }

    public function consultarCertificado(CertificacionRequest $request){

        $validated = $request->validated();

        $tramite = Tramite::where('año', $validated['año'])
                            ->where('folio', $validated['folio'])
                            ->where('usuario', $validated['usuario'])
                            ->first();

        if(!$tramite){

            return response()->json([
                'error' => "Trámite no existe.",
            ], 404);

        }

        $certificacion = Certificacion::where('tramite_id', $tramite->id)
                                        ->whereHas('predio', function($q) use ($validated){
                                            $q->where('localidad', $validated['localidad'])
                                                ->where('oficina', $validated['oficina'])
                                                ->where('tipo_predio', $validated['tipo_predio'])
                                                ->where('numero_registro', $validated['numero_registro']);
                                        })
                                        ->first();

        if(!$certificacion){

            return response()->json([
                'error' => "No se encontró el certificado.",
            ], 404);

        }

        if($certificacion->estado != 'activo'){

            return response()->json([
                'error' => "El trámite de certificado no esta activo.",
            ], 401);

        }

        return (new CertificacionResource($certificacion))->response()->setStatusCode(200);

    }

}
