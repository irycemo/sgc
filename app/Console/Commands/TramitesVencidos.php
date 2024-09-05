<?php

namespace App\Console\Commands;

use App\Models\Tramite;
use Illuminate\Console\Command;

class TramitesVencidos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tramites:vencidos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rutina para cambiar el estatus de los tramites a vencidos';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        Tramite::whereDate('fecha_vencimiento', '>=', now()->toDateString())
                             ->update(['estado' => 'expirado']);
    }
}
