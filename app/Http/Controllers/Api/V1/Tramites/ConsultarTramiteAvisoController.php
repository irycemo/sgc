<?php

namespace App\Http\Controllers\Api\V1\Tramites;

use App\Models\Tramite;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultarTramiteAvisoRequest;
use App\Http\Requests\ConsultarTramiteRevisionAviso;

class ConsultarTramiteAvisoController extends Controller
{

    public function consultarTramiteAvisoRevision(ConsultarTramiteAvisoRequest $request){

        $validated = $request->validated();

        $tramite = Tramite::with('predios')
                                ->where('año', $validated['año'])
                                ->where('folio', $validated['folio'])
                                ->where('usuario', $validated['usuario'])
                                ->whereHas('servicio', function($q){
                                    $q->whereIn('clave_ingreso', ['D729', 'D728']);
                                })
                                ->first();

        if(!$tramite){

            return response()->json([
                'error' => "El trámite de revisión de aviso no existe.",
            ], 404);

        }

        if($tramite->estado != 'pagado'){

            return response()->json([
                'error' => "El trámite de revisión de aviso no esta pagado.",
            ], 401);

        }

        $predio = $tramite->predios()->wherePivot('predio_id', $validated['predio'])->first();

        if(!$predio){

            return response()->json([
                'error' => "El predio no esta asociado con el trámite.",
            ], 404);

        }

        return response()->json([
            'data' => [
                'tramite_id' => $tramite->id
            ]
        ], 200);

    }

    public function consultarTramiteAvisoAclaratorio(ConsultarTramiteRevisionAviso $request){

        $validated = $request->validated();

        $tramite = Tramite::with('predios')
                                ->where('año', $validated['año'])
                                ->where('folio', $validated['folio'])
                                ->where('usuario', $validated['usuario'])
                                ->whereHas('servicio', function($q){
                                    $q->where('clave_ingreso', 'D730');
                                })
                                ->first();

        if(!$tramite){

            return response()->json([
                'error' => "El trámite de aviso aclaratorio no existe.",
            ], 404);

        }

        if($tramite->estado != 'pagado'){

            return response()->json([
                'error' => "El trámite de aviso aclaratorio no esta pagado.",
            ], 401);

        }

        if(isset($validated['predio'])){

            $predio = $tramite->predios()->wherePivot('predio_id', $validated['predio'])->first();

            if(!$predio){

                return response()->json([
                    'error' => "El predio no esta asociado con el trámite.",
                ], 404);

            }

        }

        return response()->json([
            'data' => [
                'tramite_id' => $tramite->id
            ]
        ], 200);

    }

}
