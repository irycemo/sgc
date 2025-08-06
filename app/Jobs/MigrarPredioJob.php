<?php

namespace App\Jobs;

use Throwable;
use App\Models\Predio;
use App\Models\Persona;
use App\Models\Terreno;
use App\Models\Movimiento;
use App\Models\Colindancia;
use App\Models\Propietario;
use App\Models\Construccion;
use App\Models\TerrenosComun;
use App\Models\PredioRepetido;
use App\Models\SQLSVR\ctcdm004;
use App\Models\SQLSVR\ctcop005;
use App\Models\SQLSVR\ctpro003;
use App\Models\SQLSVR\ctref007;
use App\Models\SQLSVR\tcpro008;
use Illuminate\Support\Facades\DB;
use App\Models\ConstruccionesComun;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class MigrarPredioJob implements ShouldQueue
{
    use Queueable;

    public $referencias;

    public function __construct(public $predios){

        $this->referencias = collect(ctref007::whereIn('tipo_007', ["TV", "AH", "UP", "UB", "TE", "ED", "TP", "OM"])->get()->toArray());
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        foreach($this->predios as $predio){

            try {

                DB::transaction(function () use($predio){

                    $p = Predio::create([
                        'estado' => $predio->esta_008,
                        'region_catastral' => $predio->rcat_008,
                        'municipio' => $predio->mpio_008,
                        'zona_catastral' => $predio->zcat_008,
                        'localidad' => $predio->locl_008,
                        'sector' => $predio->sect_008,
                        'manzana' => $predio->mzna_008,
                        'predio' => $predio->pred_008,
                        'edificio' => $predio->edif_008,
                        'departamento' => $predio->dpto_008,
                        'oficina' => $predio->ofna_008,
                        'tipo_predio' => $predio->tpre_008,
                        'numero_registro' => $predio->nreg_008,
                        'tipo_vialidad' => $this->referencias->where('tipo_007', "TV")->where('cven_007', $predio->tvia_008)->first()['desc_007'],
                        'tipo_asentamiento' => $this->referencias->where('tipo_007', "AH")->where('cven_007', $predio->tase_008)->first()['desc_007'],
                        'nombre_vialidad' => $predio->call_008,
                        'numero_exterior' => $predio->next_008,
                        'numero_exterior_2' => $predio->nex2_008,
                        'numero_adicional' => $predio->nadi_008,
                        'numero_adicional_2' => $predio->nad2_008,
                        'numero_interior' => $predio->nint_008,
                        'nombre_asentamiento' => $predio->colo_008,
                        'codigo_postal' => $predio->codp_008,
                        'lote_fraccionador' => $predio->lote_008,
                        'manzana_fraccionador' => $predio->manz_008,
                        'etapa_fraccionador' => $predio->zona_008,
                        'nombre_predio' => NULL,
                        'nombre_edificio' => $predio->nedi_008,
                        'clave_edificio' => NULL,
                        'departamento_edificio' => $predio->ndpt_008,
                        'uso_1' => $this->referencias->where('tipo_007', "UP")->where('cvea_007', $predio->usop_003)->first() ? $this->referencias->where('tipo_007', "UP")->where('cvea_007', $predio->usop_003)->first()['desc_007'] : null,
                        'uso_2' => $this->referencias->where('tipo_007', "UP")->where('cvea_007', $predio->usp2_003)->first() ? $this->referencias->where('tipo_007', "UP")->where('cvea_007', $predio->usp2_003)->first()['desc_007'] : null,
                        'uso_3' => $this->referencias->where('tipo_007', "UP")->where('cvea_007', $predio->usp3_003)->first() ? $this->referencias->where('tipo_007', "UP")->where('cvea_007', $predio->usp3_003)->first()['desc_007'] : null,
                        'ubicacion_en_manzana' => $this->referencias->where('tipo_007', "UB")->where('cven_007', $predio->ubic_003)->first() ? $this->referencias->where('tipo_007', "UB")->where('cven_007', $predio->ubic_003)->first()['desc_007'] : null,
                        'superficie_terreno' => $predio->stot_008,
                        'superficie_construccion' => $predio->scon_008,
                        'superficie_judicial' => $predio->sjur_008,
                        'superficie_notarial' => $predio->snot_008,
                        'area_comun_terreno' => 0,
                        'area_comun_construccion' => 0,
                        'valor_terreno_comun' => 0,
                        'valor_construccion_comun' => 0,
                        'valor_total_terreno' => $predio->vter_003,
                        'valor_total_construccion' => $predio->vcon_003,
                        'valor_catastral' => $predio->vcas_008,
                        'curt' => NULL,
                        'folio_real' => NULL,
                        'xutm' => ($predio->xutm_003 == NULL) ? 0 : $predio->xutm_003,
                        'yutm' => ($predio->yutm_003 == NULL) ? 0 : $predio->yutm_003,
                        'zutm' => ($predio->zutm_003 == NULL) ? 0 : $predio->zutm_003,
                        'lon' => ($predio->long_003 == NULL) ? 0 : ($predio->long_003 > -103.7 && $predio->long_003 <= -100.06  ? $predio->long_003 : 0),
                        'lat' => ($predio->lati_003 == NULL) ? 0 : ($predio->lati_003 > 17.9 && $predio->lati_003 <= 20.5  ? $predio->lati_003 : 0),
                        'fecha_efectos' => $predio->fecn_008,
                        'documento_entrada' => $this->referencias->where('tipo_007', "TE")->where('cven_007', $predio->tesc_008)->first() ? $this->referencias->where('tipo_007', "TE")->where('cven_007', $predio->tesc_008)->first()['desc_007'] : null,
                        'documento_numero' => $predio->titp_008,
                        'declarante' => 'Notaria ' . $predio->cnot_003,
                        'observaciones' => $predio->obse_008,
                        'origen' => 0,
                        'actualizado_nombre' => trim($predio->nome_008)
                    ]);

                    $this->colindacnias($p->id, $predio->col1_003, $predio->col2_003, $predio->col3_003, $predio->col4_003);

                    $this->terrenos($p->id, $predio->stot_008, $predio->valt_003, $predio->vter_003);

                    $this->construcciones($p->id, $predio->mpio_008, $predio->zcat_008, $predio->locl_008, $predio->sect_008, $predio->mzna_008, $predio->pred_008, $predio->edif_008, $predio->dpto_008);

                    $this->personas($predio, $p->id);

                    $this->movimientos($predio, $p->id);

                    if ($predio->edif_008 > 0 && $predio->dpto_008 > 0){

                        $this->condominio($predio,$p->id);

                    }

                });

            }catch (QueryException $e){

                info($e);

                $errorCode = $e->errorInfo[1];

                if($errorCode == 1062){

                    $predioRepetido = PredioRepetido::where('estado', $predio->esta_008)
                                    ->where('region_catastral', $predio->rcat_008)
                                    ->where('municipio', $predio->mpio_008)
                                    ->where('zona_catastral', $predio->zcat_008)
                                    ->where('localidad', $predio->locl_008)
                                    ->where('sector', $predio->sect_008)
                                    ->where('manzana', $predio->mzna_008)
                                    ->where('predio', $predio->pred_008)
                                    ->where('edificio', $predio->edif_008)
                                    ->where('departamento', $predio->dpto_008)
                                    ->where('oficina', $predio->ofna_008)
                                    ->where('tipo_predio', $predio->tpre_008)
                                    ->where('numero_registro', $predio->nreg_008)
                                    ->first();

                    PredioRepetido::create([
                        'estado' => $predio->esta_008,
                        'region_catastral' => $predio->rcat_008,
                        'municipio' => $predio->mpio_008,
                        'zona_catastral' => $predio->zcat_008,
                        'localidad' => $predio->locl_008,
                        'sector' => $predio->sect_008,
                        'manzana' => $predio->mzna_008,
                        'predio' => $predio->pred_008,
                        'edificio' => $predio->edif_008,
                        'departamento' => $predio->dpto_008,
                        'oficina' => $predio->ofna_008,
                        'tipo_predio' => $predio->tpre_008,
                        'numero_registro' => $predio->nreg_008,
                        'error' => $e,
                        'count' => $predioRepetido ? $predioRepetido->count + 1 : 1
                    ]);

                }

                $predioRepetido = null;
                $errorCode = null;

            } catch (\Throwable $th) {

                Log::error("El predio: " . $predio->locl_008 . "-" . $predio->ofna_008 . "-" . $predio->tpre_008 . "-" . $predio->nreg_008 . ". " . $th);

            }

        }

        app('queue.worker')->shouldQuit = 1;

        $this->predios = null;
        $predio = null;
        $this->referencias = null;

    }

    public function failed(?Throwable $exception): void
    {
        Log::error($exception);
    }

    public function condominio($predioss,$idnvo)
    {

        $predio_padre = tcpro008::where('mpio_008', $predioss->mpio_008)
                                ->where('zcat_008', $predioss->zcat_008)
                                ->where('locl_008', $predioss->locl_008)
                                ->where('sect_008', $predioss->sect_008)
                                ->where('mzna_008', $predioss->mzna_008)
                                ->where('pred_008', $predioss->pred_008)
                                ->where('edif_008', 0)
                                ->where('dpto_008', 0)
                                ->where('nreg_008', 0)
                                ->first();

        if(!$predio_padre){

            $predio_padre = ctpro003::where('mpio_003', $predioss->mpio_008)
                                        ->where('zcat_003', $predioss->zcat_008)
                                        ->where('locl_003', $predioss->locl_008)
                                        ->where('sect_003', $predioss->sect_008)
                                        ->where('mzna_003', $predioss->mzna_008)
                                        ->where('pred_003', $predioss->pred_008)
                                        ->where('edif_003', 0)
                                        ->where('dpto_003', 0)
                                        ->where('nreg_003', 0)
                                        ->first();
        }

        $ctcdm004 = ctcdm004::where('mpio_004', $predioss->mpio_008)
                                ->where('zcat_004', $predioss->zcat_008)
                                ->where('locl_004', $predioss->locl_008)
                                ->where('sect_004', $predioss->sect_008)
                                ->where('mzna_004', $predioss->mzna_008)
                                ->where('pred_004', $predioss->pred_008)
                                ->where('edif_004', $predioss->edif_008)
                                ->where('dpto_004', $predioss->dpto_008)
                                ->first();

        if($predio_padre){


            if(!isset($predio_padre->stot_008)){

                $superficie_total = $predio_padre->ster_003 ?? 0;

            }else{

                $superficie_total = $predio_padre->stot_008 ?? 0;
            }

            if(!isset($predio_padre->scon_008)){

                $area_comun_construccion = $predio_padre->scon_003 ?? 0;

            }else{

                $area_comun_construccion = $predio_padre->scon_008 ?? 0;
            }

        }

        if ($ctcdm004) {

            TerrenosComun::create([
                'terrenos_comunsable_id' => $idnvo,
                'terrenos_comunsable_type' => 'App\Models\Predio',
                'area_terreno_comun' => ($predio_padre) ? $superficie_total : 0,
                'indiviso_terreno' => $ctcdm004->ipre_004 ?? 0,
                'superficie_proporcional' => $ctcdm004->prot_004 ?? 0,
                'valor_unitario' => 0,
                'valor_terreno_comun' => $ctcdm004->vter_004 ?? 0,
            ]);

            ConstruccionesComun::create([
                'construcciones_comunsable_id' => $idnvo,
                'construcciones_comunsable_type' => 'App\Models\Predio',
                'superficie_proporcional' => $ctcdm004->proc_004 ?? 0,
                'area_comun_construccion' => ($predio_padre) ? $area_comun_construccion : 0,
                'indiviso_construccion' => $ctcdm004->icon_004 ?? 0,
                'valor_clasificacion_construccion' => 0,
                'valor_construccion_comun' => $ctcdm004->vcon_004 ?? 0
            ]);

        }

        $predio_padre = null;
        $ctcdm004 = null;

    }

    public function personas($predioss,$idnvo)
    {

        $nombre = str_replace(['Y SOC', 'Y SOCIOS', 'Y SOC.'. 'Y SOCS.', 'Y SOCS', 'Y SOCIOS.', 'SOC', 'SOC.'], '', $predioss->nomb_008);

        $persona = Persona::firstOrCreate(
            [
                'nombre' => trim($predioss->nomb_008),
                'ap_paterno' => trim($predioss->apat_008),
                'ap_materno' => trim($predioss->amat_008)
            ],
            [
                'tipo' => ($predioss->tper_008 == 1) ? 'FÍSICA' : ($predioss->tper_008 == 2 ? 'MORAL' : '0'),
                'nombre' => ($predioss->tper_008 == 2) ? null : trim($nombre),
                'ap_paterno' => ($predioss->tper_008 == 2) ? null : trim($predioss->apat_008),
                'ap_materno' => ($predioss->tper_008 == 2) ? null : trim($predioss->amat_008),
                'curp' => NULL,
                'rfc' => NULL,
                'razon_social' => ($predioss->tper_008 == 2) ? trim($predioss->nomb_008) . " " . trim($predioss->apat_008) . " " . trim($predioss->amat_008) : null,
                'fecha_nacimiento' => NULL,
                'nacionalidad' => NULL,
                'estado_civil' => NULL,
                'calle' => trim($predioss->noca_008),
                'numero_exterior' => trim($predioss->exte_008),
                'numero_interior' => trim($predioss->inte_008),
                'colonia' => trim($predioss->noco_008),
                'cp' => $predioss->copd_008,
                'entidad' => $this->referencias->where('tipo_007', "ED")->where('cven_007', $predioss->cest_008)->first() ? $this->referencias->where('tipo_007', "ED")->where('cven_007', $predioss->cest_008)->first()['desc_007'] : null,
                'municipio' => trim($predioss->nomu_008),
                'ciudad' => trim($predioss->nopo_008)
            ]
        );

        $tipo = $this->referencias->where('tipo_007', "TP")->where('cven_007', $predioss->tper_008)->first();

        Propietario::create([
            'propietarioable_id' => $idnvo,
            'propietarioable_type' => 'App\Models\Predio',
            'persona_id' => $persona->id,
            'tipo' => isset($tipo) ? $tipo['desc_007'] : '0',
            'porcentaje_propiedad' => ($predioss->tper_008 == 1 || $predioss->tper_008 == 2 || $predioss->tper_008 >= 5) ? $predioss->ppro_008 : 0,
            'porcentaje_nuda' => ($predioss->tper_008 == 3) ? $predioss->ppro_008 : 0,
            'porcentaje_usufructo' => ($predioss->tper_008 == 4) ? $predioss->ppro_008 : 0,
        ]);

        //Verificar si en tccop005 hay más proppietatios
        $ctcop005 = ctcop005::where('mpio_005', $predioss->mpio_008)
                                ->where('zcat_005', $predioss->zcat_008)
                                ->where('locl_005', $predioss->locl_008)
                                ->where('sect_005', $predioss->sect_008)
                                ->where('mzna_005', $predioss->mzna_008)
                                ->where('pred_005', $predioss->pred_008)
                                ->where('edif_005', $predioss->edif_008)
                                ->where('dpto_005', $predioss->dpto_008)
                                ->get();

        foreach($ctcop005 as $propietario){

            $nombre = str_replace(['Y SOC', 'Y SOCIOS', 'Y SOC.'. 'Y SOCS.', 'Y SOCS', 'Y SOCIOS.'], '', $propietario->nomb_005);

            $persona = Persona::firstOrCreate(
                [
                    'nombre' => trim($propietario->nomb_005),
                    'ap_paterno' => trim($propietario->apat_005),
                    'ap_materno' => trim($propietario->amat_005)
                ],
                [
                    'tipo' => ($propietario->tper_005 == 1) ? 'FÍSICA' : ($propietario->tper_005 == 2 ? 'MORAL' : '0'),
                    'nombre' => ($propietario->tper_005 == 2) ? null : trim($nombre),
                    'ap_paterno' => ($propietario->tper_005 == 2) ? null : trim($propietario->apat_005),
                    'ap_materno' => ($propietario->tper_005 == 2) ? null : trim($propietario->amat_005),
                    'curp' => NULL,
                    'rfc' => NULL,
                    'razon_social' => ($propietario->tper_005 == 2) ? trim($propietario->nomb_005) . " " . trim($propietario->apat_005) . " " . trim($propietario->amat_005) : null,
                    'fecha_nacimiento' => NULL,
                    'nacionalidad' => NULL,
                    'estado_civil' => NULL,
                    'calle' => trim($propietario->noca_005),
                    'numero_exterior' => trim($propietario->next_005),
                    'numero_interior' => trim($propietario->nint_005),
                    'colonia' => trim($propietario->noco_005),
                    'cp' => $propietario->codp_005,
                    'entidad' => $this->referencias->where('tipo_007', "ED")->where('cven_007', $propietario->cest_005)->first() ? $this->referencias->where('tipo_007', "ED")->where('cven_007', $propietario->cest_005)->first()['desc_007'] : null,
                    'municipio' => trim($propietario->nomu_005),
                    'ciudad' => trim($propietario->nopo_005),
                ]
            );

            $tipo = $this->referencias->where('tipo_007', "TP")->where('cven_007', $propietario->tper_005)->first();

            Propietario::create([
                'propietarioable_id' => $idnvo,
                'propietarioable_type' => 'App\Models\Predio',
                'persona_id' => $persona->id,
                'tipo' => isset($tipo) ? $tipo['desc_007'] : '0',
                'porcentaje_propiedad' => ($propietario->tper_005 == 1 || $propietario->tper_005 == 2 || $propietario->tper_005 >= 5) ? $propietario->ppro_005 : 0,
                'porcentaje_nuda' => ($propietario->tper_005 == 3) ? $propietario->ppro_005 : 0,
                'porcentaje_usufructo' => ($propietario->tper_005 == 4) ? $propietario->ppro_005 : 0,
            ]);

        }

        $nombre = null;
        $persona = null;
        $tipo = null;
        $ctcop005 = null;

    }

    public function terrenos($idnvo, $superficie, $valor_unitario, $valor_terreno)
    {
        Terreno::create([
            'terrenoable_id' => $idnvo,
            'terrenoable_type' => 'App\Models\Predio',
            'superficie' => ($superficie == NULL) ? 0 : $superficie,
            'demerito' => 0,
            'valor_demeritado' => 0,
            'valor_unitario' => ($valor_unitario == NULL) ? 0 : $valor_unitario,
            'valor_terreno' => ($valor_terreno == NULL) ? 0 : $valor_terreno,
        ]);
    }

    public function construcciones($idnvo, $mpio, $zcat, $locl, $sect, $mzna, $pred, $edif, $dpto)
    {

        $contruccionesSS = DB::connection('sqlsrv')->select("
                                                        select * from ctcnt006
                                                        where mpio_006 = ". $mpio ."
                                                        and zcat_006 = ". $zcat ."
                                                        and locl_006 = ". $locl ."
                                                        and sect_006 = ". $sect ."
                                                        and mzna_006 = ". $mzna ."
                                                        and pred_006 = ". $pred ."
                                                        and edif_006 = ". $edif ."
                                                        and dpto_006 = ". $dpto
                                                    );

        foreach($contruccionesSS as $constss){

            Construccion::create([
                'construccionable_id' => $idnvo,
                'construccionable_type' => 'App\Models\Predio',
                'referencia' => $constss->rcon_006 ?? 'N/A',
                'tipo' => $constss->tipo_006,
                'uso' => $constss->usoc_006,
                'estado' => $constss->cate_006,
                'calidad' => $constss->cali_006,
                'niveles' => $constss->nive_006,
                'superficie' => $constss->scon_006,
                'valor_unitario' => 0, //Verificar
                'valor_construccion' => $constss->valc_006,
            ]);

        }

        $contruccionesSS = null;
    }

    public function colindacnias($idnvo, $col1, $col2, $col3, $col4)
    {
        if (trim($col1) != "")
        {
            Colindancia::create([
                'colindanciaable_id' => $idnvo,
                'colindanciaable_type' => 'App\Models\Predio',
                'viento' => 0,
                'longitud' => 0,
                'descripcion' => trim($col1),
            ]);
        }

        if (trim($col2) != "")
        {
            Colindancia::create([
                'colindanciaable_id' => $idnvo,
                'colindanciaable_type' => 'App\Models\Predio',
                'viento' => 0,
                'longitud' => 0,
                'descripcion' => trim($col2),
            ]);
        }

        if (trim($col3) != "")
        {
            Colindancia::create([
                'colindanciaable_id' => $idnvo,
                'colindanciaable_type' => 'App\Models\Predio',
                'viento' => 0,
                'longitud' => 0,
                'descripcion' =>trim($col3),
            ]);
        }

        if (trim($col4) != "")
        {
            Colindancia::create([
                'colindanciaable_id' => $idnvo,
                'colindanciaable_type' => 'App\Models\Predio',
                'viento' => 0,
                'longitud' => 0,
                'descripcion' => trim($col4),
            ]);
        }
    }

    public function movimientos($predioss, $idnvo){

        $movimientos = DB::connection('sqlsrv')->select("select * from cthis021
                                                            where mpio_021 = ". $predioss->mpio_008 ."
                                                            and zcat_021 = ". $predioss->zcat_008 ."
                                                            and locl_021 = ". $predioss->locl_008 ."
                                                            and sect_021 = ". $predioss->sect_008 ."
                                                            and mzna_021 = ". $predioss->mzna_008 ."
                                                            and pred_021 = ". $predioss->pred_008 ."
                                                            and edif_021 = ". $predioss->edif_008 ."
                                                            and dpto_021 = ". $predioss->dpto_008
                                                        );

        foreach ($movimientos as $movimiento) {

            if(empty($movimiento->obse_021)) continue;

            Movimiento::create([
                'predio_id' => $idnvo,
                'nombre' => $this->referencias->where('cven_007', $movimiento->cmto_021)->where('tipo_007', 'OM')->first()['desc_007'],
                'fecha' => $movimiento->femo_021,
                'descripcion' => $movimiento->obse_021,
                'actualizado_nombre' => trim($movimiento->nome_021),
            ]);

        }

        $movimientos = null;
        $movimiento = null;

    }

}
