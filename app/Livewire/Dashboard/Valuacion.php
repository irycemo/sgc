<?php

namespace App\Livewire\Dashboard;

use App\Models\Avaluo;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Valuacion extends Component
{

    public $predios_ignorados = [];
    public $variaciones_catastrales = [];
    public $avaluos = [];

    public function mount(){

        $predios_ignorados = Avaluo::select('estado', DB::raw('count(*) as total'))
                                            ->when(auth()->user()->valuador, function($q){
                                                $q->where('asignado_a', auth()->id());
                                            })
                                            ->whereNotNull('predio_ignorado_id')
                                            ->groupBy('estado')
                                            ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                                            ->get();

        foreach ($predios_ignorados as $predios_ignorado) {

            $this->predios_ignorados [] = ['estado' => $predios_ignorado->estado, 'total' => $predios_ignorado->total];

        }

        $variaciones_catastrales = Avaluo::select('estado', DB::raw('count(*) as total'))
                                            ->when(auth()->user()->valuador, function($q){
                                                $q->where('asignado_a', auth()->id());
                                            })
                                            ->whereNotNull('variacion_catastral_id')
                                            ->groupBy('estado')
                                            ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                                            ->get();

        foreach ($variaciones_catastrales as $variaciones_catastrale) {

            $this->variaciones_catastrales [] = ['estado' => $variaciones_catastrale->estado, 'total' => $variaciones_catastrale->total];

        }

        $avaluos = Avaluo::select('estado', DB::raw('count(*) as total'))
                                            ->when(auth()->user()->valuador, function($q){
                                                $q->where('asignado_a', auth()->id());
                                            })
                                            ->groupBy('estado')
                                            ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                                            ->get();

        foreach ($avaluos as $avaluo) {

            $this->avaluos [] = ['estado' => $avaluo->estado, 'total' => $avaluo->total];

        }


    }

    public function render()
    {
        return view('livewire.dashboard.valuacion');
    }
}
