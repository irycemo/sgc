<?php

use App\Jobs\GenerarCertificacionMigracionJob;
use App\Jobs\MigrarPredioJob;
use App\Models\OldCertificado;
use App\Models\OldTraslado;
use App\Models\Predio;
use App\Models\Tramite;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Schema;

Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('01:30');

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
                                    ->where('tcpro008.mpio_008', 53)
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

    $certificados = DB::connection('sqlsrv')->table('certificaciones')
                            ->whereIn('ofna', 101)
                            ->get();

    $this->info('Incia migración de certificados el: ' . now());

    $progressbar = $this->output->createProgressBar(count($certificados));

    $progressbar->start();

    foreach ($certificados as $certificado) {

        OldCertificado::create([
            'locl' => $certificado->locl,
            'ofna' => $certificado->ofna,
            'tpre' => $certificado->tpre,
            'nreg' => $certificado->nreg,
            'tipo' => trim($certificado->anit),
            'stat' => trim($certificado->cont),
            'tipo_cer' => $certificado->cnot,
            'ciudad' => trim($certificado->stat),
            'imprimio' => trim($certificado->act1),
            'actualizo' => trim($certificado->nven),
            'fecha' => $certificado->fecha,
            'acer' => $certificado->ffir,
            'atra' => $certificado->nomp,
            'foli' => $certificado->ster,
            'usua' => $certificado->scon,
            'observaciones' => $certificado->obse,
        ]);

        $progressbar->advance();

    }

    $progressbar->finish();

    $this->info('Finaliza: ' . now());

});

Artisan::command('migrar-traslados', function(){

    Schema::disableForeignKeyConstraints();

    DB::table('old_traslados')->truncate();

    $traslados = DB::connection('sqlsrv')->table('cttra108')
                            ->whereIn('stat_108', ['OPERADO', 'AUTORIZADO', 'RECHAZADO'])
                            ->where('mpio_108', 53)
                            ->get();

    $this->info('Incia migración de traslados el: ' . now());

    $progressbar = $this->output->createProgressBar(count($traslados));

    $progressbar->start();

    foreach ($traslados as $traslado) {

        $adquirientes = DB::connection('sqlsrv')->table('ctcop105')
                            ->where('anit_105', $traslado->anit_108)
                            ->where('cont_105', $traslado->cont_108)
                            ->where('cnot_105', $traslado->cnot_108)
                            ->get();

        $adquirientes_text = '';

        foreach ($adquirientes as $adquiriente) {

            $adquirientes_text = $adquirientes_text . ' Tipo: ' . trim($adquiriente->tper_105) . ', ' . trim($adquiriente->apat_105) . ' ' . trim($adquiriente->amat_105) . ' ' . trim($adquiriente->nomb_105) . ' ' . trim($adquiriente->ppro_105);

        }

        OldTraslado::create([
            'locl' => trim($traslado->locl_108),
            'ofna' => trim($traslado->ofna_108),
            'tpre' => trim($traslado->tpre_108),
            'nreg' => trim($traslado->nreg_108),
            'anit' => trim($traslado->anit_108),
            'cont' => trim($traslado->cont_108),
            'cnot' => trim($traslado->cnot_108),
            'stat' => trim($traslado->stat_108),
            'act1' => trim($traslado->act1_108),
            'nven' => trim($traslado->nven_108),
            'adquiriente' => $adquirientes_text,
            'ffir' => trim($traslado->ffir_108),
            'nombre_predio' => trim($traslado->nomp_108),
            'superficie_notarial' => trim($traslado->ster_108),
            'superficie_construccion' => trim($traslado->scon_108),
            'antecedente_tomo' => trim($traslado->tomo_108),
            'antecedente_registro' => trim($traslado->regi_108),
            'antecedente_acto' => trim($traslado->nact_108),
            'documento_entrada' => trim($traslado->nesc_108),
            'documento_numero' => trim($traslado->volu_108),
            'distrito' => trim($traslado->dtop_108),
            'seccion' => trim($traslado->libr_108),
            'observacion' => trim($traslado->obse_108),
            'lugar_firma' => trim($traslado->lfir_108),
            'fecha_firma' => trim($traslado->ffir_108),
            'anexos' => trim($traslado->anex_108),
            'valor_base' => trim($traslado->vbas_108),
            'reduccion' => trim($traslado->redu_108),
            'tasa' => trim($traslado->tasa_108),
            'valor_avaluo' => trim($traslado->vava_108),
            'valor_vivienda_mixto' => trim($traslado->cviv_108),
            'valor_otro_uso_mixto' => trim($traslado->cotr_108),
            'isai' => trim($traslado->isai_108),
            'fecha_reduccion' => trim($traslado->fsai_108),
            'valor_catastral'=> trim($traslado->vcas_108),
            'latitud' => trim($traslado->lati_108),
            'longitud' => trim($traslado->long_108),
            'tramtie_año' => trim($traslado->atra_108),
            'tramtie_folio' => trim($traslado->foli_108),
            'tramtie_usuario' => trim($traslado->usua_108),
            'avaluo_año' => trim($traslado->ania_108),
            'avaluo_folio' => trim($traslado->cona_108),
            'avaluo_usuario' => trim($traslado->cvev_108),
            'nombre_notario' => trim($traslado->notn_108),
            'certificado_año' => trim($traslado->acer_108),
            'certificado_folio' => trim($traslado->ncer_108),
        ]);

        $progressbar->advance();

    }

    $progressbar->finish();

    $this->info('Finaliza: ' . now());

});

Artisan::command('migrar-tramites', function(){

    Schema::disableForeignKeyConstraints();
    DB::table('tramites')->truncate();

    $tramites = DB::connection('sqlsrv')->table('ctatr013')
                    ->join('ctrec024', function($q){
                        $q->on('ctatr013.atra_013', 'ctrec024.atra_024')
                            ->on('ctatr013.foli_013', 'ctrec024.foli_024')
                            ->on('ctatr013.usua_013', 'ctrec024.usu_024');
                    })
                    ->where('atra_013', 2026)
                    ->where('ofna_013', 101)
                    ->get();

    $this->info('Incia migración de trámites el: ' . now());

    $progressbar = $this->output->createProgressBar(count($tramites));

    $progressbar->start();

    foreach ($tramites as $tramite) {

        $predios_300 = DB::connection('sqlsrv')->table('ctcta300')
                                                ->where('atra_300', $tramite->atra_013)
                                                ->where('foli_300', $tramite->foli_013)
                                                ->where('usua_300', $tramite->usua_013)
                                                ->get();

        if($predios_300->count()){

            $array_predios_id = [];

            foreach ($predios_300 as $predio) {

                $predio_prod = Predio::where('localidad', (int)$predio->locl_300)
                                        ->where('oficina', (int)$predio->ofna_300)
                                        ->where('tipo_predio', (int)$predio->tpre_300)
                                        ->where('numero_registro', (int)$predio->nreg_300)
                                        ->first();

                if($predio_prod){

                    array_push($array_predios_id, $predio_prod->id);

                }

            }

        }else{

            $predio_prod = Predio::where('localidad', (int)$tramite->locl_013)
                                ->where('oficina', (int)$tramite->ofna_013)
                                ->where('tipo_predio', (int)$tramite->tpre_013)
                                ->where('numero_registro', (int)$tramite->nreg_013)
                                ->first();

            if($predio_prod){

                array_push($array_predios_id, $predio_prod->id);

            }

        }

        $servicios_server = [
            '34-5-1' => 3,      //'CERTIFICADO DE REGISTRO ordinario'
            '34-5-2' => 293,    //'CERTIFICADO DE REGISTRO urgente',
            '34-5-3' => 293,    //'CERTIFICADO DE REGISTRO urgente',
            '34-2-1' => 5,      //'CERTIFICADO negativo',
            '34-4-1' => 297,    //'CERTIFICADO ordinario colindancias',
            '34-4-2' => 296,    //'CERTIFICADO ordinario colindancias',
            '34-3-1' => 7,      //'Historia anticipo',
            '34-3-2' => 8,      //'Historia 5 movimientos',
            '34-3-3' => 9,      //'Historia 6 a 10 movimientos',
            '34-3-4' => 10,     //'Historia 11 a 15 modvimientos',
            '34-3-5' => 11,     //'Historia > 15 movimientos',
            '40-1-0' => 66,     //'Revision aviso rustico',
            '40-2-0' => 67,     //'Revision aviso urbano',
            '40-4-0' => 298,    //'Revision aviso urbano sentencia',
            '40-3-0' => 299,    //'Revision aviso rustico sentencia',
            '41-1-0' => 68,     //'Aviso aclaratorio rustico',
            '41-2-0' => 295,    //'Aviso aclaratorio urbano',
            '39-1-0' => 64,     //'Cedula rustico',
            '39-2-0' => 65,     //'Cedula urbano',
            '39-3-0' => 65,     //'Cedula ran, insus coret',
            '31-1-2' => 44,     //'Desglose otro tipo',
            '31-1-3' => 44,     //'Desglose otro tipo',
            '31-1-1' => 43,     //'Desglose fraccionamientos',
            '26-2-3' => 36,     //'Determinación ubicación superior 50 km',
            '26-2-2' => 35,     //'Determinación ubicación 20 a 50 km',
            '26-2-1' => 34,     //'Determinación ubicación 20 km',
            '26-2-0' => 33,     //'Determinación ubicación cualquier lado',
            '26-1-0' => 33,     //'Determinación ubicación cualquier lado',
            '35-1-0' => 55,     //'Copia simple',
            '35-2-0' => 56,     //'Copia certificada',
            '35-3-0' => 57,     //'Consulta de acervo',
            '23-8-0' => 28,     //'Copias en archivo digital en formato dwf: Planos catastrales no digitalizados',
            '23-6-5' => 27,     //'Copias en archivo digital en formato dwf: De los planos de valores unitarios de terreno urbano de los demás municipios con los que se cuenta planos de valores autorizados por el Congreso.',
            '23-6-4' => 26,     //'Copias en archivo digital en formato dwf: De los planos de valores unitarios de terreno urbano por sector de los municipios de Apatzingán, La Piedad, Lázaro Cárdenas, Morelia, Uruapan y Zamora.',
            '23-6-1' => 23,     //'Copias en archivo digital en formato dwf: De los municipios de La Piedad, Morelia, Uruapan y Zamora.',
            '23-6-2' => 24,     //'Copias en archivo digital en formato dwf: De los municipios de Apatzingán, Jacona, Jiquilpan, Los Reyes, Lázaro Cárdenas, Maravatío, Pátzcuaro, Puruándiro, Sahuayo y Zitácuaro.',
            '23-6-3' => 25,     //'Copias en archivo digital en formato dwf: De los municipios de Ciudad Hidalgo, Coeneo, Cotija, Cuitzeo, Huandacareo, Paracho, Purépero, Quiroga, Salvador Escalante, Tacámbaro, Tangancícuaro, Venustiano Carranza, Yurécuaro, Zacapu y Zinapécuaro.',
            '23-5-0' => 22,     //'Copias impresas de planos catastrales digitalizados: Por fotografía aérea escaneada en archivo digital en formato dwf.',
            '23-4-0' => 21,     //'Copias impresas de planos catastrales digitalizados: De sector, en formato dwf, por cada manzana existente en el mismo.',
            '23-3-0' => 20,     //'Copias impresas de planos catastrales digitalizados: Manzanero, en formato dwf.',
            '23-2-4' => 19,     //'Copias impresas de planos catastrales digitalizados: Con curvas de nivel. De los Municipios de Coeneo, Cotija, Cuitzeo, Huandacareo, Jiquilpan, Maravatío, Paracho, Purépero, Quiroga, Salvador Escalante, Tangancícuaro, Tarímbaro, Venustiano Carranza, Yurécuaro, Zacapu y Zinapécuaro, escala 1:7,500.',
            '23-2-3' => 18,     //'Copias impresas de planos catastrales digitalizados: Con curvas de nivel. De los Municipios de Apatzingán, Cd. Hidalgo, Jacona, La Piedad, Lázaro Cárdenas, Los Reyes, Pátzcuaro, Puruándiro, Tacámbaro, Sahuayo y Zitácuaro, escala 1:7,500.',
            '23-2-2' => 17,     //'Copias impresas de planos catastrales digitalizados: Con curvas de nivel. De los Municipios de Morelia, Uruapan y Zamora, escala 1:10,000',
            '23-2-1' => 16,     //'Copias impresas de planos catastrales digitalizados: Manzaneros. Concurvas de nivel',
            '23-1-4' => 15,     //'Copias impresas de planos catastrales digitalizados: De los Municipios de Coeneo, Cotija, Cuitzeo, Huandacareo, Jiquilpan, Maravatío, Paracho, Purépero, Quiroga, Salvador Escalante, Tangancícuaro, Tarímbaro, Venustiano Carranza, Yurécuaro, Zacapu y Zinapécuaro, escala 1:7,500.',
            '23-1-3' => 14,     //'Copias impresas de planos catastrales digitalizados: De los Municipios de Apatzingán, Cd. Hidalgo, Jacona, La Piedad, Lázaro Cárdenas, Los Reyes, Pátzcuaro, Puruándiro, Tacámbaro, Sahuayo y Zitácuaro, escala 1:7,500.',
            '23-1-2' => 13,     //'Copias impresas de planos catastrales digitalizados: De los Municipios de Morelia, Uruapan y Zamora, escala 1:10,000.',
            '23-1-1' => 12,     //'Copias impresas de planos catastrales digitalizados: Manzaneros',
            '46-0-0' => 107,    //'Georreferenciación de croquis administrativos del catastro',
            '37-0-0' => 52,     //'Por información respecto de los nombres de colindantes, a propietarios o poseedores de predios registrados.',
            '42-1-0' => 69,     //'Por resolución administrativa emitida por el Registro Agrario Nacional o Instituto Nacional del Suelo Sustentable.',
            '42-2-0' => 69,     //'Por resolución administrativa emitida por el Registro Agrario Nacional o Instituto Nacional del Suelo Sustentable.',
            '42-3-0' => 300,    //'Por resolución judicial  cuando la regulación provenga de prescripción positiva',
            '29-4-0' => 40,     //'Sobre predios ubicados fuera de la localidad donde se encuentre la oficina recaudadora dentro de un radio superior a 50 kilómetros.',
            '29-3-0' => 39,     //'Sobre predios ubicados fuera de la localidad donde se encuentre la oficina recaudadora dentro de un radio hasta de 50 kilómetros.',
            '29-2-0' => 38,     //'Sobre predios ubicados fuera de la localidad donde se encuentre la oficina recaudadora dentro de un radio hasta de 20 kilómetros.',
            '29-1-0' => 37,     //'Sobre predios ubicados dentro del área de la población donde se encuentra la oficina recaudadora.',
            '24' => 29,         //'Levantamientos topograficos',
            '38-0-0' => 63,     //'Modificación de datos administrativos catastrales',
            '38-1-0' => 63,     //'Modificación de datos administrativos catastrales',
            '32-2-0' => 292,    //'Inscripción o registro de predios ignorados',
            '32-2-1' => 292,    //'Inscripción o registro de predios ignorados',
            '32-2-2' => 292,    //'Inscripción o registro de predios ignorados',
            '32-2-3' => 292,    //'Inscripción o registro de predios ignorados',
            '32-5-0' => 47,     //'Solicitud de Predio Ignorado',
            '30-2-0' => 42,     //'Otras cuentas catastrales analizadas y reestructuradas distintas de fraccionamientos y condominios.',
            '30-1-0' => 41,     //'Por cuenta catastral analizada y reestructurada, tratándose de fraccionamientos y condominios.',
            '72-3-0' => 46,     //'Variación Catastral Otro tipo de inmueble',
            '72-4-0' => 45,     //'Variación Catastral Vivienda',
            '44-0-0' => 105,    //'Ubicación cartográfica para la asignación correcta de clave catastral',
            '45-0-0' => 106,    //'Ubicación cartográfica por cambio de localidad',
            '27-2-0' => 54,     //'Si se requieren investigaciones adicionales a la información proporcionada por los interesados.',
            '27-1-0' => 53,     //'Si la información que proporcionen los interesados es suficiente.',
            '33-4-0' => 53,     //'Por revisión de examen que solicite el sustentante',
            '33-3-0' => 53,     //'Derecho a examen de conocimientos que al efecto practique el Instituto a través de la Dirección de Catastro',
            '33-2-0' => 53,     //'Por refrendo anual de la autorización de perito valuador.',
            '33-1-0' => 53,     //'Por autorización e inscripción de peritos valuadores de bienes inmuebles..',
        ];

        $key = trim($tramite->conc_013) . '-' . trim($tramite->clas_013) . '-' . trim($tramite->subc_013);

        if(trim($tramite->conc_013) == '24'){

            $servicio_id = $servicios_server['24'];

        }else{

            if(isset($servicios_server[$key])){

                $servicio_id = $servicios_server[$key];

            }else{

                $this->info('No se encontro: ' . $key);

                continue;

            }

        }

        $tramite = Tramite::create([
            'estado' => 'pagado',
            'tipo_tramite' => trim($tramite->iden_013) == 'E' ? 'exento' : 'normal',
            'tipo_servicio' => 'ordinario',
            'año' => trim($tramite->atra_013),
            'folio' => trim($tramite->foli_013),
            'usuario' => trim($tramite->usua_013),
            'solicitante' => 'usuario',
            'nombre_solicitante' => trim($tramite->nomb_013),
            'fecha_pago' => trim($tramite->fech_024),
            'folio_pago' => trim($tramite->frec_024),
            'orden_de_pago' => trim($tramite->orde_013),
            'linea_de_captura' => trim($tramite->line_013),
            'monto' => trim($tramite->tot1_013),
            'cantidad' => trim($tramite->can2_013),
            'observaciones' => trim($tramite->obse_013) . ' Creado mediante migración de base de datos 2026.',
            'oficina_id' => 53,
            'servicio_id' => $servicio_id
        ]);

        $tramite->predios()->sync($array_predios_id);

        $progressbar->advance();

    }

    $progressbar->finish();

    $this->info('Finaliza: ' . now());

});

Artisan::command('generar-certificados', function(){

    Schema::disableForeignKeyConstraints();
    DB::table('certificacions')->truncate();

    $tramites = Tramite::whereIn('servicio_id', [3, 293, 297, 296, 64, 65])->get();

    $this->info('Incia migración de trámites el: ' . now());

    $progressbar = $this->output->createProgressBar(count($tramites));

    $progressbar->start();

    foreach ($tramites as $tramite) {

        GenerarCertificacionMigracionJob::dispatch($tramite);

        $progressbar->advance();

    }

    $progressbar->finish();

    $this->info('Finaliza: ' . now());

});

Artisan::command('migrar-historico', function(){

    Schema::disableForeignKeyConstraints();
    DB::table('historicos')->truncate();

    $this->info('Incia migración del historico el: ' . now());

    $now = now()->format('Y-m-d H:i:s');

    $handle = fopen(storage_path('app/public/historico.csv'), 'r');

    $chunkSize = 500;

    $chunks = [];

    try {

        $rowPlaceholders = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?, ?, ?, ? , ?, ? , ?, ? , ?)';

        $placeholders = implode(',', array_fill(0, $chunkSize, $rowPlaceholders));

        $stmt =  DB::connection()->getPdo()->prepare("
                                                        INSERT INTO historicos (
                                                            localidad,
                                                            oficina,
                                                            tipo_predio,
                                                            numero_registro,
                                                            fecha_actualizacion,
                                                            fecha_escritura,
                                                            fecha_movimiento,
                                                            empleado,
                                                            movimiento,
                                                            adquiriente,
                                                            transmitente,
                                                            numero_registro_inicial,
                                                            numero_registro_final,
                                                            valor_catastral,
                                                            numero_documento,
                                                            numero_fojas,
                                                            numero_tomo,
                                                            capital_mayor_fojas,
                                                            capital_mayor_tomo,
                                                            numero_comprobante,
                                                            superficie_notaria,
                                                            superficie_terreno,
                                                            superficie_construccion,
                                                            ubicacion,
                                                            observaciones,
                                                            created_at,
                                                            updated_at
                                                        )
                                                        VALUES {$placeholders}
                                                    ");

        while(($line = fgetcsv($handle, null, '|')) !== false){

            dd($line);

            $chunks = array_merge($chunks, [
                $line[0], //localidad
                $line[1], //oficina
                $line[2], //tipo_predio
                $line[3], //numero_registro
                $line[4], //fecha_actualizacion
                $line[13], //fecha_escritura
                $line[24], //fecha_movimiento
                trim($line[27]), //empleado
                trim($line[28]), //movimiento
                trim($line[6]), //adquiriente
                trim($line[7]), //transmitente
                trim($line[8]), //numero_registro_inicial
                trim($line[9]), //numero_registro_final
                trim($line[10]), //valor_catastral
                $line[12], // numero_documento
                $line[14], // numero_fojas
                $line[15], // numero_tomo
                $line[16], // capital_mayor_fojas
                $line[17], // capital_mayor_tomo
                $line[19], // numero_comprobante
                $line[20], // superficie_notaria
                $line[21], // superficie_terreno
                $line[22], // superficie_construccion
                trim($line[23]), // ubicacion
                trim($line[27]), // observaciones
                $now,
                $now
            ]);

            if(count($chunks) === $chunkSize * 23){

                $stmt->execute($chunks);

                $chunks = [];

            }

        }

        if(!empty($chunks)){


            $remainingRows = count($chunks) / 23;

            $rowPlaceholders = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?, ?, ?, ? , ?, ? , ?, ? , ?)';

            $placeholders = implode(',', array_fill(0, $remainingRows, $rowPlaceholders));

            $stmt = DB::connection()->getPdo()->prepare("
                                                        INSERT INTO old_certificados (
                                                                localidad,
                                                                oficina,
                                                                tipo_predio,
                                                                numero_registro,
                                                                fecha_actualizacion,
                                                                fecha_escritura,
                                                                fecha_movimiento,
                                                                empleado,
                                                                movimiento,
                                                                adquiriente,
                                                                transmitente,
                                                                numero_registro_inicial,
                                                                numero_registro_final,
                                                                valor_catastral,
                                                                numero_documento,
                                                                numero_fojas,
                                                                numero_tomo,
                                                                capital_mayor_fojas,
                                                                capital_mayor_tomo,
                                                                numero_comprobante,
                                                                superficie_notaria,
                                                                superficie_terreno,
                                                                superficie_construccion,
                                                                ubicacion,
                                                                observaciones,
                                                                created_at,
                                                                updated_at
                                                            )
                                                        VALUES {$placeholders}
                                                    ");

            $stmt->execute($chunks);

        }

        $this->info('Finaliza migración de certificados el: ' . now());

    }  finally {

        fclose($handle);

    }

    $progressbar->finish();

    $this->info('Finaliza: ' . now());

});

Artisan::command('concluir-tramites', function(){

    $certifados_old = OldCertificado::whereIn('atra', [2025, 2026])->get();

    foreach($certifados_old as $certificado){

        $tramite = Tramite::where('año', $certificado->atra)->where('folio', $certificado->foli)->where('usuario', $certificado->usua)->first();

        $tramite?->update(['estado' => 'concluido']);

    }

});


