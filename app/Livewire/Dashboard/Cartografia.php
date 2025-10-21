<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\PredioIgnorado;
use Illuminate\Support\Facades\DB;

class Cartografia extends Component
{

    public $predios_ignorados = [];

    public function mount(){

        $predios_ignorados = PredioIgnorado::select('estado', DB::raw('count(*) as total'))
                                            ->when(auth()->user()->hasRole('Oficina rentistica'), function($q){
                                                $q->where('oficina_id', auth()->user()->oficina_id);
                                            })
                                            ->where('estado', 'asignar clave')
                                            ->groupBy('estado')
                                            ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                                            ->get();

        foreach ($predios_ignorados as $predios_ignorado) {

            $this->predios_ignorados [] = ['estado' => $predios_ignorado->estado, 'total' => $predios_ignorado->total];

        }

    }

    public function render()
    {
        return view('livewire.dashboard.cartografia');
    }
}
