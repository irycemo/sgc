<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PredioCuentaPredialResource;

class TramiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'estado' => $this->estado,
            'año' => $this->año,
            'folio' => $this->folio,
            'usuario' => $this->usuario,
            'servicio_id' => $this->servicio_id,
            'servicio' => $this->servicio->nombre,
            'monto' => (float)$this->monto,
            'cantidad' => $this->cantidad,
            'linea_de_captura' => $this->linea_de_captura,
            'orden_de_pago' => $this->orden_de_pago,
            'folio_pago' => $this->folio_pago,
            'fecha_pago' => $this->fecha_pago?->format('d/m/Y'),
            'fecha_entrega' => $this->fecha_entrega?->format('d/m/Y'),
            'tipo_servicio' => $this->tipo_servicio,
            'tipo_tramite' => $this->tipo_tramite,
            'numero_oficio' => $this->numero_oficio,
            'fecha_vencimiento' => $this->limite_de_pago?->format('d/m/Y'),
            'nombre_solicitante' => $this->nombre_solicitante,
            'solicitante' => $this->solicitante,
            'created_at' => $this->created_at,
            'predios' => PredioCuentaPredialResource::collection($this->predios)
        ];

    }
}
