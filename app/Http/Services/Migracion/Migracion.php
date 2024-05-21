<?php

namespace App\Http\Services\Migracion;
use App\Models\Predio;
use App\Models\Persona;
use App\Models\Terreno;
use App\Models\Movimiento;
use App\Models\Colindancia;
use App\Models\Propietario;
use App\Models\Construccion;
use App\Models\Condominioterreno;
use App\Models\Migracion\ctcdm004;
use App\Models\Migracion\ctpro003;
use App\Models\Migracion\tcpro008;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Condominioconstruccion;

class Migracion
{

    public $referencias;

    public function __construct($referencias)
    {
        $this->referencias = $referencias;
    }


    public function run($predioss)
    {

        try {

            DB::transaction(function () use($predioss){

                $p = Predio::create([
                    'estado' => $predioss->esta_008,
                    'region_catastral' => $predioss->rcat_008,
                    'municipio' => $predioss->mpio_008,
                    'zona_catastral' => $predioss->zcat_008,
                    'localidad' => $predioss->locl_008,
                    'sector' => $predioss->sect_008,
                    'manzana' => $predioss->mzna_008,
                    'predio' => $predioss->pred_008,
                    'edificio' => $predioss->edif_008,
                    'departamento' => $predioss->dpto_008,
                    'oficina' => $predioss->ofna_008,
                    'tipo_predio' => $predioss->tpre_008,
                    'numero_registro' => $predioss->nreg_008,
                    'tipo_vialidad' => $this->referencias->where('tipo_007', "TV")->where('cven_007', $predioss->tvia_008)->first()->desc_007,
                    'tipo_asentamiento' => $this->referencias->where('tipo_007', "AH")->where('cven_007', $predioss->tase_008)->first()->desc_007,
                    'nombre_vialidad' => $predioss->call_008,
                    'numero_exterior' => $predioss->next_008,
                    'numero_exterior_2' => $predioss->nex2_008,
                    'numero_adicional' => $predioss->nadi_008,
                    'numero_adicional_2' => $predioss->nad2_008,
                    'numero_interior' => $predioss->nint_008,
                    'nombre_asentamiento' => $predioss->colo_008,
                    'codigo_postal' => $predioss->codp_008,
                    'lote_fraccionador' => $predioss->lote_008,
                    'manzana_fraccionador' => $predioss->manz_008,
                    'etapa_fraccionador' => $predioss->zona_008,
                    'nombre_predio' => NULL,
                    'nombre_edificio' => $predioss->nedi_008,
                    'clave_edificio' => NULL,
                    'departamento_edificio' => $predioss->ndpt_008,
                    'uso_1' => $this->referencias->where('tipo_007', "UP")->where('cvea_007', $predioss->usop_003)->first()?->desc_007,
                    'uso_2' => $this->referencias->where('tipo_007', "UP")->where('cvea_007', $predioss->usp2_003)->first()?->desc_007,
                    'uso_3' => $this->referencias->where('tipo_007', "UP")->where('cvea_007', $predioss->usp3_003)->first()?->desc_007,
                    'ubicacion_en_manzana' => $this->referencias->where('tipo_007', "UB")->where('cven_007', $predioss->ubic_003)->first()?->desc_007,
                    'superficie_terreno' => $predioss->stot_008,
                    'superficie_construccion' => $predioss->scon_008,
                    'superficie_judicial' => $predioss->sjur_008,
                    'superficie_notarial' => $predioss->snot_008,
                    'area_comun_terreno' => 0,
                    'area_comun_construccion' => 0,
                    'valor_terreno_comun' => 0,
                    'valor_construccion_comun' => 0,
                    'valor_total_terreno' => $predioss->vter_003,
                    'valor_total_construccion' => $predioss->vcon_003,
                    'valor_catastral' => $predioss->vcas_008,
                    'curt' => NULL,
                    'folio_real' => NULL,
                    'xutm' => ($predioss->xutm_003 == NULL) ? 0 : $predioss->xutm_003,
                    'yutm' => ($predioss->yutm_003 == NULL) ? 0 : $predioss->yutm_003,
                    'zutm' => ($predioss->zutm_003 == NULL) ? 0 : $predioss->zutm_003,
                    'lon' => ($predioss->long_003 == NULL) ? 0 : ($predioss->long_003 > -103.7 && $predioss->long_003 <= -100.06  ? $predioss->long_003 : 0),
                    'lat' => ($predioss->lati_003 == NULL) ? 0 : ($predioss->lati_003 > 17.9 && $predioss->lati_003 <= 20.5  ? $predioss->lati_003 : 0),
                    'fecha_efectos' => $predioss->fecn_008,
                    'documento_entrada' => $this->referencias->where('tipo_007', "TE")->where('cven_007', $predioss->tesc_008)->first()->desc_007,
                    'documento_numero' => $predioss->titp_008,
                    'declarante' => 'Notaria ' . $predioss->cnot_003,
                    'observaciones' => $predioss->obse_008,
                    'origen' => 0,
                    'actualizado_nombre' => $predioss->nome_008
                ]);

                $this->colindacnias($p->id, $predioss->col1_003, $predioss->col2_003, $predioss->col3_003, $predioss->col4_003);

                $this->terrenos($p->id, $predioss->stot_008, $predioss->valt_003, $predioss->vter_003);

                $this->construcciones($p->id, $predioss->mpio_008, $predioss->zcat_008, $predioss->locl_008, $predioss->sect_008, $predioss->mzna_008, $predioss->pred_008, $predioss->edif_008, $predioss->dpto_008);

                $this->personas($predioss, $p->id);

                $this->movimientos($predioss, $p->id);

                if ($predioss->edif_008 > 0 && $predioss->dpto_008 > 0){

                    $this->condominio($predioss,$p->id);

                }

            });

        } catch (\Throwable $th) {

            Log::error("El predio: " . $predioss->locl_008 . "-" . $predioss->ofna_008 . "-" . $predioss->tpre_008 . "-" . $predioss->nreg_008 . ". " . $th);
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

        if(!isset($predio_padre->stot_008)){

            $superficie_total = $predio_padre->stot_003;

        }else{

            $superficie_total = $predio_padre->stot_008;
        }

        if(!isset($predio_padre->scon_008)){

            $area_comun_construccion = $predio_padre->scon_003;

        }else{

            $area_comun_construccion = $predio_padre->scon_008;
        }

       if ($ctcdm004) {

            Condominioterreno::create([
                'condominioterrenoable_id' => $idnvo,
                'condominioterrenoable_type' => 'App\Models\Predio',
                'area_terreno_comun' => ($predio_padre) ? $superficie_total : 0,
                'indiviso_terreno' => $ctcdm004->ipre_004,
                'valor_unitario' => 0,
                'valor_terreno_comun' => ($ctcdm004->vter_004 == NULL) ? 0 : $ctcdm004->vter_004,
            ]);

            Condominioconstruccion::create([
                'condominioconstruccionable_id' => $idnvo,
                'condominioconstruccionable_type' => 'App\Models\Predio',
                'area_comun_construccion' => ($predio_padre) ? $area_comun_construccion : 0,
                'indiviso_construccion' => $ctcdm004->icon_004,
                'valor_clasificacion_construccion' => 0,
                'valor_construccion_comun' => ($ctcdm004->vcon_004 == NULL) ? 0 : $ctcdm004->vcon_004,
            ]);

       }

    }

    public function personas($predioss,$idnvo)
    {

        $ep = $this->existe_persona($predioss->nomb_008,$predioss->apat_008,$predioss->amat_008);

        if ($ep == 0)
        {

            $nombre = str_replace(['Y SOC', 'Y SOCIOS', 'Y SOC.'. 'Y SOCS.', 'Y SOCS', 'Y SOCIOS.'], '', $predioss->nomb_008);

            $persona = Persona::create([
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
                'ciudad' => $predioss->nopo_008,
            ]);

            $this->crear_propietario($predioss,$idnvo,$persona->id,8);

        }

        else{

            $this->crear_propietario($predioss,$idnvo,$ep,8);

        }


        //Verificar si en tccop005 hay más proppietatios
        $ctcop005 = DB::connection('sqlsrv')->select("select * from ctcop005
                                                            where mpio_005 = ". $predioss->mpio_008 ."
                                                            and zcat_005 = ". $predioss->zcat_008 ."
                                                            and locl_005 = ". $predioss->locl_008 ."
                                                            and sect_005 = ". $predioss->sect_008 ."
                                                            and mzna_005 = ". $predioss->mzna_008 ."
                                                            and pred_005 = ". $predioss->pred_008 ."
                                                            and edif_005 = ". $predioss->edif_008 ."
                                                            and dpto_005 = ". $predioss->dpto_008);

        foreach($ctcop005 as $propietario){

            $ep = $this->existe_persona($propietario->nomb_005,$propietario->apat_005,$propietario->amat_005);

            if ($ep == 0)
            {

                $nombre = str_replace(['Y SOC', 'Y SOCIOS', 'Y SOC.'. 'Y SOCS.', 'Y SOCS', 'Y SOCIOS.'], '', $propietario->nomb_005);

                $persona005 = Persona::create([
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
                ]);

                $this->crear_propietario($propietario,$idnvo,$persona005->id,5);

            }else{

                $this->crear_propietario($propietario,$idnvo,$ep,5);

            }

        }
    }

    public function crear_propietario($predioss,$idnvo,$idpersona,$tabla)
    {
        if ($tabla == 8){
            Propietario::create([
                'propietarioable_id' => $idnvo,
                'propietarioable_type' => 'App\Models\Predio',
                'persona_id' => $idpersona,
                'tipo' => $this->referencias->where('tipo_007', "TP")->where('cven_007', $predioss->tper_008)->first()->desc_007,
                'porcentaje' => ($predioss->tper_008 == 1 || $predioss->tper_008 == 2 || $predioss->tper_008 >= 5) ? $predioss->ppro_008 : 0,
                'porcentaje_nuda' => ($predioss->tper_008 == 3) ? $predioss->ppro_008 : 0,
                'porcentaje_usufructo' => ($predioss->tper_008 == 4) ? $predioss->ppro_008 : 0,
            ]);
        }
        else{
            Propietario::create([
                'propietarioable_id' => $idnvo,
                'propietarioable_type' => 'App\Models\Predio',
                'persona_id' => $idpersona,
                'tipo' => $this->referencias->where('tipo_007', "TP")->where('cven_007', $predioss->tper_005)->first()->desc_007,
                'porcentaje' => ($predioss->tper_005 == 1 || $predioss->tper_005 == 2 || $predioss->tper_005 >= 5) ? $predioss->ppro_005 : 0,
                'porcentaje_nuda' => ($predioss->tper_005 == 3) ? $predioss->ppro_005 : 0,
                'porcentaje_usufructo' => ($predioss->tper_005 == 4) ? $predioss->ppro_005 : 0,
            ]);
        }

    }

    public function existe_persona($nomb,$apat,$amat)
    {

        $persona = Persona::where('nombre',$nomb)
                            ->where('ap_paterno',$apat)
                            ->where('ap_materno',$amat)
                            ->first();

        if ($persona)
            return $persona->id;
        else
            return 0;
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
                'referencia' => $constss->rcon_006,
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
