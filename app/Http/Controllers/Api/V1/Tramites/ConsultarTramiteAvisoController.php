<?php

namespace App\Http\Controllers\Api\V1\Tramites;

use App\Models\Tramite;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultarTramiteAvisoRequest;

class ConsultarTramiteAvisoController extends Controller
{

    public function consultarTramiteAviso(ConsultarTramiteAvisoRequest $request){

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
                'error' => "El trámite de aviso no existe.",
            ], 404);

        }

        if($tramite->estado === 'nuevo'){

            return response()->json([
                'error' => "El trámite de aviso no esta pagado.",
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

}
