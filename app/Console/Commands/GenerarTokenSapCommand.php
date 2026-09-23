<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GenerarTokenSapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generar-token-sap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para obtener el token para generar las lineas de captura cada hora';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        try {

            $token = $this->generarToken();

            Cache::forget('sap_token');

            Cache::put('sap_token', $token);

        } catch (\Throwable $th) {

            Log::error($th);

            throw new GeneralException("Error de comunicación con SAP.");

        }

    }

    public function generarToken(){

        $response = Http::post(config('services.sap.SAP_GENERAR_TOKEN_URL'), [
                                "email" => config('services.sap.SAP_TOKEN_USUARIO'),
                                "password" => config('services.sap.SAP_TOKEN_CONTRASEÑA')
                            ]);

        if($response->status() === 200){

            $data = json_decode($response, true);

            return $data['token'];

        }else{

        dd($response);

            throw new GeneralException("Error de comunicación con SAP." . $response);

        }


    }

}
