<?php

namespace App\Livewire\Cartografia\Conciliar;

use App\Models\Predio;
use Livewire\Component;
use Illuminate\Support\Arr;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Services\SistemaPeritosExternos\SistemaPeritosExternosService;
use App\Traits\Predios\ValidarSector;

class ConciliarAvaluosPeritosExternos extends Component
{

    use ValidarSector;

    public $paginaActual = 1;
    public $paginaAnterior;
    public $paginaSiguiente;
    public $pagination = 10;
    public $años;
    public $año;
    public $folio;
    public $usuario;
    public $modalConciliar = false;
    public $avaluo_seleccionado;

    public $region_catastral;
    public $municipio;
    public $zona_catastral;
    public $localidad;
    public $sector;
    public $manzana;
    public $predio;
    public $edificio;
    public $departamento;

    public function updatedFolio(){

        if($this->folio == '') $this->folio = null;

    }

    public function updatedUsuario(){

        if($this->usuario == '') $this->usuario = null;

    }

    public function nextPage(){ (int)$this->paginaActual++; $this->dispatch('gotoTop'); }

    public function previousPage(){ (int)$this->paginaActual--; $this->dispatch('gotoTop'); }

    public function validarDisponibilidad(){

        $predio = Predio::where('estado', 16)
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

        if($predio){

            throw new GeneralException("La clave catastral ya existe en el padrón, verifique.");

        }

    }

    public function abrirModalConciliar($avaluo){

        $this->modalConciliar = true;

        $this->avaluo_seleccionado =  $avaluo;

        $this->region_catastral = $this->avaluo_seleccionado['region_catastral'];
        $this->municipio = $this->avaluo_seleccionado['municipio'];
        $this->zona_catastral = $this->avaluo_seleccionado['zona_catastral'];
        $this->localidad = $this->avaluo_seleccionado['localidad'];
        $this->sector = $this->avaluo_seleccionado['sector'];
        $this->manzana = $this->avaluo_seleccionado['manzana'];
        $this->predio = $this->avaluo_seleccionado['predio'];
        $this->edificio = $this->avaluo_seleccionado['edificio'];
        $this->departamento = $this->avaluo_seleccionado['departamento'];

    }

    public function conciliar(){

        try {

            DB::transaction(function () {

                (new SistemaPeritosExternosService())->conciliarPredio([
                    'id' => $this->avaluo_seleccionado['id'],
                    'sector' => $this->sector,
                    'manzana' => $this->manzana,
                    'predio' => $this->predio,
                    'edificio' => $this->edificio,
                    'departamento' => $this->departamento,
                ]);

                $predio = Predio::where('region_catastral', $this->avaluo_seleccionado['region_catastral'])
                                    ->where('municipio', $this->avaluo_seleccionado['municipio'])
                                    ->where('zona_catastral', $this->avaluo_seleccionado['zona_catastral'])
                                    ->where('localidad', $this->avaluo_seleccionado['localidad'])
                                    ->where('sector', $this->avaluo_seleccionado['sector'])
                                    ->where('manzana', $this->avaluo_seleccionado['manzana'])
                                    ->where('predio', $this->avaluo_seleccionado['predio'])
                                    ->where('edificio', $this->avaluo_seleccionado['edificio'])
                                    ->where('departamento', $this->avaluo_seleccionado['departamento'])
                                    ->where('oficina', $this->avaluo_seleccionado['oficina'])
                                    ->where('tipo_predio', $this->avaluo_seleccionado['tipo_predio'])
                                    ->where('numero_registro', $this->avaluo_seleccionado['numero_registro'])
                                    ->first();

                if(!$predio){

                    throw new GeneralException('El predio no existe en el padrón');

                }

                $this->validarDisponibilidad();

                $this->validarSectorNoBinding($this->avaluo_seleccionado['localidad'], $this->avaluo_seleccionado['oficina'], $this->avaluo_seleccionado['municipio'], $this->sector);

                $predio->update([
                    'sector' => $this->sector,
                    'manzana' => $this->manzana,
                    'predio' => $this->predio,
                    'edificio' => $this->edificio,
                    'departamento' => $this->departamento,
                ]);

            });

            $this->modalConciliar = false;

            $this->dispatch('mostrarMensaje', ['success', "Se concilió la información con éxito."]);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al conciliar avalúo externo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    public function render()
    {

        $avaluos = [];

        try {

            $data = (new SistemaPeritosExternosService())->consultarAvaluosConciliar($this->año, $this->folio, $this->usuario, $this->paginaActual, $this->pagination);

            $this->paginaActual = Arr::get($data, 'meta.current_page');
            $this->paginaAnterior = Arr::get($data, 'links.prev');
            $this->paginaSiguiente = Arr::get($data, 'links.next');

            $avaluos = collect($data['data']);

        } catch (GeneralException $ex) {

            abort(403, message:$ex->getMessage());

        } catch (\Throwable $th) {

            Log::error("Error al consultar consultar avalúos de peritos externos es SGC. " . $th);

            abort(403, message:"Error al consultar avalúos de peritos externos");

        }

        return view('livewire.cartografia.conciliar.conciliar-avaluos-peritos-externos', compact('avaluos'))->extends('layouts.admin');

    }
}
