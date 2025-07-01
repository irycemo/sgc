<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\PropietarioResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PredioPropietariosResource extends JsonResource
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
            'region_catastral' => $this->region_catastral,
            'municipio' => $this->municipio,
            'zona_catastral' => $this->zona_catastral,
            'localidad' => $this->localidad,
            'sector' => $this->sector,
            'manzana' => $this->manzana,
            'predio' => $this->predio,
            'edificio' => $this->edificio,
            'departamento' => $this->departamento,
            'oficina' => $this->oficina,
            'tipo_predio' => $this->tipo_predio,
            'numero_registro' => $this->numero_registro,
            'propietarios' => PropietarioResource::collection($this->propietarios)
        ];
    }
}
