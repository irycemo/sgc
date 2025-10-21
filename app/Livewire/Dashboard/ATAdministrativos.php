<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\PredioIgnorado;
use App\Models\VariacionCatastral;
use Illuminate\Support\Facades\DB;

class ATAdministrativos extends Component
{

    public $predios_ignorados = [];
    public $variaciones_catastrales = [];

    public function mount(){

        $predios_ignorados = PredioIgnorado::select('estado', DB::raw('count(*) as total'))
                                            ->when(auth()->user()->hasRole('Oficina rentistica'), function($q){
                                                $q->where('oficina_id', auth()->user()->oficina_id);
                                            })
                                            ->groupBy('estado')
                                            ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                                            ->get();

        foreach ($predios_ignorados as $predios_ignorado) {

            $this->predios_ignorados [] = ['estado' => $predios_ignorado->estado, 'total' => $predios_ignorado->total];

        }

        $variaciones_catastrales = VariacionCatastral::select('estado', DB::raw('count(*) as total'))
                                            ->when(auth()->user()->hasRole('Oficina rentistica'), function($q){
                                                $q->where('oficina_id', auth()->user()->oficina_id);
                                            })
                                            ->groupBy('estado')
                                            ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                                            ->get();

        foreach ($variaciones_catastrales as $variaciones_catastrale) {

            $this->variaciones_catastrales [] = ['estado' => $variaciones_catastrale->estado, 'total' => $variaciones_catastrale->total];

        }

    }

    public function render()
    {
        return view('livewire.dashboard.a-t-administrativos');
    }
}
