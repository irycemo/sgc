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
            'folio' => $this->año . '-' . $this->folio . '-' . $this->usuario,
            'clasificacion_zona' => $this->clasificacion_zona,
            'construccion_dominante' => $this->construccion_dominante,
            'agua' => $this->agua ? 'Si' : 'No',
            'drenaje' => $this->drenaje ? 'Si' : 'No',
            'pavimento' => $this->pavimento ? 'Si' : 'No',
            'energia_electrica' => $this->energia_electrica ? 'Si' : 'No',
            'alumbrado_publico' => $this->alumbrado_publico ? 'Si' : 'No',
            'banqueta' => $this->banqueta ? 'Si' : 'No',
            'observaciones' => $this->observaciones,
            'notificado_en' => $this->notificado_en,
            'notificado_por' => $this->notificador->name,
            'valuador' => $this->creadoPor->name,
            'bloques' => BloqueResource::collection($this->bloques),
            'predio' => new PredioApiResource($this->predioAvaluo),
        ];

    }
}
