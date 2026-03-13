<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OficinaResource extends JsonResource
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
            'region' => $this->region,
            'municipio' => $this->municipio,
            'oficina' => $this->oficina,
            'localidad' => $this->localidad,
            'tipo' => $this->tipo,
            'nombre' => $this->nombre,
            'ubicacion' => $this->ubicacion,
            'titular' => $this->titular,
            'email' => $this->email,
            'telefonos' => $this->telefonos,
            'autoridad_municipal' => $this->autoridad_municipal,
            'valuador_municipal' => $this->valuador_municipal,
            'cabecera' => $this->cabeceraMunicipal?->nombre,
        ];

    }
}
