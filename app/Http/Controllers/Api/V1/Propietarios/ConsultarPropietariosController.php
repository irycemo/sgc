<?php

namespace App\Http\Controllers\Api\V1\Propietarios;

use App\Models\Predio;
use Carbon\Carbon;
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
                'error' => "El trámite de certificado no esta relacionado con el predio del aviso.",
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

        $fecha_creacion_certificado = Carbon::parse($certificacion->created_at);

        $fecha_mas_mes = $fecha_creacion_certificado->copy()->addMonth();

        if(now()->between($fecha_creacion_certificado, $fecha_mas_mes)){

            $dentro_del_primer_mes = true;

        }else{

            $dentro_del_primer_mes = false;

        }

        $data = json_decode($certificacion->cadena_original, true);

        return response()->json([
            'data' => [
                'propietarios' => $data['predio']['propietarios'],
                'dentro_del_primer_mes' => $dentro_del_primer_mes
            ],
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
