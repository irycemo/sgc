<?php

namespace App\Imports;

use App\Constantes\Constantes;
use App\Exceptions\GeneralException;
use App\Models\Avaluo;
use App\Models\Construccion;
use App\Models\ConstruccionesComun;
use App\Models\CuentaAsignada;
use App\Models\File;
use App\Models\ManzanaAsignada;
use App\Models\Oficina;
use App\Models\Predio;
use App\Models\PredioAvaluo;
use App\Models\Terreno;
use App\Models\TerrenosComun;
use App\Services\Coordenadas\Coordenadas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;

class FichaTecnicaSimple implements ToCollection, WithHeadingRow, WithValidation, WithMultipleSheets, SkipsEmptyRows
{

    public $avaluos = [];

    public $data;

    public $predio_origen_id;

    public function __construct(public $valoresConstruccion, public $valoresRusticos){}

    public function rules(): array
    {
        return [
            'registro' => 'required|numeric|min:1',
            'region' => 'required|numeric|min:1',
            'municipio' => 'required|numeric|min:1',
            'localidad' => 'required|numeric|min:1',
            'sector' => 'required|numeric|min:1',
            'zona' => 'required|numeric|min:1',
            'manzana' => 'required|numeric',
            'predio' => 'required|numeric|min:1',
            'edificio' => [ 'required', 'numeric'],
            'departamento' => [ 'required', 'numeric'],
            'tipo_predio' => 'required|numeric|min:1|max:2',
            'oficina' => 'required|numeric|min:1',
            'estado_clave' => 'required',
            'tipo_asentamiento' => ['required', Rule::in(Constantes::TIPO_ASENTAMIENTO)],
            'nombre_asentamiento' => 'required',
            'tipo_vialidad' => ['required', Rule::in(Constantes::TIPO_VIALIDADES)],
            'nombre_vialidad' => 'required|',
            'numero_exterior' => 'required',
            'latitud' => 'nullable',
            'longitud' => 'nullable',
            'clasificacion_zona' => ['required', Rule::in(Constantes::CLASIFICACION_ZONA)],
            'tipo_construccion_dominante' => ['required', Rule::in(Constantes::CONSTRUCCION_DOMINANTE)],
            'superficie_terreno' => 'nullable|numeric|gt:0',
            'valor_unitario_terreno' => 'nullable|numeric|gt:0',
            'superficie_comun' => 'nullable|numeric|gt:0',
            'indiviso_terreno' => 'nullable|numeric|gt:0',
            'valor_unitario' => 'nullable|numeric|gt:0',
            'referencia' => 'nullable',
            'tipo_construccion' => 'nullable|numeric|in:1,2,3',
            'uso_construccion' => 'nullable|numeric|in:1,2,3',
            'estado_construccion' => 'nullable|numeric|in:1,2,3',
            'calidad_construccion' => 'nullable|numeric|in:1,2,3',
            'agua_potable' => ['required', Rule::in(['SI', 'NO'])],
            'drenaje' => ['required', Rule::in(['SI', 'NO'])],
            'pavimento' => ['required', Rule::in(['SI', 'NO'])],
            'energia_electrica' => ['required', Rule::in(['SI', 'NO'])],
            'alumbrado_publico' => ['required', Rule::in(['SI', 'NO'])],
            'banqueta' => ['required', Rule::in(['SI', 'NO'])],
            'niveles' => 'nullable|numeric',
            'superficie_construccion' => 'nullable|numeric|gt:0',
            'superficie_construccion_comun' => 'nullable|numeric|gt:0',
            'indiviso_construccion' => 'nullable|numeric|gt:0',
            'tipo' => 'nullable|numeric|in:1,2,3',
            'uso' => 'nullable|numeric|in:1,2,3',
            'estado' => 'nullable|numeric|in:1,2,3',
            'calidad' => 'nullable|numeric|in:1,2,3',
            'uso_1' =>  ['required', Rule::in(Constantes::USO_PREDIO)],
            'uso_2' =>  ['nullable', Rule::in(Constantes::USO_PREDIO)],
            'uso_3' =>  ['nullable', Rule::in(Constantes::USO_PREDIO)],
            'ubicacion_en_manzana' => ['required', Rule::in(Constantes::UBICACION_PREDIO)],
            'predio_existe_en_padron' => ['required', Rule::in(['SI', 'NO'])],
            'domicilio_para_notificacion' => 'nullable'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $rows = $validator->getData(); // Todas las filas

            $count_predio_origen = 0;

            foreach ($rows as $index => $row) {

                if($row['predio_existe_en_padron'] == 'SI') $count_predio_origen ++;

                $edificio = $row['edificio'] ?? null;

                $departamento = $row['departamento'] ?? null;

                if ($edificio == 0 && $departamento > 0) {

                    throw new GeneralException("En la fila ".($index + 2).": Si edificio es 0, el departamento debe ser 0.");

                }

                if ($departamento == 0 && $edificio > 0) {

                    throw new GeneralException("En la fila ".($index + 2).": Si departamento es 0, el edificio debe ser 0.");

                }

            }

            if($count_predio_origen === 0){

                throw new GeneralException("Es necesario un predio origen.");

            }

            if($count_predio_origen > 1){

                throw new GeneralException("Solo puede haber un predio origen.");

            }

        });

    }

    public function collection(Collection $rows)
    {

        try {

            DB::transaction(function () use($rows){

                foreach ($rows as $key => $row)
                {

                    $key = $key + 3;

                    if($row['predio_existe_en_padron'] == 'SI'){

                        $this->predio_origen_id = $this->revisarPredio($row, $key);

                        $this->validarDisponibilidadAvaluos($row, $key);

                    }else{

                        $this->revisarAsignacionCuentaPredial($row, $key);

                        $this->revisarAsignacionManzana($row, $key);

                        // Revisar manzana asignada

                        $this->validarDisponibilidadPadron($row, $key);

                        $this->validarDisponibilidadAvaluos($row, $key);

                        $this->validarSector($row, $key);

                    }

                    if(isset($row['latitud']) && isset($row['longitud'])){

                        $coordenadas = $this->procesarCoordenadas($row['latitud'], $row['longitud'], $key);

                    }

                    /* TERRENO */
                    if(isset($row['superficie_terreno']) && isset($row['valor_unitario_terreno'])){

                        if($row['tipo_predio'] == 1){

                            $valor_terreno = round((float)$row['superficie_terreno'] * (float)$row['valor_unitario_terreno'], 4);

                        }elseif($row['tipo_predio'] == 2){

                            $valor_terreno = round((float)$row['superficie_terreno'] * (float)$row['valor_unitario_terreno'] / 10000, 4);

                        }

                        $terreno = [
                            'superficie' => $row['superficie_terreno'],
                            'valor_unitario' => $row['valor_unitario_terreno'],
                            'valor_terreno' => $valor_terreno
                        ];

                    }else{

                        $terreno = [];

                    }

                    /* TERRENO COMUN */
                    if(isset($row['superficie_comun']) && isset($row['indiviso_terreno']) && isset($row['valor_unitario'])){

                        $superficie_proporcional = round((float)$row['superficie_comun'] * round((float)$row['indiviso_terreno'], 4) / 100, 4);



                        if($row['tipo_predio'] == 1){

                            $valor_terreno_comun = round($superficie_proporcional * (float)$row['valor_unitario'], 4);

                        }elseif($row['tipo_predio'] == 2){

                            $valor_terreno_comun = round($superficie_proporcional * (float)$row['valor_unitario'] / 10000, 4);

                        }

                        $terrenoComun = [
                            'superficie_comun' => $row['superficie_comun'],
                            'indiviso_terreno' => $row['indiviso_terreno'],
                            'valor_unitario' => $row['valor_unitario'],
                            'superficie_proporcional' => $superficie_proporcional,
                            'valor_terreno_comun' => $valor_terreno_comun
                        ];

                    }else{

                        $terrenoComun = [];

                    }

                    /* CONSTRUCCION */
                    if(isset($row['referencia']) && isset($row['tipo_construccion']) && isset($row['uso_construccion']) && isset($row['estado_construccion']) && isset($row['calidad_construccion']) && isset($row['niveles']) && isset($row['superficie_construccion'])){

                        $valorUnitario = $this->valoresConstruccion->where('tipo', $row['tipo_construccion'])->where('uso', $row['uso_construccion'])->where('calidad', $row['calidad_construccion'])->where('estado', $row['estado_construccion'])->first()->valor;

                        $valor_construccion = round($valorUnitario * (float)$row['superficie_construccion'], 4);

                        $construccion = [
                            'referencia' => $row['referencia'],
                            'tipo' => $row['tipo_construccion'],
                            'uso' => $row['uso_construccion'],
                            'calidad' => $row['calidad_construccion'],
                            'estado' => $row['estado_construccion'],
                            'niveles' => $row['niveles'],
                            'superficie_construccion' => $row['superficie_construccion'],
                            'valor_unitario' => $valorUnitario,
                            'valor_construccion' => $valor_construccion,
                        ];

                    }else{

                        $construccion = [];

                    }

                    /* CONSTRUCCION COMUN */
                    if(isset($row['referencia']) && isset($row['tipo']) && isset($row['uso']) && isset($row['estado']) && isset($row['calidad']) && isset($row['niveles']) && isset($row['superficie_construccion_comun']) && isset($row['indiviso_construccion'])){

                        $superficie_proporcional_construccion = (float)$row['superficie_construccion_comun'] * (float)$row['indiviso_construccion'] / 100;

                        $valorUnitario = $this->valoresConstruccion->where('tipo', $row['tipo'])->where('uso', $row['uso'])->where('calidad', $row['calidad'])->where('estado', $row['estado'])->first()->valor;

                        $valor_construccion_comun = round($valorUnitario * $superficie_proporcional_construccion, 4);

                        $construccionComun = [
                            'referencia' => $row['referencia'],
                            'tipo' => $row['tipo'],
                            'uso' => $row['uso'],
                            'calidad' => $row['calidad'],
                            'estado' => $row['estado'],
                            'niveles' => $row['niveles'],
                            'indiviso_construccion' => $row['indiviso_construccion'],
                            'superficie_construccion_comun' => $row['superficie_construccion_comun'],
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

                    if($row['edificio'] > 0){

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

                        throw new GeneralException('El valor catastral no puede ser 0 en la fila. ' . $key);

                    }

                    if($row['ubicacion_en_manzana'] == 'ESQUINA'){

                        $valor_esquina = $terreno['superficie'] * (0.10);

                        $valorCatastral = $valorCatastral + $valor_esquina;

                    }

                    $predio = $this->crearPredio($row, $coordenadas, $terreno, $terrenoComun, $construccion, $construccionComun, $superficie_total_terreno, $superficie_total_construccion, $valorCatastral);

                    $this->procesarPropietariosColindancias($predio->id);

                    $this->procesarRelaciones($terreno, $terrenoComun, $construccion, $construccionComun, $predio->id);

                    $avaluo = $this->crearAvaluo($row, $predio->id);

                    $predio->audits()->latest()->first()->update(['tags' => 'Se genera predio mediante ficha tecnica simple apartir de avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario]);

                    $avaluo->audits()->latest()->first()->update(['tags' => 'Generó avalúo mediante ficha tecnica simple con folio: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario]);

                    $this->avaluos[] = $avaluo->load('predioAvaluo.propietarios.persona');

                }

                $this->data = $this->avaluos;

            });

        } catch (GeneralException $ex) {

            throw new GeneralException($ex->getMessage());

        } catch (\Throwable $th) {

            Log::error("Error al importar ficha técnica usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            throw new GeneralException("Hubo un error al importar ficha técnica.");

        }

    }

    public function revisarPredio($row, $key):int
    {

        $predioCompleto = Predio::where('estado', $row['estado_clave'])
                                    ->where('region_catastral', $row['region'])
                                    ->where('municipio', $row['municipio'])
                                    ->where('zona_catastral', $row['zona'])
                                    ->where('localidad', $row['localidad'])
                                    ->where('sector', $row['sector'])
                                    ->where('manzana', $row['manzana'])
                                    ->where('predio', $row['predio'])
                                    ->where('edificio', $row['edificio'])
                                    ->where('departamento', $row['departamento'])
                                    ->where('oficina', $row['oficina'])
                                    ->where('tipo_predio', $row['tipo_predio'])
                                    ->where('numero_registro', $row['registro'])
                                    ->first();

        if(! $predioCompleto){

            throw new GeneralException("El predio no existe en el padrón, verifique. " . 'Línea: ' . $key);

        }

        return $predioCompleto->id;

    }

    public function revisarAsignacionCuentaPredial($row, $key):void
    {

        $cuentaAsignada = CuentaAsignada::where('localidad', $row['localidad'])
                                        ->where('oficina', $row['oficina'])
                                        ->where('tipo_predio', $row['tipo_predio'])
                                        ->where('numero_registro', $row['registro'])
                                        ->where('asignado_a', auth()->id())
                                        ->first();

        if(!$cuentaAsignada) throw new GeneralException("No tienes asignada la cuenta: " . $row['localidad'] . '-' . $row['oficina'] . '-' . $row['tipo'] . '-' . $row['registro']);

    }

    public function revisarAsignacionManzana($row, $key):void
    {

        $cuentaAsignada = ManzanaAsignada::where('municipio', $row['municipio'])
                                        ->where('zona', $row['zona'])
                                        ->where('localidad', $row['localidad'])
                                        ->where('sector', $row['sector'])
                                        ->where('manzana', $row['manzana'])
                                        ->where('asignado_a', auth()->id())
                                        ->first();

        if(!$cuentaAsignada) throw new GeneralException("No tienes asignada la manzana: " . $row['municipio'] . '-' . $row['zona'] . '-' . $row['localidad'] . '-' . $row['sector'] . '-' . $row['manzana'] . '. Linea ' . $key);

    }

    public function validarDisponibilidadPadron($row, $key):void
    {

        $predioCompleto = Predio::where('estado', $row['estado_clave'])
                                    ->where('region_catastral', $row['region'])
                                    ->where('municipio', $row['municipio'])
                                    ->where('zona_catastral', $row['zona'])
                                    ->where('localidad', $row['localidad'])
                                    ->where('sector', $row['sector'])
                                    ->where('manzana', $row['manzana'])
                                    ->where('predio', $row['predio'])
                                    ->where('edificio', $row['edificio'])
                                    ->where('departamento', $row['departamento'])
                                    ->where('oficina', $row['oficina'])
                                    ->where('tipo_predio', $row['tipo_predio'])
                                    ->where('numero_registro', $row['registro'])
                                    ->first();

        if($predioCompleto){

            throw new GeneralException("El predio ya existe en el padrón, verifique. " . 'Línea: ' . $key);

        }else{

            $cuentaPredial = Predio::where('localidad', $row['localidad'])
                                        ->where('oficina', $row['oficina'])
                                        ->where('tipo_predio', $row['tipo_predio'])
                                        ->where('numero_registro', $row['registro'])
                                        ->first();

            if($cuentaPredial){

                throw new GeneralException("La cuenta predial ya existe en el padrón con otra clave catastral, verifique. " . 'Línea: ' . $key);

            }

            $claveCatastral = Predio::where('estado', $row['estado_clave'])
                                        ->where('region_catastral', $row['region'])
                                        ->where('municipio', $row['municipio'])
                                        ->where('zona_catastral', $row['zona'])
                                        ->where('localidad', $row['localidad'])
                                        ->where('sector', $row['sector'])
                                        ->where('manzana', $row['manzana'])
                                        ->where('predio', $row['predio'])
                                        ->where('edificio', $row['edificio'])
                                        ->where('departamento', $row['departamento'])
                                        ->first();

            if($claveCatastral){

                throw new GeneralException("La clave catastral ya existe en el padrón con otra cuenta predial, verifique. " . 'Línea: ' . $key);

            }

        }

    }

    public function validarDisponibilidadAvaluos($row, $key):void
    {

        $predioCompletoAvaluo = PredioAvaluo::where('status', 'activo')
                                                ->where('estado', $row['estado_clave'])
                                                ->where('region_catastral', $row['region'])
                                                ->where('municipio', $row['municipio'])
                                                ->where('zona_catastral', $row['zona'])
                                                ->where('localidad', $row['localidad'])
                                                ->where('sector', $row['sector'])
                                                ->where('manzana', $row['manzana'])
                                                ->where('edificio', $row['edificio'])
                                                ->where('departamento', $row['departamento'])
                                                ->where('oficina', $row['oficina'])
                                                ->where('tipo_predio', $row['tipo_predio'])
                                                ->where('oficina', $row['oficina'])
                                                ->where('numero_registro', $row['registro'])
                                                ->first();

        if($predioCompletoAvaluo){

            $avaluo = Avaluo::where('predio_avaluo', $predioCompletoAvaluo->id)->first();

            if($avaluo){

                $this->borrarAvaluo($avaluo);

            }else{

                throw new GeneralException("Ya existe en un avaluo del predio " . $predioCompletoAvaluo->cuentaPredial() . ", verifique. " . 'Línea: ' . $key);

            }

        }else{

            $cuentaPredialAvaluo = PredioAvaluo::where('status', 'activo')
                                                ->where('localidad', $row['localidad'])
                                                ->where('oficina', $row['oficina'])
                                                ->where('tipo_predio', $row['tipo_predio'])
                                                ->where('numero_registro', $row['registro'])
                                                ->first();

            if($cuentaPredialAvaluo){

                throw new GeneralException("Ya existe en un avaluo del predio " . $cuentaPredialAvaluo->cuentaPredial() . ", verifique. " . 'Línea: ' . $key);

            }

            $claveCatastralAvaluo = PredioAvaluo::where('status', 'activo')
                                                    ->where('status', 'activo')
                                                    ->where('estado', $row['estado_clave'])
                                                    ->where('region_catastral', $row['region'])
                                                    ->where('municipio', $row['municipio'])
                                                    ->where('zona_catastral', $row['zona'])
                                                    ->where('localidad', $row['localidad'])
                                                    ->where('sector', $row['sector'])
                                                    ->where('manzana', $row['manzana'])
                                                    ->where('predio', $row['predio'])
                                                    ->where('edificio', $row['edificio'])
                                                    ->where('departamento', $row['departamento'])
                                                    ->first();

            if($claveCatastralAvaluo){

                throw new GeneralException("Ya existe en un avaluo del predio " . $claveCatastralAvaluo->cuentaPredial() . ", verifique. " . 'Línea: ' . $key);

            }

        }

    }

    public function validarSector($row, $key):void
    {

        $oficina = Oficina::where('localidad', $row['localidad'])
                            ->where('oficina', $row['oficina'])
                            ->first();

        if(!$oficina){

            throw new GeneralException("No se encontraron oficinas con los datos ingresados. " . 'Línea: ' . $key);

        }

        $sectores = json_decode($oficina->sectores, true);

        if(is_null($sectores)){

            throw new GeneralException("La oficina no tiene sectores. " . 'Línea: ' . $key);

        }

        if(!in_array($row['sector'], $sectores)){

            throw new GeneralException("El sector no corresponde a la zona. " . 'Línea: ' . $key);

        }

        if($oficina->municipio != $row['municipio']){

            throw new GeneralException("El municipio no corresponde a la oficina. " . 'Línea: ' . $key);

        }

    }

    public function procesarCoordenadas($lat, $lon, $linea):array
    {

        $ll = (new Coordenadas())->ll2utm($lat, $lon);

            if(!$ll['success']){

                throw new GeneralException($ll['msg'] . " en la línea " . $í);


            }else{

                if((float)$ll['attr']['zone'] < 13 || (float)$ll['attr']['zone'] > 14){

                    throw new GeneralException("Las coordenadas no corresponden a una zona válida en la línea " . $linea);

                    $lat = null;
                    $lon = null;

                }

                return $array = [
                    'xutm' => strval($ll['attr']['x']),
                    'yutm' => strval($ll['attr']['y']),
                    'zutm' => $ll['attr']['zone']
                ];

            }

    }

    public function crearPredio($row, $coordenadas, $terreno, $terrenoComun, $construccion, $construccionComun, $superficie_total_terreno, $superficie_total_construccion, $valorCatastral): PredioAvaluo
    {

        $valor_total_terreno = ($terreno['valor_terreno'] ?? 0) + ($terrenoComun['valor_terreno_comun'] ?? 0);

        $valor_total_construccion = ($construccion['valor_construccion'] ?? 0) + ($construccionComun['valor_construccion'] ?? 0);

        return PredioAvaluo::create([
            'status' => 'activo',
            'estado' => $row['estado_clave'],
            'region_catastral' => $row['region'],
            'municipio' => $row['municipio'],
            'zona_catastral' => $row['zona'],
            'localidad' => $row['localidad'],
            'sector' => $row['sector'],
            'manzana' => $row['manzana'],
            'predio' => $row['predio'],
            'edificio' => $row['edificio'],
            'departamento' => $row['departamento'],
            'oficina' => $row['oficina'],
            'tipo_predio' => $row['tipo_predio'],
            'numero_registro' => $row['registro'],
            'tipo_vialidad' => $row['tipo_vialidad'],
            'tipo_asentamiento' => $row['tipo_asentamiento'],
            'nombre_vialidad' => $row['nombre_vialidad'],
            'numero_exterior' => $row['numero_exterior'],
            'numero_exterior_2' => $row['numero_exterior_2'],
            'numero_adicional' => $row['numero_adicional'],
            'numero_adicional_2' => $row['numero_adicional_2'],
            'numero_interior' => $row['numero_interior'],
            'nombre_asentamiento' => $row['nombre_asentamiento'],
            'codigo_postal' => $row['codigo_postal'],
            'lote_fraccionador' => $row['lote_fraccionador'],
            'manzana_fraccionador' => $row['manzana_fraccionador'],
            'etapa_fraccionador' => $row['etapa_fraccionador'],
            'nombre_predio' => $row['predio_rustico_antecedente'],
            'nombre_edificio' => $row['nombre_edificio'],
            'clave_edificio' => $row['clave_edificio'],
            'departamento_edificio' => $row['departamento_edificio'],
            'xutm' => $coordenadas['xutm'] ?? null,
            'yutm' => $coordenadas['yutm'] ?? null,
            'zutm' => $coordenadas['zutm'] ?? null,
            'uso_1' => $row['uso_1'],
            'uso_2' => $row['uso_2'],
            'uso_3' => $row['uso_3'],
            'ubicacion_en_manzana' => $row['ubicacion_en_manzana'],
            'lon'=> $row['longitud'],
            'lat'=> $row['latitud'],
            'observaciones' => $row['observaciones'],
            'superficie_terreno' => $terreno['superficie'] ?? null,
            'valor_total_terreno' => $valor_total_terreno,
            'valor_total_construccion' => $valor_total_construccion,
            'superficie_construccion' => $construccion['superficie_construccion'] ?? null,
            'area_comun_terreno' => $terrenoComun['superficie'] ?? null,
            'valor_terreno_comun' => $terrenoComun['valor_terreno_comun'] ?? null,
            'area_comun_construccion' => $construccionComun['superficie_construccion_comun'] ?? null,
            'valor_construccion_comun' => $construccionComun['valor_construccion'] ?? null,
            'domicilio_notificacion' => $row['domicilio_para_notificacion'],
            'superficie_total_terreno' => $superficie_total_terreno,
            'superficie_total_construccion' => $superficie_total_construccion,
            'valor_catastral' => $valorCatastral,
            'actualizado_por' => auth()->id()
        ]);

    }

    public function procesarPropietariosColindancias($predio_nuevo):void
    {

        $predio_origen = Predio::find($this->predio_origen_id);

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

    public function crearAvaluo($row, $predioId):Avaluo
    {

        $avaluo =  Avaluo::create([
            'predio_avaluo' => $predioId,
            'predio' => $this->predio_origen_id,
            'año' => now()->format('Y'),
            'folio' => (Avaluo::where('año', now()->format('Y'))->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1,
            'usuario' => auth()->user()->clave,
            'estado' => 'nuevo',
            'clasificacion_zona' => $row['clasificacion_zona'],
            'construccion_dominante' => $row['tipo_construccion_dominante'],
            'asignado_a' => auth()->id(),
            'creado_por' => auth()->id(),
            'oficina_id' => auth()->user()->oficina_id,
            'agua' => $row['agua_potable'] == 'SI' ? 1 : 0,
            'drenaje' => $row['drenaje']  == 'SI' ? 1 : 0,
            'pavimento' => $row['pavimento']  == 'SI' ? 1 : 0,
            'energia_electrica' => $row['energia_electrica']  == 'SI' ? 1 : 0,
            'alumbrado_publico' => $row['alumbrado_publico']  == 'SI' ? 1 : 0,
            'banqueta' => $row['banqueta']  == 'SI' ? 1 : 0,
            'observaciones' => $row['observaciones']
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
                'creado_por' => auth()->id()
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
                'creado_por' => auth()->id()
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
                'creado_por' => auth()->id()
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
                'creado_por' => auth()->id()
            ]);

        }

    }

    public function borrarAvaluo(Avaluo $avaluo){

        $predio = $avaluo->predioAvaluo;

        $predio->propietarios()->delete();

        $predio->colindancias()->delete();

        $predio->terrenosComun()->delete();

        $predio->construccionesComun()->delete();

        $predio->construcciones()->delete();

        $predio->terrenos()->delete();

        $avaluo->bloques()->delete();

        $files = File::where('fileable_id', $avaluo->id)->where('fileable_type', 'App\Models\Avaluo')->get();

        foreach ($files as $file) {

            if(app()->isProduction()){

                if (Storage::disk('s3')->exists(config('services.ses.ruta_avaluos_fotos') . $file->url)) {

                    Storage::disk('s3')->delete(config('services.ses.ruta_avaluos_fotos') . $file->url);

                }

            }else{

                if (Storage::disk('avaluos')->exists($file->url)) {

                    Storage::disk('avaluos')->delete($file->url);

                }

            }

        }

        $avaluo->delete();

        $predio->delete();

    }

    public function headingRow(): int
    {
        return 2;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

}
