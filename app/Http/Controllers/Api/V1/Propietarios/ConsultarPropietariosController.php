<?php

namespace App\Http\Controllers\Api\V1\Propietarios;

use App\Models\Tramite;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultarPropietariosRequest;
use App\Models\Certificacion;

class ConsultarPropietariosController extends Controller
{

    public function consultarPropietariosCertificado(ConsultarPropietariosRequest $request){

        $validated = $request->validated();

        $tramite = Tramite::with('predios')
                                ->where('año', $validated['año'])
                                ->where('folio', $validated['folio'])
                                ->where('usuario', $validated['usuario'])
                                ->first();

        if(!$tramite){

            return response()->json([
                'error' => "El trámite no existe.",
            ], 404);

        }

        if($tramite->estado === 'nuevo'){

            return response()->json([
                'error' => "El trámite no esta pagado.",
            ], 401);

        }

        $predio = $tramite->predios()->wherePivot('predio_id', $validated['predio'])->first();

        if(!$predio){

            return response()->json([
                'error' => "El predio no esta asociado con el trámite.",
            ], 404);

        }

        $certificacion = Certificacion::where('tramite_id', $tramite->id)->where('predio_id', $predio->id)->first();

        $data = json_decode($certificacion->cadena_original, true);

        return response()->json([
            'data' => $data['predio']['propietarios'],
        ], 200);

    }

}
