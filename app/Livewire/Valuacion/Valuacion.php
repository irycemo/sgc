<?php

namespace App\Livewire\Valuacion;

use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\Oficina;
use App\Models\Terreno;
use Livewire\Component;
use App\Models\Colindancia;
use App\Models\Propietario;
use App\Models\Construccion;
use App\Models\PredioAvaluo;
use App\Models\TerrenosComun;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\DB;
use App\Models\ConstruccionesComun;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Traits\Predios\ValidarSector;
use App\Traits\Predios\CoordenadasTrait;
use App\Traits\Predios\ValidarCuentaAsignada;
use App\Traits\Predios\ValidarDisponibilidad;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Valuacion extends Component
{

    use CoordenadasTrait;
    use ValidarSector;
    use ValidarDisponibilidad;
    use ValidarCuentaAsignada;

    public $avaluo_id;

    public $tipoVialidades;
    public $tipoAsentamientos;

    public $predio_padron;
    public $editar = false;
    public $es_nuevo = false;

    public PredioAvaluo $predio;

    protected function rules(){
        return [
            'predio.copia' => 'nullable',
            'predio.sociedad' => 'required',
            'predio.numero_registro' => 'required|numeric|min:1',
            'predio.region_catastral' => 'required|numeric|min:1',
            'predio.municipio' => 'required|numeric|min:1',
            'predio.localidad' => 'required|numeric|min:1',
            'predio.sector' => 'required|numeric|min:1',
            'predio.zona_catastral' => 'required|numeric|min:1,|same:predio.localidad',
            'predio.manzana' => 'required|numeric|min:0',
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

    public function crearModeloVacio(){
        return PredioAvaluo::make([
            'sociedad' => false,
            'estado' => 16,
            'copia' => false
        ]);
    }

    public function updatedEsNuevo(){

        if($this->es_nuevo){

            $this->predio->copia = false;

        }

    }

    public function updatedPredioLocalidad(){

        $this->predio->zona_catastral = $this->predio->localidad;

    }

    public function updatedPredioOficina(){

        $oficina = Oficina::where('oficina', $this->predio->oficina)->first();

        $this->predio->municipio = $oficina?->municipio;
        $this->predio->region_catastral = $oficina?->region;
        $this->predio->zona_catastral = $this->predio->localidad;

    }

    public function buscarCuentaPredial(){

        $this->validate([
            'predio.numero_registro' => 'required|numeric',
            'predio.tipo_predio' => 'required|numeric',
            'predio.localidad' => 'required|numeric',
            'predio.oficina' => 'required|numeric',
        ]);

        $this->reset('editar');

        try {

            $this->validarCuentaAsignada();

            $this->predio = PredioAvaluo::with('propietarios', 'avaluo')
                                    ->where('estado', '!=', 'notificado')
                                    ->where('numero_registro', $this->predio->numero_registro)
                                    ->where('tipo_predio', $this->predio->tipo_predio)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('oficina', $this->predio->oficina)
                                    ->whereHas('avaluo', function($q){
                                        $q->whereNotIn('estado', ['notificado', 'concluido']);
                                    })
                                    ->firstOrFail();

            $this->predio->zona_catastral = $this->predio->localidad;

            if($this->predio->avaluo->asignado_a != auth()->id()){

                $this->predio = $this->crearModeloVacio();

                $this->dispatch('mostrarMensaje', ['error', "El avaluo está asinagnado a otro valuador."]);

                return;

            }

            $this->editar = true;

            $this->dispatch('cargarPredio', $this->predio->id);

        } catch(GeneralException $e){

            $this->dispatch('mostrarMensaje', ['error', $e->getMessage()]);

        } catch(ModelNotFoundException $e){

            $this->dispatch('mostrarMensaje', ['error', "No existen avaluos relacionados a la cuenta predial."]);

        } catch (\Throwable $th) {

            Log::error("Error al buscar predio por cuenta predial en valuación por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

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

        $this->reset('editar');

        try {

            $this->validarCuentaAsignada();

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
                                            $q->whereNotIn('estado', ['notificado', 'concluido']);
                                        })
                                        ->firstOrFail();

            $this->predio->zona_catastral = $this->predio->localidad;

            if($this->predio->avaluo->asignado_a != auth()->id()){

                $this->predio = $this->crearModeloVacio();

                $this->dispatch('mostrarMensaje', ['error', "El avalúo está asinagnado a otro valuador."]);

                return;

            }

            $this->editar = true;

            $this->dispatch('cargarPredio', $this->predio->id);

        } catch(GeneralException $e){

            $this->dispatch('mostrarMensaje', ['error', $e->getMessage()]);

        } catch(ModelNotFoundException $e){

            $this->dispatch('mostrarMensaje', ['error', "No existen avaluos relacionados a la clave catastral."]);

        } catch (\Throwable $th) {

            Log::error("Error al buscar predio por clave catastral en valuación el usuario: (id: " . auth()->id() . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function cargarDatosPadron(){

        $this->validate([
            'predio.numero_registro' => 'required',
            'predio.tipo_predio' => 'required',
            'predio.localidad' => 'required',
            'predio.oficina' => 'required',
        ]);

        $this->reset('editar');

        try {

            $this->predio_padron = Predio::with('propietarios.persona')
                                    ->where('numero_registro', $this->predio->numero_registro)
                                    ->where('tipo_predio', $this->predio->tipo_predio)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('oficina', $this->predio->oficina)
                                    ->firstOrFail();


            foreach($this->predio_padron->getAttributes() as $attribute => $value){

                $this->predio[$attribute] = $value;

            }

            $this->predio->zona_catastral = $this->predio->localidad;

            $this->predio->id = null;
            $this->predio->actualizado_por = null;

            $this->predio->copia = true;

        } catch(GeneralException $e){

            $this->dispatch('mostrarMensaje', ['error', $e->getMessage()]);

        } catch(ModelNotFoundException $e){

            $this->dispatch('mostrarMensaje', ['error', "No existe información relacionada a la cuenta predial."]);

        } catch (\Throwable $th) {
            Log::error("Error al buscar copiar predio en valaución por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function crearAvaluo(){

        $this->validate();

        try {

            if(!$this->predio->copia) {

                $this->validarCuentaAsignada();

                $this->validarDisponibilidad();

            }

            $this->validarSector();

            DB::transaction(function () {

                $this->predio->actualizado_por = auth()->user()->id;
                $this->predio->save();

                if($this->predio->copia || $this->es_nuevo) $this->copiarRelaciones();

                $avaluo = Avaluo::create([
                    'año' => now()->format('Y'),
                    'folio' => (Avaluo::where('año', now()->format('Y'))->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1,
                    'usuario' => auth()->user()->clave,
                    'predio_avaluo' => $this->predio->id,
                    'estado' => 'nuevo',
                    'creado_por' => auth()->id(),
                    'asignado_a' => auth()->id(),
                ]);

                $avaluo->audits()->latest()->first()->update(['tags' => 'Generó avalúo con folio: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario]);

                $this->dispatch('mostrarMensaje', ['success', "El avaluo se creó con el folio " . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . '.']);

            });

            $this->editar = true;

            $this->dispatch('cargarPredio', $this->predio->id);

        } catch(GeneralException $e){

            $this->dispatch('mostrarMensaje', ['error', $e->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al crear avalúo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function copiarRelaciones(){

        foreach($this->predio_padron->propietarios as $propietario){

            Propietario::create([
                'propietarioable_id' => $this->predio->id,
                'propietarioable_type' => 'App\Models\PredioAvaluo',
                'persona_id' => $propietario->persona_id,
                'porcentaje_propiedad' => $propietario->porcentaje_propiedad,
                'porcentaje_nuda' => $propietario->porcentaje_nuda,
                'porcentaje_usufructo' => $propietario->porcentaje_usufructo,
                'tipo' => 'PROPIETARIO',
                'creado_por' => auth()->id()
            ]);

        }

        foreach($this->predio_padron->colindancias as $colindancia){

            Colindancia::create([
                'colindanciaable_id' => $this->predio->id,
                'colindanciaable_type' => 'App\Models\PredioAvaluo',
                'viento' => $colindancia->viento,
                'longitud' => $colindancia->longitud,
                'descripcion' => $colindancia->descripcion,
                'creado_por' => auth()->id()
            ]);

        }

        foreach($this->predio_padron->terrenos as $terreno){

            Terreno::create([
                'terrenoable_id' => $this->predio->id,
                'terrenoable_type' => 'App\Models\PredioAvaluo',
                'superficie' => $terreno->superficie,
                'demerito' => $terreno->demerito,
                'valor_demeritado' => $terreno->valor_demeritado,
                'valor_unitario' => $terreno->valor_unitario,
                'valor_terreno' => $terreno->valor_terreno,
                'creado_por' => auth()->id()
            ]);

        }

        foreach($this->predio_padron->terrenosComun as $terrenoComun){

            TerrenosComun::create([
                'terrenos_comunsable_id' => $this->predio->id,
                'terrenos_comunsable_type' => 'App\Models\PredioAvaluo',
                'area_terreno_comun' => $terrenoComun->area_terreno_comun,
                'indiviso_terreno' => $terrenoComun->indiviso_terreno,
                'valor_unitario' => $terrenoComun->valor_unitario,
                'superficie_proporcional' => $terrenoComun->superficie_proporcional,
                'valor_terreno_comun' => $terrenoComun->valor_terreno_comun,
                'creado_por' => auth()->id()
            ]);

        }

        foreach($this->predio_padron->construcciones as $construccion){

            Construccion::create([
                'construccionable_id' => $this->predio->id,
                'construccionable_type' => 'App\Models\PredioAvaluo',
                'referencia' => $construccion->referencia,
                'tipo' => $construccion->tipo,
                'uso' => $construccion->uso,
                'estado' => $construccion->estado,
                'calidad' => $construccion->calidad,
                'niveles' => $construccion->niveles,
                'superficie' => $construccion->superficie,
                'valor_unitario' => $construccion->valor_unitario,
                'valor_construccion' => $construccion->valor_construccion,
                'creado_por' => auth()->id()
            ]);

        }

        foreach($this->predio_padron->construccionesComun as $construccionComun){

            ConstruccionesComun::create([
                'construcciones_comunsable_id' => $this->predio->id,
                'construcciones_comunsable_type' => 'App\Models\PredioAvaluo',
                'area_comun_construccion' => $construccionComun->area_comun_construccion,
                'superficie_proporcional' => $construccionComun->superficie_proporcional,
                'indiviso_construccion' => $construccionComun->indiviso_construccion,
                'valor_clasificacion_construccion' => $construccionComun->valor_clasificacion_construccion,
                'valor_construccion_comun' => $construccionComun->valor_construccion_comun,
                'creado_por' => auth()->id()
            ]);

        }

    }

    public function actualizarAvaluo(){

        if($this->predio->avaluo->estado != 'nuevo'){

            $this->dispatch('mostrarMensaje', ['warning', 'El avalúo no se puede modificar.']);

            return;

        }

        $this->validate();

        try {

            DB::transaction(function () {

                $this->predio->save();

                $avaluo = Avaluo::where('predio_avaluo', $this->predio->id)->first();

                $avaluo->update([
                    'actualizado_por' => auth()->user()->id,
                    'estado' => 'nuevo'
                ]);

                $avaluo->audits()->latest()->first()->update(['tags' => 'Actualizó datos de identificación del inmueble']);

                $this->dispatch('mostrarMensaje', ['success', "El avalúo se actualizó con éxito."]);

            });

        }
        catch (\Throwable $th) {
            Log::error("Error al crear predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function mount(){

        $this->predio = $this->crearModeloVacio();

        $this->tipoVialidades = Constantes::TIPO_VIALIDADES;

        $this->tipoAsentamientos = Constantes::TIPO_ASENTAMIENTO;

        $this->predio->oficina = auth()->user()->oficina->oficina;

        $this->predio->municipio = auth()->user()->oficina->municipio;

        $this->predio->region_catastral = auth()->user()->oficina->region;

        $this->predio->zona_catastral = $this->predio->localidad;

        if($this->avaluo_id){

            $avaluo = Avaluo::with('predioAvaluo')->find($this->avaluo_id);

            $this->predio = $avaluo->predioAvaluo;

            $this->editar = true;

        }

    }

    public function render()
    {

        if(in_array($this->predio?->avaluo, ['notificado', 'concluido'])) abort(403, 'No es posible cargar el avalúo');

        return view('livewire.valuacion.valuacion');
    }
}
