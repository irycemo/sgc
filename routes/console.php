<?php


use App\Models\Migracion\ctref007;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use App\Http\Services\Migracion\Migracion;
use App\Jobs\MigrarPredioJob;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('migrar', function(){

    Schema::disableForeignKeyConstraints();
    DB::table('colindancias')->truncate();
    DB::table('propietarios')->truncate();
    DB::table('personas')->truncate();
    DB::table('terrenos')->truncate();
    DB::table('construccions')->truncate();
    DB::table('condominioterrenos')->truncate();
    DB::table('condominioconstruccions')->truncate();
    DB::table('movimientos')->truncate();
    DB::table('predios')->truncate();
    DB::table('predio_repetidos')->truncate();
    DB::table('jobs')->truncate();
    DB::table('failed_jobs')->truncate();
    Schema::enableForeignKeyConstraints();

    /* $referencias = ctref007::whereIn('tipo_007', ["TV", "AH", "UP", "UB", "TE", "ED", "TP", "OM"])->get(); */

    $predios = DB::connection('sqlsrv')->table('tcpro008')
                            ->join('ctpro003', function($q){
                                $q->on('tcpro008.mpio_008', 'ctpro003.mpio_003')
                                    ->on('tcpro008.zcat_008', 'ctpro003.zcat_003')
                                    ->on('tcpro008.locl_008', 'ctpro003.locl_003')
                                    ->on('tcpro008.sect_008', 'ctpro003.sect_003')
                                    ->on('tcpro008.mzna_008', 'ctpro003.mzna_003')
                                    ->on('tcpro008.pred_008', 'ctpro003.pred_003')
                                    ->on('tcpro008.edif_008', 'ctpro003.edif_003')
                                    ->on('tcpro008.dpto_008', 'ctpro003.dpto_003')
                                    /* ->where('tcpro008.mpio_008', 53) */
                                    ->where('tcpro008.nreg_008', '>', 0);
                            })
                            ->get();

    $this->info('Incian ' . $predios->count() . ' predios en chunks de 1000 predios en: ' . now());

    $predios = $predios->chunk(1000);

    $progressbar = $this->output->createProgressBar(count($predios));

    $progressbar->start();

    foreach ($predios as $predio) {

        MigrarPredioJob::dispatch($predio);

        $progressbar->advance();

    }

    /* foreach($predios as $predio){

        (new Migracion($referencias))->run($predio);

        $progressbar->advance();

    } */

    $progressbar->finish();

    $this->info('Finaliza: ' . now());

});
