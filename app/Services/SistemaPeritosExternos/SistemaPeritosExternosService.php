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

    public function generarAvaluoPdf(int $aviso_id):array
    {

        $response = Http::withToken(config('services.sistema_peritos_externos.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_peritos_externos.generar_avaluo_pdf'),
                                [
                                    'id' => $aviso_id,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al generar pdf del avalúo. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al generar pdf del avalúo.");

        }else{

            return json_decode($response, true);

        }

    }

    public function consultarCartografia(int | null $año, int | null $folio, int | null $usuario, int $pagina_actual, int $pagination):array
    {

        $response = Http::withToken(config('services.sistema_peritos_externos.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_peritos_externos.consultar_cartografia'),
                                [
                                    'año' => $año,
                                    'folio' => $folio,
                                    'usuario' => $usuario,
                                    'pagina' => $pagina_actual,
                                    'pagination' => $pagination,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar cartografia. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar cartografia.");

        }else{

            return json_decode($response, true);

        }

    }

    public function validarCartografia(int $avaluo_id):array
    {

        $response = Http::withToken(config('services.sistema_peritos_externos.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_peritos_externos.validar_cartografia'),
                                [
                                    'id' => $avaluo_id,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al validar cartografia. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al validar cartografia.");

        }else{

            return json_decode($response, true);

        }

    }

}