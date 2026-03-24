<?php

namespace App\Console\Commands;

use App\Models\Tramite;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpirarTramitesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expirar-tramites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tarea programada para expirar tramites nuevos registrados con mas de 10 dias';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $hace10Dias = now()->subDays(10);

        $tramites = Tramite::where('estado', 'nuevo')->where('created_at', '>=', $hace10Dias)->get();

        try {

            foreach($tramites as $tramite){

                $tramite->update(['estado' => 'expirado']);

            }

            Log::error("Tarea programada para expirar trámites finalizada con éxito.");

        } catch (\Throwable $th) {

            Log::error("Error al expirar tramites mediante tarea programada. " . $th);

        }

    }
}
