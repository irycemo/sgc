<?php

namespace App\Livewire\Ventanilla;

use App\Models\Tramite;
use Livewire\Component;

class TramitesLinea extends Component
{
    public function render()
    {

        $tramites = Tramite::query()
                            ->select('id', 'año', 'folio', 'usuario', 'estado', 'servicio_id', 'cantidad', 'monto', 'fecha_entrega', 'fecha_pago', 'tipo_tramite', 'tipo_servicio', 'nombre_solicitante', 'creado_por', 'actualizado_por', 'created_at', 'updated_at')
                            ->with('servicio', 'creadoPor', 'actualizadoPor')
                            ->where('usuario', )
                            ->when($this->filters['search'], fn($q, $search) => $q->where('nombre_solicitante', 'LIKE', '%' . $search . '%'))
                            ->when($this->filters['año'], fn($q, $año) => $q->where('año', $año))
                            ->when($this->filters['folio'], fn($q, $folio) => $q->where('folio', $folio))
                            ->when($this->filters['estado'], fn($q, $estado) => $q->where('estado', $estado))
                            ->when($this->filters['tipoTramite'], fn($q, $tipoTramite) => $q->where('tipo_tramite', $tipoTramite))
                            ->when($this->filters['servicio'], fn($q, $servicio) => $q->where('servicio_id', $servicio))
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.ventanilla.tramites-linea', compact('tramites'))->extends('layouts.admin');
    }
}
