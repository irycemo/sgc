<?php

namespace App\Http\Livewire\Valuacion;


use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\Persona;
use Livewire\Component;
use App\Models\Propietario;
use App\Models\PredioAvaluo;
use Illuminate\Support\Facades\DB;
use App\Http\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Coordenadas\Coordenadas;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AvaluoPredioIgnorado extends Component
{

    public $tipoPropietarios;
    public $tipoVialidades;
    public $tipoAsentamientos;
    public $ap_paterno;
    public $ap_materno;
    public $nombre;
    public $tipo_persona;
    public $tipo_propietario;
    public $porcentaje;

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

    public $predio_padron;
    public $flag = false;
    public $editar = false;

    public PredioAvaluo $predio;

    protected function rules(){
        return [
            'predio.copia' => 'nullable',
            'predio.sociedad' => 'nullable',
            'predio.numero_registro' => 'required|numeric',
            'predio.region_catastral' => 'required',
            'predio.municipio' => 'required',
            'predio.zona_catastral' => 'required',
            'predio.localidad' => 'nullable',
            'predio.sector' => 'required',
            'predio.manzana' => 'required',
            'predio.edificio' => 'required',
            'predio.departamento' => 'required',
            'predio.tipo_predio' => 'required',
            'predio.oficina' => 'required',
            'predio.estado' => 'required',
            'predio.tipo_asentamiento' => 'required',
            'predio.nombre_asentamiento' => 'required',
            'predio.tipo_vialidad' => 'required',
            'predio.nombre_vialidad' => 'required',
            'predio.numero_exterior' => 'required',
            'predio.numero_exterior_2' => 'nullable',
            'predio.numero_interior' => 'nullable',
            'predio.numero_adicional_2' => 'nullable',
            'predio.numero_adicional' => 'nullable',
            'predio.codigo_postal' => 'nullable',
            'predio.lote_fraccionador' => 'nullable',
            'predio.manzana_fraccionador' => 'nullable',
            'predio.etapa_fraccionador' => 'nullable',
            'predio.nombre_predio'  => 'nullable',
            'predio.nombre_edificio' => 'nullable',
            'predio.clave_edificio' => 'nullable',
            'predio.departamento_edificio' => 'nullable',
            'predio.xutm' => 'nullable|string',
            'predio.yutm' => 'nullable|string',
            'predio.zutm' => 'nullable',
            'predio.lat' => 'required',
            'predio.lon' => 'required',
            'ap_paterno' => 'required',
            'ap_materno' => 'required',
            'nombre' => 'required',
            'tipo_persona' => 'required',
            'tipo_propietario' => 'required',
            'porcentaje' => 'required|numeric',
         ];
    }

    protected $validationAttributes  = [
        'ap_paterno' => 'apellido paterno',
        'ap_materno' => 'apellido materno',
        'tipo_persona' => 'tipo de persona',
        'tipo_propietario' => 'tipo de propietario',
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

    public function buscarClaveCatastral(){

        try {

            $this->validate([
                'predio.numero_registro' => 'required',
                'predio.region_catastral' => 'required',
                'predio.municipio' => 'required',
                'predio.zona_catastral' => 'required',
                'predio.localidad' => 'required',
                'predio.sector' => 'required',
                'predio.manzana' => 'required',
                'predio.edificio' => 'nullable',
                'predio.departamento' => 'nullable',
            ]);

            $this->predio = PredioAvaluo::with('propietarios', 'avaluo')
                                        ->where('estado', 16)
                                        ->where('numero_registro', $this->predio->numero_registro)
                                        ->where('region_catastral', $this->predio->region_catastral)
                                        ->where('municipio', $this->predio->municipio)
                                        ->where('zona_catastral', $this->predio->zona_catastral)
                                        ->where('localidad', $this->predio->localidad)
                                        ->where('sector', $this->predio->sector)
                                        ->where('manzana', $this->predio->manzana)
                                        ->where('edificio', $this->predio->edificio)
                                        ->where('departamento', $this->predio->departamento)
                                        ->firstOrFail();

            if($this->predio->avaluo->creado_por != auth()->user()->id){

                $this->predio = PredioAvaluo::make();

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El avaluo está asinagnado a otro valuador."]);

                return;

            }

            $this->ap_paterno = $this->predio->propietarios()->first()->persona->ap_paterno;
            $this->ap_materno = $this->predio->propietarios()->first()->persona->ap_materno;
            $this->nombre = $this->predio->propietarios()->first()->persona->nombre;
            $this->tipo_persona = $this->predio->propietarios()->first()->persona->tipo;
            $this->tipo_propietario = $this->predio->propietarios()->first()->tipo;
            $this->porcentaje = $this->predio->propietarios()->first()->porcentaje;

            $this->editar = true;

            if($this->predio->copia)
                $this->flag = true;

            $this->emit('cargarPredio', $this->predio->id);

        }catch(ModelNotFoundException $e){
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "No existen avaluos relacionados a el predio."]);
        }
        catch(ValidationException $e){
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La clave catastral esta incompleta."]);
        }
        catch (\Throwable $th) {
            Log::error("Error al buscar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function convertirCoordenadas(){

        if($this->predio->xutm && $this->predio->yutm && $this->predio->zutm){

            $ll = (new Coordenadas())->utm2ll($this->predio->xutm, $this->predio->yutm, $this->predio->zutm, true);

            if(!$ll['success']){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', $ll['msg']]);

                return;

            }else{

                $this->predio->lat = $ll['attr']['lat'];
                $this->predio->lon = $ll['attr']['lon'];

            }


        }elseif($this->predio->lat && $this->predio->lon){

            $ll = (new Coordenadas())->ll2utm($this->predio->lat, $this->predio->lon);

            if(!$ll['success']){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', $ll['msg']]);

                return;

            }else{

                if((float)$ll['attr']['zone'] < 13 || (float)$ll['attr']['zone'] > 14){

                    $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Las coordenadas no corresponden a una zona válida."]);

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
                                                ->where('edificio', $this->predio->edificio)
                                                ->where('departamento', $this->predio->departamento)
                                                ->where('oficina', $this->predio->oficina)
                                                ->where('tipo_predio', $this->predio->tipo_predio)
                                                ->where('numero_registro', $this->predio->numero_registro)
                                                ->first();

        if(!$predioCompletoAvaluo){

            $cuentaPredialAvaluo = PredioAvaluo::where('localidad', $this->predio->localidad)
                                                ->where('oficina', $this->predio->oficina)
                                                ->where('tipo_predio', $this->predio->tipo_predio)
                                                ->where('numero_registro', $this->predio->numero_registro)
                                                ->first();

            if($cuentaPredialAvaluo){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La cuenta predial ya existe en avaluos con otra clave catastral, verifique."]);

                return true;
            }

            $claveCatastralAvaluo = PredioAvaluo::where('estado', $this->predio->estado)
                                                    ->where('region_catastral', $this->predio->region_catastral)
                                                    ->where('municipio', $this->predio->municipio)
                                                    ->where('zona_catastral', $this->predio->zona_catastral)
                                                    ->where('localidad', $this->predio->localidad)
                                                    ->where('sector', $this->predio->sector)
                                                    ->where('manzana', $this->predio->manzana)
                                                    ->where('edificio', $this->predio->edificio)
                                                    ->where('departamento', $this->predio->departamento)
                                                    ->first();

            if($claveCatastralAvaluo){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La clave catastral ya existe en avaluos con otra cuenta predial, verifique."]);

                return true;

            }

        }else{

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El predio ya existe en avaluos, verifique."]);

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
                                    ->where('edificio', $this->predio->edificio)
                                    ->where('departamento', $this->predio->departamento)
                                    ->where('oficina', $this->predio->oficina)
                                    ->where('tipo_predio', $this->predio->tipo_predio)
                                    ->where('numero_registro', $this->predio->numero_registro)
                                    ->first();

        if(!$predioCompleto){

            $cuentaPredial = Predio::where('localidad', $this->predio->localidad)
                                        ->where('oficina', $this->predio->oficina)
                                        ->where('tipo_predio', $this->predio->tipo_predio)
                                        ->where('numero_registro', $this->predio->numero_registro)
                                        ->first();

            if($cuentaPredial){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La cuenta predial ya existe en el padrón con otra clave catastral, verifique."]);

                return true;

            }

            $claveCatastral = Predio::where('estado', $this->predio->estado)
                                        ->where('region_catastral', $this->predio->region_catastral)
                                        ->where('municipio', $this->predio->municipio)
                                        ->where('zona_catastral', $this->predio->zona_catastral)
                                        ->where('localidad', $this->predio->localidad)
                                        ->where('sector', $this->predio->sector)
                                        ->where('manzana', $this->predio->manzana)
                                        ->where('edificio', $this->predio->edificio)
                                        ->where('departamento', $this->predio->departamento)
                                        ->first();

            if($claveCatastral){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La clave catastral ya existe en el padrón con otra cuenta predial, verifique."]);

                return true;

            }

        }else{

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El predio ya existe, verifique."]);

            return true;

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
                                                ->where('numero_registro', $this->predio->numero_registro)
                                                ->first();

        if(!$predioCompletoAvaluo){

            $cuentaPredialAvaluo = PredioAvaluo::where('localidad', $this->predio->localidad)
                                                ->where('oficina', $this->predio->oficina)
                                                ->where('tipo_predio', $this->predio->tipo_predio)
                                                ->where('numero_registro', $this->predio->numero_registro)
                                                ->first();

            if($cuentaPredialAvaluo){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La cuenta predial ya existe en avaluos con otra clave catastral, verifique."]);

                return true;
            }

            $claveCatastralAvaluo = PredioAvaluo::where('estado', $this->predio->estado)
                                                    ->where('region_catastral', $this->predio->region_catastral)
                                                    ->where('municipio', $this->predio->municipio)
                                                    ->where('zona_catastral', $this->predio->zona_catastral)
                                                    ->where('localidad', $this->predio->localidad)
                                                    ->where('sector', $this->predio->sector)
                                                    ->where('manzana', $this->predio->manzana)
                                                    ->where('edificio', $this->predio->edificio)
                                                    ->where('departamento', $this->predio->departamento)
                                                    ->first();

            if($claveCatastralAvaluo){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La clave catastral ya existe en avaluos con otra cuenta predial, verifique."]);

                return true;

            }

        }else{

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El predio ya existe en avaluos, verifique."]);

            return true;
        }

    }

    public function crear(){

        $this->validate();

        if($this->predio->localidad != 0 || $this->predio->numero_registro != 0){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La localidad y número de registro deben ser 0"]);

            return;
        }

        if($this->validarDisponibilidad())
            return;

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
                    'tipo' => $this->tipo_propietario,
                    'porcentaje' => $this->porcentaje,
                ]);

                $avaluo = Avaluo::create([
                    'folio' => Avaluo::max('folio') + 1,
                    'predio_id' => $this->predio->id,
                    'estado' => 'nuevo',
                    'creado_por' => auth()->user()->id,
                    'asignado_a' => auth()->user()->id,
                ]);

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El avaluo se creó con el folio " . $avaluo->folio . "."]);

                $this->editar = true;

                $this->emit('cargarPredio', $this->predio->id);

            });

        }
        catch (\Throwable $th) {

            Log::error("Error al crear predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function actualizar(){

        $this->validate();

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
                    'tipo' => $this->tipo_propietario,
                    'porcentaje' => $this->porcentaje,
                ]);

                $avaluo = Avaluo::where('predio_id', $this->predio->id)->first();

                $avaluo->update([
                    'actualizado_por' => auth()->user()->id
                ]);

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El avaluo se actualizó con el folio " . $avaluo->folio . "."]);

            });

        }
        catch (\Throwable $th) {
            Log::error("Error al crear predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);

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
                                        $q->where('ap_paterno', $this->propietario_ap_paterno)
                                            ->where('ap_materno', $this->propietario_ap_materno)
                                            ->where('nombre', $this->propietario_nombre);
                                    })
                                    ->whereHas('propietarioable', function($q){
                                        $q->where('localidad', 0)
                                            ->where('numero_registro', 0);
                                    })
                                    ->get();

    }

    public function cargarPredioAvaluo($id){

        try {

            $this->predio = PredioAvaluo::with('propietarios', 'avaluo')
                                        ->find($id);

            if($this->predio->avaluo->asignado_a != auth()->user()->id){

                $this->predio = PredioAvaluo::make();

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El avaluo está asinagnado a otro valuador."]);

                return;

            }

            $this->ap_paterno = $this->predio->propietarios()->first()->persona->ap_paterno;
            $this->ap_materno = $this->predio->propietarios()->first()->persona->ap_materno;
            $this->nombre = $this->predio->propietarios()->first()->persona->nombre;
            $this->tipo_persona = $this->predio->propietarios()->first()->persona->tipo;
            $this->tipo_propietario = $this->predio->propietarios()->first()->tipo;
            $this->porcentaje = $this->predio->propietarios()->first()->porcentaje;

            $this->editar = true;

            if($this->predio->copia)
                $this->flag = true;

            $this->emit('cargarPredio', $this->predio->id);

        }catch(ModelNotFoundException $e){
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "No existen avaluos relacionados a el predio."]);
        }
        catch(ValidationException $e){
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La clave catastral esta incompleta."]);
        }
        catch (\Throwable $th) {
            Log::error("Error al buscar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);
        }

        $this->modal = false;

        $this->reset('propietario_ap_paterno', 'propietario_ap_materno', 'propietario_nombre', 'predios_propietario');

    }

    public function asignarCuenta(){

        $this->validate([
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo' => 'required',
            'numero_registro' => 'required',
        ]);

        $this->predio->localidad = $this->localidad;
        $this->predio->oficina = $this->oficina;
        $this->predio->tipo_predio = $this->tipo;
        $this->predio->numero_registro = $this->numero_registro;

        if($this->validarDisponibilidad2())
            return;

        $this->predio->save();

        $this->dispatchBrowserEvent('mostrarMensaje', ['success', "La cunta predial se asigno correctamente, puede consultar el avalúo en la sección Valuación y Desglose."]);

        $this->modal2 = false;

        $this->predio = PredioAvaluo::make();

    }

    public function mount(){

        $this->tipoPropietarios = Constantes::TIPO_PROPIETARIO;

        $this->tipoVialidades = Constantes::TIPO_VIALIDADES;

        $this->tipoAsentamientos = Constantes::TIPO_ASENTAMIENTO;

        $this->predio = $this->crearModeloVacio();

        $this->predio->oficina = auth()->user()->oficina;

    }

    public function render()
    {
        return view('livewire.valuacion.avaluo-predio-ignorado')->extends('layouts.admin');
    }
}