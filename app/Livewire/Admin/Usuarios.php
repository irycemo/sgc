<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Oficina;
use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;

class Usuarios extends Component
{
    use WithPagination;
    use ComponentesTrait;

    public $roles;
    public $areas_adscripcion;
    public $oficinas;
    public $modalPermisos = false;
    public $listaDePermisos = [];
    public $permisos;

    public User $modelo_editar;
    public $role;

    public $filters = [
        'rol' => '',
        'oficina' => '',
        'area' => ''
    ];

    protected function rules(){
        return [
            'modelo_editar.name' => 'required',
            'modelo_editar.valuador' => Rule::requiredIf($this->role === "3"),
            'modelo_editar.ap_paterno' => 'required',
            'modelo_editar.ap_materno' => 'required',
            'modelo_editar.email' => 'required|email|unique:users,email,' . $this->modelo_editar->id,
            'modelo_editar.status' => 'required|in:activo,inactivo',
            'role' => 'required',
            'modelo_editar.oficina_id' => 'required',
            'modelo_editar.area' => 'required'
         ];
    }

    protected $validationAttributes  = [
        'role' => 'rol',
        'oficina_id' => 'oficina',
        'modelo_editar.oficina' => 'ubicación'
    ];

    public function crearModeloVacio(){
        $this->modelo_editar =  User::make([
            'valuador' => false
        ]);
    }

    public function abrirModalEditar(User $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->role = $modelo['roles'][0]['id'];
    }

    public function abrirModalPermisos(User $modelo){

        $this->resetearTodo();

        $this->modalPermisos = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        foreach($modelo->getAllPermissions() as $permission)
            array_push($this->listaDePermisos, (string)$permission['id']);


    }

    public function asignar(){

        try {

            DB::transaction(function () {

                $this->modelo_editar->syncPermissions();

                foreach ($this->listaDePermisos as $permiso)
                    $this->modelo_editar->givePermissionTo(Permission::find($permiso)->name);


                $this->resetearTodo();

                $this->dispatch('mostrarMensaje', ['success', "Se actualizaron los permisos con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualizar permisos usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function guardar(){

        $this->validate();

        if(User::where('name', $this->modelo_editar->name)->where('ap_paterno', $this->modelo_editar->ap_paterno)->where('ap_materno', $this->modelo_editar->ap_materno)->first()){

            $this->dispatch('mostrarMensaje', ['error', "El usuario " . $this->modelo_editar->name . " " . $this->modelo_editar->ap_paterno . " " . $this->modelo_editar->ap_materno . " ya esta registrado."]);

            $this->resetearTodo();

            return;

        }

        try {

            DB::transaction(function () {

                $this->modelo_editar->password = bcrypt('sistema');
                $this->modelo_editar->creado_por = auth()->user()->id;
                $this->modelo_editar->clave = User::max('clave') + 1;
                $this->modelo_editar->save();

                $this->modelo_editar->auditAttach('roles', $this->role);

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "El usuario se creó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al crear usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function actualizar(){

        $this->validate();

        try{

            DB::transaction(function () {

                $this->modelo_editar->actualizado_por = auth()->user()->id;
                $this->modelo_editar->save();

                $this->modelo_editar->auditSync('roles', $this->role);

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "El usuario se actualizó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualizar usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function borrar(){

        try{

            $usuario = User::find($this->selected_id);

            $usuario->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "El usuario se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function mount(){

        $this->crearModeloVacio();

        array_push($this->fields, 'role', 'listaDePermisos', 'modalPermisos');

        $this->roles = Role::where('id', '!=', 1)->select('id', 'name')->orderBy('name')->get();

        $this->areas_adscripcion = Constantes::AREAS_ADSCRIPCION;

        sort($this->areas_adscripcion);

        $this->oficinas = Oficina::select('oficina', 'id', 'nombre')->whereNUll('cabecera')->orderBy('nombre')->get();

        $permisos = Permission::all();

        $this->permisos = $permisos->groupBy(function($permiso) {
            return $permiso->area;
        })->all();

    }

    public function render()
    {

        $usuarios = User::with('creadoPor', 'actualizadoPor', 'oficina')
                            ->where(function($q){
                                $q->where('name', 'LIKE', '%' . $this->search . '%')
                                    ->orWhere('email', 'LIKE', '%' . $this->search . '%')
                                    ->orWhere('ap_paterno', 'LIKE', '%' . $this->search . '%')
                                    ->orWhere('ap_materno', 'LIKE', '%' . $this->search . '%')
                                    ->orWhere('clave', 'LIKE', '%' . $this->search . '%');
                            })
                            ->when($this->filters['rol'], fn($q, $rol) => $q->whereHas('roles', function($q) use($rol){ $q->where('name', $rol); }))
                            ->when($this->filters['oficina'], fn($q, $oficina) => $q->whereHas('oficina', function($q) use($oficina){ $q->where('nombre', $oficina); }))
                            ->when($this->filters['area'], fn($q, $area) => $q->where('area', $area))
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.Admin.usuarios', compact('usuarios'))->extends('layouts.admin');
    }
}
