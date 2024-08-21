<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PredioCompletoResource extends JsonResource
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
            'superficie_terreno' => $this->superficie_terreno,
            'superficie_construccion' => $this->superficie_construccion,
            'superficie_notarial' => $this->superficie_notarial,
            'area_comun_terreno' => $this->area_comun_terreno,
            'area_comun_construccion' => $this->area_comun_construccion,
            'valor_terreno_comun' => $this->valor_terreno_comun,
            'valor_construccion_comun' => $this->valor_construccion_comun,
            'valor_total_terreno' => $this->valor_total_terreno,
            'valor_total_construccion' => $this->valor_total_construccion,
            'valor_catastral' => $this->valor_catastral,
            'tipo_vialidad' => $this->tipo_vialidad,
            'tipo_asentamiento' => $this->tipo_asentamiento,
            'nombre_vialidad' => $this->nombre_vialidad,
            'numero_exterior' => $this->numero_exterior,
            'numero_exterior_2' => $this->numero_exterior_2,
            'numero_adicional' => $this->numero_adicional,
            'numero_adicional_2' => $this->numero_adicional_2,
            'numero_interior' => $this->numero_interior,
            'nombre_asentamiento' => $this->nombre_asentamiento,
            'codigo_postal' => $this->codigo_postal,
            'lote_fraccionador' => $this->lote_fraccionador,
            'manzana_fraccionador' => $this->manzana_fraccionador,
            'etapa_fraccionador' => $this->etapa_fraccionador,
            'nombre_predio' => $this->nombre_predio,
            'nombre_edificio' => $this->nombre_edificio,
            'clave_edificio' => $this->clave_edificio,
            'departamento_edificio' => $this->departamento_edificio,
            'nombre_predio' => $this->nombre_predio,
            'lon' => $this->lon,
            'lat' => $this->lat,
            'xutm' => $this->xutm,
            'yutm' => $this->yutm,
            'zutm' => $this->zutm,
            'colindancias' => ColindanciaResource::make($this->colindancias)
        ];

    }
}
