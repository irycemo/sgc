<?php

namespace App\Services\SistemaTramitesLinea;

use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Http;

class SistemaTramitesLineaService{

    public function consultarAviso(int $aviso_stl):array
    {

        $response = Http::withToken(config('services.sistema_tramites_en_linea.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_tramites_en_linea.consultar_aviso'),
                                [
                                    'id' => $aviso_stl,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar aviso. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar aviso.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function consultarAvisoConFolio(int $año, int $folio, int $usuario):array
    {

        $response = Http::withToken(config('services.sistema_tramites_en_linea.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_tramites_en_linea.consultar_aviso_con_folio'),
                                [
                                    'año' => $año,
                                    'folio' => $folio,
                                    'usuario' => $usuario,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar aviso. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar aviso.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function autorizarAviso(int $aviso_stl, string | null $obseraciones = null):array
    {

        $response = Http::withToken(config('services.sistema_tramites_en_linea.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_tramites_en_linea.autorizar_aviso'),
                                [
                                    'id' => $aviso_stl,
                                    'observaciones' => $obseraciones
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al autorizar aviso. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al autorizar aviso.");

        }else{

            return json_decode($response, true);

        }

    }

    public function operarAviso(int $aviso_stl):array
    {

        $response = Http::withToken(config('services.sistema_tramites_en_linea.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_tramites_en_linea.operar_aviso'),
                                [
                                    'id' => $aviso_stl,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al operar aviso. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al operar aviso.");

        }else{

            return json_decode($response, true);

        }

    }

    public function rechazarAviso(int $aviso_stl, string $observaciones):array
    {

        $response = Http::withToken(config('services.sistema_tramites_en_linea.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_tramites_en_linea.rechazar_aviso'),
                                [
                                    'id' => $aviso_stl,
                                    'observaciones' => $observaciones
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al rechazar aviso. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al rechazar aviso.");

        }else{

            return json_decode($response, true);

        }

    }

    public function generarAvisoPdf(int $aviso_id):array
    {

        $response = Http::withToken(config('services.sistema_tramites_en_linea.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_tramites_en_linea.generar_aviso_pdf'),
                                [
                                    'id' => $aviso_id,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al generar pdf del aviso. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al generar pdf del aviso.");

        }else{

            return json_decode($response, true);

        }

    }

}