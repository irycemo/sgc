<?php

namespace App\Livewire\Cartografia\AsignarClaveCatastral;

use App\Models\Avaluo;
use App\Models\Predio;
use Livewire\Component;
use App\Models\PredioAvaluo;
use Livewire\WithPagination;
use App\Models\PredioIgnorado;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Traits\Predios\ValidarSector;

class AsignarClaveCatastral extends Component
{

    use WithPagination;
    use ComponentesTrait;
    use ValidarSector;

    public PredioIgnorado $modelo_editar;

    public $region_catastral;
    public $municipio;
    public $localidad;
    public $sector;
    public $zona_catastral;
    public $manzana;
    public $predio;
    public $edificio;
    public $departamento;
    public $oficina;
    public $tipo_predio;

    protected function rules(){
        return [
            'region_catastral' => 'required|numeric',
            'municipio' => 'required|numeric',
            'localidad' => 'required|numeric',
            'sector' => 'required|numeric',
            'zona_catastral' => 'required|numeric',
            'manzana' => 'required|numeric',
            'predio' => 'required|numeric',
            'edificio' => 'required|numeric',
            'departamento' => 'required|numeric',
            'oficina' => 'required|numeric',
            'tipo_predio' => 'required|numeric',
         ];
    }

    public function crearModeloVacio(){
        $this->modelo_editar = PredioIgnorado::make();
    }

    public function resetear(){

        $this->reset([
            'region_catastral',
            'municipio',
            'localidad',
            'sector',
            'zona_catastral',
            'manzana',
            'predio',
            'edificio',
            'departamento',
            'modal'
        ]);

    }

    public function abrirModalAsignar(PredioIgnorado $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function asignarClaveCatastral(){

        $this->validate();

        try {

            $this->validarSectorNoBinding($this->localidad, $this->oficina, $this->municipio, $this->sector);

            $predio_padron = Predio::where('estado', 16)
                                            ->where('region_catastral', $this->region_catastral)
                                            ->where('municipio', $this->municipio)
                                            ->where('zona_catastral', $this->zona_catastral)
                                            ->where('localidad', $this->localidad)
                                            ->where('sector', $this->sector)
                                            ->where('manzana', $this->manzana)
                                            ->where('predio', $this->predio)
                                            ->where('edificio', $this->edificio)
                                            ->where('departamento', $this->departamento)
                                            ->first();

            if($predio_padron){

                throw new GeneralException('La clave catastral ingresada ya existe en el padrón.');

            }

            $predio_avaluo = PredioAvaluo::where('estado', 16)
                                            ->where('region_catastral', $this->region_catastral)
                                            ->where('municipio', $this->municipio)
                                            ->where('zona_catastral', $this->zona_catastral)
                                            ->where('localidad', $this->localidad)
                                            ->where('sector', $this->sector)
                                            ->where('manzana', $this->manzana)
                                            ->where('predio', $this->predio)
                                            ->where('edificio', $this->edificio)
                                            ->where('departamento', $this->departamento)
                                            ->first();

            if($predio_avaluo){

                throw new GeneralException('La clave catastral ingresada ya ha sido asignada a un avalúo de predio ignorado.');

            }else{

                DB::transaction(function () {


                    $predio_avaluo = PredioAvaluo::create([
                        'estado' =>  16,
                        'region_catastral' =>  $this->region_catastral,
                        'municipio' =>  $this->municipio,
                        'zona_catastral' =>  $this->zona_catastral,
                        'localidad' =>  $this->localidad,
                        'sector' =>  $this->sector,
                        'manzana' =>  $this->manzana,
                        'predio' =>  $this->predio,
                        'edificio' =>  $this->edificio,
                        'departamento' =>  $this->departamento,
                        'numero_registro' => 0,
                        'tipo_predio' => $this->tipo_predio,
                        'oficina' => $this->modelo_editar->oficina->oficina
                    ]);

                    $avaluo = Avaluo::create([
                        'estado' => 'nuevo',
                        'predio_avaluo' => $predio_avaluo->id,
                        'asignado_a' => $this->modelo_editar->valuador,
                        'año' => now()->format('Y'),
                        'usuario' => $this->modelo_editar->valuadorAsignado->clave,
                        'folio' => (Avaluo::where('año', now()->format('Y'))->where('usuario', $this->modelo_editar->valuadorAsignado->clave)->max('folio') ?? 0) + 1,
                        'creado_por' => auth()->id(),
                        'oficina_id' => $this->modelo_editar->oficina->id,
                        'predio_ignorado_id' => $this->modelo_editar->id
                    ]);

                    $this->modelo_editar->update(['estado' => 'clave asignada', 'actualizado_por' => auth()->id()]);

                    $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Asignó clave catastral']);

                    $this->dispatch('mostrarMensaje', ['success', "La clave catastral se asignó con éxito, se generó el avalúo de predio ignorado: " . $avaluo->año .'-' . $avaluo->folio . '-' . $avaluo->usuario. ' asignado al valuador: ' . $this->modelo_editar->valuadorAsignado->name]);

                });

                $this->resetear();

            }

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al asignar clave catastral por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    #[Computed]
    public function prediosIgnorados(){

        return PredioIgnorado::with('creadoPor', 'actualizadoPor', 'valuadorAsignado:id,name', 'oficina:id,nombre')
                    ->when(!auth()->user()->hasRole(['Administrador', 'Jefe de departamento']), function($q){
                        $q->where('oficina_id', auth()->user()->oficina_id);
                    })
                    ->where('estado', 'asignar clave')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->pagination);

    }

    public function mount(){

        $this->crearModeloVacio();

        $this->municipio = auth()->user()->oficina->municipio;

        $this->oficina = auth()->user()->oficina->oficina;

    }

    public function render()
    {
        return view('livewire.cartografia.asignar-clave-catastral.asignar-clave-catastral')->extends('layouts.admin');
    }
}
