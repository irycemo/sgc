<?php

namespace App\Jobs\Valuacion;

use App\Jobs\Valuacion\CrearAvaluoJob;
use App\Models\Import;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;

class CrearAvaluoChain implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $batchId, public int $user_id)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $jobs = [];

        Import::where('batch_id', $this->batchId)
            ->where('status', 'pending')
            ->orderBy('row_number')
            ->chunk(500, function ($rows) use (&$jobs) {

                foreach ($rows as $row) {

                    $data = json_decode($row->data, true);

                    $jobs[] = new CrearAvaluoJob(
                        $row->id,
                        $data,
                        $this->user_id,
                        $this->batchId
                    );

                }
            });

        if (!empty($jobs)) {

            Bus::chain($jobs)->dispatch();

        }

    }
}
