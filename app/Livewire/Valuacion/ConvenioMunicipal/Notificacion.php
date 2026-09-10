<?php

namespace App\Livewire\Valuacion\ConvenioMunicipal;

use App\Constantes\Constantes;
use App\Models\Avaluo;
use App\Models\Colindancia;
use App\Models\Construccion;
use App\Models\ConstruccionesComun;
use App\Models\Predio;
use App\Models\Terreno;
use App\Models\TerrenosComun;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Notificacion extends Component
{

    public $años;
    public $año;
    public $folio;
    public $usuario;
    public $avaluo;
    public $fecha_notificacion;
    public $modal = false;

    public function buscarAvaluo(){

        $this->validate([
            'año' => 'required',
            'folio' => 'required',
            'usuario' => 'required',
        ]);

        try {

            $this->avaluo = Avaluo::where('año', $this->año)
                                        ->where('folio', $this->folio)
                                        ->where('usuario', $this->usuario)
                                        ->whereNull('notificado_en')
                                        ->whereNull('notificado_por')
                                        ->whereIn('estado', ['impreso', 'concluido'])
                                        ->firstOrFail();

            $this->reset(['folio', 'usuario']);

        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['warning', "El avalúo no existe."]);

        } catch (\Throwable $th) {
            Log::error("Error al buscar avalúo en notificación convenio municipal por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function abrirModal(){

        $this->modal = true;

    }

    public function notificar(){

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

        $this->actualizaPredio($predio);

        $this->actualizarAvaluo($predio->id);

        $this->dispatch('mostrarMensaje', ['success', "El predio se actualizó correctamente en el padrón catastral."]);

        $this->reset(['avaluo', 'modal']);

    }

    public function actualizaPredio($predio){

        $observaciones = 'SE ACTUALIZA EL PREDIO MEDIANTE AVALÚO DE ACTUALIZACIÓN CON FOLIO '. $this->avaluo->año . '-' . $this->avaluo->folio . '-' . $this->avaluo->usuario . '. ' . $this->avaluo->observaciones;

        $predio->update([
            'status' => 'activo',
            'estado' => $this->avaluo->predioAvaluo->estado,
            'es_habitacional' => $this->avaluo->predioAvaluo->es_habitacional,
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
            'observaciones' =>  $observaciones,
            'domicilio_notificacion' => $this->avaluo->predioAvaluo->domicilio_notificacion,
            'actualizado_por' => auth()->user()->id
        ]);

        $predio->audits()->latest()->first()->update(['tags' => 'Actualización mediante avalúo de actualización: ' . $this->avaluo->año . '-' . $this->avaluo->folio . '-' . $this->avaluo->usuario . '.']);

        $this->procesarRelaciones($predio);

        $predio->movimientos()->create([
                'nombre' => 'Actualización mediante avalúo dea ctualización',
                'fecha' => $this->fecha_notificacion,
                'descripcion' =>  $observaciones,
                'creado_por' => auth()->id()
            ]);

    }

    public function procesarRelaciones($predio){

        /* Propietarios */
        if(! $this->avaluo->predio){

            foreach($this->avaluo->predioAvaluo->propietarios as $propietario){

                $predio->propietarios()->create([
                    'persona_id' => $propietario->persona_id,
                    'tipo' => $propietario->tipo,
                    'porcentaje_propiedad' => $propietario->porcentaje_propiedad,
                    'porcentaje_nuda' => $propietario->porcentaje_nuda,
                    'porcentaje_usufructo' => $propietario->porcentaje_usufructo,
                ]);

            }

        }else{

            if(! $predio->propietarios->count()){

                foreach($this->avaluo->predioAvaluo->propietarios as $propietario){

                    $predio->propietarios()->create([
                        'persona_id' => $propietario->persona_id,
                        'tipo' => $propietario->tipo,
                        'porcentaje_propiedad' => $propietario->porcentaje_propiedad,
                        'porcentaje_nuda' => $propietario->porcentaje_nuda,
                        'porcentaje_usufructo' => $propietario->porcentaje_usufructo,
                    ]);

                }

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
                'superficie_proporcional' => $construccionComun['superficie_proporcional'],
                'indiviso_construccion' => $construccionComun['indiviso_construccion'],
                'valor_clasificacion_construccion' => $construccionComun['valor_clasificacion_construccion'],
                'valor_construccion_comun' => $construccionComun['valor_construccion_comun'],
                'uso' => $construccionComun['uso'],
                'tipo' => $construccionComun['tipo'],
                'calidad' => $construccionComun['calidad'],
                'estado' => $construccionComun['estado'],
            ]);

        }

    }

    public function actualizarAvaluo($predioId){

        $this->avaluo->update([
            'predio' => $predioId,
            'actualizado_por' => auth()->id(),
            'notificado_por' => auth()->id(),
            'notificado_en' => $this->fecha_notificacion,
            'estado' => 'notificado',
        ]);

        $this->avaluo->predioAvaluo->update(['status' => 'notificado']);

        $this->avaluo->audits()->latest()->first()->update(['tags' => 'Notificó avalúo']);

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.valuacion.convenio-municipal.notificacion')->extends('layouts.admin');
    }
}
