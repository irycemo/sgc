<?php

namespace App\Jobs\Valuacion;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class MergePdfsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $batchId, public array $nombres, public string $name)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            $oMerger = PDFMerger::init();

            foreach ($this->nombres as $archivo) {

                $relativePath = 'livewire-tmp/' . $archivo . '.pdf';

                if (! Storage::disk('local')->exists($relativePath)) {
                    continue;
                }

                $oMerger->addPDF(Storage::path($relativePath), 'all');

            }

            $oMerger->merge();

            Storage::put('livewire-tmp/' . $this->name, $oMerger->output());

        } catch (\Throwable $th) {

            Log::error("Error en job merge pdfs. " . $th);

            throw $th;

        }
    }
}
