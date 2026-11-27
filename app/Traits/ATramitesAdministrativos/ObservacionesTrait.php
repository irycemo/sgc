<?php

namespace App\Traits\ATramitesAdministrativos;

use Illuminate\Support\Facades\Log;

trait ObservacionesTrait
{

    public $modal_observaciones = false;

    public $observaciones;

    public function guardarObservaciones(){

        $this->validate(['observaciones' => 'required']);

        try {

            $this->modelo_editar->update([
                'observaciones' => $this->observaciones,
                'actualizado_por' => auth()->id()
            ]);

            $this->modal_observaciones = false;

            $this->dispatch('mostrarMensaje', ['success', "Las observaciones se guardaron con éxito."]);

        } catch (\Throwable $th) {

            Log::error(
                "Error al guardar observaciones en tramite administrativo.",
                [
                    'message' => $th->getMessage(),
                    'user_id' => auth()->id(),
                    'user' => auth()->user()->name,
                    'trace' => $th->getTraceAsString()
                ]
            );

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

}
