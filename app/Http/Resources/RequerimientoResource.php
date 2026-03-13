<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequerimientoResource extends JsonResource
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
            'descripcion' => $this->descripcion,
            'creado_por' => $this->creadoPor->name,
            'created_at' => $this->created_at,
            'usuario_stl' => $this->usuario_stl,
            'archivo_url' => $this->archivo_url,
            'estado' => $this->estado,
        ];
    }
}
