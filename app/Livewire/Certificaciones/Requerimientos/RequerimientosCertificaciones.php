<?php

namespace App\Livewire\Certificaciones\Requerimientos;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Certificacion;
use App\Constantes\Constantes;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RequerimientosCertificaciones extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public Certificacion $modelo_editar;

    public $observacion;
    public $años;

    public $filters = [
        'año' => '',
        'folio' => '',
        'tAño' => '',
        'tFolio' => '',
        'localidad' => '',
        'p_oficina' => '',
        't_predio' => '',
        'registro' => '',
    ];

    protected function rules(){
        return [
            'observacion' => 'required'
         ];
    }

    protected $validationAttributes  = [
        'modelo_editar.name' => 'nombre',
    ];

    public function crearModeloVacio(){
        $this->modelo_editar = Certificacion::make();
    }

    public function abrirModalEditar(Certificacion $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->modelo_editar->load('requerimientos.creadoPor');

    }

    public function responder($string = null){

        $this->validate();

        try {

            DB::transaction(function () use ($string){

                $this->modelo_editar->requerimientos()->create([
                    'descripcion' => $this->observacion,
                    'creado_por' => auth()->id(),
                    'estado' => $string ?? 'respuesta'
                ]);

                foreach ($this->modelo_editar->requerimientos as $requerimiento) {

                    if($requerimiento->estado == 'nuevo'){

                        $requerimiento->update(['estado' => 'atendido']);

                    }

                }

            });

            $this->dispatch('mostrarMensaje', ['success', "El requerimiento ha sido atendido."]);

            $this->reset(['modal','observacion']);


        } catch (\Throwable $th) {

            Log::error("Error atender requerimiento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    #[Computed]
    public function certificaciones(){

        return Certificacion::with('tramite:id,año,folio,usuario', 'predio:id,localidad,oficina,tipo_predio,numero_registro')
                                ->has('requerimientos')
                                ->doesntHave('ultimoRequerimientoFinalizado')
                                ->where('estado', 'activo')
                                ->when(!auth()->user()->hasRole('Administrador'), function($q){
                                    $q->where('oficina_id', auth()->user()->oficina_id);
                                })
                                ->when($this->filters['tFolio'], function($q, $tFolio){
                                    $q->WhereHas('tramite', function($q) use($tFolio){
                                        $q->where('folio', $tFolio);
                                    });
                                })
                                ->when($this->filters['localidad'], function($q, $localidad){
                                    $q->WhereHas('predio', function($q) use($localidad){
                                        $q->where('localidad', $localidad);
                                    });
                                })
                                ->when($this->filters['p_oficina'], function($q, $oficina){
                                    $q->WhereHas('predio', function($q) use($oficina){
                                        $q->where('oficina', $oficina);
                                    });
                                })
                                ->when($this->filters['t_predio'], function($q, $t_predio){
                                    $q->WhereHas('predio', function($q) use($t_predio){
                                        $q->where('tipo_predio', $t_predio);
                                    });
                                })
                                ->when($this->filters['registro'], function($q, $registro){
                                    $q->WhereHas('predio', function($q) use($registro){
                                        $q->where('numero_registro', $registro);
                                    });
                                })
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);

    }

    public function mount(){

        $this->crearModeloVacio();

        $this->años = Constantes::AÑOS;

        $this->filters['tAño'] = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.certificaciones.requerimientos.requerimientos-certificaciones')->extends('layouts.admin');
    }
}
