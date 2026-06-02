<?php

namespace App\Imports;

use App\Constantes\Constantes;
use App\Models\Avaluo;
use App\Models\CuentaAsignada;
use App\Models\File;
use App\Models\Import;
use App\Models\ManzanaAsignada;
use App\Models\Oficina;
use App\Models\Predio;
use App\Models\PredioAvaluo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;

class FichaTecnicaJobs implements OnEachRow, WithHeadingRow, WithValidation, WithMultipleSheets, SkipsEmptyRows, WithChunkReading
{

    protected bool $hasErrors = false;

    public $errores = [];

    public function __construct(public string $batchId, public $userId){}

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

    public function onRow(Row $row)
    {

        $this->errores = [];

        $count_predio_origen = 0;

        $count_predios_nuevos = 0;

        $predio_origen = null;

        if($row['predio_existe_en_padron'] == 'SI'){

            $predio_origen = $this->revisarPredio($row);

            $this->validarDisponibilidadAvaluos($row);

            $count_predio_origen ++;

        }

        if($row['predio_existe_en_padron'] == 'NO'){

            $this->revisarAsignacionCuentaPredial($row);

            $this->validarDisponibilidadPadron($row);

            $this->validarDisponibilidadAvaluos($row);

            $this->validarSector($row);

            $count_predios_nuevos ++;

        }

        $edificio = $row['edificio'] ?? null;

        $departamento = $row['departamento'] ?? null;

        if ($edificio == 0 && $departamento > 0) {

            $this->errores[] = "En la fila " . ($row->getIndex()) . ": Si edificio es 0, el departamento debe ser 0.";

        }

        if ($departamento == 0 && $edificio > 0) {

            $this->errores[] = "En la fila ".($row->getIndex()).": Si departamento es 0, el edificio debe ser 0.";

        }

        $data = $row->toArray();

        Import::create([
            'batch_id'   => $this->batchId,
            'row_number' => $row->getIndex(),
            'data'       => json_encode($data),
            'errores'    => $this->errores ? json_encode($this->errores) : null,
            'status'     => $this->errores ? 'error' : 'pending',
            'predios_existente' => $count_predio_origen,
            'predios_nuevos' => $count_predios_nuevos,
            'predio_origen' => $predio_origen
        ]);

    }

    public function revisarPredio($row):int
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

            $this->errores[] = "El predio no existe en el padrón, verifique. " . 'Línea: ' . $row->getIndex();

            return 0;

        }

        return $predioCompleto->id;

    }

    public function revisarAsignacionCuentaPredial($row):void
    {

        $cuentaAsignada = CuentaAsignada::where('localidad', $row['localidad'])
                                        ->where('oficina', $row['oficina'])
                                        ->where('tipo_predio', $row['tipo_predio'])
                                        ->where('numero_registro', $row['registro'])
                                        ->where('asignado_a', $this->userId)
                                        ->first();

        if(!$cuentaAsignada){

            $this->errores[] = "No tienes asignada la cuenta: " . $row['localidad'] . '-' . $row['oficina'] . '-' . $row['tipo'] . '-' . $row['registro'];

        }

    }

    public function revisarAsignacionManzana($row):void
    {

        if($row['manzana'] == 0) return;

        $cuentaAsignada = ManzanaAsignada::where('municipio', $row['municipio'])
                                        ->where('zona', $row['zona'])
                                        ->where('localidad', $row['localidad'])
                                        ->where('sector', $row['sector'])
                                        ->where('manzana', $row['manzana'])
                                        ->where('asignado_a', $this->userId)
                                        ->first();

        if(!$cuentaAsignada){

            $this->errores[] = "No tienes asignada la manzana: " . $row['municipio'] . '-' . $row['zona'] . '-' . $row['localidad'] . '-' . $row['sector'] . '-' . $row['manzana'] . '. Linea ' . $row->getIndex();

        }

    }

    public function validarDisponibilidadPadron($row):void
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

            $this->errores[] = "El predio ya existe en el padrón, verifique. " . 'Línea: ' . $row->getIndex();

        }else{

            $cuentaPredial = Predio::where('localidad', $row['localidad'])
                                        ->where('oficina', $row['oficina'])
                                        ->where('tipo_predio', $row['tipo_predio'])
                                        ->where('numero_registro', $row['registro'])
                                        ->first();

            if($cuentaPredial){

                $this->errores[] =  "La cuenta predial ya existe en el padrón con otra clave catastral, verifique. " . 'Línea: ' . $row->getIndex();

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

                $this->errores[] =  "La clave catastral ya existe en el padrón con otra cuenta predial, verifique. " . 'Línea: ' . $row->getIndex();

            }

        }

    }

    public function validarDisponibilidadAvaluos($row):void
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

            if($avaluo->estado === 'nuevo'){

                $this->borrarAvaluo($avaluo);

            }else{

                $this->errores[] = "Ya existe en un avaluo del predio " . $predioCompletoAvaluo->cuentaPredial() . ", verifique. " . 'Línea: ' . $row->getIndex();

            }

        }else{

            $cuentaPredialAvaluo = PredioAvaluo::where('status', 'activo')
                                                ->where('localidad', $row['localidad'])
                                                ->where('oficina', $row['oficina'])
                                                ->where('tipo_predio', $row['tipo_predio'])
                                                ->where('numero_registro', $row['registro'])
                                                ->first();

            if($cuentaPredialAvaluo){

                $this->errores[] = "Ya existe en un avaluo del predio " . $cuentaPredialAvaluo->cuentaPredial() . ", verifique. " . 'Línea: ' . $row->getIndex();

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

                $this->errores[] = "Ya existe en un avaluo del predio " . $claveCatastralAvaluo->cuentaPredial() . ", verifique. " . 'Línea: ' . $row->getIndex();

            }

        }

    }

    public function validarSector($row):void
    {

        $oficina = Oficina::where('localidad', $row['localidad'])
                            ->where('oficina', $row['oficina'])
                            ->first();

        if(!$oficina){

            $this->errores[] = "No se encontraron oficinas con los datos ingresados. " . 'Línea: ' . $row->getIndex();

        }

        $sectores = json_decode($oficina->sectores, true);

        if(is_null($sectores)){

            $this->errores[] = "La oficina no tiene sectores. " . 'Línea: ' . $row->getIndex();

        }

        if(!in_array($row['sector'], $sectores)){

            $this->errores[] = "El sector no corresponde a la zona. " . 'Línea: ' . $row->getIndex();

        }

        if($oficina->municipio != $row['municipio']){

            $this->errores[] = "El municipio no corresponde a la oficina. " . 'Línea: ' . $row->getIndex();

        }

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

    public function chunkSize(): int
    {
        return 100;
    }

    public function hasErrors(): bool
    {
        return $this->hasErrors;
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

}
