<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PredioCuentaPredialResource extends JsonResource
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
            'localidad' => $this->localidad,
            'oficina' => $this->oficina,
            'tipo_predio' => $this->tipo_predio,
            'numero_registro' => $this->numero_registro,
        ];

    }
}
