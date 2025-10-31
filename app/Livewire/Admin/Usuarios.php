<?php

namespace App\Livewire\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Oficina;
use Livewire\Component;
use App\Models\Permission;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Constantes\Constantes;
use App\Traits\ComponentesTrait;
use App\Mail\RegistroUsuarioMail;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Usuarios extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $roles;
    public $role;
    public $areas_adscripcion;
    public $oficinas;
    public $modalPermisos = false;
    public $listaDePermisos = [];
    public $permisos;

    public User $modelo_editar;

    public $filters = [
        'rol' => '',
        'oficina' => '',
        'area' => ''
    ];

    protected function rules(){
        return [
            'modelo_editar.name' => 'required',
            'modelo_editar.valuador' => 'accepted_if:role,3',
            'modelo_editar.email' => 'required|email|unique:users,email,' . $this->modelo_editar->id,
            'modelo_editar.estado' => 'required|in:activo,inactivo',
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

        if(isset($modelo['roles'][0]))
            $this->role = $modelo->roles()->first()->id;

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

                $this->modelo_editar->syncPermissions([]);

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

        if($this->revisarUsuariosUnicos()) return;

        if(User::where('name', $this->modelo_editar->name)->first()){

            $this->dispatch('mostrarMensaje', ['error', "El usuario " . $this->modelo_editar->name . " ya esta registrado."]);

            $this->resetearTodo();

            return;

        }

        try {

            DB::transaction(function () {

                if(app()->isProduction()){

                    $password = Str::password(12);

                }else{

                    $password = 'sistema';

                }

                $this->modelo_editar->password = bcrypt($password);
                $this->modelo_editar->creado_por = auth()->id();
                $this->modelo_editar->clave = User::max('clave') + 1;
                $this->modelo_editar->save();

                $this->modelo_editar->auditAttach('roles', $this->role);

                Mail::to($this->modelo_editar->email)->send(new RegistroUsuarioMail($this->modelo_editar, $password));

                $this->resetearTodo();

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

        if($this->revisarUsuariosUnicos()) return;

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

    public function resetearPassword($id){

        try{

            $usuario = User::find($id);

            if(app()->isProduction()){

                $password = Str::password(12);

                $usuario->password = bcrypt($password);

                Mail::to($usuario->email)->send(new RegistroUsuarioMail($usuario, $password));

            }else{

                $usuario->password = bcrypt('sistema');

            }

            $usuario->save();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La contraseña se reestableció con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al resetear contraseña por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function revisarUsuariosUnicos(){

        $role = Role::find($this->role)->first();

        if($role->name == 'Jefe de departamento inscripciones' && User::where('status', 'activo')->whereHas('roles', function($q){ $q->where('name', 'Jefe de departamento inscripciones'); })->first()){

            $this->dispatch('mostrarMensaje', ['error', "Solo puede haber un Jefe de departamento inscripciones activo a la vez."]);

            return true;

        }

        if($role->name == 'Jefe de departamento certificaciones' && User::where('status', 'activo')->whereHas('roles', function($q){ $q->where('name', 'Jefe de departamento certificaciones'); })->first()){

            $this->dispatch('mostrarMensaje', ['error', "Solo puede haber un Jefe de departamento certificaciones activo a la vez."]);

            return true;

        }

        if($role->name == 'Director' && User::where('status', 'activo')->whereHas('roles', function($q){ $q->where('name', 'Director'); })->first()){

            $this->dispatch('mostrarMensaje', ['error', "Solo puede haber un Director activo a la vez."]);

            return true;

        }

    }

    public function mount(){

        $this->crearModeloVacio();

        array_push($this->fields, 'role', 'listaDePermisos', 'modalPermisos');

        $this->roles = Role::where('id', '!=', 1)->select('id', 'name')->orderBy('name')->get();

        $this->areas_adscripcion = Constantes::AREAS_ADSCRIPCION;

        sort($this->areas_adscripcion);

        $permisos = Permission::all();

        $this->permisos = $permisos->groupBy(function($permiso) {
            return $permiso->area;
        })->all();

        $this->oficinas = Oficina::select('oficina', 'id', 'nombre')->whereNUll('cabecera')->orderBy('nombre')->get();

    }

    #[Computed]
    public function usuarios(){

        return User::with('creadoPor:id,name', 'actualizadoPor:id,name', 'oficina:id,oficina,nombre')
                        ->where(function($q){
                            $q->where('name', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('clave', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('email', 'LIKE', '%' . $this->search . '%');
                        })
                        ->when($this->filters['rol'], fn($q, $rol) => $q->whereHas('roles', function($q) use($rol){ $q->where('name', $rol); }))
                        ->when($this->filters['oficina'], fn($q, $oficina) => $q->whereHas('oficina', function($q) use($oficina){ $q->where('nombre', $oficina); }))
                        ->when($this->filters['area'], fn($q, $area) => $q->where('area', $area))
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.admin.usuarios')->extends('layouts.admin');

    }

}
