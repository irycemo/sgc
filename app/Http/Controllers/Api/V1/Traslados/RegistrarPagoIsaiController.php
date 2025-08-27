<?php

namespace App\Http\Controllers\Api\V1\Traslados;

use App\Models\Predio;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrarPagoIsaiRequest;
use App\Models\Traslado;
use App\Services\SistemaTramitesLinea\SistemaTramitesLineaService;

class RegistrarPagoIsaiController extends Controller
{

    public function registrarPagoIsai(RegistrarPagoIsaiRequest $request){

        $validated = $request->validated();

        $predio = Predio::where('localidad', $validated['localidad'])
                            ->where('oficina', $validated['oficina'])
                            ->where('tipo_predio', $validated['tipo_predio'])
                            ->where('numero_registro', $validated['numero_registro'])
                            ->first();

        if(! $predio){

            return response()->json([
                'error' => 'El predio no existe.',
            ], 404);

        }

        if($predio->status != 'activo'){

            return response()->json([
                'error' => 'El predio no esta activo.',
            ], 401);

        }

        try {

            $data_aviso = (new SistemaTramitesLineaService())->consultarAvisoConFolio($validated['año_aviso'], $validated['folio_aviso'], $validated['usuario_aviso']);

            $traslado = Traslado::where('predio_id', $predio->id)
                                    ->where('aviso_stl', $data_aviso['id'])
                                    ->whereIn('estado', ['cerrado', 'autorizado'])
                                    ->first();

            if(! $traslado){

                return response()->json([
                    'error' => 'No hay un traslado para ingresar el pago de ISAI.',
                ], 404);

            }

            if(! $traslado->valor_isai != $validated['valor_isai']){

                return response()->json([
                    'error' => 'El valor del ISAI no corresponde al valor asentado en el aviso.',
                ], 401);

            }

            $traslado->update([
                'pago_isai' => true
            ]);


        } catch (GeneralException $ex) {

            return response()->json([
                'error' => $ex->getMessage(),
            ], 404);

        } catch (\Throwable $th) {

            Log::error("Error al registrar pago de ISAI desde SACPI." . $th);

            return response()->json([
                'error' => 'Hubo un error al ingresar la información en el Sistema de Gestión Catastral.',
            ], 500);

        }

        return response()->json([
            'data' => [
                'mensaje' => 'El pago de ISAI se registro correctamente en el Sistema de Gestión Catastral.'
            ]
        ], 200);

    }

}
