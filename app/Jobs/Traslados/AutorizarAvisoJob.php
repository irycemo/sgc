<?php

namespace App\Jobs\Traslados;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Models\Traslado;
use App\Services\SistemaTramitesLinea\SistemaTramitesLineaService;
use Illuminate\Foundation\Queue\Queueable;

class AutorizarAvisoJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Traslado $traslado, public string $observaciones)
    {}

    public function handle(): void
    {

        (new SistemaTramitesLineaService())->autorizarAviso($this->traslado->aviso_stl, $this->observaciones);

    }

    public function failed(?\Throwable $exception): void
    {

        Log::error('Falló el Job de autorizar aviso', [
            'traslado_id' => $this->traslado->id,
            'aviso_folio' => $this->traslado->folioAviso(),
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);

    }

}
