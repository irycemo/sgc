<?php

namespace App\Livewire\Admin\OldBD;

use Livewire\Component;
use App\Models\OldAudit;

class Auditoria extends Component
{

    public $audits = [];

    public $filters = [
        'locl' => '',
        'ofna' => '',
        'tpre' => '',
        'nreg' => '',
        'ania' => '',
        'foli' => '',
        'usua' => '',
    ];

    public function buscar(){

        $this->audits = OldAudit::when($this->filters['locl'], fn($q, $locl) => $q->where('locl', $locl))
                                    ->when($this->filters['ofna'], fn($q, $ofna) => $q->where('ofna', $ofna))
                                    ->when($this->filters['tpre'], fn($q, $tpre) => $q->where('tpre', $tpre))
                                    ->when($this->filters['nreg'], fn($q, $nreg) => $q->where('nreg', $nreg))
                                    ->when($this->filters['ania'], fn($q, $ania) => $q->where('ania', $ania))
                                    ->when($this->filters['foli'], fn($q, $foli) => $q->where('foli', $foli))
                                    ->when($this->filters['usua'], fn($q, $usua) => $q->where('usua', $usua))
                                    /* ->orWhere('emple', 'LIKE', '%'. $this->search . '%') */
                                    ->orderBy('fecha', 'desc')
                                    ->get();

    }

    public function render()
    {
        return view('livewire.admin.old-b-d.auditoria')->extends('layouts.admin');
    }
}
