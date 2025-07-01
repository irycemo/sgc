<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificacionListaResource extends JsonResource
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
            'tipo' => $this->tipo->label(),
            'año' => $this->año,
            'folio' => $this->folio,
            'estado' => $this->estado,
            'oficina_id' => $this->oficina_id,
            'tramite_id' => $this->tramite_id,
            'predio_id' => $this->predio_id,
            'observaciones' => $this->observaciones,
            'tramite_año' => $this->tramite->año,
            'tramite_folio' => $this->tramite->folio,
            'localidad' => $this->predio->localidad,
            'oficina' => $this->predio->oficina,
            'tipo_predio' => $this->predio->tipo_predio,
            'numero_registro' => $this->predio->numero_registro,
            'requerimientos' => RequerimientoResource::collection($this->requerimientos)
        ];
    }
}
