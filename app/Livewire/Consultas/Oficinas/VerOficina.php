<?php

namespace App\Livewire\Consultas\Oficinas;

use App\Models\Oficina;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class VerOficina extends Component
{

    public $ofice_id;

    public $oficina;
    public $sectores;
    public $editar = false;
    public $modal = false;

    public $titular;
    public $email;
    public $telefonos;
    public $autoridad_municipal;
    public $valuador_municipal;
    public $ubicacion;

    public $total_predios;
    public $predios;
    public $predios_urbanos;
    public $valor_urbanos;
    public $predios_rusticos;
    public $valor_rusticos;
    public $predios_88;
    public $predios_99;
    public $prediosLocalidad;
    public $prediosTipo;
    public $prediosSector;
    public $usuarios;
    public $usuario;
    public $permisos;

    public function actualizar(){

        $this->validate([
            'titular' => 'required',
            'email' => 'required|email',
            'telefonos' => 'required',
            'autoridad_municipal' => 'nullable',
            'valuador_municipal' => 'nullable',
            'ubicacion' => 'required',
        ]);

        try {

            $this->oficina->update([
                'titular' => $this->titular,
                'email' => $this->email,
                'telefonos' => $this->telefonos,
                'autoridad_municipal' => $this->autoridad_municipal,
                'valuador_municipal' => $this->valuador_municipal,
                'ubicacion' => $this->ubicacion,
                'actualizado_por' => auth()->user()->id
            ]);

            $this->editar = false;

        } catch (\Throwable $th) {

            Log::error("Error al actualizar oficina por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function abrirModalVer(User $user){

        $this->usuario = $user->getAllPermissions();

        $this->permisos = $user->getAllPermissions()->groupBy(function($permiso) {
            return $permiso->area;
        })->all();

        $this->modal = true;

    }

    public function mount(){

        if($this->ofice_id){

            $this->oficina = Oficina::find($this->ofice_id);

        }else{

            $this->oficina = auth()->user()->oficina;

        }

        $this->titular = $this->oficina->titular;
        $this->email = $this->oficina->email;
        $this->telefonos = $this->oficina->telefonos;
        $this->autoridad_municipal = $this->oficina->autoridad_municipal;
        $this->valuador_municipal = $this->oficina->valuador_municipal;
        $this->ubicacion = $this->oficina->ubicacion;
        $this->sectores = json_decode($this->oficina->sectores, true);

        if(auth()->user()->hasRole('Administrador'))
            $this->usuarios = User::where('estado', 'activo')->where('oficina_id', $this->oficina->id)->get();
        else
            $this->usuarios = User::where('estado', 'activo')->where('oficina_id', $this->oficina->id)->where('area', auth()->user()->area)->get();

        /* $this->total_predios = Predio::count();

        $this->predios = Predio::where('oficina', $this->oficina->oficina)->where('localidad', $this->oficina->localidad)->count();

        $this->predios_urbanos =  Predio::where('tipo_predio', 1)->where('oficina', $this->oficina->oficina)->where('localidad', $this->oficina->localidad)->count();

        $this->valor_urbanos =  Predio::where('tipo_predio', 1)->where('oficina', $this->oficina->oficina)->where('localidad', $this->oficina->localidad)->sum('valor_catastral');

        $this->predios_rusticos =  Predio::where('tipo_predio', 2)->where('oficina', $this->oficina->oficina)->where('localidad', $this->oficina->localidad)->count();

        $this->valor_rusticos =  Predio::where('tipo_predio', 2)->where('oficina', $this->oficina->oficina)->where('localidad', $this->oficina->localidad)->sum('valor_catastral');

        $this->predios_88 =  Predio::where('sector', 88)->where('oficina', $this->oficina->oficina)->where('localidad', $this->oficina->localidad)->count();

        $this->predios_99 =  Predio::where('sector', 99)->where('oficina', $this->oficina->oficina)->where('localidad', $this->oficina->localidad)->count();

        */



    }

    public function render()
    {
        return view('livewire.consultas.oficinas.ver-oficina')->extends('layouts.admin');
    }
}
