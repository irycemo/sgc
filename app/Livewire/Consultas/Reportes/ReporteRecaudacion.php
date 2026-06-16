<?php

namespace App\Livewire\Consultas\Reportes;

use App\Models\CategoriaServicio;
use App\Models\Servicio;
use App\Models\Tramite;
use Livewire\Component;

class ReporteRecaudacion extends Component
{

    public $categorias;
    public $categoria;
    public $servicios;
    public $servicio_id;
    public $fecha1;
    public $fecha2;
    public $tipo_tramite;

    public $tramites = [];

    public $total;

    public function updatedCategoria(){

        $this->servicios = Servicio::where('estado', 'activo')
                                    ->where('categoria_servicio_id', $this->categoria)
                                    ->orderBy('nombre')->get();

    }

    public function updated(){

        set_time_limit(120);

        $this->tramites = $this->tramites();

        $this->total();

    }

    public function tramites(){

        $tramites = Tramite::with('servicio:id,nombre')
                            ->select('id', 'servicio_id', 'fecha_pago', 'documento_de_pago', 'tipo_tramite', 'monto', 'creado_por')
                            ->whereNotNull('documento_de_pago')
                            ->when(isset($this->servicio_id) && $this->servicio_id != "", function($q){
                                return $q->where('servicio_id', $this->servicio_id);
                            })
                            ->when(isset($this->categoria) && $this->categoria != "", function($q){
                                return $q->whereHas('servicio', function($q){
                                    $q->select('id', 'categoria_servicio_id')
                                        ->where('categoria_servicio_id', $this->categoria);
                                });
                            })
                            ->when(isset($this->tipo_tramite) && $this->tipo_tramite != "", function($q){
                                return $q->where('tipo_tramite', $this->tipo_tramite);
                            })
                            ->whereBetween('fecha_pago', [$this->fecha1, $this->fecha2])
                            ->get();

        $array2 = [];

        foreach ($tramites as $tramite) {

            if(isset($array2[$tramite->servicio->nombre])) continue;

            $array2[$tramite->servicio->nombre]['monto'] = $tramites->where('servicio', $tramite->servicio)->sum('monto');

            $array2[$tramite->servicio->nombre]['cantidad'] = $tramites->where('servicio', $tramite->servicio)->count();

        }

        return $array2;

    }

    public function total(){

        $this->total = collect($this->tramites)->sum('monto');


    }

    public function mount(){

        $this->servicios = Servicio::where('estado', 'activo')
                                        ->orderBy('nombre')->get();

        $this->categorias = CategoriaServicio::orderBy('nombre')->get();

    }

    public function render()
    {
        return view('livewire.consultas.reportes.reporte-recaudacion');
    }

}
