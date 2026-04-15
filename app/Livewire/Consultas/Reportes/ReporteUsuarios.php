<?php

namespace App\Livewire\Consultas\Reportes;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ReporteUsuarios extends Component
{

    use WithPagination;

    public $fecha1;
    public $fecha2;
    public $pagination = 10;

    public $estado;
    public $oficinas;
    public $oficina;
    public $documentos;
    public $documento;
    public $roles;
    public $rol;
    public $permisos;
    public $permiso;

    public function descargarExcel(){

        $this->fecha1 = $this->fecha1 . ' 00:00:00';
        $this->fecha2 = $this->fecha2 . ' 23:59:59';


        try {

            return Excel::download(new UsersExport($this->estado, $this->oficina, $this->año, $this->documento, $this->fecha1, $this->fecha2), 'Reporte_de_certificaciones_' . now()->format('d-m-Y') . '.xlsx');

        } catch (\Throwable $th) {

            Log::error("Error generar archivo de reporte de certificaciones por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    #[Computed]
    public function certificaciones(){

        return User::with('oficina:id,nombre')
                    ->when (isset($this->estado) && $this->estado != "", function($q){
                        $q->where('estado', $this->estado);
                    })
                    ->when(isset($this->oficina) && $this->oficina != "", function($q){
                        return $q->where('oficina_id', $this->oficina);
                    })
                    ->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2 . ' 23:59:59'])
                    ->paginate($this->pagination);

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->documentos = Constantes::CERTIFICACIONES;

        $this->oficinas = Oficina::select('id', 'nombre')->orderBy('nombre')->get();

    }

    public function render()
    {
        return view('livewire.consultas.reportes.reporte-usuarios');
    }
}
