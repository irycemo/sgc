<?php

namespace App\Livewire\Consultas\PlanosValores;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class PlanosValores extends Component
{

    public $planos = [];

    public function mount(){

        $archivos = Storage::disk('s3')->files('planos_valores');

        foreach ($archivos as $filePath) {

            $this->planos[] = [
                'path' => $filePath,
                'name' => basename($filePath),
                'url'  => Storage::disk('s3')->temporaryUrl(
                    $filePath,
                    now()->addMinutes(15)
                )
            ];

        }

    }

    public function render()
    {
        return view('livewire.consultas.planos-valores.planos-valores')->extends('layouts.admin');
    }
}
