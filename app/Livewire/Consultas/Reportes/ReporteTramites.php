<?php

namespace App\Livewire\Consultas\Reportes;

use App\Models\User;
use App\Models\Oficina;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Servicio;
use App\Models\Dependencia;
use Livewire\WithPagination;
use App\Exports\TramitesExport;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReporteTramites extends Component
{

    use WithPagination;

    public $fecha1;
    public $fecha2;
    public $pagination = 10;

    public $estado;
    public $servicios;
    public $servicio;
    public $tipo_tramite;
    public $tipo_servicio;
    public $dependencias;
    public $dependencia;
    public $usuarios;
    public $usuario;
    public $oficinas;
    public $oficina;

    public function descargarExcel(){

        $this->fecha1 = $this->fecha1 . ' 00:00:00';
        $this->fecha2 = $this->fecha2 . ' 23:59:59';


        try {

            return Excel::download(new TramitesExport($this->estado, $this->servicio, $this->tipo_tramite, $this->tipo_servicio, $this->dependencia, $this->usuario, $this->oficina, $this->fecha1, $this->fecha2), 'Reporte_de_trámites_' . now()->format('d-m-Y') . '.xlsx');

        } catch (\Throwable $th) {

            Log::error("Error generar archivo de reporte de trámites por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    #[Computed]
    public function tramites(){

        return Tramite::with('servicio')
                        ->when (isset($this->estado) && $this->estado != "", function($q){
                            $q->where('estado', $this->estado);
                        })
                        ->when (isset($this->servicio) && $this->servicio != "", function($q){
                            $q->where('servicio_id', $this->servicio);
                        })
                        ->when(isset($this->tipo_tramite) && $this->tipo_tramite != "", function($q){
                            return $q->where('tipo_tramite', $this->tipo_tramite);
                        })
                        ->when(isset($this->tipo_servicio) && $this->tipo_servicio != "", function($q){
                            return $q->where('tipo_servicio', $this->tipo_servicio);
                        })
                        ->when(isset($this->dependencia) && $this->dependencia != "", function($q){
                            return $q->where('nombre_solicitante', $this->dependencia);
                        })
                        ->when(isset($this->usuario) && $this->usuario != "", function($q){
                            return $q->where('creado_por', $this->usuario);
                        })
                        ->when(isset($this->oficina) && $this->oficina != "", function($q){
                            $q->whereHas('creadoPor', function($q){
                                $q->select('id', 'oficina_id')
                                    ->where('oficina_id', $this->oficina);
                            });
                        })
                        ->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2 . ' 23:59:59'])
                        ->paginate($this->pagination);

    }

    public function mount(){

        $this->servicios = Servicio::select('id', 'nombre')->orderBy('nombre')->get();

        $this->dependencias = Dependencia::orderBy('nombre')->get();

        $this->usuarios = User::select('id', 'name')->orderBy('name')->get();

        $this->oficinas = Oficina::select('id', 'nombre')->orderBy('nombre')->get();

    }

    public function render()
    {
        return view('livewire.consultas.reportes.reporte-tramites');
    }
}
