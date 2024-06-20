<?php

namespace App\Jobs;

use App\Models\Predio;
use App\Models\Persona;
use App\Models\Terreno;
use App\Models\Movimiento;
use App\Models\Colindancia;
use App\Models\Propietario;
use App\Models\Construccion;
use Illuminate\Bus\Queueable;
use App\Models\Condominioterreno;
use App\Models\Migracion\ctcdm004;
use App\Models\Migracion\ctcop005;
use App\Models\Migracion\ctpro003;
use App\Models\Migracion\tcpro008;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Condominioconstruccion;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MigrarPredioJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $referencias, public $predio){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {

            DB::transaction(function (){

                $p = Predio::create([
                    'estado' => $this->predio->esta_008,
                    'region_catastral' => $this->predio->rcat_008,
                    'municipio' => $this->predio->mpio_008,
                    'zona_catastral' => $this->predio->zcat_008,
                    'localidad' => $this->predio->locl_008,
                    'sector' => $this->predio->sect_008,
                    'manzana' => $this->predio->mzna_008,
                    'predio' => $this->predio->pred_008,
                    'edificio' => $this->predio->edif_008,
                    'departamento' => $this->predio->dpto_008,
                    'oficina' => $this->predio->ofna_008,
                    'tipo_predio' => $this->predio->tpre_008,
                    'numero_registro' => $this->predio->nreg_008,
                    'tipo_vialidad' => $this->referencias->where('tipo_007', "TV")->where('cven_007', $this->predio->tvia_008)->first()->desc_007,
                    'tipo_asentamiento' => $this->referencias->where('tipo_007', "AH")->where('cven_007', $this->predio->tase_008)->first()->desc_007,
                    'nombre_vialidad' => $this->predio->call_008,
                    'numero_exterior' => $this->predio->next_008,
                    'numero_exterior_2' => $this->predio->nex2_008,
                    'numero_adicional' => $this->predio->nadi_008,
                    'numero_adicional_2' => $this->predio->nad2_008,
                    'numero_interior' => $this->predio->nint_008,
                    'nombre_asentamiento' => $this->predio->colo_008,
                    'codigo_postal' => $this->predio->codp_008,
                    'lote_fraccionador' => $this->predio->lote_008,
                    'manzana_fraccionador' => $this->predio->manz_008,
                    'etapa_fraccionador' => $this->predio->zona_008,
                    'nombre_predio' => NULL,
                    'nombre_edificio' => $this->predio->nedi_008,
                    'clave_edificio' => NULL,
                    'departamento_edificio' => $this->predio->ndpt_008,
                    'uso_1' => $this->referencias->where('tipo_007', "UP")->where('cvea_007', $this->predio->usop_003)->first()?->desc_007,
                    'uso_2' => $this->referencias->where('tipo_007', "UP")->where('cvea_007', $this->predio->usp2_003)->first()?->desc_007,
                    'uso_3' => $this->referencias->where('tipo_007', "UP")->where('cvea_007', $this->predio->usp3_003)->first()?->desc_007,
                    'ubicacion_en_manzana' => $this->referencias->where('tipo_007', "UB")->where('cven_007', $this->predio->ubic_003)->first()?->desc_007,
                    'superficie_terreno' => $this->predio->stot_008,
                    'superficie_construccion' => $this->predio->scon_008,
                    'superficie_judicial' => $this->predio->sjur_008,
                    'superficie_notarial' => $this->predio->snot_008,
                    'area_comun_terreno' => 0,
                    'area_comun_construccion' => 0,
                    'valor_terreno_comun' => 0,
                    'valor_construccion_comun' => 0,
                    'valor_total_terreno' => $this->predio->vter_003,
                    'valor_total_construccion' => $this->predio->vcon_003,
                    'valor_catastral' => $this->predio->vcas_008,
                    'curt' => NULL,
                    'folio_real' => NULL,
                    'xutm' => ($this->predio->xutm_003 == NULL) ? 0 : $this->predio->xutm_003,
                    'yutm' => ($this->predio->yutm_003 == NULL) ? 0 : $this->predio->yutm_003,
                    'zutm' => ($this->predio->zutm_003 == NULL) ? 0 : $this->predio->zutm_003,
                    'lon' => ($this->predio->long_003 == NULL) ? 0 : ($this->predio->long_003 > -103.7 && $this->predio->long_003 <= -100.06  ? $this->predio->long_003 : 0),
                    'lat' => ($this->predio->lati_003 == NULL) ? 0 : ($this->predio->lati_003 > 17.9 && $this->predio->lati_003 <= 20.5  ? $this->predio->lati_003 : 0),
                    'fecha_efectos' => $this->predio->fecn_008,
                    'documento_entrada' => $this->referencias->where('tipo_007', "TE")->where('cven_007', $this->predio->tesc_008)->first()->desc_007,
                    'documento_numero' => $this->predio->titp_008,
                    'declarante' => 'Notaria ' . $this->predio->cnot_003,
                    'observaciones' => $this->predio->obse_008,
                    'origen' => 0,
                    'actualizado_nombre' => $this->predio->nome_008
                ]);

                $this->colindacnias($p->id, $this->predio->col1_003, $this->predio->col2_003, $this->predio->col3_003, $this->predio->col4_003);

                $this->terrenos($p->id, $this->predio->stot_008, $this->predio->valt_003, $this->predio->vter_003);

                $this->construcciones($p->id, $this->predio->mpio_008, $this->predio->zcat_008, $this->predio->locl_008, $this->predio->sect_008, $this->predio->mzna_008, $this->predio->pred_008, $this->predio->edif_008, $this->predio->dpto_008);

                $this->personas($this->predio, $p->id);

                $this->movimientos($this->predio, $p->id);

                if ($this->predio->edif_008 > 0 && $this->predio->dpto_008 > 0){

                    $this->condominio($this->predio,$p->id);

                }

            });

        } catch (\Throwable $th) {

            Log::error("El predio: " . $this->predio->locl_008 . "-" . $this->predio->ofna_008 . "-" . $this->predio->tpre_008 . "-" . $this->predio->nreg_008 . ". " . $th);
        }

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

            Condominioterreno::create([
                'condominioterrenoable_id' => $idnvo,
                'condominioterrenoable_type' => 'App\Models\Predio',
                'area_terreno_comun' => ($predio_padre) ? $superficie_total : 0,
                'indiviso_terreno' => $ctcdm004->ipre_004 ?? 0,
                'valor_unitario' => 0,
                'valor_terreno_comun' => $ctcdm004->vter_004 ?? 0,
            ]);

            Condominioconstruccion::create([
                'condominioconstruccionable_id' => $idnvo,
                'condominioconstruccionable_type' => 'App\Models\Predio',
                'area_comun_construccion' => ($predio_padre) ? $area_comun_construccion : 0,
                'indiviso_construccion' => $ctcdm004->icon_004 ?? 0,
                'valor_clasificacion_construccion' => 0,
                'valor_construccion_comun' => $ctcdm004->vcon_004 ?? 0
            ]);

        }

    }

    public function personas($predioss,$idnvo)
    {

        $nombre = str_replace(['Y SOC', 'Y SOCIOS', 'Y SOC.'. 'Y SOCS.', 'Y SOCS', 'Y SOCIOS.'], '', $predioss->nomb_008);

        $persona = Persona::firstOrCreate(
            [
                'nombre' => $predioss->nomb_008,
                'ap_paterno' => $predioss->apat_008,
                'ap_materno' => $predioss->amat_008
            ],
            [
                'tipo' => ($predioss->tper_008 == 1) ? 'FÍSICA' : ($predioss->tper_008 == 2 ? 'MORAL' : '0'),
                'nombre' => $nombre,
                'ap_paterno' => $predioss->apat_008,
                'ap_materno' => $predioss->amat_008,
                'curp' => NULL,
                'rfc' => NULL,
                'razon_social' => ($predioss->tper_008 == 2) ? $predioss->nomb_008." ".$predioss->apat_008." ".$predioss->amat_008 : '',
                'fecha_nacimiento' => NULL,
                'nacionalidad' => NULL,
                'estado_civil' => NULL,
                'calle' => $predioss->noca_008,
                'numero_exterior' => $predioss->exte_008,
                'numero_interior' => $predioss->inte_008,
                'colonia' => $predioss->noco_008,
                'cp' => $predioss->copd_008,
                'entidad' => $this->referencias->where('tipo_007', "ED")->where('cven_007', $predioss->cest_008)->first()?->desc_007,
                'municipio' => $predioss->nomu_008,
                'ciudad' => $predioss->nopo_008
            ]
        );

        $tipo = $this->referencias->where('tipo_007', "TP")->where('cven_007', $predioss->tper_008)->first();

        Propietario::create([
            'propietarioable_id' => $idnvo,
            'propietarioable_type' => 'App\Models\Predio',
            'persona_id' => $persona->id,
            'tipo' => $tipo ? $tipo->desc_007 : '0',
            'porcentaje' => ($predioss->tper_008 == 1 || $predioss->tper_008 == 2 || $predioss->tper_008 >= 5) ? $predioss->ppro_008 : 0,
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
                    'nombre' => $propietario->nomb_005,
                    'ap_paterno' => $propietario->apat_005,
                    'ap_materno' => $propietario->amat_005
                ],
                [
                    'tipo' => ($propietario->tper_005 == 1) ? 'FÍSICA' : ($propietario->tper_005 == 2 ? 'MORAL' : '0'),
                    'nombre' => $nombre,
                    'ap_paterno' => $propietario->apat_005,
                    'ap_materno' => $propietario->amat_005,
                    'curp' => NULL,
                    'rfc' => NULL,
                    'razon_social' => ($propietario->tper_005 == 2) ? $propietario->nomb_005." ".$propietario->apat_005." ".$propietario->amat_005 : '',
                    'fecha_nacimiento' => NULL,
                    'nacionalidad' => NULL,
                    'estado_civil' => NULL,
                    'calle' => $propietario->noca_005,
                    'numero_exterior' => $propietario->next_005,
                    'numero_interior' => $propietario->nint_005,
                    'colonia' => $propietario->noco_005,
                    'cp' => $propietario->codp_005,
                    'entidad' => $this->referencias->where('tipo_007', "ED")->where('cven_007', $propietario->cest_005)->first()?->desc_007,
                    'municipio' => $propietario->nomu_005,
                    'ciudad' => $propietario->nopo_005,
                ]
            );

            $tipo = $this->referencias->where('tipo_007', "TP")->where('cven_007', $propietario->tper_005)->first();

            Propietario::create([
                'propietarioable_id' => $idnvo,
                'propietarioable_type' => 'App\Models\Predio',
                'persona_id' => $persona->id,
                'tipo' => $tipo ? $tipo->desc_007 : '0',
                'porcentaje' => ($propietario->tper_005 == 1 || $propietario->tper_005 == 2 || $propietario->tper_005 >= 5) ? $propietario->ppro_005 : 0,
                'porcentaje_nuda' => ($propietario->tper_005 == 3) ? $propietario->ppro_005 : 0,
                'porcentaje_usufructo' => ($propietario->tper_005 == 4) ? $propietario->ppro_005 : 0,
            ]);

        }

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
                'nombre' => $this->referencias->where('cven_007', $movimiento->cmto_021)->where('tipo_007', 'OM')->first()->desc_007,
                'fecha' => $movimiento->femo_021,
                'descripcion' => $movimiento->obse_021,
                'actualizado_nombre' => $movimiento->nome_021,
            ]);

        }
    }
}
