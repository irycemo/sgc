<?php

namespace App\Livewire\Valuacion;


use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\Oficina;
use App\Models\Persona;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Propietario;
use App\Models\PredioAvaluo;
use App\Models\AsignarCuenta;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Coordenadas\Coordenadas;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AvaluoPredioIgnorado extends Component
{

    public $avaluo_id;

    public $tipoPropietarios;
    public $tipoVialidades;
    public $tipoAsentamientos;
    public $ap_paterno;
    public $ap_materno;
    public $nombre;
    public $tipo_persona;
    public $porcentaje;
    public $razon_social;

    public $modal = false;
    public $modal2 = false;

    public $predios_propietario;
    public $propietario_ap_paterno;
    public $propietario_ap_materno;
    public $propietario_nombre;

    public $localidad;
    public $oficina;
    public $tipo;
    public $numero_registro;
    public $tramite;

    public $predio_padron;
    public $flag = false;
    public $editar = false;

    public $años;
    public $año;
    public $folio;
    public $usuario;

    public PredioAvaluo $predio;

    protected function rules(){
        return [
            'predio.copia' => 'nullable',
            'predio.sociedad' => 'nullable',
            'predio.numero_registro' => 'required|numeric',
            'predio.region_catastral' => 'required|numeric|min:1',
            'predio.municipio' => 'required|numeric|min:1',
            'predio.localidad' => 'required|numeric|min:1|same:predio.zona_catastral',
            'predio.sector' => 'required|numeric|min:1',
            'predio.zona_catastral' => 'required|numeric|min:1',
            'predio.manzana' => 'required|numeric|min:1',
            'predio.predio' => 'required|numeric|min:1',
            'predio.edificio' => 'required|numeric|min:0',
            'predio.departamento' => 'required|numeric|min:0',
            'predio.tipo_predio' => 'required|numeric|min:1|max:2',
            'predio.oficina' => 'required|numeric|min:1',
            'predio.tipo_predio' => 'required|numeric|min:1',
            'predio.estado' => 'required',
            'predio.tipo_asentamiento' => 'required',
            'predio.nombre_asentamiento' => 'required|'. utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'predio.tipo_vialidad' => 'required',
            'predio.nombre_vialidad' => 'required|'. utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'predio.numero_exterior' => 'required|'. utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'predio.numero_exterior_2' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'predio.numero_interior' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'predio.numero_adicional_2' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'predio.numero_adicional' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'predio.codigo_postal' => 'nullable|numeric',
            'predio.lote_fraccionador' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'predio.manzana_fraccionador' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'predio.etapa_fraccionador' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'predio.nombre_predio'  => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'predio.nombre_edificio' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'predio.clave_edificio' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'predio.departamento_edificio' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'predio.xutm' => 'nullable|string',
            'predio.yutm' => 'nullable|string',
            'predio.zutm' => 'nullable',
            'predio.lat' => 'required',
            'predio.lon' => 'required',
            'ap_paterno' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'ap_materno' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'nombre' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'razon_social' => [Rule::requiredIf($this->tipo_persona === 'MORAL')],
            'tipo_persona' => 'required|'. Rule::in(['FÍSICA', 'MORAL']),
            'porcentaje' => 'required|numeric|max:100',
         ];
    }

    protected $validationAttributes  = [
        'tramite' => 'trámite',
        'numero_registro' => 'número de registro',
        'ap_paterno' => 'apellido paterno',
        'ap_materno' => 'apellido materno',
        'tipo_persona' => 'tipo de persona',
        'propietario_nombre' => 'nombre',
        'propietario_ap_paterno' => 'apellido paterno',
        'propietario_ap_materno' => 'apellido materno',
    ];

    public function crearModeloVacio(){
        return PredioAvaluo::make([
            'sociedad' => false,
            'estado' => 16,
            'copia' => false,
            'numero_registro' => 0,
            'localidad' => 0
        ]);
    }

    public function updatedPredioOficina(){

        $oficina = Oficina::where('oficina', $this->predio->oficina)->first();

        $this->predio->municipio = $oficina?->municipio;
        $this->predio->region_catastral = $oficina?->region;
        $this->predio->zona_catastral = $this->predio->localidad;

    }

    public function updatedPredioXutm(){
        $this->convertirCoordenadas();
    }

    public function updatedPredioYutm(){
        $this->convertirCoordenadas();
    }

    public function updatedPredioZutm(){
        $this->convertirCoordenadas();
    }

    public function updatedPredioLat(){
        $this->convertirCoordenadas();
    }

    public function updatedPredioLon(){
        $this->convertirCoordenadas();
    }

    public function updatedPredioLocalidad(){

        $this->predio->zona_catastral = $this->predio->localidad;

    }

    public function updatedTipoPersona(){

        if($this->tipo_persona == 'FÍSICA'){

            $this->reset(['razon_social', 'nombre', 'ap_paterno', 'ap_materno']);

        }elseif($this->tipo_persona == 'MORAL'){

            $this->reset(['razon_social', 'nombre', 'ap_paterno', 'ap_materno']);

        }

    }

    public function resetearCoordenadas(){

        $this->reset([
            'predio.xutm',
            'predio.yutm',
            'predio.zutm',
            'predio.lat' ,
            'predio.lon' ,
        ]);

    }

    public function buscarClaveCatastral(){

        try {

            $this->validate([
                'predio.region_catastral' => 'required',
                'predio.municipio' => 'required',
                'predio.zona_catastral' => 'required',
                'predio.localidad' => 'required',
                'predio.sector' => 'required',
                'predio.manzana' => 'required',
                'predio.predio' => 'required',
                'predio.edificio' => 'nullable',
                'predio.departamento' => 'nullable',
            ]);

            $this->predio = PredioAvaluo::with('propietarios', 'avaluo')
                                        ->where('estado', 16)
                                        ->where('region_catastral', $this->predio->region_catastral)
                                        ->where('municipio', $this->predio->municipio)
                                        ->where('zona_catastral', $this->predio->zona_catastral)
                                        ->where('localidad', $this->predio->localidad)
                                        ->where('sector', $this->predio->sector)
                                        ->where('manzana', $this->predio->manzana)
                                        ->where('predio', $this->predio->predio)
                                        ->where('edificio', $this->predio->edificio)
                                        ->where('departamento', $this->predio->departamento)
                                        ->firstOrFail();

            $this->predio->zona_catastral = $this->predio->localidad;

            if($this->predio->avaluo->creado_por != auth()->user()->id){

                $this->predio = PredioAvaluo::make([
                    'oficina' => auth()->user()->oficina->oficina
                ]);

                $this->dispatch('mostrarMensaje', ['error', "El avaluo está asinagnado a otro valuador."]);

                return;

            }

            $this->ap_paterno = $this->predio->propietarios()->first()->persona->ap_paterno;
            $this->ap_materno = $this->predio->propietarios()->first()->persona->ap_materno;
            $this->nombre = $this->predio->propietarios()->first()->persona->nombre;
            $this->tipo_persona = $this->predio->propietarios()->first()->persona->tipo;
            $this->porcentaje = $this->predio->propietarios()->first()->porcentaje;

            $this->editar = true;

            if($this->predio->copia)
                $this->flag = true;

            $this->dispatch('cargarPredio', $this->predio->id);

        }catch(ModelNotFoundException $e){
            $this->dispatch('mostrarMensaje', ['error', "No existen avaluos relacionados a el predio."]);
        }
        catch(ValidationException $e){
            $this->dispatch('mostrarMensaje', ['error', "La clave catastral esta incompleta."]);
        }
        catch (\Throwable $th) {
            Log::error("Error al buscar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function convertirCoordenadas(){

        if($this->predio->xutm && $this->predio->yutm && $this->predio->zutm){

            $ll = (new Coordenadas())->utm2ll($this->predio->xutm, $this->predio->yutm, $this->predio->zutm, true);

            if(!$ll['success']){

                $this->dispatch('mostrarMensaje', ['error', $ll['msg']]);

                return;

            }else{

                $this->predio->lat = $ll['attr']['lat'];
                $this->predio->lon = $ll['attr']['lon'];

            }


        }elseif($this->predio->lat && $this->predio->lon){

            $ll = (new Coordenadas())->ll2utm($this->predio->lat, $this->predio->lon);

            if(!$ll['success']){

                $this->dispatch('mostrarMensaje', ['error', $ll['msg']]);

                return;

            }else{

                if((float)$ll['attr']['zone'] < 13 || (float)$ll['attr']['zone'] > 14){

                    $this->dispatch('mostrarMensaje', ['error', "Las coordenadas no corresponden a una zona válida."]);

                    $this->predio->lat = null;
                    $this->predio->lon = null;

                    return;

                }

                $this->predio->xutm = strval($ll['attr']['x']);
                $this->predio->yutm = strval($ll['attr']['y']);
                $this->predio->zutm = $ll['attr']['zone'];

            }

        }


    }

    public function validarDisponibilidad(){

        $predioCompletoAvaluo = PredioAvaluo::where('estado', $this->predio->estado)
                                                ->where('region_catastral', $this->predio->region_catastral)
                                                ->where('municipio', $this->predio->municipio)
                                                ->where('zona_catastral', $this->predio->zona_catastral)
                                                ->where('localidad', $this->predio->localidad)
                                                ->where('sector', $this->predio->sector)
                                                ->where('manzana', $this->predio->manzana)
                                                ->where('predio', $this->predio->manzana)
                                                ->where('edificio', $this->predio->edificio)
                                                ->where('departamento', $this->predio->departamento)
                                                ->where('oficina', $this->predio->oficina)
                                                ->where('tipo_predio', $this->predio->tipo_predio)
                                                ->where('numero_registro', $this->predio->numero_registro)
                                                ->first();

        if($predioCompletoAvaluo){

            $this->dispatch('mostrarMensaje', ['error', "Ya existe un avalúo activo con el predio ingresado."]);

            return true;

        }

        if(!$predioCompletoAvaluo){

            $claveCatastralAvaluo = PredioAvaluo::where('estado', $this->predio->estado)
                                                    ->where('region_catastral', $this->predio->region_catastral)
                                                    ->where('municipio', $this->predio->municipio)
                                                    ->where('zona_catastral', $this->predio->zona_catastral)
                                                    ->where('localidad', $this->predio->localidad)
                                                    ->where('sector', $this->predio->sector)
                                                    ->where('manzana', $this->predio->manzana)
                                                    ->where('predio', $this->predio->manzana)
                                                    ->where('edificio', $this->predio->edificio)
                                                    ->where('departamento', $this->predio->departamento)
                                                    ->first();

            if($claveCatastralAvaluo){

                $this->dispatch('mostrarMensaje', ['error', "La clave catastral ya existe en avaluos con otra cuenta predial, verifique."]);

                return true;

            }

        }else{

            $this->dispatch('mostrarMensaje', ['error', "El predio ya existe en avaluos, verifique."]);

            return true;
        }

    }

    public function validarDisponibilidad2(){

        $predioCompleto = Predio::where('estado', $this->predio->estado)
                                    ->where('region_catastral', $this->predio->region_catastral)
                                    ->where('municipio', $this->predio->municipio)
                                    ->where('zona_catastral', $this->predio->zona_catastral)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('sector', $this->predio->sector)
                                    ->where('manzana', $this->predio->manzana)
                                    ->where('predio', $this->predio->predio)
                                    ->where('edificio', $this->predio->edificio)
                                    ->where('departamento', $this->predio->departamento)
                                    ->where('oficina', $this->predio->oficina)
                                    ->where('tipo_predio', $this->predio->tipo_predio)
                                    ->where('numero_registro', $this->predio->numero_registro)
                                    ->first();

        if($predioCompleto){

            $this->dispatch('mostrarMensaje', ['error', "El predio ya existe en el padrón, verifique."]);

            return true;

        }else{

            $cuentaPredial = Predio::where('localidad', $this->predio->localidad)
                                        ->where('oficina', $this->predio->oficina)
                                        ->where('tipo_predio', $this->predio->tipo_predio)
                                        ->where('numero_registro', $this->predio->numero_registro)
                                        ->first();

            if($cuentaPredial){

                $this->dispatch('mostrarMensaje', ['error', "La cuenta predial ya existe en el padrón con otra clave catastral, verifique."]);

                return true;

            }

            $claveCatastral = Predio::where('estado', $this->predio->estado)
                                        ->where('region_catastral', $this->predio->region_catastral)
                                        ->where('municipio', $this->predio->municipio)
                                        ->where('zona_catastral', $this->predio->zona_catastral)
                                        ->where('localidad', $this->predio->localidad)
                                        ->where('sector', $this->predio->sector)
                                        ->where('manzana', $this->predio->manzana)
                                        ->where('predio', $this->predio->predio)
                                        ->where('edificio', $this->predio->edificio)
                                        ->where('departamento', $this->predio->departamento)
                                        ->first();

            if($claveCatastral){

                $this->dispatch('mostrarMensaje', ['error', "La clave catastral ya existe en el padrón con otra cuenta predial, verifique."]);

                return true;

            }

        }

        $predioCompletoAvaluo = PredioAvaluo::where('estado', $this->predio->estado)
                                                ->where('region_catastral', $this->predio->region_catastral)
                                                ->where('municipio', $this->predio->municipio)
                                                ->where('zona_catastral', $this->predio->zona_catastral)
                                                ->where('localidad', $this->predio->localidad)
                                                ->where('sector', $this->predio->sector)
                                                ->where('manzana', $this->predio->manzana)
                                                ->where('edificio', $this->predio->edificio)
                                                ->where('departamento', $this->predio->departamento)
                                                ->where('oficina', $this->predio->oficina)
                                                ->where('tipo_predio', $this->predio->tipo_predio)
                                                ->where('oficina', $this->predio->oficina)
                                                ->where('tipo_predio', $this->predio->tipo_predio)
                                                ->where('numero_registro', $this->predio->numero_registro)
                                                ->first();

        if($predioCompletoAvaluo){

            $this->dispatch('mostrarMensaje', ['error', "El predio ya existe en avaluos, verifique."]);

            return true;

        }else{

            $cuentaPredialAvaluo = PredioAvaluo::where('localidad', $this->predio->localidad)
                                                ->where('oficina', $this->predio->oficina)
                                                ->where('tipo_predio', $this->predio->tipo_predio)
                                                ->where('numero_registro', $this->predio->numero_registro)
                                                ->first();

            if($cuentaPredialAvaluo){

                $this->dispatch('mostrarMensaje', ['error', "La cuenta predial ya existe en avaluos con otra clave catastral, verifique."]);

                return true;
            }

        }

    }

    public function validarSector(){

        $oficina = Oficina::where('localidad', $this->predio->localidad)
                            ->where('oficina', $this->predio->oficina)
                            ->first();

        if(!$oficina){

            $this->dispatch('mostrarMensaje', ['error', "No se encontraron oficinas con los datos ingresados."]);

            return true;

        }

        $sectores = json_decode($oficina->sectores, true);

        if(count($sectores) == 0){

            $this->dispatch('mostrarMensaje', ['error', "La oficina no tiene sectores."]);

            return true;

        }

        if(!in_array($this->predio->sector, $sectores)){

            $this->dispatch('mostrarMensaje', ['error', "El sector no corresponde a la zona."]);

            return true;

        }

        if($oficina->municipio != $this->predio->municipio){

            $this->dispatch('mostrarMensaje', ['error', "El municipio no corresponde a la oficina."]);

            return true;

        }

    }

    public function validarCuentaAsignada(){

        $cuenta = AsignarCuenta::where('localidad', $this->localidad)
                                ->where('oficina', $this->oficina)
                                ->where('tipo', $this->tipo_predio)
                                ->where('registro', $this->numero_registro)
                                ->where('tipo', $this->tipo_predio)
                                ->where('valuador', auth()->id())
                                ->first();

        if(!$cuenta){

            $this->dispatch('mostrarMensaje', ['error', "No tienes asignada la cuenta ingresada."]);

            return true;

        }

    }

    public function crear(){

        $this->validate();

        if($this->predio->numero_registro != 0){

            $this->dispatch('mostrarMensaje', ['error', "El número de registro deben ser 0"]);

            return;
        }

        if($this->validarDisponibilidad() || $this->validarSector()) return;

        try {

            DB::transaction(function () {

                $this->predio->actualizado_por = auth()->user()->id;
                $this->predio->save();

                $persona = Persona::firstOrCreate(
                    [
                        'ap_paterno' => $this->ap_paterno,
                        'ap_materno' => $this->ap_materno,
                        'nombre' => $this->nombre,
                        'tipo' => $this->tipo_persona,
                    ],
                    [
                        'ap_paterno' => $this->ap_paterno,
                        'ap_materno' => $this->ap_materno,
                        'nombre' => $this->nombre,
                        'tipo' => $this->tipo_persona,
                    ]
                );

                $this->predio->propietarios()->create([
                    'persona_id' => $persona->id,
                    'tipo' => 'PROPIETARIO',
                    'porcentaje' => $this->porcentaje,
                ]);

                $avaluo = Avaluo::create([
                    'año' => now()->format('Y'),
                    'folio' => Avaluo::max('folio') + 1,
                    'predio_id' => $this->predio->id,
                    'estado' => 'nuevo',
                    'creado_por' => auth()->user()->id,
                    'asignado_a' => auth()->user()->id,
                ]);

                $avaluo->audits()->latest()->first()->update(['tags' => 'Generó avalúo de predio ignaorado con folio: ' . $avaluo->año . '-' . $avaluo->folio]);

                $this->dispatch('mostrarMensaje', ['success', "El avaluo se creó con el folio " . $avaluo->folio . "."]);

                $this->editar = true;

                $this->dispatch('cargarPredio', $this->predio->id);

            });

        }
        catch (\Throwable $th) {

            Log::error("Error al crear predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function actualizar(){

        $this->authorize('update',$this->predio->avaluo);

        $this->validate();

        if($this->predio->avaluo->estado == "concluido"){

            $this->dispatch('mostrarMensaje', ['error', "El avalúo esta concluido no se puede editar"]);

            return;
        }

        if($this->predio->avaluo->estado == "notificado"){

            $this->dispatch('mostrarMensaje', ['error', "El avalúo esta notificado no se puede editar"]);

            return;
        }

        try {

            DB::transaction(function () {

                $this->predio->save();

                $persona = Persona::firstOrCreate(
                    [
                        'ap_paterno' => $this->ap_paterno,
                        'ap_materno' => $this->ap_materno,
                        'nombre' => $this->nombre,
                        'tipo' => $this->tipo_persona,
                    ],
                    [
                        'ap_paterno' => $this->ap_paterno,
                        'ap_materno' => $this->ap_materno,
                        'nombre' => $this->nombre,
                        'tipo' => $this->tipo_persona,
                    ]
                );

                $this->predio->propietarios()->first()->update([
                    'persona_id' => $persona->id,
                    'tipo' => 'PROPIETARIO',
                    'porcentaje' => $this->porcentaje,
                ]);

                $avaluo = Avaluo::where('predio_id', $this->predio->id)->first();

                $avaluo->update([
                    'actualizado_por' => auth()->user()->id,
                    'estado' => 'nuevo'
                ]);

                $avaluo->audits()->latest()->first()->update(['tags' => 'Actualizó información del predio del avalúo']);

                $this->dispatch('mostrarMensaje', ['success', "El avaluo se actualizó con el folio " . $avaluo->folio . "."]);

            });

        }
        catch (\Throwable $th) {
            Log::error("Error al crear predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function busacarPropietario(){

        $this->validate([
            'propietario_ap_paterno' => 'required',
            'propietario_ap_materno' => 'required',
            'propietario_nombre' => 'required',
        ]);

        $this->predios_propietario =  Propietario::with('persona', 'propietarioable.avaluo')
                                    ->whereHas('persona', function($q){
                                        $q->where('ap_paterno', 'like',  '%' . $this->propietario_ap_paterno . '%')
                                            ->where('ap_materno', 'like',  '%' . $this->propietario_ap_materno . '%')
                                            ->where('nombre', 'like',  '%' . $this->propietario_nombre . '%');
                                    })
                                    ->whereHas('propietarioable', function($q){
                                        $q->where('numero_registro', 0);
                                    })
                                    ->get();

    }

    public function cargarPredioAvaluo($id){

        try {

            $this->predio = PredioAvaluo::with('propietarios', 'avaluo')
                                        ->find($id);

            if($this->predio->avaluo->asignado_a != auth()->user()->id){

                $this->predio = PredioAvaluo::make();

                $this->dispatch('mostrarMensaje', ['error', "El avaluo está asinagnado a otro valuador."]);

                return;

            }

            $this->ap_paterno = $this->predio->propietarios()->first()->persona->ap_paterno;
            $this->ap_materno = $this->predio->propietarios()->first()->persona->ap_materno;
            $this->nombre = $this->predio->propietarios()->first()->persona->nombre;
            $this->tipo_persona = $this->predio->propietarios()->first()->persona->tipo;
            $this->porcentaje = $this->predio->propietarios()->first()->porcentaje;

            $this->editar = true;

            if($this->predio->copia)
                $this->flag = true;

            $this->dispatch('cargarPredio', $this->predio->id);

        }catch(ModelNotFoundException $e){
            $this->dispatch('mostrarMensaje', ['error', "No existen avaluos relacionados a el predio."]);
        }
        catch(ValidationException $e){
            $this->dispatch('mostrarMensaje', ['error', "La clave catastral esta incompleta."]);
        }
        catch (\Throwable $th) {
            Log::error("Error al buscar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

        $this->modal = false;

        $this->reset('propietario_ap_paterno', 'propietario_ap_materno', 'propietario_nombre', 'predios_propietario');

    }

    public function asignarCuenta(){

        /* $this->validate([
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo' => 'required|min:1|max:2',
            'numero_registro' => 'required',
            'año' => 'required',
            'folio' => 'required',
            'usuario' => 'required',
        ]); */

        $this->authorize('update', $this->predio->avaluo);

        $tramite = Tramite::where('año', $this->año)->where('folio', $this->folio)->where('usuario', $this->usuario)->first();

        if(!$tramite){

            $this->dispatch('mostrarMensaje', ['error', "El trámite no existe."]);

            return;

        }elseif($tramite->servicio_id != 292){

            $this->dispatch('mostrarMensaje', ['error', "El trámite no es una inscripción o registro de predios ignorado."]);

            return;

        }elseif($tramite->estado != 'pagado'){

            $this->dispatch('mostrarMensaje', ['error', "El trámite no esta pagado."]);

            return;

        }elseif($tramite->predio_avaluo != $this->predio->id){

            $this->dispatch('mostrarMensaje', ['error', "El trámite no esta asociado a la clave catastral del avalúo."]);

            return;

        }

        $this->predio->localidad = $this->localidad;
        $this->predio->oficina = $this->oficina;
        $this->predio->tipo_predio = $this->tipo;
        $this->predio->numero_registro = $this->numero_registro;

        if($this->validarDisponibilidad2()) return;

        if($this->validarCuentaAsignada()) return;

        DB::transaction(function () use ($tramite){

            $this->predio->save();

            $this->predio->avaluo->update(['estado' => 'concluido']);

            $this->predio->avaluo->audits()->latest()->first()->update(['tags' => 'Asigno cuenta predial a avalúo de predio ignorado']);

            $this->dispatch('mostrarMensaje', ['success', "La cuenta predial se asignó correctamente."]);

            $this->modal2 = false;

            $this->predio = PredioAvaluo::make();

            $tramite->update(['estado' => 'concluido']);

        });

    }

    public function abrirModalAsignar(){

        if(!$this->predio->avaluo){

            $this->dispatch('mostrarMensaje', ['error', "Primero debe cargar el avalúo."]);

            return;

        }

        $this->oficina = auth()->user()->oficina->oficina;

        $this->localidad = $this->predio->localidad;

        $this->tipo = $this->predio->tipo_predio;

        $this->modal2 = true;

    }

    public function mount(){


        $this->tipoVialidades = Constantes::TIPO_VIALIDADES;

        $this->tipoAsentamientos = Constantes::TIPO_ASENTAMIENTO;

        $this->predio = $this->crearModeloVacio();

        $this->predio->oficina = auth()->user()->oficina->oficina;

        $this->predio->municipio = auth()->user()->oficina->municipio;

        $this->predio->region_catastral = auth()->user()->oficina->region;

        if($this->avaluo_id){

            $avaluo = Avaluo::with('predioAvaluo')->find($this->avaluo_id);

            $this->predio = $avaluo->predioAvaluo;

            $this->tipo_persona = $this->predio->propietarios()->first()->persona->tipo;
            $this->ap_paterno = $this->predio->propietarios()->first()->persona->ap_paterno;
            $this->ap_materno = $this->predio->propietarios()->first()->persona->ap_materno;
            $this->nombre = $this->predio->propietarios()->first()->persona->nombre;
            $this->razon_social = $this->predio->propietarios()->first()->persona->razon_social;
            $this->porcentaje = $this->predio->propietarios()->first()->porcentaje;

            $this->editar = true;

        }

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.valuacion.avaluo-predio-ignorado')->extends('layouts.admin');
    }
}
