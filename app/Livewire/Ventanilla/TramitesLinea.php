<?php

namespace App\Livewire\Ventanilla;

use Livewire\Component;

class TramitesLinea extends Component
{
    public function render()
    {
        return view('livewire.ventanilla.tramites-linea')->extends('layouts.admin');
    }
}
