<?php

namespace App\Livewire\Valuacion;

use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\Persona;
use App\Models\Terreno;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Colindancia;
use App\Models\Propietario;
use App\Models\Construccion;
use Livewire\WithPagination;
use App\Models\TerrenosComun;
use App\Constantes\Constantes;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use App\Enums\Tramites\AvaluoPara;
use Illuminate\Support\Facades\DB;
use App\Models\ConstruccionesComun;
use Illuminate\Support\Facades\Log;
use App\Services\Predio\ArchivoPredioService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Notificacion extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $años;
    public $año;
    public $folio;
    public $usuario;

    public $modal = false;

    public $avaluo;

    public $fecha_notificacion;

    public $tramite;

    public $predio;

    public $flag_notificar = false;

    public function buscarTramite(){

        $this->flag_notificar = false;

        $this->validate([
            'año' => 'required',
            'folio' => 'required',
            'usuario' => 'required',
        ]);

        try {

            $this->tramite = Tramite::where('año', $this->año)
                                        ->where('folio', $this->folio)
                                        ->where('usuario', $this->usuario)
                                        ->firstOrFail();

            $avaluo = Avaluo::whereIn('estado', ['impreso', 'concluido'])
                            ->whereNull('notificado_en')
                            ->whereNull('notificado_por')
                            ->where('tramite_inspeccion', $this->tramite->id)
                            ->first();

            if($avaluo){

                $this->flag_notificar = true;

            }

            $this->reset(['folio', 'usuario']);


        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no existe."]);

        } catch (\Throwable $th) {
            Log::error("Error al buscar trámite en notificación por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }


    }

    public function abrirModal(){

        $this->modal = true;

    }

    public function notificar(){

        $this->validate(
            [
                'fecha_notificacion' => 'required|before:tomorrow',
                'tramite' => 'required'
            ]
        );

        $predio = Predio::where('estado', $this->avaluo->predioAvaluo->estado)
                            ->where('region_catastral', $this->avaluo->predioAvaluo->region_catastral)
                            ->where('municipio', $this->avaluo->predioAvaluo->municipio)
                            ->where('zona_catastral', $this->avaluo->predioAvaluo->zona_catastral)
                            ->where('localidad', $this->avaluo->predioAvaluo->localidad)
                            ->where('sector', $this->avaluo->predioAvaluo->sector)
                            ->where('manzana', $this->avaluo->predioAvaluo->manzana)
                            ->where('predio', $this->avaluo->predioAvaluo->predio)
                            ->where('edificio', $this->avaluo->predioAvaluo->edificio)
                            ->where('departamento', $this->avaluo->predioAvaluo->departamento)
                            ->where('oficina', $this->avaluo->predioAvaluo->oficina)
                            ->where('tipo_predio', $this->avaluo->predioAvaluo->tipo_predio)
                            ->where('numero_registro', $this->avaluo->predioAvaluo->numero_registro)
                            ->first();

        if($predio){

            try {

                DB::transaction(function () use($predio){

                    $this->actualizaPredio($predio);

                    $this->actualizarAvaluo($predio->id);

                    $this->dispatch('mostrarMensaje', ['success', "El predio se actualizó correctamente en el padrón catastral."]);

                });

            } catch (\Throwable $th) {

                Log::error("Error al actualizar predio en el padron desde notificación de avalúo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
                $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->modal = false;

            }

        }else{

            try {

                DB::transaction(function () {

                    $this->predio = $this->creaPredio();

                    $this->actualizarAvaluo($this->predio->id);

                    $this->dispatch('mostrarMensaje', ['success', "El predio se creó correctamente en el padrón catastral."]);

                });

            } catch (\Throwable $th) {

                Log::error("Error al crear predio desde notificación de avalúo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
                $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->modal = false;

            }

        }

        if($this->tramite->avaluo_para === AvaluoPara::PREDIO_IGNORADO){

            if($this->avaluo->predioIgnorado->archivo){

                (new ArchivoPredioService($this->predio, null))->guardarConUrl('prediosignorados/'. $this->avaluo->predioIgnorado->archivo);

            }

        }

        if($this->tramite->avaluo_para === AvaluoPara::FUSION){

            foreach ($this->tramite->predios as $predio_fusionante) {

                if($predio->id === $predio_fusionante->id) continue;

                $predio_fusionante->update([
                    'status' => 'fusionado',
                    'actualizado_por' => auth()->id(),
                ]);

                $predio_fusionante->movimientos()->create([
                    'nombre' => $this->tramite->avaluo_para->label(),
                    'fecha' => $this->fecha_notificacion,
                    'descripcion' => 'Se fusiona el predio mediante ' . $this->tramite->avaluo_para->label() . ' con folio '. $this->avaluo->año . '-' . $this->avaluo->folio . '-' . $this->avaluo->usuario . ' resultando el predio ' . $predio->cuentaPredial(). '.',
                    'creado_por' => auth()->id()
                ]);

            }

        }

        if($this->tramite->avaluo_para === AvaluoPara::CAMBIO_REGIMEN){

            $predio_rustico = Predio::find($this->tramite->predios->first()->id);

            $predio_rustico->update([
                'status' => 'baja',
                'actualizado_por' => auth()->id(),
            ]);

            $predio_rustico->movimientos()->create([
                'nombre' => $this->tramite->avaluo_para->label(),
                'fecha' => $this->fecha_notificacion,
                'descripcion' => 'Se da de baja el predio mediante ' . $this->tramite->avaluo_para->label() . ' con folio '. $this->avaluo->año . '-' . $this->avaluo->folio . '-' . $this->avaluo->usuario . ' por cambio de regimen. Da origen al predio ' . $this->predio->cuentaPredial(),
                'creado_por' => auth()->id()
            ]);

        }

    }

    public function notificarTodos(){

        $avaluos = Avaluo::with('predioAvaluo')
                            ->whereIn('estado', ['impreso', 'concluido'])
                            ->whereNull('notificado_en')
                            ->whereNull('notificado_por')
                            ->where('tramite_inspeccion', $this->tramite->id)
                            ->get();

        foreach ($avaluos as $avaluo) {

            if($avaluo->estado == 'notificado') continue;

            $this->avaluo = $avaluo;

            $this->avaluo->load('predioAvaluo.colindancias', 'predioAvaluo.terrenosComun', 'predioAvaluo.construccionesComun', 'predioAvaluo.terrenos', 'predioAvaluo.construcciones', 'predioAvaluo.propietarios.persona');

            $this->notificar();

            $this->dispatch('mostrarMensaje', ['success', "Los avalúos se notificaron con éxito."]);

        }

        $this->reset('tramite');

    }

    public function creaPredio(){

        $predio = Predio::create([
            'status' => 'activo',
            'estado' => $this->avaluo->predioAvaluo->estado,
            'region_catastral' => $this->avaluo->predioAvaluo->region_catastral,
            'municipio' => $this->avaluo->predioAvaluo->municipio,
            'zona_catastral' => $this->avaluo->predioAvaluo->zona_catastral,
            'localidad' => $this->avaluo->predioAvaluo->localidad,
            'sector' => $this->avaluo->predioAvaluo->sector,
            'manzana' => $this->avaluo->predioAvaluo->manzana,
            'predio' => $this->avaluo->predioAvaluo->predio,
            'edificio' => $this->avaluo->predioAvaluo->edificio,
            'departamento' => $this->avaluo->predioAvaluo->departamento,
            'oficina' => $this->avaluo->predioAvaluo->oficina,
            'tipo_predio' => $this->avaluo->predioAvaluo->tipo_predio,
            'numero_registro' => $this->avaluo->predioAvaluo->numero_registro,
            'tipo_vialidad' => $this->avaluo->predioAvaluo->tipo_vialidad,
            'tipo_asentamiento' => $this->avaluo->predioAvaluo->tipo_asentamiento,
            'nombre_vialidad' => $this->avaluo->predioAvaluo->nombre_vialidad,
            'numero_exterior' => $this->avaluo->predioAvaluo->numero_exterior,
            'numero_exterior_2' => $this->avaluo->predioAvaluo->numero_exterior_2,
            'numero_adicional' => $this->avaluo->predioAvaluo->numero_adicional,
            'numero_adicional_2' => $this->avaluo->predioAvaluo->numero_adicional_2,
            'numero_interior' => $this->avaluo->predioAvaluo->numero_interior,
            'nombre_asentamiento' => $this->avaluo->predioAvaluo->nombre_asentamiento,
            'codigo_postal' => $this->avaluo->predioAvaluo->codigo_postal,
            'lote_fraccionador' => $this->avaluo->predioAvaluo->lote_fraccionador,
            'manzana_fraccionador' => $this->avaluo->predioAvaluo->manzana_fraccionador,
            'etapa_fraccionador' => $this->avaluo->predioAvaluo->etapa_fraccionador,
            'nombre_predio' => $this->avaluo->predioAvaluo->nombre_predio,
            'nombre_edificio' => $this->avaluo->predioAvaluo->nombre_edificio,
            'clave_edificio' => $this->avaluo->predioAvaluo->clave_edificio,
            'departamento_edificio' => $this->avaluo->predioAvaluo->departamento_edificio,
            'uso_1' => $this->avaluo->predioAvaluo->uso_1,
            'uso_2' => $this->avaluo->predioAvaluo->uso_2,
            'uso_3' => $this->avaluo->predioAvaluo->uso_3,
            'ubicacion_en_manzana' => $this->avaluo->predioAvaluo->ubicacion_en_manzana,
            'superficie_terreno' => $this->avaluo->predioAvaluo->superficie_terreno,
            'superficie_construccion' => $this->avaluo->predioAvaluo->superficie_construccion,
            'superficie_judicial' => $this->avaluo->predioAvaluo->superficie_judicial,
            'superficie_notarial' => $this->avaluo->predioAvaluo->superficie_notarial,
            'area_comun_terreno' => $this->avaluo->predioAvaluo->area_comun_terreno,
            'area_comun_construccion' => $this->avaluo->predioAvaluo->area_comun_construccion,
            'valor_terreno_comun' => $this->avaluo->predioAvaluo->valor_terreno_comun,
            'valor_construccion_comun' => $this->avaluo->predioAvaluo->valor_construccion_comun,
            'valor_total_terreno' => $this->avaluo->predioAvaluo->valor_total_terreno,
            'valor_total_construccion' => $this->avaluo->predioAvaluo->valor_total_construccion,
            'superficie_total_terreno' => $this->avaluo->predioAvaluo->superficie_total_terreno,
            'superficie_total_construccion' => $this->avaluo->predioAvaluo->superficie_total_construccion,
            'valor_catastral' => $this->avaluo->predioAvaluo->valor_catastral,
            'xutm' => $this->avaluo->predioAvaluo->xutm,
            'yutm' => $this->avaluo->predioAvaluo->yutm,
            'zutm' => $this->avaluo->predioAvaluo->zutm,
            'lon' => $this->avaluo->predioAvaluo->lon,
            'lat' => $this->avaluo->predioAvaluo->lat,
            'fecha_efectos' => $this->fecha_notificacion,
            'observaciones' => $this->avaluo->predioAvaluo->observaciones,
            'origen' => 'Alta mediante avalúo'
        ]);

        $predio->movimientos()->create([
            'nombre' => 'Alta mediante ' . $this->tramite->avaluo_para->label(),
            'fecha' => $this->fecha_notificacion,
            'descripcion' => 'Se da de alta predio en el padrón catastral mediante ' . $this->tramite->avaluo_para->label() . ' con folio '. $this->avaluo->año . '-' . $this->avaluo->folio . '-' . $this->avaluo->usuario . '.',
            'creado_por' => auth()->id()
        ]);

        $predio->audits()->latest()->first()->update(['tags' => 'Se genera predio apartir de ' . $this->tramite->avaluo_para->label() . ': ' . $this->avaluo->año . '-' . $this->avaluo->folio . '-' . $this->avaluo->usuario]);

        $this->procesarRelaciones($predio);

        return $predio;

    }

    public function actualizaPredio($predio){

        $predio->update([
            'status' => 'activo',
            'estado' => $this->avaluo->predioAvaluo->estado,
            'region_catastral' => $this->avaluo->predioAvaluo->region_catastral,
            'municipio' => $this->avaluo->predioAvaluo->municipio,
            'zona_catastral' => $this->avaluo->predioAvaluo->zona_catastral,
            'localidad' => $this->avaluo->predioAvaluo->localidad,
            'sector' => $this->avaluo->predioAvaluo->sector,
            'manzana' => $this->avaluo->predioAvaluo->manzana,
            'predio' => $this->avaluo->predioAvaluo->predio,
            'edificio' => $this->avaluo->predioAvaluo->edificio,
            'departamento' => $this->avaluo->predioAvaluo->departamento,
            'oficina' => $this->avaluo->predioAvaluo->oficina,
            'tipo_predio' => $this->avaluo->predioAvaluo->tipo_predio,
            'numero_registro' => $this->avaluo->predioAvaluo->numero_registro,
            'tipo_vialidad' => $this->avaluo->predioAvaluo->tipo_vialidad,
            'tipo_asentamiento' => $this->avaluo->predioAvaluo->tipo_asentamiento,
            'nombre_vialidad' => $this->avaluo->predioAvaluo->nombre_vialidad,
            'numero_exterior' => $this->avaluo->predioAvaluo->numero_exterior,
            'numero_exterior_2' => $this->avaluo->predioAvaluo->numero_exterior_2,
            'numero_adicional' => $this->avaluo->predioAvaluo->numero_adicional,
            'numero_adicional_2' => $this->avaluo->predioAvaluo->numero_adicional_2,
            'numero_interior' => $this->avaluo->predioAvaluo->numero_interior,
            'nombre_asentamiento' => $this->avaluo->predioAvaluo->nombre_asentamiento,
            'codigo_postal' => $this->avaluo->predioAvaluo->codigo_postal,
            'lote_fraccionador' => $this->avaluo->predioAvaluo->lote_fraccionador,
            'manzana_fraccionador' => $this->avaluo->predioAvaluo->manzana_fraccionador,
            'etapa_fraccionador' => $this->avaluo->predioAvaluo->etapa_fraccionador,
            'nombre_predio' => $this->avaluo->predioAvaluo->nombre_predio,
            'nombre_edificio' => $this->avaluo->predioAvaluo->nombre_edificio,
            'clave_edificio' => $this->avaluo->predioAvaluo->clave_edificio,
            'departamento_edificio' => $this->avaluo->predioAvaluo->departamento_edificio,
            'uso_1' => $this->avaluo->predioAvaluo->uso_1,
            'uso_2' => $this->avaluo->predioAvaluo->uso_2,
            'uso_3' => $this->avaluo->predioAvaluo->uso_3,
            'ubicacion_en_manzana' => $this->avaluo->predioAvaluo->ubicacion_en_manzana,
            'superficie_terreno' => $this->avaluo->predioAvaluo->superficie_terreno,
            'superficie_construccion' => $this->avaluo->predioAvaluo->superficie_construccion,
            'area_comun_terreno' => $this->avaluo->predioAvaluo->area_comun_terreno,
            'area_comun_construccion' => $this->avaluo->predioAvaluo->area_comun_construccion,
            'valor_terreno_comun' => $this->avaluo->predioAvaluo->valor_terreno_comun,
            'valor_construccion_comun' => $this->avaluo->predioAvaluo->valor_construccion_comun,
            'valor_total_terreno' => $this->avaluo->predioAvaluo->valor_total_terreno,
            'valor_total_construccion' => $this->avaluo->predioAvaluo->valor_total_construccion,
            'superficie_total_terreno' => $this->avaluo->predioAvaluo->superficie_total_terreno,
            'superficie_total_construccion' => $this->avaluo->predioAvaluo->superficie_total_construccion,
            'valor_catastral' => $this->avaluo->predioAvaluo->valor_catastral,
            'xutm' => $this->avaluo->predioAvaluo->xutm,
            'yutm' => $this->avaluo->predioAvaluo->yutm,
            'zutm' => $this->avaluo->predioAvaluo->zutm,
            'lon' => $this->avaluo->predioAvaluo->lon,
            'lat' => $this->avaluo->predioAvaluo->lat,
            'fecha_efectos' => $this->fecha_notificacion,
            'observaciones' => $this->avaluo->predioAvaluo->observaciones,
            'actualizado_por' => auth()->user()->id
        ]);

        $predio->movimientos()->create([
            'nombre' => 'Actualización mediante ' . $this->tramite->avaluo_para->label(),
            'fecha' => $this->fecha_notificacion,
            'descripcion' => 'Se actualiza el predio mediante ' . $this->tramite->avaluo_para->label() . ' con folio '. $this->avaluo->año . '-' . $this->avaluo->folio . '-' . $this->avaluo->usuario . '.',
            'creado_por' => auth()->id()
        ]);

        $predio->audits()->latest()->first()->update(['tags' => 'Actualización mediante  ' . $this->tramite->avaluo_para->label() . ': ' . $this->avaluo->año . '-' . $this->avaluo->folio . '-' . $this->avaluo->usuario . '.']);

        $this->procesarRelaciones($predio);

    }

    public function procesarRelaciones($predio){

        if(!$this->avaluo->predio){

            /* Propietarios */
            foreach($predio->propietarios as $propietario){

                Propietario::destroy($propietario->id);

            }

            foreach($this->avaluo->predioAvaluo->propietarios as $propietario){

                $persona = Persona::firstOrCreate(
                    [
                        'ap_paterno' => $propietario->persona->ap_paterno,
                        'ap_materno' => $propietario->persona->ap_materno,
                        'nombre' => $propietario->persona->nombre,
                        'tipo' => $propietario->persona->tipo,
                    ],
                    [
                        'ap_paterno' => $propietario->persona->ap_paterno,
                        'ap_materno' => $propietario->persona->ap_materno,
                        'nombre' => $propietario->persona->nombre,
                        'tipo' => $propietario->persona->tipo,
                    ]
                );

                $predio->propietarios()->create([
                    'persona_id' => $persona->id,
                    'tipo' => $propietario->tipo,
                    'porcentaje_propiedad' => $propietario->porcentaje_propiedad,
                    'porcentaje_nuda' => $propietario->porcentaje_nuda,
                    'porcentaje_usufructo' => $propietario->porcentaje_usufructo,
                ]);

            }

        }

        /* Colindancias */
        foreach($predio->colindancias as $colindancia){

            Colindancia::destroy($colindancia->id);

        }

        foreach($this->avaluo->predioAvaluo->colindancias as $colindancia){

            $predio->colindancias()->create([
                'viento' => $colindancia['viento'],
                'longitud' => $colindancia['longitud'],
                'descripcion' => $colindancia['descripcion'],
            ]);

        }

        /* Construcciones */
        foreach($predio->construcciones as $construccion){

            Construccion::destroy($construccion->id);

        }

        foreach($this->avaluo->predioAvaluo->construcciones as $construccion){

            $predio->construcciones()->create([
                'referencia' => $construccion['referencia'],
                'valor_unitario' => $construccion['valor_unitario'],
                'niveles' => $construccion['niveles'],
                'superficie' => $construccion['superficie'],
                'uso' => $construccion['uso'],
                'tipo' => $construccion['tipo'],
                'calidad' => $construccion['calidad'],
                'estado' => $construccion['estado'],
                'valor_construccion' => (float)$construccion['valor_unitario'] * (float)$construccion['superficie']
            ]);

        }

        /* Terrenos */
        foreach($predio->terrenos as $terreno){

            Terreno::destroy($terreno->id);

        }

        foreach($this->avaluo->predioAvaluo->terrenos as $terreno){

            $predio->terrenos()->create([
                'superficie' => $terreno['superficie'],
                'valor_unitario' => $terreno['valor_unitario'],
                'demerito' => $terreno['demerito'],
                'valor_demeritado' => $terreno['valor_demeritado'],
                'valor_terreno' => $terreno['valor_terreno'],
            ]);

        }

        /* Terrenos en común */
        foreach($predio->terrenosComun as $terrenoComun){

            TerrenosComun::destroy($terrenoComun->id);

        }

        foreach($this->avaluo->predioAvaluo->terrenosComun as $terrenoComun){

            $predio->terrenosComun()->create([
                'area_terreno_comun' => $terrenoComun['area_terreno_comun'],
                'indiviso_terreno' => $terrenoComun['indiviso_terreno'],
                'valor_unitario' => $terrenoComun['valor_unitario'],
                'valor_terreno_comun' => $terrenoComun['valor_terreno_comun'],
                'superficie_proporcional' => $terrenoComun['superficie_proporcional'],
            ]);

        }

        /* Construcciones en común */
        foreach($predio->construccionesComun as $construccionComun){

            ConstruccionesComun::destroy($construccionComun->id);

        }

        foreach($this->avaluo->predioAvaluo->construccionesComun as $construccionComun){

            $predio->construccionesComun()->create([
                'area_comun_construccion' => $construccionComun['area_comun_construccion'],
                'indiviso_construccion' => $construccionComun['indiviso_construccion'],
                'valor_clasificacion_construccion' => $construccionComun['valor_clasificacion_construccion'],
                'valor_construccion_comun' => $construccionComun['valor_construccion_comun'],
            ]);

        }

    }

    public function actualizarAvaluo($predioId){

        $this->avaluo->update([
            'predio' => $predioId,
            'actualizado_por' => auth()->id(),
            'notificado_por' => auth()->id(),
            'notificado_en' => $this->fecha_notificacion,
            'estado' => 'notificado'
        ]);

        $this->avaluo->predioAvaluo->update(['status' => 'notificado']);

        $this->avaluo->audits()->latest()->first()->update(['tags' => 'Notificó avalúo', 'tramite_id' => $this->tramite->id]);

        $this->modal = false;

    }

    #[Computed]
    public function avaluos(){

        if($this->tramite)
            return Avaluo::with('predioAvaluo')
                            ->whereIn('estado', ['impreso', 'concluido'])
                            ->whereNull('notificado_en')
                            ->whereNull('notificado_por')
                            ->where('tramite_inspeccion', $this->tramite->id)
                            ->paginate(10);
    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.valuacion.notificacion')->extends('layouts.admin');
    }

}
