<?php

namespace App\Imports;

use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\PredioAvaluo;
use App\Models\AsignarCuenta;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Constantes\Constantes;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Http\Services\Coordenadas\Coordenadas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Exceptions\ErrorAlValidarLineaDeCaptura;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use App\Exceptions\ErrorAlProcesarCoordenadasException;
use App\Exceptions\ErrorAlProcesarColindanciasException;
use Illuminate\Support\Facades\Validator;

class AvaluoImport implements ToCollection, WithHeadingRow, WithValidation
{

    use RemembersRowNumber;

    public $data;

    public function collection(Collection $rows)
    {

        DB::transaction(function () use($rows){

            foreach ($rows as $row)
            {

                $this->validarDisponibilidad($row);

                $coordenadas = $this->procesarCoordenadas($row['latitud'], $row['longitud']);

                $colindancias = $this->procesarColindacias($row['colindancias']);

                $predio = PredioAvaluo::create([
                    'status' => 'activo',
                    'sociedad' => $row['sociedad'] == 'SI' ? 1 : 0,
                    'estado' => $row['estado'],
                    'region_catastral' => $row['region'],
                    'municipio' => $row['municipio'],
                    'zona_catastral' => $row['zona'],
                    'localidad' => $row['localidad'],
                    'sector' => $row['sector'],
                    'manzana' => $row['manzana'],
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
                    'lon'=> $row['latitud'],
                    'lat'=> $row['longitud'],
                    'observaciones' => $row['observaciones'],
                    'actualizado_por' => auth()->user()->id
                ]);

                foreach($colindancias as $coindancia){

                    $predio->colindancias()->create([
                        'viento' => $coindancia['viento'],
                        'longitud' => $coindancia['longitud'],
                        'descripcion' => $coindancia['descripcion'],
                    ]);

                }

                $this->data = Avaluo::create([
                    'name' => $row[0],
                ]);

            }

        });

    }

    public function rules(): array
    {
        return [
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo' => 'required',
            'registro' => 'required',
            'estado' => 'required',
            'region' => 'required',
            'municipio' => 'required',
            'zona' => 'required',
            'sector' => 'required',
            'manzana' => 'required',
            'edificio' => 'required',
            'departamento' => 'required',
            'ap_paterno' => 'required',
            'ap_materno' => 'required',
            'nombre' => 'required',
            'tipo_persona' => ['required', Rule::in(['FISICA', 'MORAL'])],
            'tipo_propietario' => ['required', Rule::in(Constantes::TIPO_PROPIETARIO)],
            'porcentaje' => 'required',
            'sociedad' => ['required', Rule::in(['SI', 'NO'])],
            'tipo_asentamiento' => ['required', Rule::in(Constantes::TIPO_ASENTAMIENTO)],
            'nombre_asentamiento' => 'required',
            'tipo_vialidad' => ['required', Rule::in(Constantes::TIPO_VIALIDADES)],
            'nombre_vialidad' => 'required',
            'numero_exterior' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
            'colindancias' => 'required',
            'clasificacion_zona' => ['required', Rule::in(Constantes::CLASIFICACION_ZONA)],
            'tipo_construccion_dominante' => ['required', Rule::in(Constantes::CONSTRUCCION_DOMINANTE)],
            'agua potable' => ['required', Rule::in(['SI', 'NO'])],
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
            'terrenos' => 'required',
            'construcciones' => 'required',
            'terrenos_comun' => 'required',
            'construcciones_comun' => 'required',
            'uso_1' =>  ['required', Rule::in(Constantes::USO_PREDIO)],
            'uso_2' =>  ['required', Rule::in(Constantes::USO_PREDIO)],
            'uso_3' =>  ['required', Rule::in(Constantes::USO_PREDIO)],
            'ubicación manzana' => ['required', Rule::in(Constantes::UBICACION_PREDIO)],
        ];
    }

    public function validarDisponibilidad($row){

        $predioCompleto = Predio::where('estado', $row['estado'])
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
                                    ->where('numero_registro', $row['registro'])
                                    ->first();

        if(!$predioCompleto){

            $cuentaPredial = Predio::where('localidad', $row['localidad'])
                                        ->where('oficina', $row['oficina'])
                                        ->where('tipo_predio', $row['tipo'])
                                        ->where('numero_registro', $row['registro'])
                                        ->first();

            if($cuentaPredial)
                throw new ErrorAlValidarLineaDeCaptura("La cuenta predial ya existe en el padrón con otra clave catastral, verifique en la linea " . $this->getRowNumber());

            $claveCatastral = Predio::where('estado', $row['estado'])
                                        ->where('region_catastral', $row['region'])
                                        ->where('municipio', $row['municipio'])
                                        ->where('zona_catastral', $row['zona'])
                                        ->where('localidad', $row['localidad'])
                                        ->where('sector', $row['sector'])
                                        ->where('manzana', $row['manzana'])
                                        ->where('edificio', $row['edificio'])
                                        ->where('departamento', $row['departamento'])
                                        ->first();

            if($claveCatastral)
                throw new ErrorAlValidarLineaDeCaptura("La clave catastral ya existe en el padrón con otra cuenta predial, verifique en la linea " . $this->getRowNumber());

        }else
            throw new ErrorAlValidarLineaDeCaptura("El predio ya existe, verifique en la linea " . $this->getRowNumber());

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
                                                ->where('numero_registro', $row['registro'])
                                                ->first();

        if(!$predioCompletoAvaluo){

            $cuentaPredialAvaluo = PredioAvaluo::where('localidad', $row['localidad'])
                                                ->where('oficina', $row['oficina'])
                                                ->where('tipo_predio', $row['tipo'])
                                                ->where('numero_registro', $row['registro'])
                                                ->first();

            if($cuentaPredialAvaluo)
                throw new ErrorAlValidarLineaDeCaptura("La cuenta predial ya existe en avaluos con otra clave catastral, verifique en la linea " . $this->getRowNumber());

            $claveCatastralAvaluo = PredioAvaluo::where('estado', $row['estado'])
                                                    ->where('region_catastral', $row['region'])
                                                    ->where('municipio', $row['municipio'])
                                                    ->where('zona_catastral', $row['zona'])
                                                    ->where('localidad', $row['localidad'])
                                                    ->where('sector', $row['sector'])
                                                    ->where('manzana', $row['manzana'])
                                                    ->where('edificio', $row['edificio'])
                                                    ->where('departamento', $row['departamento'])
                                                    ->first();

            if($claveCatastralAvaluo)
                throw new ErrorAlValidarLineaDeCaptura("La clave catastral ya existe en avaluos con otra cuenta predial, verifique en la linea " . $this->getRowNumber());

        }else
            throw new ErrorAlValidarLineaDeCaptura("El predio ya existe en avaluos, verifique en la linea " . $this->getRowNumber());

        $cuentaAsignada = AsignarCuenta::where('localidad', $row['localidad'])
                                        ->where('oficina', $row['oficina'])
                                        ->where('tipo_predio', $row['tipo'])
                                        ->where('numero_registro', $row['registro'])
                                        ->where('valuador', auth()->user()->id)
                                        ->first();

        if(!$cuentaAsignada)
            throw new ErrorAlValidarLineaDeCaptura("No tienes la cuenta asignada en la linea " . $this->getRowNumber());

    }

    public function procesarCoordenadas($lat, $lon):array
    {

        $ll = (new Coordenadas())->ll2utm($lat, $lon);

            if(!$ll['success']){

                throw new ErrorAlProcesarCoordenadasException($ll['msg'] . " en la linea " . $this->getRowNumber());


            }else{

                if((float)$ll['attr']['zone'] < 13 || (float)$ll['attr']['zone'] > 14){

                    throw new ErrorAlProcesarCoordenadasException("Las coordenadas no corresponden a una zona válida en la linea " . $this->getRowNumber());

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

    public function procesarColindacias($colindancias):array
    {

        $array = str_split($colindancias, '|');

        $colindanciasArreglo = [];

        foreach($array as $colindancia){

            $campos = str_split($colindancia, ':');

            if(!in_array($campos[0], Constantes::VIENTOS))
                throw new ErrorAlProcesarColindanciasException("Error en el campo viento de las colindancias en la linea " . $this->getRowNumber());

            if(!isset($campos[1]) || !isset($campos[2]))
                throw new ErrorAlProcesarColindanciasException("Error en los campos de las colindancias en la linea " . $this->getRowNumber());

            if(isset($campos[3]))
                throw new ErrorAlProcesarColindanciasException("Error en los campos de las colindancias en la linea " . $this->getRowNumber());

            $colindanciasArreglo [] = [
                'viento' => $campos[0],
                'longitud' => $campos[1],
                'descripcion' => $campos[2],
            ];

        }

        return $colindanciasArreglo;

    }

    public function headingRow(): int
    {
        return 2;
    }

}
