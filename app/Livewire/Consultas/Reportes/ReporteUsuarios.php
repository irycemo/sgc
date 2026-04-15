<?php

namespace App\Livewire\Consultas\Reportes;

use App\Exports\UsersExport;
use App\Models\Oficina;
use App\Models\Permission;
use App\Models\Role;
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

            return Excel::download(new UsersExport($this->estado, $this->oficina, $this->rol, $this->permiso, $this->fecha1, $this->fecha2), 'Reporte_de_usuarios_' . now()->format('d-m-Y') . '.xlsx');

        } catch (\Throwable $th) {

            Log::error("Error generar archivo de reporte de usuarios por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    #[Computed]
    public function usuarios(){

        return User::with('oficina:id,nombre')
                    ->when (isset($this->estado) && $this->estado != "", function($q){
                        $q->where('estado', $this->estado);
                    })
                    ->when(isset($this->oficina) && $this->oficina != "", function($q){
                        return $q->where('oficina_id', $this->oficina);
                    })
                    ->when(isset($this->rol) && $this->rol != "", function($q){
                        $q->whereHas('roles', function($q){
                            $q->where('name', $this->rol);
                        });
                    })
                    ->when(isset($this->permiso) && $this->permiso != "", function($q){
                        $q->whereHas('permissions', function($q){
                            $q->where('name', $this->permiso);
                        });
                    })
                    ->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2 . ' 23:59:59'])
                    ->paginate($this->pagination);

    }

    public function mount(){

        $this->oficinas = Oficina::select('id', 'nombre')->orderBy('nombre')->get();

        $this->roles = Role::orderBy('name')->get();

        $this->permisos = Permission::orderBy('name')->get();

    }

    public function render()
    {
        return view('livewire.consultas.reportes.reporte-usuarios');
    }
}
