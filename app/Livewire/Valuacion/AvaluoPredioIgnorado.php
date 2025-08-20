<?php

namespace App\Livewire\Valuacion;

use App\Models\Avaluo;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Propietario;
use App\Models\PredioAvaluo;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Traits\Predios\ValidarSector;
use App\Traits\Predios\UbicacionTrait;
use App\Traits\Predios\CoordenadasTrait;
use App\Traits\Predios\ValidarCuentaAsignada;
use App\Traits\Predios\ValidarDisponibilidad;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AvaluoPredioIgnorado extends Component
{

    use UbicacionTrait;
    use CoordenadasTrait;
    use ValidarDisponibilidad;
    use ValidarCuentaAsignada;
    use ValidarSector;

    public $avaluo_id;

    public $tipoAsentamientos;
    public $tipoVialidades;

    public $modalPropietario = false;
    public $modalAsignarCuenta = false;

    public $predios_propietario = [];
    public $propietario_ap_paterno;
    public $propietario_ap_materno;
    public $propietario_nombre;

    public $tramite;
    public $años;
    public $año;
    public $folio;
    public $usuario;

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
            'predio.codigo_postal' => 'nullable|numeric',
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
            'localidad' => 0,
            'oficina' => auth()->user()->oficina->oficina,
            'municipio' => auth()->user()->oficina->municipio,
            'region_catastral' => auth()->user()->oficina->region

        ]);
    }

    public function abrirModalAsignar(){

        if(!$this->predio->avaluo){

            $this->dispatch('mostrarMensaje', ['error', "Primero debe cargar el avalúo."]);

            return;

        }

        $this->oficina = auth()->user()->oficina->oficina;

        $this->localidad = $this->predio->localidad;

        $this->tipo = $this->predio->tipo_predio;

        $this->modalAsignarCuenta = true;

    }

    public function buscarClaveCatastral(){

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

        try {

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

            if($this->predio->avaluo->asignado_a != auth()->user()->id){

                $this->predio = $this->crearModeloVacio();

                $this->dispatch('mostrarMensaje', ['warning', "El avalúo está asinagnado a otro valuador."]);

                return;

            }

            if($this->predio->numero_registro > 0){

                $this->predio = $this->crearModeloVacio();

                $this->dispatch('mostrarMensaje', ['warning', "El avalúo ya tiene cuenta predial asignada."]);

                return;

            }

            $this->editar = true;

            $this->dispatch('cargarPredio', $this->predio->id);

        } catch(ModelNotFoundException $e){

            $this->dispatch('mostrarMensaje', ['error', "No existen avaluos relacionados a la clave catastral."]);

        } catch (\Throwable $th) {

            Log::error("Error al buscar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
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

    public function cargarAvaluoPropietario($id){

        $this->predio = PredioAvaluo::find($id);

        if($this->predio->avaluo->asignado_a != auth()->user()->id){

            $this->crearModeloVacio();

            $this->dispatch('mostrarMensaje', ['error', "El avaluo está asinagnado a otro valuador."]);

            return;

        }

        $this->editar = true;

        $this->dispatch('cargarPredio', $this->predio->id);

        $this->modalPropietario = false;

    }

    public function validacionesCrear(){

        $this->validarDisponibilidadPredioIgnorado();

        $this->validarSector();

        if($this->predio->numero_registro != 0) throw new GeneralException("El número de registro deben ser 0");

    }

    public function crear(){

        $this->validate();

        try {

            $this->validacionesCrear();

            DB::transaction(function () {

                $this->predio->actualizado_por = auth()->user()->id;
                $this->predio->save();

                $avaluo = Avaluo::create([
                    'año' => now()->format('Y'),
                    'folio' => Avaluo::max('folio') + 1,
                    'usuario' => auth()->user()->clave,
                    'predio_avaluo' => $this->predio->id,
                    'estado' => 'nuevo',
                    'creado_por' => auth()->id(),
                    'asignado_a' => auth()->id()
                ]);

                $avaluo->audits()->latest()->first()->update(['tags' => 'Generó avalúo de predio ignaorado con folio: ' . $avaluo->año . '-' . $avaluo->folio]);

                $this->dispatch('mostrarMensaje', ['success', "El avaluo se creó con el folio " . $avaluo->folio . "."]);

                $this->editar = true;

                $this->dispatch('cargarPredio', $this->predio->id);

            });

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al crear valúo de predio ignorado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function actualizar(){

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

            $this->predio->save();

            $this->dispatch('mostrarMensaje', ['success', "El avaluo se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar avalúo de predio ignorado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function validacionesAsignar(){

        $this->tramite = Tramite::where('año', $this->año)->where('folio', $this->folio)->where('usuario', $this->usuario)->first();

        if(!$this->tramite){

            throw new GeneralException("El trámite no existe.");

        }elseif($this->tramite->servicio->nombre != 'Inscripción o registro de predios ignorados'){

            throw new GeneralException("El trámite no es una inscripción o registro de predios ignorado.");

        }elseif($this->tramite->estado != 'pagado'){

            throw new GeneralException("El trámite no esta pagado.");

        }elseif($this->tramite->predio_avaluo != $this->predio->id){

            throw new GeneralException("El trámite no esta asociado a la clave catastral del avalúo.");

        }

        $this->validarDisponibilidadPadron();

        $this->validarCuentaAsignada();

    }

    public function asignarCuenta(){

        $this->validate([
            'numero_registro' => 'required',
        ]);

        try {

            $this->predio->numero_registro = $this->numero_registro;

            $this->validacionesAsignar();

            DB::transaction(function () {

                $this->predio->save();

                $this->predio->avaluo->touch();

                $this->predio->avaluo->audits()->latest()->first()->update(['tags' => 'Asigno cuenta predial a avalúo de predio ignorado']);

                $this->tramite->update(['estado' => 'concluido']);

            });

            $this->dispatch('mostrarMensaje', ['success', "La cuenta predial se asignó correctamente."]);

            $this->modalAsignarCuenta = false;

            $this->predio = PredioAvaluo::make();

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al asignar cuenta predial a avalúo de predio ignorado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function mount(){

        $this->tipoVialidades = Constantes::TIPO_VIALIDADES;

        $this->tipoAsentamientos = Constantes::TIPO_ASENTAMIENTO;

        $this->predio = $this->crearModeloVacio();

        if($this->avaluo_id){

            $avaluo = Avaluo::with('predioAvaluo')->find($this->avaluo_id);

            $this->predio = $avaluo->predioAvaluo;

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
