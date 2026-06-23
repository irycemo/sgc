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

    public function __construct(public $predio){

        $this->referencias = collect(ctref007::whereIn('tipo_007', ["TV", "AH", "UP", "UB", "TE", "ED", "TP", "OM", "RP"])->get()->toArray());
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {

            DB::transaction(function () {

                $p = Predio::create([
                    'estado' => $this->predio['esta_008'],
                    'region_catastral' => $this->predio['rcat_008'],
                    'municipio' => $this->predio['mpio_008'],
                    'zona_catastral' => $this->predio['zcat_008'],
                    'localidad' => $this->predio['locl_008'],
                    'sector' => $this->predio['sect_008'],
                    'manzana' => $this->predio['mzna_008'],
                    'predio' => $this->predio['pred_008'],
                    'edificio' => $this->predio['edif_008'],
                    'departamento' => $this->predio['dpto_008'],
                    'oficina' => $this->predio['ofna_008'],
                    'tipo_predio' => $this->predio['tpre_008'],
                    'numero_registro' => $this->predio['nreg_008'],
                    'tipo_vialidad' => $this->referencias->where('tipo_007', "TV")->where('cven_007', $this->predio['tvia_008'])->first()['desc_007'],
                    'tipo_asentamiento' => $this->referencias->where('tipo_007', "AH")->where('cven_007', $this->predio['tase_008'])->first()['desc_007'],
                    'nombre_vialidad' => trim($this->predio['call_008']),
                    'numero_exterior' => trim($this->predio['next_008']),
                    'numero_exterior_2' => trim($this->predio['nex2_008']),
                    'numero_adicional' => trim($this->predio['nadi_008']),
                    'numero_adicional_2' => trim($this->predio['nad2_008']),
                    'numero_interior' => trim($this->predio['nint_008']),
                    'nombre_asentamiento' => trim($this->predio['colo_008']),
                    'codigo_postal' => $this->predio['codp_008'],
                    'lote_fraccionador' => trim($this->predio['lote_008']),
                    'manzana_fraccionador' => trim($this->predio['manz_008']),
                    'etapa_fraccionador' => trim($this->predio['zona_008']),
                    'nombre_predio' => NULL,
                    'nombre_edificio' => NULL,
                    'clave_edificio' => NULL,
                    'departamento_edificio' => NULL,
                    'uso_1' => $this->referencias->where('tipo_007', "UP")->where('cvea_007', $this->predio['usop_003'])->first() ? $this->referencias->where('tipo_007', "UP")->where('cvea_007', $this->predio['usop_003'])->first()['desc_007'] : null,
                    'uso_2' => $this->referencias->where('tipo_007', "UP")->where('cvea_007', $this->predio['usp2_003'])->first() ? $this->referencias->where('tipo_007', "UP")->where('cvea_007', $this->predio['usp2_003'])->first()['desc_007'] : null,
                    'uso_3' => $this->referencias->where('tipo_007', "UP")->where('cvea_007', $this->predio['usp3_003'])->first() ? $this->referencias->where('tipo_007', "UP")->where('cvea_007', $this->predio['usp3_003'])->first()['desc_007'] : null,
                    'ubicacion_en_manzana' => $this->referencias->where('tipo_007', "UB")->where('cven_007', $this->predio['ubic_003'])->first() ? $this->referencias->where('tipo_007', "UB")->where('cven_007', $this->predio['ubic_003'])->first()['desc_007'] : null,
                    'superficie_total_terreno' => $this->predio['stot_008'],
                    'superficie_total_construccion' => $this->predio['scon_008'],
                    'superficie_judicial' => $this->predio['sjur_008'],
                    'superficie_notarial' => $this->predio['snot_008'],
                    'area_comun_terreno' => 0,
                    'area_comun_construccion' => 0,
                    'valor_terreno_comun' => 0,
                    'valor_construccion_comun' => 0,
                    'valor_total_terreno' => $this->predio['vter_003'],
                    'valor_total_construccion' => $this->predio['vcon_003'],
                    'valor_catastral' => $this->predio['vcas_008'],
                    'curt' => NULL,
                    'folio_real' => NULL,
                    'xutm' => ($this->predio['xutm_003'] == NULL) ? 0 : $this->predio['xutm_003'],
                    'yutm' => ($this->predio['yutm_003'] == NULL) ? 0 : $this->predio['yutm_003'],
                    'zutm' => ($this->predio['zutm_003'] == NULL) ? 0 : $this->predio['zutm_003'],
                    'lon' => ($this->predio['long_003'] == NULL) ? 0 : ($this->predio['long_003'] > -103.7 && $this->predio['long_003'] <= -100.06  ? $this->predio['long_003'] : 0),
                    'lat' => ($this->predio['lati_003'] == NULL) ? 0 : ($this->predio['lati_003'] > 17.9 && $this->predio['lati_003'] <= 20.5  ? $this->predio['lati_003'] : 0),
                    'fecha_efectos' => $this->predio['fecn_008'],
                    'fecha_otorgamiento' => NULL,
                    'documento_entrada' => $this->referencias->where('tipo_007', "TE")->where('cven_007', $this->predio['tesc_008'])->first() ? $this->referencias->where('tipo_007', "TE")->where('cven_007', $this->predio['tesc_008'])->first()['desc_007'] : null,
                    'documento_numero' => trim($this->predio['titp_008']),
                    'declarante' => 'Notaria ' . trim($this->predio['cnot_003']),
                    'observaciones' => trim($this->predio['obse_008']),
                    'origen' => $this->referencias->where('tipo_007', "OM")->where('cvea_007', $this->predio['cmto_008'])->first() ? $this->referencias->where('tipo_007', "MO")->where('cvea_007', $this->predio['cmto_008'])->first()['desc_007'] : null,
                    'regimen' => $this->referencias->where('tipo_007', "RP")->where('cvea_007', $this->predio['rpro_008'])->first() ? $this->referencias->where('tipo_007', "RP")->where('cvea_007', $this->predio['rpro_008'])->first()['desc_007'] : null,
                    'tomo' => $this->predio['tomo_003'],
                    'registro' => $this->predio['regi_003'],
                    'libro' => $this->predio['libr_003'],
                    'distrito' => null,
                    'domicilio_notificacion' => $this->predio['noca_008'] . ' ' . $this->predio['exte_008'] . ' ' . $this->predio['adic_008'] . ' ' . $this->predio['inte_008'] . ' ' . $this->predio['nedi_008'] . ' ' . $this->predio['ndpt_008'] . ' ' . $this->predio['noco_008'] . ' ' . $this->predio['nopo_008'] . ' ' . $this->predio['nomu_008'] . ' ' . $this->predio['copd_008'],
                    'actualizado_nombre' => trim($this->predio['nome_008'])
                ]);

                $this->colindancias($p->id, $this->predio['col1_003'], $this->predio['col2_003'], $this->predio['col3_003'], $this->predio['col4_003']);

                $this->construcciones($p->id, $this->predio['mpio_008'], $this->predio['zcat_008'], $this->predio['locl_008'], $this->predio['sect_008'], $this->predio['mzna_008'], $this->predio['pred_008'], $this->predio['edif_008'], $this->predio['dpto_008']);

                $this->personas($this->predio, $p->id);

                $this->movimientos($this->predio, $p->id);

                if ($this->predio['edif_008'] > 0 && $this->predio['dpto_008'] > 0){

                    $ctcdm004 = ctcdm004::where('mpio_004', $this->predio['mpio_008'])
                            ->where('zcat_004', $this->predio['zcat_008'])
                            ->where('locl_004', $this->predio['locl_008'])
                            ->where('sect_004', $this->predio['sect_008'])
                            ->where('mzna_004', $this->predio['mzna_008'])
                            ->where('pred_004', $this->predio['pred_008'])
                            ->where('edif_004', $this->predio['edif_008'])
                            ->where('dpto_004', $this->predio['dpto_008'])
                            ->first();

                    if($ctcdm004){

                        $this->terrenos($p->id, $ctcdm004->ster_004, $ctcdm004->valt_004, $ctcdm004->vter_004);

                        $this->condominio($this->predio, $p->id);

                        $p->nombre_edificio = $ctcdm004->noed_008 ? trim($ctcdm004->noed_008) : null;
                        $p->clave_edificio = $ctcdm004->cled_008 ? trim($ctcdm004->cled_008) : null;
                        $p->departamento_edificio = $ctcdm004->ndpt_008 ? trim($ctcdm004->ndpt_008) : null;

                        $p->save();

                    }else{

                        Log::info("El predio: " . $this->predio['locl_008'] . "-" . $this->predio['ofna_008'] . "-" . $this->predio['tpre_008'] . "-" . $this->predio['nreg_008'] . ". No tiene registro de condominio en ctcdm004.");

                    }

                }else{

                    $this->terrenos($p->id, $this->predio['stot_008'], $this->predio['valt_003'], $this->predio['vter_003']);

                }

            });

        }catch (QueryException $e){

            info($e);

            $errorCode = $e->errorInfo[1];

            if($errorCode == 1062){

                /* order by fecn_008 */

                $predioRepetido = PredioRepetido::where('estado', $this->predio['esta_008'])
                                ->where('region_catastral', $this->predio['rcat_008'])
                                ->where('municipio', $this->predio['mpio_008'])
                                ->where('zona_catastral', $this->predio['zcat_008'])
                                ->where('localidad', $this->predio['locl_008'])
                                ->where('sector', $this->predio['sect_008'])
                                ->where('manzana', $this->predio['mzna_008'])
                                ->where('predio', $this->predio['pred_008'])
                                ->where('edificio', $this->predio['edif_008'])
                                ->where('departamento', $this->predio['dpto_008'])
                                ->where('oficina', $this->predio['ofna_008'])
                                ->where('tipo_predio', $this->predio['tpre_008'])
                                ->where('numero_registro', $this->predio['nreg_008'])
                                ->first();

                if(! $predioRepetido){

                    PredioRepetido::create([
                        'estado' => $this->predio['esta_008'],
                        'region_catastral' => $this->predio['rcat_008'],
                        'municipio' => $this->predio['mpio_008'],
                        'zona_catastral' => $this->predio['zcat_008'],
                        'localidad' => $this->predio['locl_008'],
                        'sector' => $this->predio['sect_008'],
                        'manzana' => $this->predio['mzna_008'],
                        'predio' => $this->predio['pred_008'],
                        'edificio' => $this->predio['edif_008'],
                        'departamento' => $this->predio['dpto_008'],
                        'oficina' => $this->predio['ofna_008'],
                        'tipo_predio' => $this->predio['tpre_008'],
                        'numero_registro' => $this->predio['nreg_008'],
                        'error' => $e,
                        'count' => 1
                    ]);

                }else{

                    $predioRepetido->update(['count' => $predioRepetido->count + 1]);

                }

            }

            $predioRepetido = null;
            $errorCode = null;

        } catch (\Throwable $th) {

            Log::error("El predio: " . $this->predio['locl_008'] . "-" . $this->predio['ofna_008'] . "-" . $this->predio['tpre_008'] . "-" . $this->predio['nreg_008'] . ". " . $th);

        }

        app('queue.worker')->shouldQuit = 1;

        $this->predio = null;
        $predio = null;
        $this->referencias = null;

    }

    public function failed(?Throwable $exception): void
    {
        Log::error($exception);
    }

    public function condominio($predio, $idnvo)
    {

        $predio_padre = tcpro008::where('mpio_008', $predio['mpio_008'])
                                ->where('zcat_008', $predio['zcat_008'])
                                ->where('locl_008', $predio['locl_008'])
                                ->where('sect_008', $predio['sect_008'])
                                ->where('mzna_008', $predio['mzna_008'])
                                ->where('pred_008', $predio['pred_008'])
                                ->where('edif_008', 0)
                                ->where('dpto_008', 0)
                                ->where('nreg_008', 0)
                                ->first();

        $ctcdm004 = ctcdm004::where('mpio_004', $predio['mpio_008'])
                                ->where('zcat_004', $predio['zcat_008'])
                                ->where('locl_004', $predio['locl_008'])
                                ->where('sect_004', $predio['sect_008'])
                                ->where('mzna_004', $predio['mzna_008'])
                                ->where('pred_004', $predio['pred_008'])
                                ->where('edif_004', $predio['edif_008'])
                                ->where('dpto_004', $predio['dpto_008'])
                                ->first();

        if($predio_padre){


            $superficie_total = $predio_padre->stot_008 ?? 0;

            $area_comun_construccion = $predio_padre->scon_008 ?? 0;

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

    public function personas($predio, $idnvo)
    {

        $nombre = str_replace(['Y SOC', 'Y SOCIOS', 'Y SOC.'. 'Y SOCS.', 'Y SOCS', 'Y SOCIOS.', 'SOC', 'SOC.'], '', $predio['nomb_008']);

        if($predio['tper_008'] == 2){

            $persona = Persona::where('razon_social', trim($predio['nomb_008']) . " " . trim($predio['apat_008']) . " " . trim($predio['amat_008']))->first();

        }else{

            $persona = Persona::where('nombre', trim($predio['nomb_008']))
                                ->where('ap_paterno', trim($predio['apat_008']))
                                ->where('ap_materno', trim($predio['amat_008']))
                                ->where('calle', trim($predio['noca_008']))
                                ->first();
        }

        if(! $persona){

            $persona = Persona::create([
                    'tipo' => ($predio['tper_008'] == 1) ? 'FÍSICA' : ($predio['tper_008'] == 2 ? 'MORAL' : 'FÍSICA'),
                    'nombre' => ($predio['tper_008'] == 2) ? null : trim($nombre),
                    'ap_paterno' => ($predio['tper_008'] == 2) ? null : trim($predio['apat_008']),
                    'ap_materno' => ($predio['tper_008'] == 2) ? null : trim($predio['amat_008']),
                    'curp' => NULL,
                    'rfc' => NULL,
                    'razon_social' => ($predio['tper_008'] == 2) ? " " . trim($predio['nomb_008']) . " " . trim($predio['apat_008']) . " " . trim($predio['amat_008']) : null,
                    'fecha_nacimiento' => NULL,
                    'nacionalidad' => NULL,
                    'estado_civil' => NULL,
                    'calle' => trim($predio['noca_008']),
                    'numero_exterior' => trim($predio['exte_008']),
                    'numero_interior' => trim($predio['inte_008']),
                    'colonia' => trim($predio['noco_008']),
                    'cp' => $predio['copd_008'],
                    'entidad' => $this->referencias->where('tipo_007', "ED")->where('cven_007', $predio['cest_008'])->first() ? $this->referencias->where('tipo_007', "ED")->where('cven_007', $predio['cest_008'])->first()['desc_007'] : null,
                    'municipio' => trim($predio['nomu_008']),
                    'ciudad' => trim($predio['nopo_008'])
                ]);

        }

        $tipo = $this->referencias->where('tipo_007', "TP")->where('cven_007', $predio['tper_008'])->first();

        Propietario::create([
            'propietarioable_id' => $idnvo,
            'propietarioable_type' => 'App\Models\Predio',
            'persona_id' => $persona->id,
            'tipo' => isset($tipo) ? $tipo['desc_007'] : '0',
            'porcentaje_propiedad' => ($predio['tper_008'] == 1 || $predio['tper_008'] == 2 || $predio['tper_008'] >= 5) ? $predio['ppro_008'] : 0,
            'porcentaje_nuda' => ($predio['tper_008'] == 3) ? $predio['ppro_008'] : 0,
            'porcentaje_usufructo' => ($predio['tper_008'] == 4) ? $predio['ppro_008'] : 0,
        ]);

        //Verificar si en tccop005 hay más proppietatios
        $ctcop005 = ctcop005::where('mpio_005', $predio['mpio_008'])
                                ->where('zcat_005', $predio['zcat_008'])
                                ->where('locl_005', $predio['locl_008'])
                                ->where('sect_005', $predio['sect_008'])
                                ->where('mzna_005', $predio['mzna_008'])
                                ->where('pred_005', $predio['pred_008'])
                                ->where('edif_005', $predio['edif_008'])
                                ->where('dpto_005', $predio['dpto_008'])
                                ->get();

        foreach($ctcop005 as $propietario){

            $nombre = str_replace(['Y SOC', 'Y SOCIOS', 'Y SOC.'. 'Y SOCS.', 'Y SOCS', 'Y SOCIOS.', 'SOC', 'SOC.'], '', $propietario->nomb_005);

            if($propietario->tper_005 == 2){

                $persona = Persona::where('razon_social', trim($propietario->nomb_005) . " " . trim($propietario->apat_005) . " " . trim($propietario->amat_005))->first();

            }else{

                $persona = Persona::where('nombre', trim($propietario->nomb_005))
                                    ->where('ap_paterno', trim($propietario->apat_005))
                                    ->where('ap_materno', trim($propietario->amat_005))
                                    ->where('calle', trim($propietario->noca_005))
                                    ->first();
            }

            if(!$persona){

                $persona = Persona::create([
                        'tipo' => ($propietario->tper_005 == 1) ? 'FÍSICA' : ($propietario->tper_005 == 2 ? 'MORAL' : 'FÍSICA'),
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
                    ]);

            }

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
                'valor_unitario' => $constss->scon_006 != 0 ? ($constss->valc_006 / $constss->scon_006) : 0,
                'valor_construccion' => $constss->valc_006,
            ]);

        }

        $contruccionesSS = null;
    }

    public function colindancias($idnvo, $col1, $col2, $col3, $col4)
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

    public function movimientos($predio, $idnvo){

        $movimientos = DB::connection('sqlsrv')->select("select * from cthis021
                                                            where mpio_021 = ". $predio['mpio_008'] ."
                                                            and zcat_021 = ". $predio['zcat_008'] ."
                                                            and locl_021 = ". $predio['locl_008'] ."
                                                            and sect_021 = ". $predio['sect_008'] ."
                                                            and mzna_021 = ". $predio['mzna_008'] ."
                                                            and pred_021 = ". $predio['pred_008'] ."
                                                            and edif_021 = ". $predio['edif_008'] ."
                                                            and dpto_021 = ". $predio['dpto_008']
                                                        );

        foreach ($movimientos as $movimiento) {

            if(empty($movimiento->obse_021)) continue;

            Movimiento::create([
                'predio_id' => $idnvo,
                'nombre' => $this->referencias->where('cven_007', $movimiento->cmto_021)->where('tipo_007', 'OM')->first()['desc_007'],
                'fecha' => $movimiento->femo_021,
                'descripcion' => $movimiento->obse_021, /// Concatenar todos los campos
                'actualizado_nombre' => trim($movimiento->nome_021),
            ]);

        }

        $movimientos = null;
        $movimiento = null;

    }

}
