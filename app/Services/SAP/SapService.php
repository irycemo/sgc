<?php

namespace App\Services\SAP;

use App\Models\Tramite;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Http;

class SapService{

    public $soapUserApi;
    public $soapPasswordApi;
    public $tramite;

    public function __construct(Tramite $tramite)
    {

        $this->soapUserApi = config('services.sap.SAP_USUARIO_API');

        $this->soapPasswordApi = config('services.sap.SAP_CONTRASENA_API');

        $this->tramite = $tramite;

    }

    public function generarLineaDeCaptura(){

        $url = config('services.sap.SAP_GENERAR_LINEA_DE_CAPTURA_URL');

        $observaciones = "Numero de control: " . $this->tramite->año . '-' . $this->tramite->folio . '-' . $this->tramite->usuario .  " Tipo de servicio: " . $this->tramite->tipo_servicio;

        try {

            $response = Http::withBasicAuth($this->soapUserApi, $this->soapPasswordApi)->post($url, [
                "MT_ServGralLC_PI_Sender" => [
                    "ES_GEN_DATA" => [
                        "TP_PROCESAMIENTO" => "2",
                        "TP_DATOMAESTRO" => "E",
                        "TP_DIVERSO" => "CATASTRO",
                        "RFC" => "XXXX0001XXX",
                        "NOMBRE_RAZON" => $this->tramite->nombre_solicitante,
                        "OBSERVACIONES" => $observaciones,
                    ],
                    "TB_CONCEPTOS" => [
                        "TP_INGRESO" => $this->tramite->servicio->clave_ingreso,
                        "CANTIDAD" => $this->tramite->cantidad,
                        "IMPORTE" => round($this->tramite->monto, 2)
                    ]
                ]
            ]);

        } catch (\Throwable $th) {

            Log::error($th);

            throw new GeneralException("Error de comunicación con SAP.");

            return;

        }

        $data = json_decode($response, true);

        if(isset($data['mensaje']) && $data['mensaje'] == 'Error al consumir servicio'){

            Log::error($data['mensaje'] . ' EN SAP');

            throw new GeneralException("Error de comunicación con SAP.");

            return;

        }

        if(isset($data['ES_MSJ']['TpMens'])){

            Log::error($data['ES_MSJ']['V1Mens'] . ' EN SAP');

            throw new GeneralException("Error de comunicación con SAP.");

            return;

        }

        if(isset($data['ERROR'])){

            Log::error($data['ERROR'] . ' SAP');

            throw new GeneralException("Error de comunicación con SAP.");

            return;

        }

        return $data;

    }

    public function validarLineaDeCaptura(){

        $url = config('services.sap.SAP_VALIDAR_LINEA_DE_CAPTURA_URL');

        try {

            $response = Http::withBasicAuth($this->soapUserApi, $this->soapPasswordApi)->get($url .'/' . $this->tramite->linea_de_captura);

        } catch (\Throwable $th) {

            Log::error($th);

            throw new GeneralException("Error de comunicación con SAP.");

            return;

        }

        if($response->status() != 200){

            throw new GeneralException("Error de comunicación con SAP.");

            return;

        }

        $data = json_decode($response, true);

        if(isset($data['ES_MSJ'])){

            Log::error($data['ES_MSJ']['V1_MENS'] . ' EN SAP');

            throw new GeneralException($data['ES_MSJ']['V1_MENS'] ." en SAP.");

            return;

        }

        if(isset($data['ERROR'])){

            Log::error($data['ERROR'] . ' SAP');

            throw new GeneralException("Error de comunicación con SAP.");

            return;

        }

        return $data;

    }

}