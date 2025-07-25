<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RechazoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'observaciones' => $this->observaciones,
            'creado_por' => $this->creadoPor->name ?? '',
            'created_at' => $this->created_at
        ];
    }
}
