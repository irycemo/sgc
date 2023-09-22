<?php

namespace App\Http\Livewire\Consultas;

use App\Models\User;
use App\Models\Predio;
use Livewire\Component;
use App\Models\Oficina as Office;
use Illuminate\Support\Facades\Log;

class Oficina extends Component
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
    public $predios_rusticos;
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
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);

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

            $this->oficina = Office::find($this->ofice_id);

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

        $this->total_predios = Predio::count();

        $this->predios = Predio::select('id', 'tipo_predio', 'sector', 'valor_catastral', 'localidad')->where('oficina', $this->oficina->oficina)->orderBy('localidad')->get();

        $this->predios_urbanos = $this->predios->where('tipo_predio', 1)->count();

        $this->predios_rusticos = $this->predios->where('tipo_predio', 2)->count();

        $this->predios_88 = $this->predios->where('sector', 88)->count();

        $this->predios_99 = $this->predios->where('sector', 99)->count();

        $this->usuarios = User::where('status', 'activo')->where('oficina_id', $this->oficina->id)->where('area', auth()->user()->area)->get();

        $this->prediosLocalidad = $this->predios->groupBy('localidad')->toArray();

        foreach ($this->prediosLocalidad as $key => $predio ) {

            $this->prediosTipo [] = [
                'localidad' => $key,
                'tipo' => 1,
                'cantidad' => $this->predios->where('localidad', $key)->where('tipo_predio', 1)->count()
            ];

            $this->prediosTipo [] = [
                'localidad' => $key,
                'tipo' => 2,
                'cantidad' => $this->predios->where('localidad', $key)->where('tipo_predio', 2)->count()
            ];

        }

        $orderBySector = $this->predios->groupBy('sector')->toArray();

        foreach ($orderBySector as $key => $predio ) {


            $this->prediosSector [] = [
                'sector' => $key,
                'localidad' => $predio[0]['localidad'],
                'cantidad' => $this->predios->where('localidad', $predio[0]['localidad'])->where('tipo_predio', $predio[0]['tipo_predio'])->where('sector', $key)->count()
            ];

        }

    }

    public function render()
    {
        return view('livewire.consultas.oficina')->extends('layouts.admin');
    }
}
