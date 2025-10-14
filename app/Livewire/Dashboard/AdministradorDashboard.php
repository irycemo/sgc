<?php

namespace App\Livewire\Dashboard;

use App\Models\Avaluo;
use Livewire\Component;
use App\Models\Traslado;
use App\Models\Certificacion;
use App\Models\PredioIgnorado;
use App\Models\VariacionCatastral;
use Illuminate\Support\Facades\DB;

class AdministradorDashboard extends Component
{

    public $certificaciones = [];
    public $certificados = [];
    public $traslados = [];
    public $avaluos = [];
    public $predios_ignorados = [];
    public $variaciones_catastrales = [];

    public function mount(){

        $certificaciones = Certificacion::select('estado', DB::raw('count(*) as total'))
                                        ->groupBy('estado')
                                        ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                                        ->get();

        foreach ($certificaciones as $certificacion) {

            $this->certificaciones [] = ['estado' => $certificacion->estado, 'total' => $certificacion->total];

        }


        $certificados = DB::table('predio_tramite')
                            ->select('estado', DB::raw('count(*) as total'))
                            ->groupBy('estado')
                            ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                            ->get();

        foreach ($certificados as $certificado) {

            $this->certificados [] = ['estado' => $certificado->estado, 'total' => $certificado->total];

        }

        $traslados = Traslado::select('estado', DB::raw('count(*) as total'))
                                ->groupBy('estado')
                                ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                                ->get();

        foreach ($traslados as $traslado) {

            $this->traslados [] = ['estado' => $traslado->estado, 'total' => $traslado->total];

        }

        $avaluos = Avaluo::select('estado', DB::raw('count(*) as total'))
                                ->groupBy('estado')
                                ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                                ->get();

        foreach ($avaluos as $avaluo) {

            $this->avaluos [] = ['estado' => $avaluo->estado, 'total' => $avaluo->total];

        }

        $predios_ignorados = PredioIgnorado::select('estado', DB::raw('count(*) as total'))
                                            ->groupBy('estado')
                                            ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                                            ->get();

        foreach ($predios_ignorados as $predios_ignorado) {

            $this->predios_ignorados [] = ['estado' => $predios_ignorado->estado, 'total' => $predios_ignorado->total];

        }

        $variaciones_catastrales = VariacionCatastral::select('estado', DB::raw('count(*) as total'))
                                            ->groupBy('estado')
                                            ->where('created_at', '>' , now()->startOfMonth()->toDateString())
                                            ->get();

        foreach ($variaciones_catastrales as $variaciones_catastrale) {

            $this->variaciones_catastrales [] = ['estado' => $variaciones_catastrale->estado, 'total' => $variaciones_catastrale->total];

        }

    }

    public function render()
    {
        return view('livewire.dashboard.administrador-dashboard');
    }

}
