<?php

namespace App\Livewire\Tramites\TramitesLinea;

use App\Models\Tramite;
use Livewire\Component;
use App\Models\Servicio;
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
    ];

    public $servicios;

    public Tramite $modelo_editar;

    public function updatedFilters() { $this->resetPage(); }

    public function crearModeloVacio(){
        $this->modelo_editar = Tramite::make();
    }

    #[Computed]
    public function tramites(){

        return Tramite::query()
                ->select('id', 'año', 'folio', 'usuario', 'estado', 'servicio_id', 'cantidad', 'monto', 'fecha_entrega', 'fecha_pago', 'tipo_tramite', 'tipo_servicio', 'nombre_solicitante', 'creado_por', 'actualizado_por', 'created_at', 'updated_at')
                ->with('servicio', 'creadoPor', 'actualizadoPor')
                ->where('usuario', 11)
                ->whereIn('estado', ['pagado', 'autorizado'])
                ->whereHas('servicio', function ($q){
                    $q->whereIn('clave_ingreso', ['DM34', 'DM32', 'DM35', 'DM31']);
                })
                ->when($this->filters['search'], fn($q, $search) => $q->where('nombre_solicitante', 'LIKE', '%' . $search . '%'))
                ->when($this->filters['año'], fn($q, $año) => $q->where('año', $año))
                ->when($this->filters['folio'], fn($q, $folio) => $q->where('folio', $folio))
                ->when($this->filters['estado'], fn($q, $estado) => $q->where('estado', $estado))
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->pagination);

    }

    public function mount(){

        $this->crearModeloVacio();

        array_push($this->fields, 'predios', 'predio', 'localidad', 'oficina', 'tipo', 'registro');

        /* $this->servicios = Servicio::select('id', 'nombre')->whereIn('id', [3,4,5,6,7,8,9,10,11,66,67,68,64,65,57,55])->orderBy('nombre')->get(); */

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
