<?php

namespace App\Jobs;

use App\Http\Controllers\Certificaciones\CedulaActualizcacionController;
use App\Http\Controllers\Certificaciones\CertificadoRegistroController;
use App\Models\Tramite;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerarCertificacionMigracionJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Tramite $tramite)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $user = User::where('email', 'sistematramiteslinea@gmail.com')->first();

        foreach($this->tramite->predios as $predio){

            match($this->tramite->servicio_id){
                3   => (new CertificadoRegistroController())->certificado($this->tramite, $predio, 'CERTIFICADO DE REGISTRO CATASTRAL', $user),
                293 => (new CertificadoRegistroController())->certificado($this->tramite, $predio, 'CERTIFICADO DE REGISTRO CATASTRAL', $user),
                297 => (new CertificadoRegistroController())->certificado($this->tramite, $predio, 'CERTIFICADO DE REGISTRO CATASTRAL', $user),
                296 => (new CertificadoRegistroController())->certificado($this->tramite, $predio, 'CERTIFICADO DE REGISTRO CATASTRAL', $user),
                64  => (new CedulaActualizcacionController())->cedula($this->tramite, $predio, $user),
                65  => (new CedulaActualizcacionController())->cedula($this->tramite, $predio, $user),
            };

            $this->tramite->predios()->updateExistingPivot($predio->id, ['estado' => 'I']);

        }

        $this->tramite->update(['usados' => $this->tramite->cantidad, 'estado' => 'concluido']);


    }
}
