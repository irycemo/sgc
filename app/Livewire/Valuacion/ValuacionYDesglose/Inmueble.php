<?php

namespace App\Livewire\Valuacion\ValuacionYDesglose;

use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\Oficina;
use App\Models\Persona;
use Livewire\Component;
use App\Models\PredioAvaluo;
use App\Models\AsignarCuenta;
use Illuminate\Support\Facades\DB;
use App\Http\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Coordenadas\Coordenadas;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Inmueble extends Component
{

    public $avaluo_id;

    public $tipoPropietarios;
    public $tipoVialidades;
    public $tipoAsentamientos;
    public $ap_paterno;
    public $ap_materno;
    public $nombre;
    public $tipo_persona;
    public $tipo_propietario;
    public $porcentaje;

    public $predio_padron;
    public $flag = false;
    public $editar = false;

    public PredioAvaluo $predio;

    protected function rules(){
        return [
            'predio.copia' => 'nullable',
            'predio.sociedad' => 'nullable',
            'predio.numero_registro' => 'required|min:1',
            'predio.region_catastral' => 'required|min:1',
            'predio.municipio' => 'required|min:1',
            'predio.localidad' => 'required|min:1|same:predio.zona_catastral',
            'predio.sector' => 'required|min:1',
            'predio.zona_catastral' => 'required|min:1',
            'predio.manzana' => 'required|min:1',
            'predio.predio' => 'required|min:1',
            'predio.edificio' => 'required|min:1',
            'predio.departamento' => 'required|min:1',
            'predio.tipo_predio' => 'required|min:1|max:2',
            'predio.oficina' => 'required|min:1',
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
            'porcentaje' => 'required|numeric|max:100',
         ];
    }

    protected $validationAttributes  = [
        'ap_paterno' => 'apellido paterno',
        'ap_materno' => 'apellido materno',
        'tipo_persona' => 'tipo de persona',
        'tipo_propietario' => 'tipo de propietario',
    ];

    public function crearModeloVacio(){
        return PredioAvaluo::make([
            'sociedad' => false,
            'estado' => 16,
            'copia' => false
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

        $this->reset('editar');

        $this->predio->avaluo = null;

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
                                        ->where('status', '!=', 'notificado')
                                        ->where('region_catastral', $this->predio->region_catastral)
                                        ->where('municipio', $this->predio->municipio)
                                        ->where('zona_catastral', $this->predio->zona_catastral)
                                        ->where('localidad', $this->predio->localidad)
                                        ->where('sector', $this->predio->sector)
                                        ->where('manzana', $this->predio->manzana)
                                        ->where('predio', $this->predio->predio)
                                        ->where('edificio', $this->predio->edificio)
                                        ->where('departamento', $this->predio->departamento)
                                        ->whereHas('avaluo', function($q){
                                            $q->where('estado', '!=', 'notificado');
                                        })
                                        ->firstOrFail();

            if($this->predio->avaluo->asignado_a != auth()->user()->id){

                $this->predio = PredioAvaluo::make([
                    'oficina' => auth()->user()->oficina
                ]);

                $this->dispatch('mostrarMensaje', ['error', "El avaluo está asinagnado a otro valuador."]);

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

    public function buscarCuentaPredial(){

        $this->reset('editar');

        $this->predio->avaluo = null;

        try {

            $this->validate([
                'predio.numero_registro' => 'required',
                'predio.tipo_predio' => 'required',
                'predio.localidad' => 'required',
                'predio.oficina' => 'required',
            ]);

            $this->predio = PredioAvaluo::with('propietarios', 'avaluo')
                                    ->where('estado', '!=', 'notificado')
                                    ->where('numero_registro', $this->predio->numero_registro)
                                    ->where('tipo_predio', $this->predio->tipo_predio)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('oficina', $this->predio->oficina)
                                    ->whereHas('avaluo', function($q){
                                        $q->where('estado', '!=', 'notificado');
                                    })
                                    ->firstOrFail();

            if($this->predio->avaluo->asignado_a != auth()->user()->id){

                $this->predio = PredioAvaluo::make([
                    'oficina' => auth()->user()->oficina
                ]);

                $this->dispatch('mostrarMensaje', ['error', "El avaluo está asinagnado a otro valuador."]);

                return;

            }

            if($this->ap_paterno = $this->predio->propietarios()->first()){

                $this->ap_paterno = $this->predio->propietarios()->first()->persona->ap_paterno;
                $this->ap_materno = $this->predio->propietarios()->first()->persona->ap_materno;
                $this->nombre = $this->predio->propietarios()->first()->persona->nombre;
                $this->tipo_persona = $this->predio->propietarios()->first()->persona->tipo;
                $this->tipo_propietario = $this->predio->propietarios()->first()->tipo;
                $this->porcentaje = $this->predio->propietarios()->first()->porcentaje;

            }

            $this->editar = true;

            if($this->predio->copia)
                $this->flag = true;

            $this->dispatch('cargarPredio', $this->predio->id);

        }
        catch(ModelNotFoundException $e){
            $this->dispatch('mostrarMensaje', ['error', "No existen avaluos relacionados a el predio."]);
        }
        catch(ValidationException $e){
            $this->dispatch('mostrarMensaje', ['error', "La cuenta predial esta incompleta."]);
        }
        catch (\Throwable $th) {
            Log::error("Error al buscar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function datosPadron(){

        $this->reset('editar');

        $this->predio->avaluo = null;

        try {

            $this->validate([
                'predio.numero_registro' => 'required',
                'predio.tipo_predio' => 'required',
                'predio.localidad' => 'required',
                'predio.oficina' => 'required',
            ]);

            $this->predio_padron = Predio::with('propietarios.persona')
                                    ->where('numero_registro', $this->predio->numero_registro)
                                    ->where('tipo_predio', $this->predio->tipo_predio)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('oficina', $this->predio->oficina)
                                    ->firstOrFail();


            foreach($this->predio_padron->getAttributes() as $attribute => $value){

                $this->predio[$attribute] = $value;

            }

            $this->predio->id = null;
            $this->predio->actualizado_por = null;
            $this->predio->created_at = now();
            $this->predio->updated_at = now();

            $this->ap_paterno = $this->predio_padron->propietarios()->first()->persona->ap_paterno;
            $this->ap_materno = $this->predio_padron->propietarios()->first()->persona->ap_materno;
            $this->nombre = $this->predio_padron->propietarios()->first()->persona->nombre;
            $this->tipo_persona = $this->predio_padron->propietarios()->first()->persona->tipo;
            $this->tipo_propietario = $this->predio_padron->propietarios()->first()->tipo;
            $this->porcentaje = $this->predio_padron->propietarios()->first()->porcentaje;

            if($this->predio_padron->propietarios()->count() > 1){

                $this->predio->sociedad = true;

            }

            $this->predio->copia = true;

            $this->flag = true;

        }
        catch(ValidationException $e){
            $this->dispatch('mostrarMensaje', ['error', "La cuenta predial esta incompleta."]);
        }
        catch(ModelNotFoundException $e){
            $this->dispatch('mostrarMensaje', ['error', "No existe información relacionada a el predio."]);
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

        if(!$predioCompleto){

            $cuentaPredial = Predio::where('localidad', $this->predio->localidad)
                                        ->where('oficina', $this->predio->oficina)
                                        ->where('tipo_predio', $this->predio->tipo_predio)
                                        ->where('numero_registro', $this->predio->numero_registro)
                                        ->first();

            if($cuentaPredial){

                $this->dispatch('mostrarMensaje', ['error', "La cuenta predial ya existe en el padrón con otra clave catastral, verifique."]);

                return true;

            }

            $claveCatastral = Predio::where('status', '!=', 'notificado')
                                        ->where('estado', $this->predio->estado)
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

        $predioCompletoAvaluo = PredioAvaluo::where('status', '!=', 'notificado')
                                            ->where('estado', $this->predio->estado)
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

        if(!$predioCompletoAvaluo){

            $cuentaPredialAvaluo = PredioAvaluo::where('status', '!=', 'notificado')
                                                ->where('localidad', $this->predio->localidad)
                                                ->where('oficina', $this->predio->oficina)
                                                ->where('tipo_predio', $this->predio->tipo_predio)
                                                ->where('numero_registro', $this->predio->numero_registro)
                                                ->first();

            if($cuentaPredialAvaluo){

                $this->dispatch('mostrarMensaje', ['error', "La cuenta predial ya existe en avaluos con otra clave catastral, verifique."]);

                return true;
            }

            $claveCatastralAvaluo = PredioAvaluo::where('status', '!=', 'notificado')
                                                    ->where('estado', $this->predio->estado)
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

            if($claveCatastralAvaluo){

                $this->dispatch('mostrarMensaje', ['error', "La clave catastral ya existe en avaluos con otra cuenta predial, verifique."]);

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

        if(!$sectores){

            $this->dispatch('mostrarMensaje', ['error', "La zona no tiene sectores."]);

            return true;

        }

        if(!in_array($this->predio->sector, $sectores)){

            $this->dispatch('mostrarMensaje', ['error', "El sector no corresponde a la zona."]);

            return true;

        }

    }

    public function crear(){

        $this->validate();

        if($this->validarDisponibilidad() || $this->validarSector())
            return;

        if(!$this->flag){

            $cuentaAsignada = AsignarCuenta::where('localidad', $this->predio->localidad)
                                            ->where('oficina', $this->predio->oficina)
                                            ->where('tipo_predio', $this->predio->tipo_predio)
                                            ->where('numero_registro', $this->predio->numero_registro)
                                            ->where('valuador', auth()->user()->id)
                                            ->first();

            if(!$cuentaAsignada){

                $this->dispatch('mostrarMensaje', ['error', "No tienes la cuenta asignada."]);

                return true;

            }

        }

        try {

            DB::transaction(function () {

                $this->predio->actualizado_por = auth()->user()->id;
                $this->predio->save();

                if($this->flag){

                    foreach($this->predio_padron->propietarios as $propietario){

                        $this->predio->propietarios()->create([
                            'persona_id' => $propietario->persona->id,
                            'tipo' => $propietario->tipo,
                            'porcentaje' => $propietario->porcentaje,
                        ]);

                    }

                }else{

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

                }

                $avaluo = Avaluo::create([
                    'año' => now()->format('Y'),
                    'folio' => (Avaluo::where('año', now()->format('Y'))->max('folio') ?? 0) + 1,
                    'predio_id' => $this->predio->id,
                    'estado' => 'nuevo',
                    'creado_por' => auth()->user()->id,
                    'asignado_a' => auth()->user()->id,
                ]);

                $avaluo->audits()->latest()->first()->update(['tags' => 'Generó avalúo con folio: ' . $avaluo->año . '-' . $avaluo->folio]);

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

        if($this->validarDisponibilidad() || $this->validarSector())
            return;

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
                    'tipo' => $this->tipo_propietario,
                    'porcentaje' => $this->porcentaje,
                ]);

                $avaluo = Avaluo::where('predio_id', $this->predio->id)->first();

                $avaluo->update([
                    'actualizado_por' => auth()->user()->id,
                    'estado' => 'nuevo'
                ]);

                $this->dispatch('mostrarMensaje', ['success', "El avaluo se actualizó con el folio " . $avaluo->folio . "."]);

            });

        }
        catch (\Throwable $th) {
            Log::error("Error al crear predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function mount(){

        $this->tipoPropietarios = Constantes::TIPO_PROPIETARIO;

        $this->tipoVialidades = Constantes::TIPO_VIALIDADES;

        $this->tipoAsentamientos = Constantes::TIPO_ASENTAMIENTO;

        $this->predio = $this->crearModeloVacio();

        $this->predio->oficina = auth()->user()->oficina->oficina;

        if($this->avaluo_id){

            $avaluo = Avaluo::with('predioAvaluo')->find($this->avaluo_id);

            $this->predio = $avaluo->predioAvaluo;

            $this->ap_paterno = $this->predio->propietarios()->first()->persona->ap_paterno;
            $this->ap_materno = $this->predio->propietarios()->first()->persona->ap_materno;
            $this->nombre = $this->predio->propietarios()->first()->persona->nombre;
            $this->tipo_persona = $this->predio->propietarios()->first()->persona->tipo;
            $this->tipo_propietario = $this->predio->propietarios()->first()->tipo;
            $this->porcentaje = $this->predio->propietarios()->first()->porcentaje;

            $this->editar = true;

        }

    }

    public function render()
    {
        return view('livewire.valuacion.valuacion-y-desglose.inmueble');
    }

}
