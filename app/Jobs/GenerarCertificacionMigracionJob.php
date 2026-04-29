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

            (new CertificadoRegistroController())->certificado($this->tramite, $predio, 'CERTIFICADO DE REGISTRO CATASTRAL', $user, false);

            $this->tramite->predios()->updateExistingPivot($predio->id, ['estado' => 'I']);

        }

        $this->tramite->update(['usados' => $this->tramite->cantidad, 'estado' => 'concluido']);


    }
}
