<?php

namespace App\Http\Livewire\Valuacion;

use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\Terreno;
use Livewire\Component;
use App\Models\Referencia;
use App\Models\Colindancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Condominioconstruccion;
use App\Models\CondominioTerreno;
use App\Models\Construccion;

class Notificacion extends Component
{

    public $inicio;
    public $final;
    public $pagination = 50;
    public $modal = false;
    public $avaluo;
    public $fecha_notificacion;

    public function abrirModal(Avaluo $avaluo){

        $this->avaluo = $avaluo;

        $this->avaluo->load('predio.colindancias', 'predio.condominioTerrenos', 'predio.condominioConstrucciones', 'predio.terrenos', 'predio.construcciones');

        $this->modal = true;

    }

    public function notificar(){

        $this->validate(
            ['fecha_notificacion' => 'required|before:tomorrow']
        );

        $predio = Predio::where('estado', $this->avaluo->predio->estado)
                            ->where('region_catastral', $this->avaluo->predio->region_catastral)
                            ->where('municipio', $this->avaluo->predio->municipio)
                            ->where('zona_catastral', $this->avaluo->predio->zona_catastral)
                            ->where('localidad', $this->avaluo->predio->localidad)
                            ->where('sector', $this->avaluo->predio->sector)
                            ->where('manzana', $this->avaluo->predio->manzana)
                            ->where('edificio', $this->avaluo->predio->edificio)
                            ->where('departamento', $this->avaluo->predio->departamento)
                            ->where('oficina', $this->avaluo->predio->oficina)
                            ->where('tipo_predio', $this->avaluo->predio->tipo_predio)
                            ->where('numero_registro', $this->avaluo->predio->numero_registro)
                            ->first();

        if($predio){

            try {

                $this->actualizaPredio($predio);

                $this->actualizarAvaluo();

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El predio se actualizó correctamente en el padrón catastral."]);

            } catch (\Throwable $th) {

                Log::error("Error al actualizar predio en el padron desde notificación de avaluo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->modal = false;

            }

        }else{

            try {

                $this->creaPredio();

                $this->actualizarAvaluo();

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El predio se creó correctamente en el padrón catastral."]);

            } catch (\Throwable $th) {

                Log::error("Error al crear predio desde notificación de avaluo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->modal = false;

            }

        }

    }

    public function creaPredio(){

        DB::transaction(function () {

            $predio = Predio::create([
                'status' => 'activo',
                'estado' => $this->avaluo->predio->estado,
                'region_catastral' => $this->avaluo->predio->region_catastral,
                'municipio' => $this->avaluo->predio->municipio,
                'zona_catastral' => $this->avaluo->predio->zona_catastral,
                'localidad' => $this->avaluo->predio->localidad,
                'sector' => $this->avaluo->predio->sector,
                'manzana' => $this->avaluo->predio->manzana,
                'edificio' => $this->avaluo->predio->edificio,
                'departamento' => $this->avaluo->predio->departamento,
                'oficina' => $this->avaluo->predio->oficina,
                'tipo_predio' => $this->avaluo->predio->tipo_predio,
                'numero_registro' => $this->avaluo->predio->numero_registro,
                'tipo_vialidad' => $this->avaluo->predio->tipo_vialidad,
                'tipo_asentamiento' => $this->avaluo->predio->tipo_asentamiento,
                'nombre_vialidad' => $this->avaluo->predio->nombre_vialidad,
                'numero_exterior' => $this->avaluo->predio->numero_exterior,
                'numero_exterior_2' => $this->avaluo->predio->numero_exterior_2,
                'numero_adicional' => $this->avaluo->predio->numero_adicional,
                'numero_adicional_2' => $this->avaluo->predio->numero_adicional_2,
                'numero_interior' => $this->avaluo->predio->numero_interior,
                'nombre_asentamiento' => $this->avaluo->predio->nombre_asentamiento,
                'codigo_postal' => $this->avaluo->predio->codigo_postal,
                'lote_fraccionador' => $this->avaluo->predio->lote_fraccionador,
                'manzana_fraccionador' => $this->avaluo->predio->manzana_fraccionador,
                'etapa_fraccionador' => $this->avaluo->predio->etapa_fraccionador,
                'nombre_predio' => $this->avaluo->predio->nombre_predio,
                'nombre_edificio' => $this->avaluo->predio->nombre_edificio,
                'clave_edificio' => $this->avaluo->predio->clave_edificio,
                'departamento_edificio' => $this->avaluo->predio->departamento_edificio,
                'uso_1' => $this->avaluo->predio->uso_1,
                'uso_2' => $this->avaluo->predio->uso_2,
                'uso_3' => $this->avaluo->predio->uso_3,
                'ubicacion_en_manzana' => $this->avaluo->predio->ubicacion_en_manzana,
                'superficie_terreno' => $this->avaluo->predio->superficie_terreno,
                'superficie_construccion' => $this->avaluo->predio->superficie_construccion,
                'superficie_judicial' => $this->avaluo->predio->superficie_judicial,
                'superficie_notarial' => $this->avaluo->predio->superficie_notarial,
                'valor_catastral' => $this->avaluo->predio->valor_catastral,
                'valor_total_terreno' => $this->avaluo->predio->valor_total_terreno,
                'valor_construccion' => $this->avaluo->predio->valor_construccion,
                'titulo_propiedad' => $this->avaluo->predio->titulo_propiedad,
                'curt' => $this->avaluo->predio->curt,
                'folio_real' => $this->avaluo->predio->folio_real,
                'xutm' => $this->avaluo->predio->xutm,
                'yutm' => $this->avaluo->predio->yutm,
                'zutm' => $this->avaluo->predio->zutm,
                'lon' => $this->avaluo->predio->lon,
                'lat' => $this->avaluo->predio->lat,
                'fecha_efectos' => $this->avaluo->predio->fecha_efectos,
                'fecha_notificacion' => $this->fecha_notificacion,
                'observaciones' => $this->avaluo->predio->observaciones,
            ]);

            $this->procesarRelaciones($predio);

        });

    }

    public function actualizaPredio($predio){

        DB::transaction(function () use($predio){

            $predio->update([
                'status' => 'activo',
                'estado' => $this->avaluo->predio->estado,
                'region_catastral' => $this->avaluo->predio->region_catastral,
                'municipio' => $this->avaluo->predio->municipio,
                'zona_catastral' => $this->avaluo->predio->zona_catastral,
                'localidad' => $this->avaluo->predio->localidad,
                'sector' => $this->avaluo->predio->sector,
                'manzana' => $this->avaluo->predio->manzana,
                'edificio' => $this->avaluo->predio->edificio,
                'departamento' => $this->avaluo->predio->departamento,
                'oficina' => $this->avaluo->predio->oficina,
                'tipo_predio' => $this->avaluo->predio->tipo_predio,
                'numero_registro' => $this->avaluo->predio->numero_registro,
                'tipo_vialidad' => $this->avaluo->predio->tipo_vialidad,
                'tipo_asentamiento' => $this->avaluo->predio->tipo_asentamiento,
                'nombre_vialidad' => $this->avaluo->predio->nombre_vialidad,
                'numero_exterior' => $this->avaluo->predio->numero_exterior,
                'numero_exterior_2' => $this->avaluo->predio->numero_exterior_2,
                'numero_adicional' => $this->avaluo->predio->numero_adicional,
                'numero_adicional_2' => $this->avaluo->predio->numero_adicional_2,
                'numero_interior' => $this->avaluo->predio->numero_interior,
                'nombre_asentamiento' => $this->avaluo->predio->nombre_asentamiento,
                'codigo_postal' => $this->avaluo->predio->codigo_postal,
                'lote_fraccionador' => $this->avaluo->predio->lote_fraccionador,
                'manzana_fraccionador' => $this->avaluo->predio->manzana_fraccionador,
                'etapa_fraccionador' => $this->avaluo->predio->etapa_fraccionador,
                'nombre_predio' => $this->avaluo->predio->nombre_predio,
                'nombre_edificio' => $this->avaluo->predio->nombre_edificio,
                'clave_edificio' => $this->avaluo->predio->clave_edificio,
                'departamento_edificio' => $this->avaluo->predio->departamento_edificio,
                'uso_1' => $this->avaluo->predio->uso_1,
                'uso_2' => $this->avaluo->predio->uso_2,
                'uso_3' => $this->avaluo->predio->uso_3,
                'ubicacion_en_manzana' => $this->avaluo->predio->ubicacion_en_manzana,
                'superficie_terreno' => $this->avaluo->predio->superficie_terreno,
                'superficie_construccion' => $this->avaluo->predio->superficie_construccion,
                'superficie_judicial' => $this->avaluo->predio->superficie_judicial,
                'superficie_notarial' => $this->avaluo->predio->superficie_notarial,
                'valor_catastral' => $this->avaluo->predio->valor_catastral,
                'valor_total_terreno' => $this->avaluo->predio->valor_total_terreno,
                'valor_construccion' => $this->avaluo->predio->valor_construccion,
                'titulo_propiedad' => $this->avaluo->predio->titulo_propiedad,
                'curt' => $this->avaluo->predio->curt,
                'folio_real' => $this->avaluo->predio->folio_real,
                'xutm' => $this->avaluo->predio->xutm,
                'yutm' => $this->avaluo->predio->yutm,
                'zutm' => $this->avaluo->predio->zutm,
                'lon' => $this->avaluo->predio->lon,
                'lat' => $this->avaluo->predio->lat,
                'fecha_efectos' => $this->avaluo->predio->fecha_efectos,
                'fecha_notificacion' => $this->fecha_notificacion,
                'observaciones' => $this->avaluo->predio->observaciones,
            ]);

            $this->procesarRelaciones($predio);

        });

    }

    public function procesarRelaciones($predio){

        DB::transaction(function () use($predio){

            /* Colindancias */
            foreach($predio->colindancias as $colindancia){

                Colindancia::destroy($colindancia->id);

            }

            foreach($this->avaluo->predio->colindancias as $colindancia){

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

            foreach($this->avaluo->predio->construcciones as $construccion){

                $predio->construcciones()->create([
                    'referencia' => $construccion['referencia'],
                    'valor_unitario' => $construccion['valor_unitario'],
                    'niveles' => $construccion['niveles'],
                    'superficie' => $construccion['superficie'],
                    'uso' => $construccion['uso'],
                    'tipo' => $construccion['tipo'],
                    'calidad' => $construccion['calidad'],
                    'estado' => $construccion['estado'],
                ]);

            }

            /* Terrenos */
            foreach($predio->terrenos as $terreno){

                Terreno::destroy($terreno->id);

            }

            foreach($this->avaluo->predio->terrenos as $terreno){

                $predio->terrenos()->create([
                    'superficie' => $terreno['superficie'],
                    'valor_unitario' => $terreno['valor_unitario'],
                    'demerito' => $terreno['demerito'],
                    'valor_demeritado' => $terreno['valor_demeritado'],
                    'valor_terreno' => $terreno['valor_terreno'],
                ]);

            }

            /* Terrenos de condominios */
            foreach($predio->condominioTerrenos as $construccion){

                CondominioTerreno::destroy($construccion->id);

            }

            foreach($this->avaluo->predio->condominioTerrenos as $construccion){

                $predio->condominioTerrenos()->create([
                    'area_terreno_comun' => $construccion['area_terreno_comun'],
                    'indiviso_terreno' => $construccion['indiviso_terreno'],
                    'valor_unitario' => $construccion['valor_unitario'],
                    'valor_terreno_comun' => $construccion['valor_terreno_comun'],
                ]);

            }

            /* Construcciones de condominios */
            foreach($predio->condominioConstrucciones as $construccion){

                Condominioconstruccion::destroy($construccion->id);

            }

            foreach($this->avaluo->predio->condominioConstrucciones as $construccion){

                $predio->condominioConstrucciones()->create([
                    'area_comun_construccion' => $construccion['area_comun_construccion'],
                    'indiviso_construccion' => $construccion['indiviso_construccion'],
                    'valor_clasificacion_construccion' => $construccion['valor_clasificacion_construccion'],
                    'valor_construccion_comun' => $construccion['valor_construccion_comun'],
                ]);

            }

        });

    }

    public function actualizarAvaluo(){

        $this->avaluo->update([
            'actualizado_por' => auth()->user()->id,
            'notificado_por' => auth()->user()->id,
            'notificado_en' => $this->fecha_notificacion,
            'estado' => 'notificado'
        ]);

        $this->modal = false;

    }

    public function render()
    {

        $avaluos = Avaluo::with('predio.propietarios.persona')
                                    ->whereBetween('folio', [$this->inicio, $this->final])
                                    ->whereNull('notificado_en')
                                    ->paginate($this->pagination);

        return view('livewire.valuacion.notificacion', compact('avaluos'))->extends('layouts.admin');
    }
}
