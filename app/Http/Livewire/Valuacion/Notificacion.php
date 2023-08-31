<?php

namespace App\Http\Livewire\Valuacion;

use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\Persona;
use App\Models\Terreno;
use Livewire\Component;
use App\Models\Referencia;
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

        $this->avaluo->load('predio.colindancias', 'predio.condominioTerrenos', 'predio.condominioConstrucciones', 'predio.terrenos', 'predio.construcciones', 'predio.propietarios.persona');

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
                            ->where('predio', $this->avaluo->predio->predio)
                            ->where('edificio', $this->avaluo->predio->edificio)
                            ->where('departamento', $this->avaluo->predio->departamento)
                            ->where('oficina', $this->avaluo->predio->oficina)
                            ->where('tipo_predio', $this->avaluo->predio->tipo_predio)
                            ->where('numero_registro', $this->avaluo->predio->numero_registro)
                            ->first();

        if($predio){

            try {

                DB::transaction(function () use($predio){

                    $this->actualizaPredio($predio);

                    $this->actualizarAvaluo();

                    $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El predio se actualizó correctamente en el padrón catastral."]);

                });

            } catch (\Throwable $th) {

                Log::error("Error al actualizar predio en el padron desde notificación de avaluo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->modal = false;

            }

        }else{

            try {

                DB::transaction(function () {

                    $this->creaPredio();

                    $this->actualizarAvaluo();

                    $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El predio se creó correctamente en el padrón catastral."]);

                });

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
                'predio' => $this->avaluo->predio->predio,
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
                'area_comun_terreno' => $this->avaluo->predio->area_comun_terreno,
                'area_comun_construccion' => $this->avaluo->predio->area_comun_construccion,
                'valor_terreno_comun' => $this->avaluo->predio->valor_terreno_comun,
                'valor_construccion_comun' => $this->avaluo->predio->valor_construccion_comun,
                'valor_total_terreno' => $this->avaluo->predio->valor_total_terreno,
                'valor_total_construccion' => $this->avaluo->predio->valor_total_construccion,
                'valor_catastral' => $this->avaluo->predio->valor_catastral,
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

            $predio->audits()->latest()->first()->update(['tags' => 'Se genera predio apartir de avalúo: ' . $this->avaluo->folio]);

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
                'predio' => $this->avaluo->predio->predio,
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
                'area_comun_terreno' => $this->avaluo->predio->area_comun_terreno,
                'area_comun_construccion' => $this->avaluo->predio->area_comun_construccion,
                'valor_terreno_comun' => $this->avaluo->predio->valor_terreno_comun,
                'valor_construccion_comun' => $this->avaluo->predio->valor_construccion_comun,
                'valor_total_terreno' => $this->avaluo->predio->valor_total_terreno,
                'valor_total_construccion' => $this->avaluo->predio->valor_total_construccion,
                'valor_catastral' => $this->avaluo->predio->valor_catastral,
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
            foreach($this->avaluo->predio->propietarios as $propietario){

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

        DB::transaction(function (){

            $this->avaluo->update([
                'actualizado_por' => auth()->user()->id,
                'notificado_por' => auth()->user()->id,
                'notificado_en' => $this->fecha_notificacion,
                'estado' => 'notificado'
            ]);

            $this->avaluo->predio->update(['status' => 'notificado']);

            $this->avaluo->audits()->latest()->first()->update(['tags' => 'Notifico avalúo']);

            $this->modal = false;

        });

    }

    public function render()
    {

        $avaluos = Avaluo::with('predio.propietarios.persona')
                                    ->where('estado', 'impreso')
                                    ->whereBetween('folio', [$this->inicio, $this->final])
                                    ->whereNull('notificado_en')
                                    ->whereNull('notificado_por')
                                    ->paginate($this->pagination);

        return view('livewire.valuacion.notificacion', compact('avaluos'))->extends('layouts.admin');
    }
}
