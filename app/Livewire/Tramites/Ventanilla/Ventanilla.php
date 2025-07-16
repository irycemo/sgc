<?php

namespace App\Livewire\Tramites\Ventanilla;

use App\Models\Notaria;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Servicio;
use App\Models\Dependencia;
use Livewire\Attributes\On;
use App\Constantes\Constantes;
use App\Models\CategoriaServicio;

class Ventanilla extends Component
{

    public $solicitantes;
    public $dependencias;
    public $notarias;

    public $años;
    public $año;

    public $categorias;
    public $categoria;
    public $categoria_seleccionada;

    public $servicios;
    public $servicio;
    public $servicio_seleccionado;

    public $tramite;
    public $tramite_año;
    public $tramite_folio;
    public $tramite_usuario;

    public $flag = false;
    public $flags = [
        'Simple' => false,
        'Completo' => false,
        'Certificaciones catastrales' => false,
        'Predio Ignorado' => false,
        'Inspecciones Oculares' => false,
        'Expedición de duplicados de documentos catastrales' => false,
        'Levantamientos topográficos' => false
    ];

    #[On('reset')]
    public function resetearTodo(){

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

            $this->dispatch('mostrarMensaje', ['warning', 'Seleccione una catagoría correcta.']);

            return;

        }

        $this->reset('flags');

        $this->flags[$componente] = true;

    }

    public function buscarTramite(){

        $this->validate(['tramite_folio' => 'required', 'tramite_año' => 'required', 'tramite_usuario' => 'required']);

        $this->reset(['categoria_seleccionada', 'servicio_seleccionado', 'flags']);

        $this->tramite = Tramite::with('predios.propietarios.persona', 'servicio')
                                    ->where('año', $this->tramite_año)
                                    ->where('folio', $this->tramite_folio)
                                    ->where('usuario', $this->tramite_usuario)
                                    ->first();

        if(!$this->tramite){

            $this->dispatch('mostrarMensaje', ['warning', "No se encontro el trámite."]);

            $this->reset(['categoria_seleccionada', 'servicio_seleccionado', 'servicios', 'categoria','tramite_folio', 'tramite', 'flag', 'tramite_usuario']);

            return;

        }

        $this->categoria_seleccionada = json_encode($this->tramite->servicio->categoria);

        $this->updatedCategoriaSeleccionada();

        $this->servicio_seleccionado = json_encode($this->tramite->servicio);

        $this->updatedServicioSeleccionado();

        if($this->tramite) $this->dispatch('cargarTramite', $this->tramite);

        $this->reset(['categoria_seleccionada', 'servicio_seleccionado', 'servicios', 'categoria','tramite_folio', 'tramite_usuario']);

    }

    public function mount(){

        $this->solicitantes = Constantes::SOLICITANTES;

        $this->dependencias = Dependencia::orderBy('nombre')->get();

        $this->notarias = Notaria::orderBy('numero')->get();

        $this->categorias = CategoriaServicio::orderBy('nombre')->get();

        $this->años = Constantes::AÑOS;

        $this->tramite_año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.tramites.ventanilla.ventanilla')->extends('layouts.admin');
    }
}
