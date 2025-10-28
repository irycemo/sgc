<?php

namespace App\Http\Controllers\Api\V1\Propietarios;

use App\Models\Predio;
use App\Models\Tramite;
use Illuminate\Http\Request;
use App\Models\Certificacion;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultarPropietariosRequest;
use App\Http\Resources\PropietariosResource;

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

        $predio = $tramite->predios()->wherePivot('predio_id', $validated['predio'])->wherePivot('estado', 'I')->first();

        if(!$predio){

            return response()->json([
                'error' => "El predio no esta asociado con el trámite.",
            ], 404);

        }

        if($predio->status != 'activo'){

            return response()->json([
                'error' => "El predio no esta activo.",
            ], 401);

        }

        $certificacion = Certificacion::where('tramite_id', $tramite->id)->where('predio_id', $predio->id)->where('estado', 'activo')->first();

        if(!$certificacion){

            return response()->json([
                'error' => "No se encontro el certificado.",
            ], 401);

        }

        $data = json_decode($certificacion->cadena_original, true);

        return response()->json([
            'data' => $data['predio']['propietarios'],
        ], 200);

    }

    public function consultarPropietariosPredioId(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $predio = Predio::with('propietarios.persona')->find($validated['id']);

        if(!$predio){

            return response()->json([
                'error' => "El predio no existe.",
            ], 404);

        }

        if($predio->status != 'activo'){

            return response()->json([
                'error' => "El predio no esta activo.",
            ], 401);

        }

        return PropietariosResource::collection($predio->propietarios)->response()->setStatusCode(200);

    }

}
