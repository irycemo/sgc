<?php

use App\Models\OldTraslado;
use App\Jobs\MigrarPredioJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('cache:recaudacion')->dailyAt('23:10');

Artisan::command('migrar', function(){

    Schema::disableForeignKeyConstraints();
    DB::table('colindancias')->truncate();
    DB::table('propietarios')->truncate();
    DB::table('personas')->truncate();
    DB::table('terrenos')->truncate();
    DB::table('construccions')->truncate();
    DB::table('terrenos_comuns')->truncate();
    DB::table('construcciones_comuns')->truncate();
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

    $this->info('Incian ' . $predios->count() . ' predios en chunks de 100 predios en: ' . now());

    $predios = $predios->chunk(100);

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

Artisan::command('migrar-audit', function(){

    Schema::disableForeignKeyConstraints();

    DB::table('old_audits')->truncate();

    $this->info('Incia migración de auditoria el: ' . now());

    $now = now()->format('Y-m-d H:i:s');

    $handle = fopen(storage_path('app/public/emi.csv'), 'r');

    fgets($handle);

    $chunkSize = 500;

    $chunks = [];

    try {

        $rowPlaceholders = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $placeholders = implode(',', array_fill(0, $chunkSize, $rowPlaceholders));

        $stmt =  DB::connection()->getPdo()->prepare("
                                                        INSERT INTO old_audits (tipo, locl, ofna, tpre, nreg, fecha, emple, expe, ania, foli, usua, created_at, updated_at)
                                                        VALUES {$placeholders}
                                                    ");

        while(($line = fgetcsv($handle)) !== false){

            $chunks = array_merge($chunks, [
                trim($line[0]), //Tipo
                $line[6], //Localidad
                $line[1], //Oficina
                $line[2], //T Predio
                $line[3], //Registro
                $line[12], //Fecha
                trim($line[13]), //Empleado
                trim($line[14]), //Expe
                $line[15], //T Año
                $line[16], //T Folio
                $line[17], //T Usuario
                $now,
                $now
            ]);

            if(count($chunks) === $chunkSize * 13){

                $stmt->execute($chunks);

                $chunks = [];

            }

        }

        if(!empty($chunks)){

            $remainingRows = count($chunks) / 13;

            $rowPlaceholders = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

            $placeholders = implode(',', array_fill(0, $remainingRows, $rowPlaceholders));

            $stmt = DB::connection()->getPdo()->prepare("
                                                        INSERT INTO old_audits (tipo, locl, ofna, tpre, nreg, fecha, emple, expe, ania, foli, usua, created_at, updated_at)
                                                        VALUES {$placeholders}
                                                    ");

            $stmt->execute($chunks);

        }

        $this->info('Finaliza migración de auditoria el: ' . now());

    }  finally {

        fclose($handle);

    }

});

Artisan::command('migrar-certificados', function(){

    Schema::disableForeignKeyConstraints();

    DB::table('old_certificados')->truncate();

    $this->info('Incia migración de certificados el: ' . now());

    $now = now()->format('Y-m-d H:i:s');

    $handle = fopen(storage_path('app/public/certificados.csv'), 'r');

    fgets($handle);

    $chunkSize = 500;

    $chunks = [];

    try {

        $rowPlaceholders = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?, ?)';

        $placeholders = implode(',', array_fill(0, $chunkSize, $rowPlaceholders));

        $stmt =  DB::connection()->getPdo()->prepare("
                                                        INSERT INTO old_certificados (locl, ofna, tpre, nreg, tipo, stat, tipo_cer, ciudad, imprimio, actualizo, fecha, acer, atra, foli, usua, created_at, updated_at)
                                                        VALUES {$placeholders}
                                                    ");

        while(($line = fgetcsv($handle)) !== false){

            $chunks = array_merge($chunks, [
                $line[0], //Localidad
                $line[1], //Oficina
                $line[2], //T Predio
                $line[3], //Registro
                trim($line[4]), //Tipo
                trim($line[5]), //Status
                trim($line[6]), //Tipo certificado
                trim($line[7]), //Ciudad
                trim($line[8]), //Imprimio
                trim($line[9]), //Actualizo
                $line[10], // Fecha
                $line[11], // Acer
                $line[12], // Atra
                $line[13], // Foli
                $line[14], // Usua
                $now,
                $now
            ]);

            if(count($chunks) === $chunkSize * 17){

                $stmt->execute($chunks);

                $chunks = [];

            }

        }

        if(!empty($chunks)){


            $remainingRows = count($chunks) / 17;

            $rowPlaceholders = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ?, ?)';

            $placeholders = implode(',', array_fill(0, $remainingRows, $rowPlaceholders));

            $stmt = DB::connection()->getPdo()->prepare("
                                                        INSERT INTO old_certificados (locl, ofna, tpre, nreg, tipo, stat, tipo_cer, ciudad, imprimio, actualizo, fecha, acer, atra, foli, usua, created_at, updated_at)
                                                        VALUES {$placeholders}
                                                    ");

            $stmt->execute($chunks);

        }

        $this->info('Finaliza migración de certificados el: ' . now());

    }  finally {

        fclose($handle);

    }

});

Artisan::command('migrar-traslados', function(){

    Schema::disableForeignKeyConstraints();

    DB::table('old_traslados')->truncate();

    $traslados = DB::connection('sqlsrv')->table('cttra108')
                            ->whereIn('stat_108', ['OPERADO', 'AUTORIZADO'])
                            ->get();

    /* $traslados = $traslados->chunk(100); */

    $this->info('Incia migración de traslados el: ' . now());

    foreach ($traslados as $traslado) {

        $adquirientes = DB::connection('sqlsrv')->table('ctcop105')
                            ->where('anit_105', $traslado->anit_108)
                            ->where('cont_105', $traslado->cont_108)
                            ->where('cnot_105', $traslado->cnot_108)
                            ->get();

        $adquirientes_text = '';

        foreach ($adquirientes as $adquiriente) {

            $adquirientes_text = $adquirientes_text . '\n' . trim($adquiriente->apat_105) . ' ' . trim($adquiriente->amat_105) . ' ' . trim($adquiriente->nomb_105) . ' ' . trim($adquiriente->ppro_105);

        }

        OldTraslado::create([
            'locl' => $traslado->locl_108,
            'ofna' => $traslado->ofna_108,
            'tpre' => $traslado->tpre_108,
            'nreg' => $traslado->nreg_108,
            'anit' => $traslado->anit_108,
            'cont' => $traslado->cont_108,
            'cnot' => $traslado->cnot_108,
            'stat' => $traslado->stat_108,
            'act1' => $traslado->act1_108,
            'nven' => $traslado->nven_108,
            'adquiriente' => $adquirientes_text,
            'ffir' => $traslado->ffir_108,
        ]);

    }

});
