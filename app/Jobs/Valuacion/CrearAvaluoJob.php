<?php

namespace App\Jobs\Valuacion;

use App\Exceptions\GeneralException;
use App\Livewire\Admin\ValoresUnitariosRusticos;
use App\Models\Avaluo;
use App\Models\Construccion;
use App\Models\ConstruccionesComun;
use App\Models\Import;
use App\Models\Predio;
use App\Models\PredioAvaluo;
use App\Models\Terreno;
use App\Models\TerrenosComun;
use App\Models\User;
use App\Models\ValoresUnitariosConstruccion;
use App\Services\Coordenadas\Coordenadas;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CrearAvaluoJob implements ShouldQueue
{
    use Queueable;
    use Batchable;

    public $tries = 20;
    public $import;
    public $user;
    public $valoresConstruccion;
    public $valoresRusticos;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $import_id, public array $row, public int $user_id, public string $batch_id)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $this->import = Import::find($this->import_id);

        $this->user = User::find($this->user_id);

        try {

            DB::transaction(function () {

                if(isset($this->row['latitud']) && isset($this->row['longitud'])){

                    $coordenadas = $this->procesarCoordenadas($this->row['latitud'], $this->row['longitud']);

                }else{

                    $coordenadas = [
                        'lat' => null,
                        'lon' => null,
                        'yutm' => null,
                        'xutm' => null,
                        'zutm' => null
                    ];

                }

                /* TERRENO */
                if(isset($this->row['superficie_terreno']) && isset($this->row['valor_unitario_terreno'])){

                    if($this->row['tipo_predio'] == 1){

                        $valor_terreno = round((float)$this->row['superficie_terreno'] * (float)$this->row['valor_unitario_terreno'], 4);

                    }elseif($this->row['tipo_predio'] == 2){

                        $valor_terreno = round((float)$this->row['superficie_terreno'] * (float)$this->row['valor_unitario_terreno'] / 10000, 4);

                    }

                    $terreno = [
                        'superficie' => $this->row['superficie_terreno'],
                        'valor_unitario' => $this->row['valor_unitario_terreno'],
                        'valor_terreno' => $valor_terreno
                    ];

                }else{

                    $terreno = [];

                }

                /* TERRENO COMUN */
                if(isset($this->row['superficie_comun']) && isset($this->row['indiviso_terreno']) && isset($this->row['valor_unitario'])){

                    $superficie_proporcional = round((float)$this->row['superficie_comun'] * round((float)$this->row['indiviso_terreno'], 4) / 100, 4);



                    if($this->row['tipo_predio'] == 1){

                        $valor_terreno_comun = round($superficie_proporcional * (float)$this->row['valor_unitario'], 4);

                    }elseif($this->row['tipo_predio'] == 2){

                        $valor_terreno_comun = round($superficie_proporcional * (float)$this->row['valor_unitario'] / 10000, 4);

                    }

                    $terrenoComun = [
                        'superficie_comun' => $this->row['superficie_comun'],
                        'indiviso_terreno' => $this->row['indiviso_terreno'],
                        'valor_unitario' => $this->row['valor_unitario'],
                        'superficie_proporcional' => $superficie_proporcional,
                        'valor_terreno_comun' => $valor_terreno_comun
                    ];

                }else{

                    $terrenoComun = [];

                }

                /* CONSTRUCCION */
                if(isset($this->row['referencia']) && isset($this->row['tipo_construccion']) && isset($this->row['uso_construccion']) && isset($this->row['estado_construccion']) && isset($this->row['calidad_construccion']) && isset($this->row['niveles']) && isset($this->row['superficie_construccion'])){

                    $valorUnitario = ValoresUnitariosConstruccion::where('tipo', $this->row['tipo_construccion'])->where('uso', $this->row['uso_construccion'])->where('calidad', $this->row['calidad_construccion'])->where('estado', $this->row['estado_construccion'])->first()->valor;

                    $valor_construccion = round($valorUnitario * (float)$this->row['superficie_construccion'], 4);

                    $construccion = [
                        'referencia' => $this->row['referencia'],
                        'tipo' => $this->row['tipo_construccion'],
                        'uso' => $this->row['uso_construccion'],
                        'calidad' => $this->row['calidad_construccion'],
                        'estado' => $this->row['estado_construccion'],
                        'niveles' => $this->row['niveles'],
                        'superficie_construccion' => $this->row['superficie_construccion'],
                        'valor_unitario' => $valorUnitario,
                        'valor_construccion' => $valor_construccion,
                    ];

                }else{

                    $construccion = [];

                }

                /* CONSTRUCCION COMUN */
                if(isset($this->row['referencia']) && isset($this->row['tipo']) && isset($this->row['uso']) && isset($this->row['estado']) && isset($this->row['calidad']) && isset($this->row['niveles']) && isset($this->row['superficie_construccion_comun']) && isset($this->row['indiviso_construccion'])){

                    $superficie_proporcional_construccion = (float)$this->row['superficie_construccion_comun'] * (float)$this->row['indiviso_construccion'] / 100;

                    $valorUnitario = ValoresUnitariosConstruccion::where('tipo', $this->row['tipo'])->where('uso', $this->row['uso'])->where('calidad', $this->row['calidad'])->where('estado', $this->row['estado'])->first()->valor;

                    $valor_construccion_comun = round($valorUnitario * $superficie_proporcional_construccion, 4);

                    $construccionComun = [
                        'referencia' => $this->row['referencia'],
                        'tipo' => $this->row['tipo'],
                        'uso' => $this->row['uso'],
                        'calidad' => $this->row['calidad'],
                        'estado' => $this->row['estado'],
                        'niveles' => $this->row['niveles'],
                        'indiviso_construccion' => $this->row['indiviso_construccion'],
                        'superficie_construccion_comun' => $this->row['superficie_construccion_comun'],
                        'valor_unitario' => $valorUnitario,
                        'superficie_proporcional' => $superficie_proporcional_construccion,
                        'valor_construccion' => $valor_construccion_comun,
                    ];

                }else{

                    $construccionComun = [];

                }

                $superficie_total_terreno = 0;

                if(isset($terreno['superficie'])){

                    $superficie_total_terreno = $terreno['superficie'];

                }

                $superficie_total_construccion = 0;

                if(isset($construccion['superficie_construccion'])){

                    $superficie_total_construccion = $construccion['superficie_construccion'];

                }

                if($this->row['edificio'] > 0){

                    if(isset($terrenoComun['superficie_comun'])){

                        $superficie_total_terreno = $superficie_total_terreno + $terrenoComun['superficie_proporcional'];

                    }

                    if(isset($construccionComun['superficie_proporcional'])){

                        $superficie_total_construccion = $superficie_total_construccion + $construccionComun['superficie_proporcional'];

                    }

                }

                $valorCatastral = ($terreno['valor_terreno'] ?? 0)
                                        + ($terrenoComun['valor_terreno_comun'] ?? 0)
                                        + ($construccion['valor_construccion'] ?? 0)
                                        + ($construccionComun['valor_construccion'] ?? 0);

                if($valorCatastral == 0){

                    throw new GeneralException('El valor catastral no puede ser 0');

                }

                if($this->row['ubicacion_en_manzana'] == 'ESQUINA'){

                    $valor_esquina = $terreno['superficie'] * (0.10);

                    $valorCatastral = $valorCatastral + $valor_esquina;

                }

                $predio = $this->crearPredio($coordenadas, $terreno, $terrenoComun, $construccion, $construccionComun, $superficie_total_terreno, $superficie_total_construccion, $valorCatastral);

                $this->procesarPropietariosColindancias($predio->id);

                $this->procesarRelaciones($terreno, $terrenoComun, $construccion, $construccionComun, $predio->id);

                $avaluo = $this->crearAvaluo($predio->id);

                $this->import->update([
                    'status' => 'processed',
                    'info' => 'Avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' Cuenta Predial: ' . $predio->cuentaPredial()
                ]);

                $procesados = Import::where('batch_id', $this->batch_id)
                                        ->where('status', 'processed')
                                        ->count();

                $total = Import::where('batch_id', $this->batch_id)->count();

                Cache::put("import:{$this->batch_id}", [
                    'estado'    => 'procesando',
                    'total'     => $total,
                    'procesados' => $procesados,
                ], now()->addMinutes(10));

            });

        } catch (\Throwable $th) {

            Log::error("Error en job crear avaluo row number: " . $this->import->row_number . " row: " . json_encode($this->row) . " " . $th);

            $this->import->update([
                'status' => 'error',
                'errores' => json_encode([$th->getMessage()]),
            ]);

            throw $th;

        }

    }

    public function crearPredio($coordenadas, $terreno, $terrenoComun, $construccion, $construccionComun, $superficie_total_terreno, $superficie_total_construccion, $valorCatastral): PredioAvaluo
    {

        $valor_total_terreno = ($terreno['valor_terreno'] ?? 0) + ($terrenoComun['valor_terreno_comun'] ?? 0);

        $valor_total_construccion = ($construccion['valor_construccion'] ?? 0) + ($construccionComun['valor_construccion'] ?? 0);

        return PredioAvaluo::create([
            'status' => 'activo',
            'estado' => $this->row['estado_clave'],
            'region_catastral' => $this->row['region'],
            'municipio' => $this->row['municipio'],
            'zona_catastral' => $this->row['zona'],
            'localidad' => $this->row['localidad'],
            'sector' => $this->row['sector'],
            'manzana' => $this->row['manzana'],
            'predio' => $this->row['predio'],
            'edificio' => $this->row['edificio'],
            'departamento' => $this->row['departamento'],
            'oficina' => $this->row['oficina'],
            'tipo_predio' => $this->row['tipo_predio'],
            'numero_registro' => $this->row['registro'],
            'tipo_vialidad' => $this->row['tipo_vialidad'],
            'tipo_asentamiento' => $this->row['tipo_asentamiento'],
            'nombre_vialidad' => $this->row['nombre_vialidad'],
            'numero_exterior' => $this->row['numero_exterior'],
            'numero_exterior_2' => $this->row['numero_exterior_2'],
            'numero_adicional' => $this->row['numero_adicional'],
            'numero_adicional_2' => $this->row['numero_adicional_2'],
            'numero_interior' => $this->row['numero_interior'],
            'nombre_asentamiento' => $this->row['nombre_asentamiento'],
            'codigo_postal' => $this->row['codigo_postal'],
            'lote_fraccionador' => $this->row['lote_fraccionador'],
            'manzana_fraccionador' => $this->row['manzana_fraccionador'],
            'etapa_fraccionador' => $this->row['etapa_fraccionador'],
            'nombre_predio' => $this->row['predio_rustico_antecedente'],
            'nombre_edificio' => $this->row['nombre_edificio'],
            'clave_edificio' => $this->row['clave_edificio'],
            'departamento_edificio' => $this->row['departamento_edificio'],
            'yutm' => $coordenadas['yutm'],
            'zutm' => $coordenadas['zutm'],
            'xutm' => $coordenadas['xutm'],
            'uso_1' => $this->row['uso_1'],
            'uso_2' => $this->row['uso_2'],
            'uso_3' => $this->row['uso_3'],
            'ubicacion_en_manzana' => $this->row['ubicacion_en_manzana'],
            'lon'=> $coordenadas['lon'],
            'lat'=> $coordenadas['lat'],
            'observaciones' => $this->row['observaciones'],
            'superficie_terreno' => $terreno['superficie'] ?? null,
            'valor_total_terreno' => $valor_total_terreno,
            'valor_total_construccion' => $valor_total_construccion,
            'superficie_construccion' => $construccion['superficie_construccion'] ?? null,
            'area_comun_terreno' => $terrenoComun['superficie'] ?? null,
            'valor_terreno_comun' => $terrenoComun['valor_terreno_comun'] ?? null,
            'area_comun_construccion' => $construccionComun['superficie_construccion_comun'] ?? null,
            'valor_construccion_comun' => $construccionComun['valor_construccion'] ?? null,
            'domicilio_notificacion' => $this->row['domicilio_para_notificacion'],
            'superficie_total_terreno' => $superficie_total_terreno,
            'superficie_total_construccion' => $superficie_total_construccion,
            'valor_catastral' => $valorCatastral,
        ]);

    }

    public function procesarPropietariosColindancias($predio_nuevo):void
    {

        $predio_origen_id = Import::where('batch_id', $this->batch_id)->whereNotNull('predio_origen')->first()->predio_origen;

        $predio_origen = Predio::find($predio_origen_id);

        $predio_nuevo = PredioAvaluo::find($predio_nuevo);

        foreach ($predio_origen->propietarios as $propietario) {

            $propietario_nuevo = $propietario->replicate();

            $propietario_nuevo->propietarioable_id = $predio_nuevo->id;
            $propietario_nuevo->propietarioable_type = 'App\Models\PredioAvaluo';

            $propietario_nuevo->save();

        }

        foreach ($predio_origen->colindancias as $colindancia) {

            $colindancia_nueva = $colindancia->replicate();

            $colindancia_nueva->colindanciaable_id = $predio_nuevo->id;
            $colindancia_nueva->colindanciaable_type = 'App\Models\PredioAvaluo';

            $colindancia_nueva->save();

        }

    }

    public function crearAvaluo($predioId):Avaluo
    {

        $avaluo = Avaluo::create([
            'predio_avaluo' => $predioId,
            'predio' => $this->import->predio_origen,
            'año' => now()->format('Y'),
            'folio' => (Avaluo::where('año', now()->format('Y'))->where('usuario', $this->user->clave)->max('folio') ?? 0) + 1,
            'usuario' => $this->user->clave,
            'estado' => 'nuevo',
            'clasificacion_zona' => $this->row['clasificacion_zona'],
            'construccion_dominante' => $this->row['tipo_construccion_dominante'],
            'asignado_a' => $this->user->id,
            'creado_por' => $this->user->id,
            'oficina_id' => $this->user->oficina_id,
            'agua' => $this->row['agua_potable'] == 'SI' ? 1 : 0,
            'drenaje' => $this->row['drenaje']  == 'SI' ? 1 : 0,
            'pavimento' => $this->row['pavimento']  == 'SI' ? 1 : 0,
            'energia_electrica' => $this->row['energia_electrica']  == 'SI' ? 1 : 0,
            'alumbrado_publico' => $this->row['alumbrado_publico']  == 'SI' ? 1 : 0,
            'banqueta' => $this->row['banqueta']  == 'SI' ? 1 : 0,
            'observaciones' => $this->row['observaciones'],
        ]);

        return $avaluo;

    }

    public function procesarRelaciones($terreno, $terrenoComun, $construccion, $construccionComun, $predioId):void
    {

        if(! empty($terreno)){

            Terreno::create([
                'terrenoable_id' => $predioId,
                'terrenoable_type' => 'App\Models\PredioAvaluo',
                'superficie' => $terreno['superficie'],
                'valor_unitario' => $terreno['valor_unitario'],
                'valor_terreno' => $terreno['valor_terreno'],
                'creado_por' => $this->user->id
            ]);

        }

        if(! empty($terrenoComun)){

            TerrenosComun::create([
                'terrenos_comunsable_id' => $predioId,
                'terrenos_comunsable_type' => 'App\Models\PredioAvaluo',
                'area_terreno_comun' => $terrenoComun['superficie_comun'],
                'indiviso_terreno' => $terrenoComun['indiviso_terreno'],
                'valor_unitario' => $terrenoComun['valor_unitario'],
                'superficie_proporcional' => $terrenoComun['superficie_proporcional'],
                'valor_terreno_comun' => $terrenoComun['valor_terreno_comun'],
                'creado_por' => $this->user->id
            ]);

        }

        if(! empty($construccion)){

            Construccion::create([
                'construccionable_id' => $predioId,
                'construccionable_type' => 'App\Models\PredioAvaluo',
                'referencia' => $construccion['referencia'],
                'tipo' => $construccion['tipo'],
                'uso' => $construccion['uso'],
                'estado' => $construccion['estado'],
                'calidad' => $construccion['calidad'],
                'niveles' => $construccion['niveles'],
                'superficie' => $construccion['superficie_construccion'],
                'valor_unitario' => $construccion['valor_unitario'],
                'valor_construccion' => $construccion['valor_construccion'],
                'creado_por' => $this->user->id
            ]);

        }

        if(! empty($construccionComun)){

            ConstruccionesComun::create([
                'construcciones_comunsable_id' => $predioId,
                'construcciones_comunsable_type' => 'App\Models\PredioAvaluo',
                'indiviso_construccion' => $construccionComun['indiviso_construccion'],
                'area_comun_construccion' => $construccionComun['superficie_construccion_comun'],
                'superficie_proporcional' => $construccionComun['superficie_proporcional'],
                'valor_clasificacion_construccion' => $construccionComun['valor_unitario'],
                'valor_construccion_comun' => $construccionComun['valor_construccion'],
                'calidad' => $construccionComun['calidad'],
                'estado' => $construccionComun['estado'],
                'uso' => $construccionComun['uso'],
                'tipo' => $construccionComun['tipo'],
                'creado_por' => $this->user->id
            ]);

        }

    }

    public function procesarCoordenadas($latitud, $longitud):array
    {

        $ll = (new Coordenadas())->ll2utm($latitud, $longitud);

        if(!$ll['success']){

            return [
                'lat' => null,
                'lon' => null,
                'yutm' => null,
                'xutm' => null,
                'zutm' => null
            ];

        }else{

            if((float)$ll['attr']['zone'] < 13 || (float)$ll['attr']['zone'] > 14){

                return [
                    'lat' => null,
                    'lon' => null,
                    'yutm' => null,
                    'xutm' => null,
                    'zutm' => null
                ];

            }

            return [
                'lat' => $latitud,
                'lon' => $longitud,
                'xutm' => strval($ll['attr']['x']),
                'yutm' => strval($ll['attr']['y']),
                'zutm' => $ll['attr']['zone']
            ];

        }

    }

}
