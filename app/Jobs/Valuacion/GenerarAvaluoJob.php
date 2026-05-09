<?php

namespace App\Jobs\Valuacion;

use App\Http\Controllers\Valuacion\AvaluoImpresionController;
use App\Models\Avaluo;
use App\Models\User;
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
    public function __construct(public int $avaluo_id, public string $nombre, public User $user)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $avaluo = Avaluo::find($this->avaluo_id);

        $pdf = (new AvaluoImpresionController())->generarAvaluo($avaluo, $this->user);

        $content = $pdf->output();

        Storage::put('livewire-tmp/' . $this->nombre . '.pdf', $content);

    }
}
