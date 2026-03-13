<?php

namespace App\Livewire\Cartografia\ValidarCartografia;

use App\Constantes\Constantes;
use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Services\SistemaPeritosExternos\SistemaPeritosExternosService;

class ValidarCartografia extends Component
{

    public $paginaActual = 1;
    public $paginaAnterior;
    public $paginaSiguiente;
    public $pagination = 10;
    public $años;
    public $año;
    public $folio;
    public $usuario;
    public $modalValidar = false;
    public $avaluo_seleccionado;

    public function updatedFolio(){

        if($this->folio == '') $this->folio = null;

    }

    public function updatedUsuario(){

        if($this->usuario == '') $this->usuario = null;

    }

    public function nextPage(){ (int)$this->paginaActual++; $this->dispatch('gotoTop'); }

    public function previousPage(){ (int)$this->paginaActual--; $this->dispatch('gotoTop'); }

    public function abrirModalValidar($avaluo){

        $this->modalValidar = true;

        $this->avaluo_seleccionado =  $avaluo;

    }

    public function validar(){

        try {

            (new SistemaPeritosExternosService())->validarCartografia($this->avaluo_seleccionado['id']);

            $this->modalValidar = false;

            $this->dispatch('mostrarMensaje', ['success', "Se valido la información con éxito."]);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al validar cartografía de perito externo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

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

            $data = (new SistemaPeritosExternosService())->consultarCartografia($this->año, $this->folio, $this->usuario, $this->paginaActual, $this->pagination);

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

        return view('livewire.cartografia.validar-cartografia.validar-cartografia', compact('avaluos'))->extends('layouts.admin');

    }

}
