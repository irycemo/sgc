<?php

namespace App\Http\Controllers\Api\V1\Servicios;

use App\Models\Servicio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServicioResource;

class ConsultarServiciosController extends Controller
{

    public function consultarServicios(Request $request){

        $validated = $request->validate(['claves_ingreso' => 'required|array']);

        return ServicioResource::collection(Servicio::whereIn('clave_ingreso', $validated['claves_ingreso'])->get())->response()->setStatusCode(200);

    }

}
