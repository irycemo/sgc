<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CodigoPostalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'codigo' => $this->codigo,
            'tipo_asentamiento' => $this->tipo_asentamiento,
            'nombre_asentamiento' => $this->nombre_asentamiento,
            'municipio' => $this->municipio,
            'ciudad' => $this->ciudad
        ];

    }
}
