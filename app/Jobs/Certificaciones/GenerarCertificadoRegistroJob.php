<?php

namespace App\Jobs\Certificaciones;

use App\Http\Controllers\Certificaciones\CertificadoRegistroController;
use App\Models\Predio;
use App\Models\Tramite;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerarCertificadoRegistroJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Tramite $tramite, public Predio $predio, public User $user, public string $observaciones)
    {}

    public function handle(): void
    {

        (new CertificadoRegistroController())->certificado($this->tramite, $this->predio, 'CERTIFICADO DE REGISTRO CATASTRAL', $this->user, $this->observaciones);

    }

}
