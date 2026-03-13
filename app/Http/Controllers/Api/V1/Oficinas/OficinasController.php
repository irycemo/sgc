<?php

namespace App\Http\Controllers\Api\V1\Oficinas;

use App\Models\Oficina;
use App\Http\Controllers\Controller;
use App\Http\Resources\OficinaResource;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\OficinaListRequest;

class OficinasController extends Controller
{

    public function consultarOficinas(OficinaListRequest $request){

        $validated = $request->validated();

        $oficinas = Oficina::with('cabeceraMunicipal:id,nombre')
                                ->when(isset($validated['search']), function($q) use ($validated){
                                    $q->where('municipio', 'LIKE', '%'. $validated['search'] . '%')
                                    ->orWhere('oficina', 'LIKE', '%'. $validated['search'] . '%')
                                    ->orWhere('localidad', 'LIKE', '%'. $validated['search'] . '%')
                                    ->orWhere('nombre', 'LIKE', '%'. $validated['search'] . '%')
                                    ->orWhere('titular', 'LIKE', '%'. $validated['search'] . '%')
                                    ->orWhere('email', 'LIKE', '%'. $validated['search'] . '%')
                                    ->orWhere('telefonos', 'LIKE', '%'. $validated['search'] . '%')
                                    ->orWhere('autoridad_municipal', 'LIKE', '%'. $validated['search'] . '%')
                                    ->orWhere('valuador_municipal', 'LIKE', '%'. $validated['search'] . '%');
                                })
                                ->orderBy('id', 'desc')
                                ->paginate($validated['pagination'], ['*'], 'page', $validated['pagina']);

        return OficinaResource::collection($oficinas)->response()->setStatusCode(200);

    }

    public function consultarOficinasCabeceras(Request $request){

        $oficinas = Oficina::with('cabeceraMunicipal:id,nombre')
                            ->whereNull('cabecera')
                            ->orderBy('nombre')
                            ->get();

        return OficinaResource::collection($oficinas)->response()->setStatusCode(200);

    }

}
