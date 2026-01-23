<?php

namespace App\Http\Controllers\Api\V1\Tramites;

use Carbon\Carbon;
use App\Models\Tramite;
use Illuminate\Http\Request;
use App\Models\Certificacion;
use App\Models\PredioTramite;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultarTramiteRefrendoRequest;
use App\Http\Requests\TramiteRequest;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\TramiteResource;
use App\Http\Requests\TramiteListaRequest;

class ConsultarTramitesController extends Controller
{

    public function consultarTramite(TramiteRequest $request){

        $validated = $request->validated();

        $tramite = Tramite::where('año', $validated['año'])
                                ->where('folio', $validated['folio'])
                                ->where('usuario', $validated['usuario'])
                                ->when((int)$validated['usuario'] == 11, function ($q) use($validated){
                                    $q->where('usuario_tramites_linea_id', $validated['entidad']);
                                })
                                ->first();

        if($tramite){

            return (new TramiteResource($tramite))->response()->setStatusCode(200);

        }else{

            return response()->json([
                'error' => "No se encontraron resultados.",
            ], 404);

        }

    }

    public function consultarTramites(TramiteListaRequest $request){

        $validated = $request->validated();

        $tramites = Tramite::with('servicio', 'predios')
                                ->where('usuario', 11)
                                ->where('usuario_tramites_linea_id', $validated['entidad'])
                                ->when(isset($validated['año']), fn($q) => $q->where('año', $validated['año']))
                                ->when(isset($validated['folio']), fn($q) => $q->where('folio', $validated['folio']))
                                ->when(isset($validated['estado']), fn($q) => $q->where('estado', $validated['estado']))
                                ->when(isset($validated['tipo_servicio']), fn($q) => $q->where('tipo_servicio', $validated['tipo_servicio']))
                                ->orderBy('id', 'desc')
                                ->paginate($validated['pagination'], ['*'], 'page', $validated['pagina']);

        return TramiteResource::collection($tramites)->response()->setStatusCode(200);

    }

    public function consultarTramiteId(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $tramite = Tramite::find($validated['id']);

        if($tramite){

            return (new TramiteResource($tramite))->response()->setStatusCode(200);

        }else{

            return response()->json([
                'error' => "No se encontraron resultados.",
            ], 404);

        }

    }

    public function consultarEstadisticas(Request $request){

        $validated = $request->validate(['entidad_id' => 'required|numeric|min:1']);

        $array = cache()->get('estadisticas_tramites_en_linea_' . $validated['entidad_id']);

        if(!$array){

            $array = Cache::rememberForever('estadisticas_tramites_en_linea_' . $validated['entidad_id'], function() use ($validated){

                $array = [];

                $certificaciones = Certificacion::select('estado', DB::raw('count(*) as total'))
                                                    ->whereHas('tramite', function($q) use($validated){
                                                        $q->select('id', 'usuario_tramites_linea_id')
                                                            ->where('usuario_tramites_linea_id', $validated['entidad_id']);
                                                    })
                                                    ->groupBy('estado')
                                                    ->whereMonth('created_at', Carbon::now()->month)
                                                    ->get();

                foreach ($certificaciones as $certificacion) {

                    $color = null;

                    if($certificacion->estado == 'activo'){

                        $color = 'green';

                    }elseif($certificacion->estado == 'cancelado'){

                        $color = 'red';

                    }

                    $array [] = ['estado' => $certificacion->estado, 'total' => $certificacion->total, 'color' => $color];

                }

                $certificados = PredioTramite::select('estado', DB::raw('count(*) as total'))
                                                ->whereHas('tramite', function($q) use($validated){
                                                    $q->select('id', 'usuario_tramites_linea_id', 'estado')
                                                        ->where('usuario_tramites_linea_id', $validated['entidad_id'])
                                                        ->where('estado', 'pagado');
                                                })
                                                ->where('estado', 'A')
                                                ->groupBy('estado')
                                                ->whereMonth('created_at', Carbon::now()->month)
                                                ->get();

                foreach ($certificados as $certificado) {

                    $array [] = ['estado' => 'pendientes', 'total' => $certificado->total, 'color' => 'gray'];

                }

                return $array;

            });

        }

        return response()->json([
            'data' => $array
        ], 200);

    }

    public function consultarTramiteRefrendo(ConsultarTramiteRefrendoRequest $request){

        $validated = $request->validated();

        $tramite = Tramite::where('año', $validated['año'])
                                ->where('folio', $validated['folio'])
                                ->where('usuario', $validated['usuario'])
                                ->first();

        if($tramite){

            info($tramite);

            if($tramite->estado != 'pagado'){

                return response()->json([
                    'error' => "El trámite no esta pagado.",
                ], 401);

            }

            if($tramite->servicio->clave_ingreso != 'D922'){

                return response()->json([
                    'error' => "El trámite ingresado no corresponde a refrendo.",
                ], 401);

            }

            return (new TramiteResource($tramite))->response()->setStatusCode(200);

        }else{

            return response()->json([
                'error' => "No se encontró el trámite.",
            ], 404);

        }

    }

}
