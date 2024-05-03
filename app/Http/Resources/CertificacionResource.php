<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificacionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'uuid' => $this->uuid,
            'año' => $this->año,
            'folio' => $this->folio,
            'documento' => $this->documento,
            'cadena_original' => $this->cadena_originial,
            'cadena_encriptada' => $this->cadena_encriptada,
            'estado' => $this->estado
        ];

    }
}
