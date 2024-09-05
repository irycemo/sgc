<?php

namespace App\Jobs;

use Throwable;
use App\Models\Tramite;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GenerarFolioTramitesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    private Tramite $tramite;

    public $tries = 5;

    /**
     * Create a new job instance.
     */
    public function __construct(int $tramiteId)
    {

        $this->onQueue('tramiteFolioQueue');

        $this->tramite = Tramite::findOrFail($tramiteId);

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $this->tramite->folio = (Tramite::where('año', $this->tramite->año)->max('folio') ?? 0) + 1;

        $this->tramite->save();

    }

    public function failed(Throwable $exception): void
    {
        // Send user notification of failure, etc...
    }

}
