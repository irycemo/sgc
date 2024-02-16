<?php

namespace App\Livewire\Admin\Avaluos;

use App\Http\Constantes\Constantes;
use App\Models\User;
use Livewire\Component;
use App\Models\PredioAvaluo;
use Livewire\WithPagination;
use App\Http\Traits\ComponentesTrait;

class Avaluos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    use WithPagination;
    use ComponentesTrait;

    public PredioAvaluo $modelo_editar;

    public $valuadores;

    public $años;

    public $filters = [
        'año' => '',
        'folio' => '',
        'valuador' => '',
        'localidad' => '',
        'oficina' => '',
        'tipo' => '',
        'registro' => '',
    ];

    public function crearModeloVacio(){
        $this->modelo_editar = PredioAvaluo::make();
    }

    public function mount(){

        $this->valuadores = User::whereNotNull('valuador')->orderBy('ap_paterno')->get();

        $this->años = Constantes::AÑOS;

        $this->crearModeloVacio();

    }

    public function render()
    {

        $predios = PredioAvaluo::with('actualizadoPor', 'avaluo.asignadoA')
                            ->when($this->filters['año'], function($q, $año) {
                                $q->whereHas('avaluo', function($q) use($año){
                                        $q->where('año', $this->filters['año']);
                                });
                            })
                            ->when($this->filters['folio'], function($q, $folio) {
                                $q->whereHas('avaluo', function($q) use($folio){
                                        $q->where('folio', $this->filters['folio']);
                                });
                            })
                            ->when($this->filters['valuador'], function($q, $valuador) {
                                $q->whereHas('avaluo', function($q) use($valuador){
                                        $q->where('asignado_a', $this->filters['valuador']);
                                });
                            })
                            ->when($this->filters['localidad'], fn($q, $localidad) => $q->where('localidad', $this->filters['localidad']))
                            ->when($this->filters['oficina'], fn($q, $oficina) => $q->where('oficina', $this->filters['oficina']))
                            ->when($this->filters['tipo'], fn($q, $tipo) => $q->where('tipo_predio', $this->filters['tipo']))
                            ->when($this->filters['registro'], fn($q, $registro) => $q->where('numero_registro', $this->filters['registro']))
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.Admin.avaluos.avaluos', compact('predios'))->extends('layouts.admin');

    }
}
