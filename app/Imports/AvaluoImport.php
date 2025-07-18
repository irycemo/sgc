<?php

namespace App\Imports;

use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\Oficina;
use App\Models\Persona;
use App\Models\Terreno;
use App\Models\Colindancia;
use App\Models\Propietario;
use App\Models\Construccion;
use App\Models\PredioAvaluo;
use App\Models\TerrenosComun;
use App\Constantes\Constantes;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\ConstruccionesComun;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Models\CuentaAsignada;
use App\Services\Coordenadas\Coordenadas;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AvaluoImport implements ToCollection, WithHeadingRow, WithValidation, WithMultipleSheets, SkipsEmptyRows
{

    public $avaluos = [];

    public $data;

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
            'edificio' => 'required|numeric|min:0',
            'departamento' => 'required|numeric|min:0',
            'tipo' => 'required|numeric|min:1|max:2',
            'oficina' => 'required|numeric|min:1',
            'estado' => 'required',
            'rfc' => [
                'required',
                'regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/',
            ],
            'curp' => [
                'nullable',
                'regex:/^[A-Z]{1}[AEIOUX]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/i',
            ],
            'ap_paterno' => 'required_if:tipo,FÍSICA',
            'ap_materno' => 'required_if:tipo,FÍSICA',
            'nombre' => 'required_if:tipo,FÍSICA',
            'razon_social' => 'required_if:tipo,MORAL',
            'tipo_persona' => ['required', Rule::in(['FÍSICA', 'MORAL'])],
            'porcentaje' => 'required|numeric|min:1|max:100',
            'sociedad' => ['required', Rule::in(['SI', 'NO'])],
            'tipo_asentamiento' => ['required', Rule::in(Constantes::TIPO_ASENTAMIENTO)],
            'nombre_asentamiento' => 'required',
            'tipo_vialidad' => ['required', Rule::in(Constantes::TIPO_VIALIDADES)],
            'nombre_vialidad' => 'required|',
            'numero_exterior' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
            'colindancias' => 'required',
            'clasificacion_zona' => ['required', Rule::in(Constantes::CLASIFICACION_ZONA)],
            'tipo_construccion_dominante' => ['required', Rule::in(Constantes::CONSTRUCCION_DOMINANTE)],
            'agua_potable' => ['required', Rule::in(['SI', 'NO'])],
            'drenaje' => ['required', Rule::in(['SI', 'NO'])],
            'pavimento' => ['required', Rule::in(['SI', 'NO'])],
            'energia_electrica' => ['required', Rule::in(['SI', 'NO'])],
            'alumbrado_publico' => ['required', Rule::in(['SI', 'NO'])],
            'banqueta' => ['required', Rule::in(['SI', 'NO'])],
            'cimentacion' => ['required', Rule::in(Constantes::CIMENTACION)],
            'estructura' => ['required', Rule::in(Constantes::ESTRUCTURAS)],
            'muros' => ['required', Rule::in(Constantes::MUROS)],
            'entrepisos' => ['required', Rule::in(Constantes::ENTREPISOS)],
            'techo' => ['required', Rule::in(Constantes::TECHOS)],
            'plafones' => ['required', Rule::in(Constantes::PLAFONES)],
            'vidrieria' => ['required', Rule::in(Constantes::VIDRIERIA)],
            'lambrines' => ['required', Rule::in(Constantes::LAMBRINES)],
            'pisos' => ['required', Rule::in(Constantes::PISOS)],
            'herreria' => ['required', Rule::in(Constantes::HERRERIA)],
            'pintura' => ['required', Rule::in(Constantes::PINTURA)],
            'carpinteria' => ['required', Rule::in(Constantes::CARPINTERIA)],
            'aplanados' => ['required', Rule::in(Constantes::APLANADOS)],
            'recubrimiento_especial' => ['required', Rule::in(Constantes::RECUBRIMIENTO_ESPECIAL)],
            'hidraulica' => ['required', Rule::in(Constantes::HIDRAULICA)],
            'sanitaria' => ['required', Rule::in(Constantes::SANITARIA)],
            'electrica' => ['required', Rule::in(Constantes::ELECTRICA)],
            'gas' => ['required', Rule::in(Constantes::GAS)],
            'especiales' => ['required', Rule::in(Constantes::ESPECIALES)],
            'terrenos' => 'nullable',
            'construcciones' => 'nullable',
            'terrenos_comun' => 'nullable',
            'construcciones_comun' => 'nullable',
            'uso_1' =>  ['required', Rule::in(Constantes::USO_PREDIO)],
            'uso_2' =>  ['nullable', Rule::in(Constantes::USO_PREDIO)],
            'uso_3' =>  ['nullable', Rule::in(Constantes::USO_PREDIO)],
            'ubicacion_manzana' => ['required', Rule::in(Constantes::UBICACION_PREDIO)],
        ];
    }

    public function collection(Collection $rows){

        try {

            DB::transaction(function () use($rows){


                foreach ($rows as $key => $row)
                {

                    $key = $key + 3;

                    $this->revisarAsignacionCuentaPredia($row, $key);

                    $this->validarDisponibilidad($row, $key);

                    $this->validarSector($row, $key);

                    $coordenadas = $this->procesarCoordenadas($row['latitud'], $row['longitud'], $key);

                    $colindancias = $this->procesarColindacias($row['colindancias'], $key);

                    /* $terrenos = $this->procesarTerrenos($row['terrenos'], $row['tipo'], $key); */

                    if(isset($row['terrenos'])){

                        $terrenos = $this->procesarTerrenos($row['terrenos'], $row['tipo'], $key);

                        $sumValorTerrenos = $terrenos->sum('valor_terreno');

                        $sumSuperficieTerrenos = $terrenos->sum('superficie');

                    }else{

                        $terrenos = null;

                        $sumValorTerrenos = 0;

                        $sumSuperficieTerrenos = 0;

                    }

                    if(isset($row['construcciones'])){

                        $construcciones = $this->procesarConstrucciones($row['construcciones'], $key);

                        $sumValorConstrucciones = $construcciones->sum('valor_construccion');

                        $sumSuperficieConstrucciones = $construcciones->sum('superficie');

                    }else{

                        $construcciones = null;

                        $sumValorConstrucciones = 0;

                        $sumSuperficieConstrucciones = 0;

                    }

                    if(isset($row['terrenos_comun'])){

                        $terrenosComun = $this->procesarTerrenosComun($row['terrenos_comun'], $key);

                        $sumValorTerenosComun = $terrenosComun->sum('valor_terreno_comun');

                        $sumAreaTerrenosComun = $terrenosComun->sum('superficie_proporcional');

                    }else{

                        $terrenosComun = null;

                        $sumValorTerenosComun = 0;

                        $sumAreaTerrenosComun = 0;

                    }

                    if(isset($row['construcciones_comun'])){

                        $construccionesComun = $this->procesarConstruccionesComun($row['construcciones_comun'], $key);

                        $sumValorConstruccionesComun = $construccionesComun->sum('valor_construccion_comun');

                        $sumAreaConstruccionComun = $construccionesComun->sum('superficie_proporcional');

                    }else{

                        $construccionesComun = null;

                        $sumValorConstruccionesComun = 0;

                        $sumAreaConstruccionComun = 0;

                    }

                    $superficie_total_terreno = $sumAreaTerrenosComun + $sumSuperficieTerrenos;

                    $superficie_total_construccion =  $sumAreaConstruccionComun + $sumSuperficieConstrucciones;

                    $valorCatastral = $sumValorTerrenos
                                            + $sumValorConstrucciones
                                            + $sumValorTerenosComun
                                            + $sumValorConstruccionesComun;

                    if($row['ubicacion_manzana'] == 'ESQUINA'){

                        $valorCatastral *= (1 + 15 / 100);

                    }

                    $predio = $this->crearPredio($row, $coordenadas, $terrenos, $sumSuperficieConstrucciones, $sumAreaTerrenosComun, $sumValorTerenosComun, $sumAreaConstruccionComun, $sumValorConstruccionesComun, $sumValorConstrucciones,  $superficie_total_terreno, $superficie_total_construccion,$valorCatastral);

                    $this->procesarPropietario($predio->id, $row, $key);

                    $this->procesarrelaciones($predio->id, $colindancias, $terrenos, $construcciones, $terrenosComun, $construccionesComun);

                    $avaluo = $this->crearAvaluo($row, $predio->id);

                    $avaluo->audits()->latest()->first()->update(['tags' => 'Generó avalúo con folio: ' . $avaluo->año . '-' . $avaluo->folio]);

                    $predio->audits()->latest()->first()->update(['tags' => 'Se genera predio apartir de avalúo: ' . $avaluo->año . '-' . $avaluo->folio]);

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

    public function procesarColindacias($colindancias, $linea):array
    {

        $array = explode('|', $colindancias);

        $colindanciasArreglo = [];

        foreach($array as $colindancia){

            $campos = explode(':', $colindancia);

            if(!in_array($campos[0], Constantes::VIENTOS))
                throw new GeneralException("Error en el campo viento de las colindancias en la línea " . $linea);

            if(!isset($campos[1]) || !isset($campos[2]))
                throw new GeneralException("Error en los campos de las colindancias en la línea " . $linea);

            if(isset($campos[3]))
                throw new GeneralException("Error en los campos de las colindancias en la línea " . $linea);

            if($campos[1] == '' || $campos[2] == '')
                throw new GeneralException("Error en los campos de las colindancias en la línea " . $linea);

            $colindanciasArreglo [] = [
                'viento' => $campos[0],
                'longitud' => $campos[1],
                'descripcion' => $campos[2],
            ];

        }
        return $colindanciasArreglo;

    }

    public function procesarTerrenos($terrenos, $tipo, $linea):collection
    {

        $array = explode('|', $terrenos);

        $terrenosArreglo = [];

        foreach($array as $terreno){

            $campos = explode(':', $terreno);

            if(!isset($campos[0]) || !isset($campos[1]) || !isset($campos[2]))
                throw new GeneralException("Faltan campos en los terrenos en la línea " . $linea);

            if($campos[0] == '' || $campos[1] == '' || $campos[2] == '')
                throw new GeneralException("Los campos no pueden estar vacios en los terrenos en la línea " . $linea);

            if(isset($campos[4]))
                throw new GeneralException("Hay campos de mas en los terrenos en la línea " . $linea);

            if($tipo == 1){

                if(!is_numeric($campos[1]))
                    throw new GeneralException("Error en los campos de los terrenos en la línea " . $linea);

                $valorUnitario = (float)$campos[1];

                $valorDemeritado = $valorUnitario - $valorUnitario * (float)$campos[2] / 100;

                $valorTerreno = (float)$campos[0] * $valorDemeritado;

                if(!is_float($valorTerreno))
                    throw new GeneralException("Error en los campos de los terrenos en la línea " . $linea);

            }elseif($tipo == 2){

                if(is_numeric($campos[1]))
                    throw new GeneralException("Error en valor unitario de los terrenos en la línea " . $linea);

                if(!$this->valoresRusticos->where('concepto', $campos[1])->first())
                    throw new GeneralException("Error en valor unitario de los terrenos en la línea " . $linea);

                $valorUnitario = $this->valoresRusticos->where('concepto', $campos[1])->first()->valor;

                $valorDemeritado = $valorUnitario - $valorUnitario * $campos[2] / 100;

                $valorTerreno = (float)$campos[0] * $valorDemeritado / 10000;

                if(!is_float($valorTerreno))
                    throw new GeneralException("Error en los campos de los terrenos en la línea " . $linea);
            }

            $terrenosArreglo [] = [
                'superficie' => $campos[0],
                'valor_unitario' => $valorUnitario,
                'demerito' => $campos[2],
                'valor_demeritado' => $valorDemeritado,
                'valor_terreno' => $valorTerreno
            ];

        }

        return collect($terrenosArreglo);

    }

    public function procesarConstrucciones($construcciones, $linea):collection
    {
        $array = explode('|', $construcciones);

        $construccionesArreglo = [];

        foreach($array as $construccion){

            $campos = explode(':', $construccion);

            if(!isset($campos[0]) || !isset($campos[1]) || !isset($campos[2]) || !isset($campos[3]) || !isset($campos[4]) || !isset($campos[5]) || !isset($campos[6]))
                throw new GeneralException("Error en los campos de las construcciones en la línea " . $linea);

            if($campos[0] == '' || $campos[1] == '' || $campos[2] == '' || $campos[3] == '' || $campos[4] == '' || $campos[5] == '' || $campos[6] == '')
                throw new GeneralException("Error en los campos de las construcciones en la línea " . $linea);

            if(isset($campos[7]))
                throw new GeneralException("Error en los campos de las construcciones en la líneas " . $linea);

            if(!$this->valoresConstruccion->where('tipo', $campos[1])->where('uso', $campos[2])->where('calidad', $campos[3])->where('estado', $campos[4])->first())
                throw new GeneralException("Error en valor unitario de las construcciones en la línea " . $linea);

            $valorUnitario = $this->valoresConstruccion->where('tipo', $campos[1])->where('uso', $campos[2])->where('calidad', $campos[3])->where('estado', $campos[4])->first()->valor;

            $construccionesArreglo [] = [
                'referencia' => $campos[0],
                'tipo' => $campos[1],
                'uso' => $campos[2],
                'calidad' => $campos[3],
                'estado' => $campos[4],
                'niveles' => $campos[5],
                'superficie' => $campos[6],
                'valor_unitario' => $valorUnitario,
                'valor_construccion' => (float)$valorUnitario * (float)$campos[6],
            ];

        }

        return collect($construccionesArreglo);

    }

    public function procesarTerrenosComun($terrenos, $linea):collection
    {
        $array = explode('|', $terrenos);

        $terrenosArreglo = [];

        foreach($array as $terreno){

            $campos = explode(':', $terreno);

            if(!isset($campos[0]) || !isset($campos[1]) || !isset($campos[2]))
                throw new GeneralException("Hacen falta campos terrenos en común en la línea " . $linea);

            if($campos[0] == '' || $campos[1] == '' || $campos[2] == '')
                throw new GeneralException("No puede haber campos vacios en terrenos en común en la línea " . $linea);

            if(isset($campos[3]))
                throw new GeneralException("Hay campos de mas en terrenos en común en la línea " . $linea);

            if((float)$campos[1] > 100)
                throw new GeneralException("Indiviso de terreno no puede ser mayor a 100 en terrenos en común en la línea " . $linea);

            $valorTerreno = (float)$campos[0] * (float)$campos[1] * (float)$campos[2];

            if(!is_float($valorTerreno))
                    throw new GeneralException("Error en los campos de los terrenos en común en la línea " . $linea);

            $terrenosArreglo [] = [
                'area_terreno_comun' => $campos[0],
                'indiviso_terreno' => $campos[1],
                'superficie_proporcional' => ($campos[0] * $campos[1]) / 100,
                'valor_unitario' => $campos[2],
                'valor_terreno_comun' => $valorTerreno
            ];

        }

        return collect($terrenosArreglo);

    }

    public function procesarConstruccionesComun($construcciones, $linea):collection
    {
        $array = explode('|', $construcciones);

        $construccionesArreglo = [];

        foreach($array as $construccion){

            $campos = explode(':', $construccion);

            if(!isset($campos[0]) || !isset($campos[1]) || !isset($campos[2]) || !isset($campos[3]) || !isset($campos[4]) || !isset($campos[5]))
                throw new GeneralException("Error en los campos de las construcciones común en la línea " . $linea);

            if($campos[0] == '' || $campos[1] == '' || $campos[2] == '' || $campos[3] == '' || $campos[4] == '' || $campos[5] == '')
                throw new GeneralException("Error en los campos de las construcciones común en la línea " . $linea);

            if(isset($campos[7]))
                throw new GeneralException("Error en los campos de las construcciones común en la línea " . $linea);

            if(!$this->valoresConstruccion->where('tipo', $campos[2])->where('uso', $campos[3])->where('calidad', $campos[4])->where('estado', $campos[5])->first())
                throw new GeneralException("Error en valor unitario de las construcciones común en la línea " . $linea);

            $valorUnitario = $this->valoresConstruccion->where('tipo', $campos[2])->where('uso', $campos[3])->where('calidad', $campos[4])->where('estado', $campos[5])->first()->valor;

            $valorConstruccion = (float)$campos[0] * (float)$campos[1] * $valorUnitario;

            if(!is_float($valorConstruccion))
                throw new GeneralException("Error en valor unitario de las construcciones común en la línea " . $linea);

            $construccionesArreglo [] = [
                'area_comun_construccion' => $campos[0],
                'indiviso_construccion' => $campos[1],
                'superficie_proporcional' => ($campos[0] * $campos[1]) / 100,
                'valor_clasificacion_construccion' => $valorUnitario,
                'valor_construccion_comun' => $valorConstruccion,
            ];

        }

        return collect($construccionesArreglo);

    }

    public function crearPredio($row, $coordenadas, $terrenos, $sumSuperficieConstrucciones, $sumAreaTerrenosComun, $sumValorTerenosComun, $sumAreaConstruccionComun, $sumValorConstruccionesComun, $sumValorConstrucciones, $superficie_total_terreno, $superficie_total_construccion, $valorCatastral): PredioAvaluo
    {

        return PredioAvaluo::create([
            'status' => 'activo',
            'sociedad' => $row['sociedad'] == 'SI' ? 1 : 0,
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
            'xutm' => $coordenadas['xutm'],
            'yutm' => $coordenadas['yutm'],
            'zutm' => $coordenadas['zutm'],
            'uso_1' => $row['uso_1'],
            'uso_2' => $row['uso_2'],
            'uso_3' => $row['uso_3'],
            'ubicacion_en_manzana' => $row['ubicacion_manzana'],
            'lon'=> $row['longitud'],
            'lat'=> $row['latitud'],
            'observaciones' => $row['observaciones'],
            'superficie_terreno' => $terrenos->sum('superficie'),
            'valor_total_terreno' => $terrenos->sum('valor_terreno'),
            'superficie_construccion' => $sumSuperficieConstrucciones,
            'area_comun_terreno' => $sumAreaTerrenosComun,
            'valor_terreno_comun' => $sumValorTerenosComun,
            'area_comun_construccion' => $sumAreaConstruccionComun,
            'valor_construccion_comun' => $sumValorConstruccionesComun,
            'valor_total_construccion' => $sumValorConstrucciones,
            'superficie_total_terreno' => $superficie_total_terreno,
            'superficie_total_construccion' => $superficie_total_construccion,
            'valor_catastral' => $valorCatastral,
            'actualizado_por' => auth()->id()
        ]);

    }

    public function procesarPropietario($predioId, $row, $linea):void
    {

        $persona = Persona::where('rfc', $row['rfc'])->first();

        if($persona){

            $v = Validator::make($persona->toArray(), [
                'curp' => 'unique:personas,curp,' . $persona->id,
            ]);

            if ($v->fails()){

                throw new GeneralException($v->errors()->first(). ' en la línea: '. $linea);
            }

            $persona->update([
                'ap_paterno' => $row['ap_paterno'],
                'ap_materno' => $row['ap_materno'],
                'nombre' => $row['nombre'],
                'razon_social' => $row['razon_social'],
                'tipo' => $row['tipo_persona'],
                'curp' => $row['curp'],
            ]);

            Propietario::create([
                'propietarioable_id' => $predioId,
                'propietarioable_type' => 'App\Models\PredioAvaluo',
                'persona_id' => $persona->id,
                'porcentaje_propiedad' => $row['porcentaje'],
            ]);

        }else{

            $v = Validator::make(
                [
                    'rfc' => $row['rfc'],
                    'curp' => $row['curp'],
                ],
                [
                    'rfc' => 'unique:personas,rfc',
                    'curp' => 'unique:personas,curp',
                ]
            );

            if ($v->fails()){

                throw new GeneralException($v->errors()->first(). ' en la línea: '. $linea);
            }

            $persona = Persona::create([
                'ap_paterno' => $row['ap_paterno'],
                'ap_materno' => $row['ap_materno'],
                'nombre' => $row['nombre'],
                'razon_social' => $row['razon_social'],
                'tipo' => $row['tipo_persona'],
                'rfc' => $row['rfc'],
                'curp' => $row['curp'],
            ]);

            Propietario::create([
                'propietarioable_id' => $predioId,
                'propietarioable_type' => 'App\Models\PredioAvaluo',
                'persona_id' => $persona->id,
                'porcentaje_propiedad' => $row['porcentaje'],
            ]);

        }

    }

    public function procesarrelaciones($predioId, $colindancias, $terrenos, $construcciones, $terrenosComun, $construccionesComun):void
    {

        foreach ($terrenos as $terreno) {

            Terreno::create([
                'terrenoable_id' => $predioId,
                'terrenoable_type' => 'App\Models\PredioAvaluo',
                'superficie' => $terreno['superficie'],
                'valor_unitario' => $terreno['valor_unitario'],
                'demerito' => $terreno['demerito'],
                'valor_demeritado' => $terreno['valor_demeritado'],
                'valor_terreno' => $terreno['valor_terreno'],
            ]);

        }

        if($construcciones){

            foreach ($construcciones as $construccion) {

                Construccion::create([
                    'construccionable_id' => $predioId,
                    'construccionable_type' => 'App\Models\PredioAvaluo',
                    'referencia' => $construccion['referencia'],
                    'valor_unitario' => $construccion['valor_unitario'],
                    'niveles' => $construccion['niveles'],
                    'superficie' => $construccion['superficie'],
                    'uso' => $construccion['uso'],
                    'tipo' => $construccion['tipo'],
                    'calidad' => $construccion['calidad'],
                    'estado' => $construccion['estado'],
                    'valor_construccion' => $construccion['valor_construccion'],
                ]);

            }

        }

        if($terrenosComun){

            foreach ($terrenosComun as $terreno) {

                TerrenosComun::create([
                    'terrenos_comunsable_id' => $predioId,
                    'terrenos_comunsable_type' => 'App\Models\PredioAvaluo',
                    'area_terreno_comun' => $terreno['area_terreno_comun'],
                    'indiviso_terreno' => $terreno['indiviso_terreno'],
                    'valor_unitario' => $terreno['valor_unitario'],
                    'valor_terreno_comun' => $terreno['valor_terreno_comun'],
                    'superficie_proporcional' => ($terreno['area_terreno_comun'] * $terreno['indiviso_terreno']) / 100
                ]);

            }

        }

        if($construccionesComun){

            foreach ($construccionesComun as $construccion) {

                ConstruccionesComun::create([
                    'construcciones_comunsable_id' => $predioId,
                    'construcciones_comunsable_type' => 'App\Models\PredioAvaluo',
                    'area_comun_construccion' => $construccion['area_comun_construccion'],
                    'indiviso_construccion' => $construccion['indiviso_construccion'],
                    'valor_clasificacion_construccion' => $construccion['valor_clasificacion_construccion'],
                    'valor_construccion_comun' => $construccion['valor_construccion_comun'],
                ]);

            }

        }

        foreach($colindancias as $coindancia){

            Colindancia::create([
                'colindanciaable_id' => $predioId,
                'colindanciaable_type' => 'App\Models\PredioAvaluo',
                'viento' => $coindancia['viento'],
                'longitud' => $coindancia['longitud'],
                'descripcion' => $coindancia['descripcion'],
            ]);

        }

    }

    public function crearAvaluo($row, $predioId):Avaluo
    {

        return Avaluo::create([
            'predio_avaluo' => $predioId,
            'año' => now()->format('Y'),
            'folio' => (Avaluo::where('año', now()->format('Y'))->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1,
            'usuario' => auth()->user()->clave,
            'estado' => 'nuevo',
            'clasificacion_zona' => $row['clasificacion_zona'],
            'construccion_dominante' => $row['tipo_construccion_dominante'],
            'agua' => $row['agua_potable'] == 'SI' ? 1 : 0,
            'drenaje' => $row['drenaje']  == 'SI' ? 1 : 0,
            'pavimento' => $row['pavimento']  == 'SI' ? 1 : 0,
            'energia_electrica' => $row['energia_electrica']  == 'SI' ? 1 : 0,
            'alumbrado_publico' => $row['alumbrado_publico']  == 'SI' ? 1 : 0,
            'banqueta' => $row['banqueta']  == 'SI' ? 1 : 0,
            'cimentacion' => $row['cimentacion'],
            'estructura' => $row['estructura'],
            'muros' => $row['muros'],
            'entrepiso' => $row['entrepisos'],
            'techo' => $row['techo'],
            'plafones' => $row['plafones'],
            'vidrieria' => $row['vidrieria'],
            'lambrines' => $row['lambrines'],
            'pisos' => $row['pisos'],
            'herreria' => $row['herreria'],
            'pintura' => $row['pintura'],
            'carpinteria' => $row['carpinteria'],
            'recubrimiento_especial' => $row['recubrimiento_especial'],
            'aplanados' => $row['aplanados'],
            'hidraulica' => $row['hidraulica'],
            'sanitaria' => $row['sanitaria'],
            'electrica' => $row['electrica'],
            'gas' => $row['gas'],
            'especiales' => $row['especiales'],
            'asignado_a' => auth()->id(),
            'creado_por' => auth()->id(),
        ]);

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
