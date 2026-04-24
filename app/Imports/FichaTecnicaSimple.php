<?php

namespace App\Imports;

use App\Constantes\Constantes;
use App\Exceptions\GeneralException;
use App\Models\Avaluo;
use App\Models\CuentaAsignada;
use App\Models\Oficina;
use App\Models\Predio;
use App\Models\PredioAvaluo;
use App\Services\Coordenadas\Coordenadas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;

class FichaTecnicaSimple implements ToCollection
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
            'manzana' => 'required|numeric|min:1',
            'predio' => 'required|numeric|min:1',
            'edificio' => [ 'required', 'numeric'],
            'departamento' => [ 'required', 'numeric'],
            'tipo' => 'required|numeric|min:1|max:2',
            'oficina' => 'required|numeric|min:1',
            'estado' => 'required',
            'tipo_asentamiento' => ['required', Rule::in(Constantes::TIPO_ASENTAMIENTO)],
            'nombre_asentamiento' => 'required',
            'tipo_vialidad' => ['required', Rule::in(Constantes::TIPO_VIALIDADES)],
            'nombre_vialidad' => 'required|',
            'numero_exterior' => 'required',
            'latitud' => 'nullable',
            'longitud' => 'nullable',
            'clasificacion_zona' => ['required', Rule::in(Constantes::CLASIFICACION_ZONA)],
            'tipo_construccion_dominante' => ['required', Rule::in(Constantes::CONSTRUCCION_DOMINANTE)],
            'superficie_terreno' => 'nullable',
            'valor_unitario_terreno' => 'nullable',
            'construcciones' => 'nullable',
            'terrenos_comun' => 'nullable',
            'construcciones_comun' => 'nullable',
            'uso_1' =>  ['required', Rule::in(Constantes::USO_PREDIO)],
            'uso_2' =>  ['nullable', Rule::in(Constantes::USO_PREDIO)],
            'uso_3' =>  ['nullable', Rule::in(Constantes::USO_PREDIO)],
            'ubicacion_manzana' => ['required', Rule::in(Constantes::UBICACION_PREDIO)],
            'predio_existe_en_padron' => ['required', Rule::in(['SI', 'NO'])],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $rows = $validator->getData(); // Todas las filas

            foreach ($rows as $index => $row) {

                $edificio = $row['edificio'] ?? null;

                $departamento = $row['departamento'] ?? null;

                if ($edificio == 0 && $departamento > 0) {

                    throw new GeneralException("En la fila ".($index + 2).": Si edificio es 0, el departamento debe ser 0.");

                }

                if ($departamento == 0 && $edificio > 0) {

                    throw new GeneralException("En la fila ".($index + 2).": Si departamento es 0, el edificio debe ser 0.");

                }

                if(isset($row['terrenos_comun'])){

                    $terrenos_comun[] = explode(':', $row['terrenos_comun']);

                }

            }

            if(isset($row['terrenos_comun'])){

                $aux = $terrenos_comun[0][0];

                foreach($terrenos_comun as $terreno){

                    if($terreno[0] === '') continue;

                    if($terreno[0] != $aux){

                        throw new GeneralException('Las áreas de los terrenos en común deben ser iguales.');

                    }

                }

            }

            //VAlidacion de predio origen

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

                    }else{

                        $this->revisarAsignacionCuentaPredia($row, $key);

                        // Revisar manzana asignada

                        $this->validarDisponibilidad($row, $key);

                        $this->validarSector($row, $key);

                    }

                    if(isset($row['latitud']) && isset($row['longitud'])){

                        $coordenadas = $this->procesarCoordenadas($row['latitud'], $row['longitud'], $key);

                    }

                    /* TERRENO */
                    if(isset($row['superficie_terreno']) && isset($row['valor_unitario_terreno'])){

                        if($row['tipo'] == 1){

                            $valor_terreno = (float)$row['superficie_terreno'] * (float)$row['valor_unitario_terreno'];

                        }elseif($row['tipo'] == 2){

                            $valor_terreno = (float)$row['superficie_terreno'] * (float)$row['valor_unitario_terreno'] / 10000;

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
                    if(isset($row['superficie_comun']) && isset($row['indiviso']) && isset($row['valor_unitario'])){

                        $superficie_proporcional = (float)$row['superficie_comun'] * (float)$row['indiviso'] / 100;

                        if($row['tipo'] == 1){

                            $valor_terreno_comun = $superficie_proporcional * (float)$row['valor_unitario'];

                        }elseif($row['tipo'] == 2){

                            $valor_terreno_comun = $superficie_proporcional * (float)$row['valor_unitario'] / 10000;

                        }

                        $terrenoComun = [
                            'superficie_comun' => $row['superficie_comun'],
                            'indiviso' => $row['indiviso'],
                            'valor_unitario' => $row['valor_unitario'],
                            'superficie_proporcional' => $superficie_proporcional,
                            'valor_terreno_comun' => $valor_terreno_comun
                        ];

                    }else{

                        $terrenoComun = [];

                    }

                    /* CONSTRUCCION */
                    if(isset($row['referencia']) && isset($row['tipo']) && isset($row['uso']) && isset($row['estado']) && isset($row['calidad']) && isset($row['niveles']) && isset($row['superficie'])){

                        $valorUnitario = $this->valoresConstruccion->where('tipo', $row['tipo'])->where('uso', $row['uso'])->where('calidad', $row['calidad'])->where('estado', $row['estado'])->first()->valor;

                        $valor_construccion = $valorUnitario * (float)$row['superficie'];

                        $construccion = [
                            'referencia' => $row['referencia'],
                            'tipo' => $row['tipo'],
                            'uso' => $row['uso'],
                            'calidad' => $row['calidad'],
                            'estado' => $row['estado'],
                            'niveles' => $row['niveles'],
                            'superficie' => $row['superficie'],
                            'valor_unitario' => $valorUnitario,
                            'valor_construccion' => $valor_construccion,
                        ];

                    }else{

                        $construccion = [];

                    }

                    /* CONSTRUCCION COMUN */
                    if(isset($row['referencia']) && isset($row['tipo']) && isset($row['uso']) && isset($row['estado']) && isset($row['calidad']) && isset($row['niveles']) && isset($row['superficie_comun']) && isset($row['indiviso_construccion'])){

                        $superficie_proporcional_construccion = (float)$row['superficie_comun'] * (float)$row['indiviso_construccion'];

                        $valorUnitario = $this->valoresConstruccion->where('tipo', $row['tipo'])->where('uso', $row['uso'])->where('calidad', $row['calidad'])->where('estado', $row['estado'])->first()->valor;

                        $valor_construccion = $valorUnitario * $superficie_proporcional_construccion;

                        $construccionComun = [
                            'referencia' => $row['referencia'],
                            'tipo' => $row['tipo'],
                            'uso' => $row['uso'],
                            'calidad' => $row['calidad'],
                            'estado' => $row['estado'],
                            'niveles' => $row['niveles'],
                            'superficie_comun' => $row['superficie_comun'],
                            'valor_unitario' => $valorUnitario,
                            'superficie_proporcional' => $superficie_proporcional_construccion,
                            'valor_construccion' => $valor_construccion,
                        ];

                    }else{

                        $construccionComun = [];

                    }

                    $superficie_total_terreno = 0;

                    if(isset($terreno['superficie'])){

                        $superficie_total_terreno = $terreno['superficie'];

                    }

                    $superficie_total_construccion = 0;

                    if(isset($construccion['superficie'])){

                        $superficie_total_construccion = $construccion['superficie'];

                    }

                    if($row['edificio'] > 0){

                        if(isset($terrenoComun['superficie_comun'])){

                            $superficie_total_terreno = $superficie_total_terreno + $terrenoComun['superficie_proporcional'];

                        }

                        if(isset($construccionComun['superficie_comun'])){

                            $superficie_total_construccion = $superficie_total_construccion + $construccionComun['superficie_proporcional'];

                        }

                    }

                    $valorCatastral = $terreno['valor_terreno']
                                            + $terrenoComun['valor_terreno_comun']
                                            + $construccion['valor_construccion']
                                            + $construccionComun['valor_construccion'];

                    if($row['ubicacion_manzana'] == 'ESQUINA'){

                        $valor_esquina = $terreno['superficie'] * (0.10);

                        $valorCatastral = $valorCatastral + $valor_esquina;

                    }

                    $predio = $this->crearPredio($row, $coordenadas, $terreno, $terrenoComun, $construccion, $construccionComun, $superficie_total_terreno, $superficie_total_construccion, $valorCatastral);

                    $this->procesarPropietarios($predio->id);

                    $avaluo = $this->crearAvaluo($row, $predio->id);

                    $predio->audits()->latest()->first()->update(['tags' => 'Se genera predio apartir de avalúo: ' . $avaluo->año . '-' . $avaluo->folio]);

                    $avaluo->audits()->latest()->first()->update(['tags' => 'Generó avalúo con folio: ' . $avaluo->año . '-' . $avaluo->folio]);

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

        $predioCompleto = Predio::where('estado', $row['estado'])
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
                                    ->where('tipo_predio', $row['tipo'])
                                    ->where('numero_registro', $row['registro'])
                                    ->first();

        if(! $predioCompleto){

            throw new GeneralException("El predio no existe en el padrón, verifique. " . 'Línea: ' . $key);

        }

        return $predioCompleto->id;

    }

    public function revisarAsignacionCuentaPredia($row, $key):void
    {

        $cuentaAsignada = CuentaAsignada::where('localidad', $row['localidad'])
                                        ->where('oficina', $row['oficina'])
                                        ->where('tipo_predio', $row['tipo'])
                                        ->where('numero_registro', $row['registro'])
                                        ->where('asignado_a', auth()->id())
                                        ->first();

        if(!$cuentaAsignada) throw new GeneralException("No tienes asignada la cuenta: " . $row['localidad'] . '-' . $row['oficina'] . '-' . $row['tipo'] . '-' . $row['registro']);

    }

    public function validarDisponibilidad($row, $key):void
    {

        $predioCompleto = Predio::where('estado', $row['estado'])
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
                                    ->where('tipo_predio', $row['tipo'])
                                    ->where('numero_registro', $row['registro'])
                                    ->first();

        if($predioCompleto){

            throw new GeneralException("El predio ya existe en el padrón, verifique. " . 'Línea: ' . $key);

        }else{

            $cuentaPredial = Predio::where('localidad', $row['localidad'])
                                        ->where('oficina', $row['oficina'])
                                        ->where('tipo_predio', $row['tipo'])
                                        ->where('numero_registro', $row['registro'])
                                        ->first();

            if($cuentaPredial){

                throw new GeneralException("La cuenta predial ya existe en el padrón con otra clave catastral, verifique. " . 'Línea: ' . $key);

            }

            $claveCatastral = Predio::where('estado', $row['estado'])
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

        $predioCompletoAvaluo = PredioAvaluo::where('estado', $row['estado'])
                                                ->where('region_catastral', $row['region'])
                                                ->where('municipio', $row['municipio'])
                                                ->where('zona_catastral', $row['zona'])
                                                ->where('localidad', $row['localidad'])
                                                ->where('sector', $row['sector'])
                                                ->where('manzana', $row['manzana'])
                                                ->where('edificio', $row['edificio'])
                                                ->where('departamento', $row['departamento'])
                                                ->where('oficina', $row['oficina'])
                                                ->where('tipo_predio', $row['tipo'])
                                                ->where('oficina', $row['oficina'])
                                                ->where('tipo_predio', $row['tipo'])
                                                ->where('numero_registro', $row['registro'])
                                                ->first();

        if($predioCompletoAvaluo){

            throw new GeneralException("El predio ya existe en avaluos, verifique. " . 'Línea: ' . $key);

        }else{

            $cuentaPredialAvaluo = PredioAvaluo::where('localidad', $row['localidad'])
                                                ->where('oficina', $row['oficina'])
                                                ->where('tipo_predio', $row['tipo'])
                                                ->where('numero_registro', $row['registro'])
                                                ->first();

            if($cuentaPredialAvaluo){

                throw new GeneralException("La cuenta predial ya existe en avaluos con otra clave catastral, verifique. " . 'Línea: ' . $key);

            }

            $claveCatastralAvaluo = PredioAvaluo::where('status', 'activo')
                                                    ->where('estado', $row['estado'])
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

                throw new GeneralException("La clave catastral ya existe en avaluos con otra cuenta predial, verifique. " . 'Línea: ' . $key);

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

        return PredioAvaluo::create([
            'status' => 'activo',
            'estado' => $row['estado'],
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
            'tipo_predio' => $row['tipo'],
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
            'ubicacion_en_manzana' => $row['ubicacion_manzana'],
            'lon'=> $row['longitud'],
            'lat'=> $row['latitud'],
            'observaciones' => $row['observaciones'],
            'superficie_terreno' => $terreno['superficie'] ?? null,
            'valor_total_terreno' => $terreno['valor_terreno'] ?? null,
            'superficie_construccion' => $construccion['superficie'] ?? null,
            'area_comun_terreno' => $terrenoComun['superficie'] ?? null,
            'valor_terreno_comun' => $terrenoComun['valor_terreno_comun'] ?? null,
            'area_comun_construccion' => $construccionComun['superficie'] ?? null,
            'valor_construccion_comun' => $construccionComun['valor_construccion'] ?? null,

            'superficie_total_terreno' => $superficie_total_terreno,
            'superficie_total_construccion' => $superficie_total_construccion,
            'valor_catastral' => $valorCatastral,
            'actualizado_por' => auth()->id()
        ]);

    }

    public function procesarPropietarios($predio_nuevo){

        $predio_origen = Predio::find($this->predio_origen_id);

        $predio_nuevo = PredioAvaluo::find($predio_nuevo);

        foreach ($predio_origen->propietarios as $propietario) {

            $propietario_nuevo = $propietario->replicate();

            $propietario_nuevo->propietarioable_id = $predio_nuevo->id;
            $propietario_nuevo->propietarioable_type = 'App\Models\PredioAvaluo';

            $propietario_nuevo->save();

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
            'observaciones' => $row['observaciones']
        ]);

        return $avaluo;

    }

}
