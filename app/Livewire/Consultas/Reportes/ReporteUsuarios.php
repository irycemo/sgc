<?php

namespace App\Livewire\Consultas\Reportes;

use App\Models\User;
use App\Models\Oficina;
use Livewire\Component;
use App\Http\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Reportes\UsuariosExport;

class ReporteUsuarios extends Component
{

    public $fecha1;
    public $fecha2;
    public $pagination = 10;

    public $estado;
    public $areas;
    public $area;
    public $oficinas;
    public $oficina;
    public $valuador;

    public function descargarExcel(){

        $this->fecha1 = $this->fecha1 . ' 00:00:00';
        $this->fecha2 = $this->fecha2 . ' 23:59:59';


        try {

            return Excel::download(new UsuariosExport($this->estado, $this->area, $this->oficina, $this->valuador, $this->fecha1, $this->fecha2), 'Reporte_de_usuarios_' . now()->format('d-m-Y') . '.xlsx');

        } catch (\Throwable $th) {

            Log::error("Error generar archivo de reporte de usuarios por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        $this->areas = Constantes::AREAS_ADSCRIPCION;

        $this->oficinas = Oficina::select('id', 'nombre')->orderBy('nombre')->get();

    }

    public function render()
    {

        $usuarios = User::with('oficina:id,nombre')
                                ->when (isset($this->estado) && $this->estado != "", function($q){
                                    $q->where('status', $this->estado);
                                })
                                ->when (isset($this->area) && $this->area != "", function($q){
                                    $q->where('area', $this->area);
                                })
                                ->when(isset($this->oficina) && $this->oficina != "", function($q){
                                    return $q->where('oficina_id', $this->oficina);
                                })
                                ->when(isset($this->valuador) && $this->valuador != "", function($q){
                                    return $q->where('valuador', $this->valuador);
                                })
                                ->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2 . ' 23:59:59'])
                                ->paginate($this->pagination);

        return view('livewire.consultas.reportes.reporte-usuarios', compact('usuarios'));
    }
}
