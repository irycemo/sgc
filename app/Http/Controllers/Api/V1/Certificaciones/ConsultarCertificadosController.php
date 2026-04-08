<?php

namespace App\Http\Controllers\Api\V1\Certificaciones;

use App\Models\Certificacion;
use App\Http\Controllers\Controller;
use App\Http\Requests\CertificacionListaRequest;
use App\Http\Resources\CertificacionListaResource;

class ConsultarCertificadosController extends Controller
{

    public function consultarCertificados(CertificacionListaRequest $request){

        $validated = $request->validated();

        $certificaciones = Certificacion::with('tramite:id,año,folio,usuario', 'predio:id,localidad,oficina,tipo_predio,numero_registro', 'requerimientos.creadoPor')
                                ->whereHas('tramite', function($q) use ($validated){
                                    $q->where('usuario_tramites_linea_id', $validated['entidad']);
                                })
                                ->when(isset($validated['año']), function($q) use ($validated){
                                    $q->whereHas('tramite', function($q) use ($validated){
                                        $q->where('año', $validated['año']);
                                    });
                                })
                                ->when(isset($validated['folio']), function($q) use ($validated){
                                    $q->whereHas('tramite', function($q) use ($validated){
                                        $q->where('folio', $validated['folio']);
                                    });
                                })
                                ->when(isset($validated['localidad']), function($q) use ($validated){
                                    $q->whereHas('predio', function($q) use ($validated){
                                        $q->where('localidad', $validated['localidad']);
                                    });
                                })
                                ->when(isset($validated['oficina']), function($q) use ($validated){
                                    $q->whereHas('predio', function($q) use ($validated){
                                        $q->where('oficina', $validated['oficina']);
                                    });
                                })
                                ->when(isset($validated['tipo_predio']), function($q) use ($validated){
                                    $q->whereHas('predio', function($q) use ($validated){
                                        $q->where('tipo_predio', $validated['tipo_predio']);
                                    });
                                })
                                ->when(isset($validated['numero_registro']), function($q) use ($validated){
                                    $q->whereHas('predio', function($q) use ($validated){
                                        $q->where('numero_registro', $validated['numero_registro']);
                                    });
                                })
                                ->when(isset($validated['estado']), fn($q) => $q->where('estado', $validated['estado']))
                                ->orderBy('id', 'desc')
                                ->paginate($validated['pagination'], ['*'], 'page', $validated['pagina']);

        return CertificacionListaResource::collection($certificaciones)->response()->setStatusCode(200);

    }

}
