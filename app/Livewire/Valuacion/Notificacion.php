<?php

namespace App\Livewire\Valuacion;

use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\Persona;
use App\Models\Terreno;
use Livewire\Component;
use App\Models\Colindancia;
use App\Models\Propietario;
use App\Models\Construccion;
use App\Models\CondominioTerreno;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Condominioconstruccion;

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

        $this->avaluo->load('predioAvaluo.colindancias', 'predioAvaluo.condominioTerrenos', 'predioAvaluo.condominioConstrucciones', 'predioAvaluo.terrenos', 'predioAvaluo.construcciones', 'predioAvaluo.propietarios.persona');

        $this->modal = true;

    }

    public function notificar(){

        $this->validate(
            ['fecha_notificacion' => 'required|before:tomorrow']
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

                    $this->actualizarAvaluo();

                    $this->dispatch('mostrarMensaje', ['success', "El predio se actualizó correctamente en el padrón catastral."]);

                });

            } catch (\Throwable $th) {

                Log::error("Error al actualizar predio en el padron desde notificación de avaluo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
                $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->modal = false;

            }

        }else{

            try {

                DB::transaction(function () {

                    $this->creaPredio();

                    $this->actualizarAvaluo();

                    $this->dispatch('mostrarMensaje', ['success', "El predio se creó correctamente en el padrón catastral."]);

                });

            } catch (\Throwable $th) {

                Log::error("Error al crear predio desde notificación de avaluo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
                $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->modal = false;

            }

        }

    }

    public function creaPredio(){

        DB::transaction(function () {

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
                'valor_catastral' => $this->avaluo->predioAvaluo->valor_catastral,
                'xutm' => $this->avaluo->predioAvaluo->xutm,
                'yutm' => $this->avaluo->predioAvaluo->yutm,
                'zutm' => $this->avaluo->predioAvaluo->zutm,
                'lon' => $this->avaluo->predioAvaluo->lon,
                'lat' => $this->avaluo->predioAvaluo->lat,
                'fecha_efectos' => $this->fecha_notificacion,
                'observaciones' => $this->avaluo->predioAvaluo->observaciones,
                'origen' => 'Alta mediante avaluo'
            ]);

            $predio->movimientos()->create([
                'nombre' => 'Alta mediante avaluo',
                'fecha' => $this->fecha_notificacion,
                'descripcion' => 'Se da de alta predio en el padrón catastral mediante el avalúo con folio '. $this->avaluo->año . '-' . $this->avaluo->folio . '.'
            ]);

            $predio->audits()->latest()->first()->update(['tags' => 'Se genera predio apartir de avalúo: ' . $this->avaluo->año . '-' . $this->avaluo->folio]);

            $this->procesarRelaciones($predio);

        });

    }

    public function actualizaPredio($predio){

        DB::transaction(function () use($predio){

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
                'superficie_judicial' => $this->avaluo->predioAvaluo->superficie_judicial,
                'superficie_notarial' => $this->avaluo->predioAvaluo->superficie_notarial,
                'area_comun_terreno' => $this->avaluo->predioAvaluo->area_comun_terreno,
                'area_comun_construccion' => $this->avaluo->predioAvaluo->area_comun_construccion,
                'valor_terreno_comun' => $this->avaluo->predioAvaluo->valor_terreno_comun,
                'valor_construccion_comun' => $this->avaluo->predioAvaluo->valor_construccion_comun,
                'valor_total_terreno' => $this->avaluo->predioAvaluo->valor_total_terreno,
                'valor_total_construccion' => $this->avaluo->predioAvaluo->valor_total_construccion,
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

            $predio->audits()->latest()->first()->update(['tags' => 'Actualización mediante avalúo: ' . $this->avaluo->folio]);

            $this->procesarRelaciones($predio);

        });

    }

    public function procesarRelaciones($predio){

        DB::transaction(function () use($predio){

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
                    'porcentaje' => $propietario->porcentaje,
                ]);

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

            /* Terrenos de condominios */
            foreach($predio->condominioTerrenos as $construccion){

                CondominioTerreno::destroy($construccion->id);

            }

            foreach($this->avaluo->predioAvaluo->condominioTerrenos as $construccion){

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

            foreach($this->avaluo->predioAvaluo->condominioConstrucciones as $construccion){

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

        DB::transaction(function (){

            $this->avaluo->update([
                'actualizado_por' => auth()->user()->id,
                'notificado_por' => auth()->user()->id,
                'notificado_en' => $this->fecha_notificacion,
                'estado' => 'notificado'
            ]);

            $this->avaluo->predioAvaluo->update(['status' => 'notificado']);

            $this->avaluo->audits()->latest()->first()->update(['tags' => 'Notifico avalúo']);

            $this->modal = false;

        });

    }

    public function render()
    {

        $avaluos = Avaluo::with('predioAvaluo.propietarios.persona')
                                    ->whereIn('estado', ['impreso', 'concluido'])
                                    ->whereBetween('folio', [$this->inicio, $this->final])
                                    ->whereNull('notificado_en')
                                    ->whereNull('notificado_por')
                                    ->paginate($this->pagination);

        return view('livewire.valuacion.notificacion', compact('avaluos'))->extends('layouts.admin');
    }
}
