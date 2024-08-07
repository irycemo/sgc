<?php

namespace App\Imports;

use Exception;
use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\Oficina;
use App\Models\Persona;
use App\Models\PredioAvaluo;
use App\Models\AsignarCuenta;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Constantes\Constantes;
use App\Models\ValoresUnitariosRusticos;
use Illuminate\Support\Facades\Validator;
use App\Models\ValoresUnitariosConstruccion;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Http\Services\Coordenadas\Coordenadas;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Exceptions\FichaTecnicaImportException;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AvaluoImport implements ToCollection, WithHeadingRow, WithValidation, WithMultipleSheets, SkipsEmptyRows
{

    public $valoresConstruccion;
    public $valoresRusticos;
    public $avaluos = [];

    public function __construct()
    {

        $this->valoresConstruccion = ValoresUnitariosConstruccion::all();

        $this->valoresRusticos = ValoresUnitariosRusticos::all();

    }

    public $data;

    public function collection(Collection $rows)
    {

        try {

            DB::transaction(function () use($rows){


                foreach ($rows as $key => $row)
                {

                    $key = $key + 3;

                    /* Validaciones */
                    $this->validarDisponibilidad($row, $key);

                    $this->validarSector($row, $key);

                    $coordenadas = $this->procesarCoordenadas($row['latitud'], $row['longitud'], $key);

                    $colindancias = $this->procesarColindacias($row['colindancias'], $key);

                    $terrenos = $this->procesarTerrenos($row['terrenos'], $row['tipo'], $key);

                    if(isset($row['construcciones'])){

                        $construcciones = $this->procesarConstrucciones($row['construcciones'], $key);

                        $sumValorConstrucciones = $construcciones->sum('valor_construccion');

                        $sumSuperficieConstrucciones = $construcciones->sum('superficie');

                    }else{

                        $sumValorConstrucciones = 0;

                        $sumSuperficieConstrucciones = 0;

                    }

                    if(isset($row['terrenos_comun'])){

                        $terrenosComun = $this->procesarTerrenosComun($row['terrenos_comun'], $key);

                        $sumValorTerenosComun = $terrenosComun->sum('valor_terreno_comun');

                        $sumAreaTerrenosComun = $terrenosComun->sum('area_terreno_comun');

                    }else{

                        $sumValorTerenosComun = 0;

                        $sumAreaTerrenosComun = 0;

                    }

                    if(isset($row['construcciones_comun'])){

                        $construccionesComun = $this->procesarConstruccionesComun($row['construcciones_comun'], $key);

                        $sumValorConstruccionesComun = $construccionesComun->sum('valor_construccion_comun');

                        $sumAreaConstruccionComun = $construccionesComun->sum('area_comun_construccion');

                    }else{

                        $sumValorConstruccionesComun = 0;

                        $sumAreaConstruccionComun = 0;

                    }

                    if($row['tipo'] == 1){

                        $valorCatastral = $terrenos->sum('valor_terreno') + $sumValorConstrucciones;

                    }elseif($row['tipo'] == 2){

                        $valorCatastral = $terrenos->sum('valor_terreno')
                                            + $sumValorConstrucciones
                                            + $sumValorTerenosComun
                                            + $sumValorConstruccionesComun;


                    }

                    if($row['ubicacion_manzana'] == 'ESQUINA'){

                        $valorCatastral *= (1 + 15 / 100);

                    }

                    /* Crear predio */
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
                        'valor_catastral' => $valorCatastral,
                        'actualizado_por' => auth()->user()->id
                    ]);

                    /* Asociar relaciones */
                    $personaId = $this->procesarPersona($row, $key);

                    $predio->propietarios()->create([
                        'persona_id' => $personaId,
                        'tipo' => $row['tipo_propietario'],
                        'porcentaje' => $row['porcentaje'],
                    ]);

                    foreach ($terrenos as $terreno) {

                        $predio->terrenos()->create([
                            'superficie' => $terreno['superficie'],
                            'valor_unitario' => $terreno['valor_unitario'],
                            'demerito' => $terreno['demerito'],
                            'valor_demeritado' => $terreno['valor_demeritado'],
                            'valor_terreno' => $terreno['valor_terreno'],
                        ]);

                    }

                    if(isset($row['construcciones'])){

                        foreach ($construcciones as $construccion) {

                            $predio->construcciones()->create([
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

                    if(isset($row['terrenos_comun'])){

                        foreach ($terrenosComun as $terreno) {

                            $predio->condominioTerrenos()->create([
                                'area_terreno_comun' => $terreno['area_terreno_comun'],
                                'indiviso_terreno' => $terreno['indiviso_terreno'],
                                'valor_unitario' => $terreno['valor_unitario'],
                                'valor_terreno_comun' => $terreno['valor_terreno_comun'],
                            ]);

                        }

                    }

                    if(isset($row['construcciones_comun'])){

                        foreach ($construccionesComun as $construccion) {

                            $predio->condominioConstrucciones()->create([
                                'area_comun_construccion' => $construccion['area_comun_construccion'],
                                'indiviso_construccion' => $construccion['indiviso_construccion'],
                                'valor_clasificacion_construccion' => $construccion['valor_clasificacion_construccion'],
                                'valor_construccion_comun' => $construccion['valor_construccion_comun'],
                            ]);

                        }

                    }

                    foreach($colindancias as $coindancia){

                        $predio->colindancias()->create([
                            'viento' => $coindancia['viento'],
                            'longitud' => $coindancia['longitud'],
                            'descripcion' => $coindancia['descripcion'],
                        ]);

                    }

                    /* Crear avaluo */
                    $avaluo = Avaluo::create([
                        'predio_id' => $predio->id,
                        'año' => now()->format('Y'),
                        'folio' => (Avaluo::where('año', now()->format('Y'))->max('folio') ?? 0) + 1,
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
                        'asignado_a' => auth()->user()->id,
                        'creado_por' => auth()->user()->id,
                    ]);

                    $avaluo->audits()->latest()->first()->update(['tags' => 'Generó avalúo con folio: ' . $avaluo->año . '-' . $avaluo->folio]);

                    $predio->audits()->latest()->first()->update(['tags' => 'Se genera predio apartir de avalúo: ' . $avaluo->año . '-' . $avaluo->folio]);

                    $this->avaluos[] = $avaluo->load('predioAvaluo.propietarios.persona');

                }

                $this->data = $this->avaluos;

            });

        } catch (ValidationException $th) {

            throw $th->getMessage();

        } catch (Exception $th) {

            throw $th;

        } catch (\Throwable $th) {
            throw $th;
        }

    }

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
            'correo' => 'nullable|email',
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
            'tipo_propietario' => ['required', Rule::in(Constantes::TIPO_PROPIETARIO)],
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

    public function validarSector($row, $key){

        $oficina = Oficina::where('localidad', $row['localidad'])
                            ->where('oficina', $row['oficina'])
                            ->first();

        if(!$oficina){

            throw new FichaTecnicaImportException("No se encontraron oficinas con los datos ingresados, verifique la cuenta predial: " . $row['localidad'] . '-' . $row['oficina'] . '-' . $row['tipo'] . '-' . $row['registro']);

        }

        if($oficina->region != $row['region']){

            throw new FichaTecnicaImportException("La región no corresponde a la oficina ingresada, verifique la cuenta predial: " . $row['localidad'] . '-' . $row['oficina'] . '-' . $row['tipo'] . '-' . $row['registro']);

        }

        $sectores = json_decode($oficina->sectores, true);

        if(!$sectores){

            throw new FichaTecnicaImportException("La zona no tiene sectores, verifique la cuenta predial: " . $row['localidad'] . '-' . $row['oficina'] . '-' . $row['tipo'] . '-' . $row['registro']);

        }

        if(!in_array($row['sector'], $sectores)){

            throw new FichaTecnicaImportException("El sector no corresponde a la zona, verifique la cuenta predial: " . $row['localidad'] . '-' . $row['oficina'] . '-' . $row['tipo'] . '-' . $row['registro']);

        }

    }

    public function validarDisponibilidad($row, $key){

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

        if(!$predioCompleto){

            $cuentaPredial = Predio::where('localidad', $row['localidad'])
                                        ->where('oficina', $row['oficina'])
                                        ->where('tipo_predio', $row['tipo'])
                                        ->where('numero_registro', $row['registro'])
                                        ->first();

            if($cuentaPredial)
                throw new FichaTecnicaImportException("La cuenta predial ya existe en el padrón con otra clave catastral, verifique la cuenta predial: " . $row['localidad'] . '-' . $row['oficina'] . '-' . $row['tipo'] . '-' . $row['registro']);

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

            if($claveCatastral)
                throw new FichaTecnicaImportException("La clave catastral ya existe en el padrón con otra cuenta predial, verifique la cuenta predial: " . $row['localidad'] . '-' . $row['oficina'] . '-' . $row['tipo'] . '-' . $row['registro']);

        }

        $predioCompletoAvaluo = PredioAvaluo::where('status','activo')
                                                ->where('estado', $row['estado'])
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

        if($predioCompletoAvaluo)
                throw new FichaTecnicaImportException("La cuenta predial ya existe en avaluos, verifique la cuenta predial: " . $row['localidad'] . '-' . $row['oficina'] . '-' . $row['tipo'] . '-' . $row['registro']);

        if(!$predioCompletoAvaluo){

            $cuentaPredialAvaluo = PredioAvaluo::where('status','activo')
                                                ->where('localidad', $row['localidad'])
                                                ->where('oficina', $row['oficina'])
                                                ->where('tipo_predio', $row['tipo'])
                                                ->where('numero_registro', $row['registro'])
                                                ->first();

            if($cuentaPredialAvaluo)
                throw new FichaTecnicaImportException("La cuenta predial ya existe en avaluos con otra clave catastral, verifique la cuenta predial: " . $row['localidad'] . '-' . $row['oficina'] . '-' . $row['tipo'] . '-' . $row['registro']);

            $claveCatastralAvaluo = PredioAvaluo::where('status','activo')
                                                    ->where('estado', $row['estado'])
                                                    ->where('region_catastral', $row['region'])
                                                    ->where('municipio', $row['municipio'])
                                                    ->where('zona_catastral', $row['zona'])
                                                    ->where('localidad', $row['localidad'])
                                                    ->where('sector', $row['sector'])
                                                    ->where('manzana', $row['manzana'])
                                                    ->where('edificio', $row['edificio'])
                                                    ->where('predio', $row['predio'])
                                                    ->where('departamento', $row['departamento'])
                                                    ->first();

            if($claveCatastralAvaluo)
                throw new FichaTecnicaImportException("La clave catastral ya existe en avaluos con otra cuenta predial, verifique la cuenta predial: " . $row['localidad'] . '-' . $row['oficina'] . '-' . $row['tipo'] . '-' . $row['registro']);

        }

        $cuentaAsignada = AsignarCuenta::where('localidad', $row['localidad'])
                                        ->where('oficina', $row['oficina'])
                                        ->where('tipo_predio', $row['tipo'])
                                        ->where('numero_registro', $row['registro'])
                                        ->where('valuador', auth()->user()->id)
                                        ->first();

        if(!$cuentaAsignada)
            throw new FichaTecnicaImportException("No tienes asignada la cuenta: " . $row['localidad'] . '-' . $row['oficina'] . '-' . $row['tipo'] . '-' . $row['registro']);

    }

    public function procesarCoordenadas($lat, $lon, $linea):array
    {

        $ll = (new Coordenadas())->ll2utm($lat, $lon);

            if(!$ll['success']){

                throw new FichaTecnicaImportException($ll['msg'] . " en la linea " . $linea);


            }else{

                if((float)$ll['attr']['zone'] < 13 || (float)$ll['attr']['zone'] > 14){

                    throw new FichaTecnicaImportException("Las coordenadas no corresponden a una zona válida en la linea " . $linea);

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
                throw new FichaTecnicaImportException("Error en el campo viento de las colindancias en la linea " . $linea);

            if(!isset($campos[1]) || !isset($campos[2]))
                throw new FichaTecnicaImportException("Error en los campos de las colindancias en la linea " . $linea);

            if(isset($campos[3]))
                throw new FichaTecnicaImportException("Error en los campos de las colindancias en la lineass " . $linea);

            if($campos[1] == '' || $campos[2] == '')
                throw new FichaTecnicaImportException("Error en los campos de las colindancias en la lineass " . $linea);

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
                throw new FichaTecnicaImportException("Faltan campos en los terrenos en la linea " . $linea);

            if($campos[0] == '' || $campos[1] == '' || $campos[2] == '')
                throw new FichaTecnicaImportException("Los campos no pueden estar vacios en los terrenos en la linea " . $linea);

            if(isset($campos[4]))
                throw new FichaTecnicaImportException("Hay campos de mas en los terrenos en la linea " . $linea);

            if($tipo == 1){

                if(!is_numeric($campos[1]))
                    throw new FichaTecnicaImportException("Error en los campos de los terrenos en la linea " . $linea);

                $valorUnitario = (float)$campos[1];

                $valorDemeritado = $valorUnitario - $valorUnitario * (float)$campos[2] / 100;

                $valorTerreno = (float)$campos[0] * $valorDemeritado;

                if(!is_float($valorTerreno))
                    throw new FichaTecnicaImportException("Error en los campos de los terrenos en la linea " . $linea);

            }elseif($tipo == 2){

                if(is_numeric($campos[1]))
                    throw new FichaTecnicaImportException("Error en valor unitario de los terrenos en la linea " . $linea);

                if(!$this->valoresRusticos->where('concepto', $campos[1])->first())
                    throw new FichaTecnicaImportException("Error en valor unitario de los terrenos en la linea " . $linea);

                $valorUnitario = $this->valoresRusticos->where('concepto', $campos[1])->first()->valor;

                $valorDemeritado = $valorUnitario - $valorUnitario * $campos[2] / 100;

                $valorTerreno = (float)$campos[0] * $valorDemeritado / 10000;

                if(!is_float($valorTerreno))
                    throw new FichaTecnicaImportException("Error en los campos de los terrenos en la linea " . $linea);
            }

            $terrenosArreglo [] = [
                'superficie' => $campos[0],
                'valor_unitario' => $valorUnitario,
                'demerito' => $campos[2],
                'valor_demeritado' => $valorDemeritado,
                'valor_terreno' => $valorTerreno
            ];

        }

        $collection = collect($terrenosArreglo);

        return $collection;

    }

    public function procesarConstrucciones($construcciones, $linea):collection
    {
        $array = explode('|', $construcciones);

        $construccionesArreglo = [];

        foreach($array as $construccion){

            $campos = explode(':', $construccion);

            if(!isset($campos[0]) || !isset($campos[1]) || !isset($campos[2]) || !isset($campos[3]) || !isset($campos[4]) || !isset($campos[5]) || !isset($campos[6]))
                throw new FichaTecnicaImportException("Error en los campos de las construcciones en la linea " . $linea);

            if($campos[0] == '' || $campos[1] == '' || $campos[2] == '' || $campos[3] == '' || $campos[4] == '' || $campos[5] == '' || $campos[6] == '')
                throw new FichaTecnicaImportException("Error en los campos de las construcciones en la linea " . $linea);

            if(isset($campos[7]))
                throw new FichaTecnicaImportException("Error en los campos de las construcciones en la lineas " . $linea);

            if(!$this->valoresConstruccion->where('tipo', $campos[1])->where('uso', $campos[2])->where('calidad', $campos[3])->where('estado', $campos[4])->first())
                throw new FichaTecnicaImportException("Error en valor unitario de las construcciones en la linea " . $linea);

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

        $collection = collect($construccionesArreglo);

        return $collection;

    }

    public function procesarTerrenosComun($terrenos, $linea):collection
    {
        $array = explode('|', $terrenos);

        $terrenosArreglo = [];

        foreach($array as $terreno){

            $campos = explode(':', $terreno);

            if(!isset($campos[0]) || !isset($campos[1]) || !isset($campos[2]))
                throw new FichaTecnicaImportException("Hacen falta campos terrenos en común en la linea " . $linea);

            if($campos[0] == '' || $campos[1] == '' || $campos[2] == '')
                throw new FichaTecnicaImportException("No puede haber campos vacios en terrenos en común en la linea " . $linea);

            if(isset($campos[3]))
                throw new FichaTecnicaImportException("Hay campos de mas en terrenos en común en la linea " . $linea);

            if((float)$campos[1] > 100)
                throw new FichaTecnicaImportException("Indiviso de terreno no puede ser mayor a 100 en terrenos en común en la linea " . $linea);

            $valorTerreno = (float)$campos[0] * (float)$campos[1] * (float)$campos[2];

            if(!is_float($valorTerreno))
                    throw new FichaTecnicaImportException("Error en los campos de los terrenos en común en la linea " . $linea);

            $terrenosArreglo [] = [
                'area_terreno_comun' => $campos[0],
                'indiviso_terreno' => $campos[1],
                'superficie_proporcional' => ($campos[0] * $campos[1]) / 100,
                'valor_unitario' => $campos[2],
                'valor_terreno_comun' => $valorTerreno
            ];

        }

        $collection = collect($terrenosArreglo);

        return $collection;

    }

    public function procesarConstruccionesComun($construcciones, $linea):collection
    {
        $array = explode('|', $construcciones);

        $construccionesArreglo = [];

        foreach($array as $construccion){

            $campos = explode(':', $construccion);

            if(!isset($campos[0]) || !isset($campos[1]) || !isset($campos[2]) || !isset($campos[3]) || !isset($campos[4]) || !isset($campos[5]))
                throw new FichaTecnicaImportException("Error en los campos de las construcciones común en la linea " . $linea);

            if($campos[0] == '' || $campos[1] == '' || $campos[2] == '' || $campos[3] == '' || $campos[4] == '' || $campos[5] == '')
                throw new FichaTecnicaImportException("Error en los campos de las construcciones común en la linea " . $linea);

            if(isset($campos[7]))
                throw new FichaTecnicaImportException("Error en los campos de las construcciones común en la lineas " . $linea);

            if(!$this->valoresConstruccion->where('tipo', $campos[2])->where('uso', $campos[3])->where('calidad', $campos[4])->where('estado', $campos[5])->first())
                throw new FichaTecnicaImportException("Error en valor unitario de las construcciones común en la linea " . $linea);

            $valorUnitario = $this->valoresConstruccion->where('tipo', $campos[2])->where('uso', $campos[3])->where('calidad', $campos[4])->where('estado', $campos[5])->first()->valor;

            $valorConstruccion = (float)$campos[0] * (float)$campos[1] * $valorUnitario;

            if(!is_float($valorConstruccion))
                throw new FichaTecnicaImportException("Error en valor unitario de las construcciones común en la linea " . $linea);

            $construccionesArreglo [] = [
                'area_comun_construccion' => $campos[0],
                'indiviso_construccion' => $campos[1],
                'superficie_proporcional' => ($campos[0] * $campos[1]) / 100,
                'valor_clasificacion_construccion' => $valorUnitario,
                'valor_construccion_comun' => $valorConstruccion,
            ];

        }

        $collection = collect($construccionesArreglo);

        return $collection;

    }

    public function procesarPersona($row, $linea):int
    {

        $persona = Persona::where('rfc', $row['rfc'])->first();

        if($persona){

            $v = Validator::make($persona->toArray(), [
                'curp' => 'unique:personas,curp,' . $persona->id,
                'correo' => 'unique:personas,correo,' . $persona->id,
            ]);

            if ($v->fails()){

                throw new Exception($v->errors()->first(). ' en la línea: '. $linea);
            }

            $persona->update([
                'ap_paterno' => $row['ap_paterno'],
                'ap_materno' => $row['ap_materno'],
                'nombre' => $row['nombre'],
                'razon_social' => $row['razon_social'],
                'tipo' => $row['tipo_persona'],
                'curp' => $row['curp'],
                'correo' => $row['correo'],
            ]);

        }else{

            $v = Validator::make(
                [
                    'rfc' => $row['rfc'],
                    'curp' => $row['curp'],
                    'correo' => $row['correo']
                ],
                [
                    'rfc' => 'unique:personas,rfc',
                    'curp' => 'unique:personas,curp',
                    'correo' => 'unique:personas,correo',
                ]
            );

            if ($v->fails()){

                throw new Exception($v->errors()->first(). ' en la línea: '. $linea);
            }

            $persona = Persona::create([
                'ap_paterno' => $row['ap_paterno'],
                'ap_materno' => $row['ap_materno'],
                'nombre' => $row['nombre'],
                'razon_social' => $row['razon_social'],
                'tipo' => $row['tipo_persona'],
                'rfc' => $row['rfc'],
                'curp' => $row['curp'],
                'correo' => $row['correo'],
            ]);

        }

        return $persona->id;

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
