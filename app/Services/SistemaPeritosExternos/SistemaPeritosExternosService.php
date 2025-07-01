<?php

namespace App\Services\SistemaPeritosExternos;

use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Http;

class SistemaPeritosExternosService{

    public function consultarAvaluo(int $avaluo_spe):array
    {

        $response = Http::withToken(config('services.sistema_peritos_externos.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_peritos_externos.consultar_avaluo'),
                                [
                                    'id' => $avaluo_spe,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar avalúo. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar avalúo.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function operarAvaluo(int $avaluo_spe):array
    {

        $response = Http::withToken(config('services.sistema_peritos_externos.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_peritos_externos.operar_avaluo'),
                                [
                                    'id' => $avaluo_spe,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al operar avalúo. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al operar avalúo.");

        }else{

            return json_decode($response, true);

        }

    }

}