<?php

namespace App\Http\Resources;

use App\Http\Resources\BloqueResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvaluoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'año' => $this->año,
            'folio' => $this->folio,
            'usuario' => $this->usuario,
            'clasificacion_zona' => $this->clasificacion_zona,
            'construccion_dominante' => $this->construccion_dominante,
            'agua' => $this->agua,
            'drenaje' => $this->drenaje,
            'pavimento' => $this->pavimento,
            'energia_electrica' => $this->energia_electrica,
            'alumbrado_publico' => $this->alumbrado_publico,
            'banqueta' => $this->banqueta,
            'observaciones' => $this->observaciones,
            'notificado_en' => $this->notificado_en,
            'notificado_por' => $this->notificado_por,
            'bloques' => BloqueResource::collection($this->bloques),
            'predio' => new PredioApiResource($this->predioAvaluo),
        ];

    }
}
