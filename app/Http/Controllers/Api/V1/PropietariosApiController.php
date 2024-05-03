<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Tramite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TramiteRequest;
use App\Http\Resources\PropietariosResource;

class PropietariosApiController extends Controller
{

    public function consultarPropietarios(TramiteRequest $request){

        $validated = $request->validated();

        $tramite = Tramite::with('predios')
                                ->where('año', $validated['año'])
                                ->where('folio', $validated['folio'])
                                ->where('usuario', 11)
                                ->where('usuario_tramites_linea_id', $validated['entidad'])
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

        $predio->load('propietarios.persona');

        return PropietariosResource::collection($predio->propietarios)->additional(['tramite_id' => $tramite->id]);

    }

}
