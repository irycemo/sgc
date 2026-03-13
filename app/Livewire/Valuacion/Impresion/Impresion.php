<?php

namespace App\Livewire\Valuacion\Impresion;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Enums\Tramites\AvaluoPara;

class Impresion extends Component
{

    public $lista_avaluo_para;
    public int|null $avaluo_para;

    #[On('resetAvaluoPara')]
    public function resetAvaluoPara(){

        $this->reset('avaluo_para');

    }

    public function updatedAvaluoPara(){

        $this->dispatch('changeAvaluoPara', $this->avaluo_para);

    }

    public function mount(){

        $this->lista_avaluo_para = AvaluoPara::cases();

    }

    public function render()
    {
        return view('livewire.valuacion.impresion.impresion')->extends('layouts.admin');
    }
}

