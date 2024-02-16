<?php

namespace App\Livewire\Ventanilla;

use App\Models\Tramite;
use Livewire\Component;
use App\Models\Servicio;
use App\Models\CategoriaServicio;
use App\Http\Constantes\Constantes;
use App\Http\Traits\ComponentesTrait;

class Ventanilla extends Component
{

    use ComponentesTrait;

    public $año;
    public $años;
    public $categorias;
    public $categoria_seleccionada;
    public $categoria;
    public $servicios;
    public $servicio_seleccionado;
    public $servicio;
    public $tramite;
    public $tramite_folio;
    public $flag = false;
    public $flags = [
        'Simple' => false,
        'Completo' => false,
        'Certificaciones catastrales' => false,
        'Predio Ignorado' => false,
        'Inspecciones Oculares' => false,
        'Simple' => false,
        'Completo' => false,
        'Expedición de duplicados de documentos catastrales' => false,
        'Levantamientos topográficos' => false
    ];

    protected $listeners = [
        'reset' => 'resetAll',
        'crearBatch' => 'crearBatch'
    ];

    public function resetAll(){

        $this->reset(['categoria_seleccionada', 'servicio_seleccionado', 'categoria', 'servicios', 'servicio', 'flags']);

    }

    public function updatedCategoriaSeleccionada(){

        if($this->categoria_seleccionada == ""){

            $this->reset('categoria_seleccionada', 'servicio_seleccionado', 'servicio');

            return;

        }

        $this->categoria = json_decode($this->categoria_seleccionada, true);

        $this->servicios = Servicio::with('categoria')->where('categoria_servicio_id', $this->categoria['id'])->where('estado', 'activo')->get();

        $this->reset('flags');

    }

    public function updatedServicioSeleccionado(){

        if($this->servicio_seleccionado == ""){

            $this->reset('flags');

            return;

        }

        $this->servicio = json_decode($this->servicio_seleccionado, true);

        $this->mostrarComponente($this->categoria['nombre']);

        $this->dispatch('cambioServicio', $this->servicio);

        if($this->tramite)
            $this->dispatch('cargarTramite', $this->tramite);

        if($this->flag){

            $this->reset('tramite');

            $this->flag = false;

        }

    }

    public function mostrarComponente(string $categoria){

        $componente = match($categoria){
                            'Certificaciones catastrales' => 'Certificaciones catastrales',
                            'Predio Ignorado' => 'Predio Ignorado',
                            'Inspecciones Oculares' => 'Inspecciones Oculares',
                            'Simple' => 'Simple',
                            'Completo' => 'Completo',
                            'Expedición de duplicados de documentos catastrales' => 'Expedición de duplicados de documentos catastrales',
                            'Levantamientos topográficos' => 'Levantamientos topográficos',
                            'Autorización e inscripción de peritos valuadores de bienes inmuebles' => 'Simple',
                            'Desglose de predios y valuación' => 'Simple',
                            'Inscripción Catastral para Registro de Predios por Regularizar' => 'Simple',
                            'Georreferenciación de croquis administrativos del catastro' => 'Completo',
                            'Ubicación cartográfica por cambio de localidad' => 'Completo',
                            'Ubicación cartográfica para la asignación correcta de clave catastral'  => 'Completo',
                            'Levantamientos aerofotogramétricos y otros servicios de alta precisión' => 'Completo',
                            'Aviso Aclaratorio' => 'Completo',
                            'Revisión de Aviso y/o cancelación' => 'Completo',
                            'Cédula de actualización' => 'Completo',
                            'Modificación de datos administrativos catastrales'  => 'Completo',
                            'Ubicación de predios en cartografía'  => 'Completo',
                            'Información a propietarios o poseedores de predios registrados'   => 'Completo',
                            'Solicitud de Variación Catastral'  => 'Completo',
                            'Reestructuración de cuentas catastrales'  => 'Completo',
                            'Determinación de la ubicación física de predios'=> 'Completo',
                            'Expedición de planos catastrales'  => 'Simple',
                            'Levantamiento Topográfico con curvas de nivel' => 'Completo',
                            default => 'No encontrada',

                        };

        if($componente == 'No encontrada'){

            $this->dispatch('mostrarMensaje', ['error', 'Seleccione una catagoría correcta']);

            return;

        }

        foreach($this->flags as $key => $flag){
            $this->flags[$key] = false;
        }

        $this->flags[$componente] = true;

    }

    public function buscarTramite(){

        $this->validate(['tramite_folio' => 'required', 'año' => 'required']);

        $this->reset('categoria_seleccionada', 'servicio_seleccionado', 'flags');

        $this->tramite = Tramite::with('predios.propietarios.persona', 'servicio')
                                    ->where('año', $this->año)
                                    ->where('folio', $this->tramite_folio)
                                    ->whereIn('estado', ['pagado', 'nuevo'])
                                    ->first();

        if(!$this->tramite){

            $this->dispatch('mostrarMensaje', ['error', "No se encontro el trámite."]);

            $this->reset(['categoria_seleccionada', 'servicio_seleccionado', 'servicios', 'categoria','tramite_folio', 'tramite', 'flag']);

            return;

        }

        $this->categoria_seleccionada = json_encode($this->tramite->servicio->categoria);

        $this->updatedCategoriaSeleccionada();

        $this->servicio_seleccionado = json_encode($this->tramite->servicio);

        $this->updatedServicioSeleccionado();

        $this->flag = true;

        $this->reset(['categoria_seleccionada', 'servicio_seleccionado', 'servicios', 'categoria','tramite_folio']);

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

        $this->categorias = CategoriaServicio::orderBy('nombre')->get();

    }

    public function render()
    {
        return view('livewire.ventanilla.ventanilla')->extends('layouts.admin');
    }
}
