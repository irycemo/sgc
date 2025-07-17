<?php

namespace App\Livewire\Admin\OldBD;

use App\Models\OldTraslado;
use Livewire\Component;

class Traslados extends Component
{

    public $traslados = [];

    public $filters = [
        'locl' => '',
        'ofna' => '',
        'tpre' => '',
        'nreg' => '',
        'anit' => '',
        'cont' => '',
        'cnot' => '',
    ];

    public function buscar(){

        $this->traslados = OldTraslado::when($this->filters['locl'], fn($q, $locl) => $q->where('locl', $locl))
                                    ->when($this->filters['ofna'], fn($q, $ofna) => $q->where('ofna', $ofna))
                                    ->when($this->filters['tpre'], fn($q, $tpre) => $q->where('tpre', $tpre))
                                    ->when($this->filters['nreg'], fn($q, $nreg) => $q->where('nreg', $nreg))
                                    ->when($this->filters['anit'], fn($q, $anit) => $q->where('anit', $anit))
                                    ->when($this->filters['cont'], fn($q, $cont) => $q->where('cont', $cont))
                                    ->when($this->filters['cnot'], fn($q, $cnot) => $q->where('cnot', $cnot))
                                    ->get();

    }

    public function render()
    {
        return view('livewire.admin.old-b-d.traslados')->extends('layouts.admin');
    }
}
