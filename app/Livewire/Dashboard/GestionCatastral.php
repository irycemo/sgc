<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Traslado;
use App\Models\Certificacion;
use App\Models\PredioTramite;
use Illuminate\Support\Facades\DB;

class GestionCatastral extends Component
{

    public $traslados = [];
    public $certificados = [];
    public $certificaciones = [];

    public function mount(){

        $certificaciones = Certificacion::select('estado', DB::raw('count(*) as total'))
                                        ->when(auth()->user()->hasRole('Oficina rentistica'), function($q){
                                            $q->where('oficina_id', auth()->user()->oficina_id);
                                        })
                                        ->groupBy('estado')
                                        ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                                        ->get();

        foreach ($certificaciones as $certificacion) {

            $this->certificaciones [] = ['estado' => $certificacion->estado, 'total' => $certificacion->total];

        }


        $certificados = PredioTramite::select('estado', DB::raw('count(*) as total'))
                            ->when(auth()->user()->hasRole('Oficina rentistica'), function($q){
                                $q->whereHas('tramite', function($q){
                                    $q->where('oficina_id', auth()->user()->oficina_id);
                                });
                            })
                            ->groupBy('estado')
                            ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                            ->get();

        foreach ($certificados as $certificado) {

            $this->certificados [] = ['estado' => $certificado->estado, 'total' => $certificado->total];

        }

        $traslados = Traslado::select('estado', DB::raw('count(*) as total'))
                                ->when(auth()->user()->hasRole('Fiscal'), function($q){
                                    $q->where('asignado_a', auth()->id());
                                })
                                ->groupBy('estado')
                                ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                                ->get();

        foreach ($traslados as $traslado) {

            $this->traslados [] = ['estado' => $traslado->estado, 'total' => $traslado->total];

        }

    }

    public function render()
    {
        return view('livewire.dashboard.gestion-catastral');
    }
}
