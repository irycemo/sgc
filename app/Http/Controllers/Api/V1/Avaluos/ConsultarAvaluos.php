<?php

namespace App\Http\Controllers\Api\V1\Avaluos;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvaluoApiRequest;
use App\Http\Requests\AvaluosApiRequest;
use App\Http\Resources\AvaluoResource;
use App\Models\Avaluo;

class ConsultarAvaluos extends Controller
{

    public function consultarAvaluo(AvaluoApiRequest $request){

        $validated = $request->validated();

        $avaluo = Avaluo::where('año', $validated['año'])
                            ->where('folio', $validated['folio'])
                            ->where('usuario', $validated['usuario'])
                            ->where('estado', 'notificado')
                            ->first();

        return (new AvaluoResource($avaluo))->response()->setStatusCode(200);

    }

    public function consultarAvaluos(AvaluosApiRequest $request){

        $validated = $request->validated();

        $avaluos = Avaluo::with(
                                 'bloques',
                                 'predioAvaluo.colindancias',
                                 'predioAvaluo.propietarios.persona',
                                 'predioAvaluo.terrenos',
                                 'predioAvaluo.terrenosComun',
                                 'predioAvaluo.construcciones',
                                 'predioAvaluo.construccionesComun'
                                )
                                ->where('estado', 'notificado')
                                ->whereHas('predioAvaluo', function($q) use ($validated){
                                    $q->where('localidad', $validated['localidad'])
                                    ->where('oficina', $validated['oficina'])
                                    ->where('tipo_predio', $validated['tipo_predio'])
                                    ->whereBetween('numero_registro', [$validated['numero_registro_inicial'], $validated['numero_registro_final']]);
                                })
                                ->get();

        return AvaluoResource::collection($avaluos)->response()->setStatusCode(200);

    }

}
