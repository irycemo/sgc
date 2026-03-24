<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConstruccionComunResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'area_comun_construccion' => $this->area_comun_construccion,
            'superficie_proporcional' => $this->superficie_proporcional,
            'indiviso_construccion' => $this->indiviso_construccion,
            'valor_construccion_comun' => $this->valor_construccion_comun,
            'calidad' => $this->calidad,
            'estado' => $this->estado,
            'uso' => $this->uso,
            'tipo' => $this->tipo,
        ];
    }
}
