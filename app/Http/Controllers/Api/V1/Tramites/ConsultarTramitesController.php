<?php

namespace App\Http\Controllers\Api\V1\Tramites;

use App\Models\Tramite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TramiteRequest;
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

}
