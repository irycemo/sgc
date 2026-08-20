<?php

namespace App\Services\SistemaArchivo;

use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Http;

class SistemaArchivoService{

    public function crearSolicitud($localidad, $oficina, $tipo_predio, $numero_registro, $solicitante){

        $response = Http::withToken(config('services.sistema_archivo.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_archivo.crear_solicitud'),
                                [
                                    'localidad' => $localidad,
                                    'oficina' => $oficina,
                                    'tipo_predio' => $tipo_predio,
                                    'numero_registro' => $numero_registro,
                                    'solicitante' => $solicitante
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al crear solicitud de archivo" . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al crear solicitud de archivo.");

        }else{

            return json_decode($response, true);

        }

    }

}
