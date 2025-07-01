<?php

namespace App\Http\Controllers\Api\V1\Tramites;

use Carbon\Carbon;
use App\Models\Tramite;
use App\Models\Certificacion;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultarTramiteAvisoRequest;

class ConsultarCertificadoAvisoController extends Controller
{

    public function consultarCertificadoAviso(ConsultarTramiteAvisoRequest $request){

        $validated = $request->validated();

        $tramite = Tramite::with('predios')
                                ->where('año', $validated['año'])
                                ->where('folio', $validated['folio'])
                                ->where('usuario', $validated['usuario'])
                                ->first();

        if(!$tramite){

            return response()->json([
                'error' => "El trámite de certificado no existe.",
            ], 404);

        }

        if($tramite->estado === 'nuevo'){

            return response()->json([
                'error' => "El trámite de certificado no esta pagado.",
            ], 401);

        }

        $predio = $tramite->predios()->wherePivot('predio_id', $validated['predio'])->first();

        if(!$predio){

            return response()->json([
                'error' => "El predio del aviso no esta asociado con el certificado catastral.",
            ], 404);

        }

        $certificacion = Certificacion::where('tramite_id', $tramite->id)
                                        ->where('predio_id', $predio->id)
                                        ->first();

        if(!$certificacion){

            return response()->json([
                'error' => "El certificado no existe.",
            ], 404);

        }

        if($certificacion->estado != 'activo'){

            return response()->json([
                'error' => "El certificado no esta activo.",
            ], 401);

        }
        if(Carbon::parse($certificacion->created_at)->diffInMonths() > 3){

            return response()->json([
                'error' => "El certificado tiene mas de 3 meses desde su elaboración.",
            ], 401);

        }

        return response()->json([
            'data' => [
                'certificado_id' => $certificacion->id
            ]
        ], 200);

    }

}
