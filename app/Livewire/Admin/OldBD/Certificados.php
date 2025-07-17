<?php

namespace App\Livewire\Admin\OldBD;

use App\Models\OldCertificado;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;

class Certificados extends Component
{

    use WithPagination;

    public $certificados = [];

    public $filters = [
        'locl' => '',
        'ofna' => '',
        'tpre' => '',
        'nreg' => '',
        'ania' => '',
        'foli' => '',
        'atra' => '',
    ];

    public function buscar(){

        $this->certificados = OldCertificado::when($this->filters['locl'], fn($q, $locl) => $q->where('locl', $locl))
                                        ->when($this->filters['ofna'], fn($q, $ofna) => $q->where('ofna', $ofna))
                                        ->when($this->filters['tpre'], fn($q, $tpre) => $q->where('tpre', $tpre))
                                        ->when($this->filters['nreg'], fn($q, $nreg) => $q->where('nreg', $nreg))
                                        ->when($this->filters['ania'], fn($q, $ania) => $q->where('ania', $ania))
                                        ->when($this->filters['foli'], fn($q, $foli) => $q->where('foli', $foli))
                                        ->when($this->filters['atra'], fn($q, $atra) => $q->where('atra', $atra))
                                        ->orderBy('fecha', 'desc')
                                        ->get();

    }

    public function render()
    {
        return view('livewire.admin.old-b-d.certificados')->extends('layouts.admin');
    }
}
