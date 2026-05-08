<?php

namespace App\Jobs\Valuacion;

use App\Http\Controllers\Valuacion\AvaluoImpresionController;
use App\Models\Avaluo;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class GenerarAvaluoJob implements ShouldQueue
{

    use Queueable;
    use Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(int $avaluo_id, string $nombre)
    {

        $avaluo = Avaluo::find($avaluo_id);

        $pdf = (new AvaluoImpresionController())->generarAvaluo($avaluo);

        $content = $pdf->output();

        Storage::put('livewire-tmp/' . $nombre . '.pdf', $content);

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
