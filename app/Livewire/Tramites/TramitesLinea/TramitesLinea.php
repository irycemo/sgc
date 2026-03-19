<?php

namespace App\Livewire\Tramites\TramitesLinea;

use App\Models\Tramite;
use Livewire\Component;
use Livewire\WithPagination;
use App\Constantes\Constantes;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;

class TramitesLinea extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $años;

    public $filters = [
        'search' => '',
        'año' => '',
        'folio' => '',
        'estado' => '',
        'servicio' => '',
        'mes' => ''
    ];

    public $servicios;

    public Tramite $modelo_editar;

    public function updatedFilters() { $this->resetPage(); }

    public function crearModeloVacio(){
        $this->modelo_editar = Tramite::make();
    }

    public function abrirModal(Tramite $modelo){

        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    #[Computed]
    public function tramites(){

        return Tramite::query()
                ->select('id', 'año', 'folio', 'usuario', 'estado', 'servicio_id', 'cantidad', 'monto', 'fecha_entrega', 'fecha_pago', 'tipo_tramite', 'tipo_servicio', 'nombre_solicitante', 'creado_por', 'actualizado_por', 'created_at', 'updated_at')
                ->with('servicio:id,nombre,clave_ingreso', 'creadoPor:id,name', 'actualizadoPor:id,name')
                ->whereIn('usuario', [11, 1202])
                ->whereIn('estado', ['pagado', 'autorizado'])
                ->whereHas('servicio', function ($q){
                    $q->whereIn('clave_ingreso', ['DM34', 'DM32', 'DM35', 'DM31']);
                })
                ->whereHas('predios', function($q){
                    $q->where('oficina', auth()->user()->oficina->oficina);
                })
                ->when($this->filters['search'], fn($q, $search) => $q->where('nombre_solicitante', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['año'], fn($q, $año) => $q->where('año', $año))
                ->when($this->filters['folio'], fn($q, $folio) => $q->where('folio', $folio))
                ->when($this->filters['estado'], fn($q, $estado) => $q->where('estado', $estado))
                ->when($this->filters['mes'], fn($q, $mes) => $q->whereMonth('created_at', $mes))
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->pagination);

    }

    public function mount(){

        $this->crearModeloVacio();

        array_push($this->fields, 'predios', 'predio', 'localidad', 'oficina', 'tipo', 'registro');

        $this->años = Constantes::AÑOS;

        $this->filters['año'] = now()->format('Y');

        $this->sort = 'tipo_servicio';

        $this->direction = 'asc';

    }

    public function render()
    {
        return view('livewire.tramites.tramites-linea.tramites-linea')->extends('layouts.admin');
    }
}
