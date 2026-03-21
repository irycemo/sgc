<?php

namespace App\Console\Commands;

use App\Exceptions\GeneralException;
use App\Models\Tramite;
use App\Services\Tramites\TramiteService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RevisarPagoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revisar-pago';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tarea programada para checar pago en sap para tramties del Sistema de Tramites en Linea';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $tramites = Tramite::with('servicio')
                                ->where('estado', 'nuevo')
                                ->where('usuario', 11)
                                ->get();

        try {

            foreach($tramites as $tramite){

                $data = $this->validarLineaDeCaptura($tramite->linea_de_captura);

                if(isset($data['FEC_PAGO'])){

                    (new TramiteService($tramite))->procesarPago();

                    info('Tramite validado mediante tarea programada: ' . $tramite->año . '-' . $tramite->folio . '-' . $tramite->usuario);

                }

            }

        } catch (GeneralException $ex) {

        } catch (\Throwable $th) {

            Log::error("Error al revisar pago de tramites en tarea programada. " . $th);

        }

    }

    public function validarLineaDeCaptura($linea_captura){

        $url = config('services.sap.SAP_VALIDAR_LINEA_DE_CAPTURA_URL');

        $response = Http::withBasicAuth(config('services.sap.SAP_USUARIO_API'), config('services.sap.SAP_CONTRASENA_API'))->get($url .'/' . $linea_captura);

        $data = json_decode($response, true);

        return $data;

    }

}
