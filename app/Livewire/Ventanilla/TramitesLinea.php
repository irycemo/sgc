<?php

namespace App\Livewire\Ventanilla;

use App\Models\Tramite;
use Livewire\Component;
use App\Models\Servicio;
use Livewire\WithPagination;
use App\Http\Constantes\Constantes;
use App\Http\Traits\ComponentesTrait;

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
        'tipoServicio' => '',
        'servicio' => '',
    ];

    public $servicios;

    public Tramite $modelo_editar;

    public function updatedFilters() { $this->resetPage(); }

    public function crearModeloVacio(){
        $this->modelo_editar = Tramite::make();
    }

    public function mount(){

        $this->crearModeloVacio();

        array_push($this->fields, 'predios', 'predio', 'localidad', 'oficina', 'tipo', 'registro');

        $this->servicios = Servicio::select('id', 'nombre')->whereIn('id', [3,4,5,6,7,8,9,10,11,66,67,68,64,65,57,55])->orderBy('nombre')->get();

        $this->años = Constantes::AÑOS;

        $this->sort = 'tipo_servicio';

        $this->direction = 'asc';

    }

    public function render()
    {

        $tramites = Tramite::query()
                            ->select('id', 'año', 'folio', 'usuario', 'estado', 'servicio_id', 'cantidad', 'monto', 'fecha_entrega', 'fecha_pago', 'tipo_tramite', 'tipo_servicio', 'nombre_solicitante', 'creado_por', 'actualizado_por', 'created_at', 'updated_at')
                            ->with('servicio', 'creadoPor', 'actualizadoPor')
                            ->where('usuario', 11)
                            /* ->whereNotIn('estado', ['nuevo', 'concluido']) */
                            ->when($this->filters['search'], fn($q, $search) => $q->where('nombre_solicitante', 'LIKE', '%' . $search . '%'))
                            ->when($this->filters['año'], fn($q, $año) => $q->where('año', $año))
                            ->when($this->filters['folio'], fn($q, $folio) => $q->where('folio', $folio))
                            ->when($this->filters['estado'], fn($q, $estado) => $q->where('estado', $estado))
                            ->when($this->filters['tipoServicio'], fn($q, $tipoServicio) => $q->where('tipo_servicio', $tipoServicio))
                            ->when($this->filters['servicio'], fn($q, $servicio) => $q->where('servicio_id', $servicio))
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.ventanilla.tramites-linea', compact('tramites'))->extends('layouts.admin');
    }
}
