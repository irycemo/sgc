<?php

namespace App\Http\Livewire\Valuacion;

use App\Models\User;
use App\Models\Predio;
use Livewire\Component;
use App\Models\AsignarCuenta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AsignacionCuentaPredial extends Component
{

    public $valuadores;
    public $valuador;
    public $localidad;
    public $oficina;
    public $tipo;
    public $titulo;
    public $cantidad;
    public $origen;
    public $observaciones;
    public $localidad_busqueda;
    public $oficina_busqueda;
    public $tipo_busqueda;
    public $registro_inicio;
    public $registro_final;
    public $cuentasAsignadas = [];

    protected function rules(){
        return [
            'valuador' => 'required',
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo' => 'required|numeric|min:1|max:2',
            'titulo' => 'nullable',
            'cantidad' => 'required',
            'origen' => 'nullable',
            'observaciones' => 'required',
         ];
    }

    public function crearCuentas(){

        $this->reset(['cuentasAsignadas']);

        $this->validate();

        $ultimaCuentaAsignada = AsignarCuenta::where('localidad', $this->localidad)
                                            ->where('oficina', $this->oficina)
                                            ->where('tipo_predio', $this->tipo)
                                            ->latest()
                                            ->orderBy('numero_registro','desc')
                                            ->first();

        if(!$ultimaCuentaAsignada){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "No hay cuentas asignadas a la oficina " . $this->oficina . " localidad: " . $this->localidad]);

            return;

        }

        $registroSolicitado = $ultimaCuentaAsignada->numero_registro + 1;

        $predio = null;

        try {

            DB::transaction(function () use($predio, $registroSolicitado){

                for ($i = 0; $i < $this->cantidad; $i++) {

                    $predio = Predio::where('localidad', $this->localidad)
                                        ->where('oficina', $this->oficina)
                                        ->where('tipo_predio', $this->tipo)
                                        ->where('numero_registro', $registroSolicitado)
                                        ->first();

                    if($predio){

                        $cuenta = AsignarCuenta::create([
                            'localidad' => $this->localidad,
                            'oficina' => $this->oficina,
                            'tipo_predio' => $this->tipo,
                            'numero_registro' => $registroSolicitado,
                            'estatus' => 1,
                            'predio_origen' => $this->origen ? $this->origen : null,
                            'observaciones' => 'Cuenta preexistente',
                            'titulo_propiedad' => $this->cantidad == 1 ? $this->titulo : null,
                            'valuador' => $this->valuador,
                            'creado_por' => auth()->user()->id
                        ]);

                        $cuenta->valuadorAsignado = [
                            'name' => $cuenta->valuadorAsignado->name,
                            'ap_paterno' => $cuenta->valuadorAsignado->ap_paterno,
                            'ap_materno' => $cuenta->valuadorAsignado->ap_materno
                        ];

                        $cuenta->creadoPor = null;

                        $this->cuentasAsignadas[] = $cuenta;

                        $i--;

                    }else{

                        $cuenta =AsignarCuenta::create([
                            'localidad' => $this->localidad,
                            'oficina' => $this->oficina,
                            'tipo_predio' => $this->tipo,
                            'numero_registro' => $registroSolicitado,
                            'observaciones' => $this->observaciones,
                            'titulo_propiedad' => $this->cantidad == 1 ? $this->titulo : null,
                            'valuador' => $this->valuador,
                            'predio_origen' => $this->origen ? $this->origen : null,
                            'creado_por' => auth()->user()->id
                        ]);

                        $cuenta->audits()->latest()->first()->update(['tags' => 'Asigno cuenta']);

                        $cuenta->valuadorAsignado = [
                            'name' => $cuenta->valuadorAsignado->name,
                            'ap_paterno' => $cuenta->valuadorAsignado->ap_paterno,
                            'ap_materno' => $cuenta->valuadorAsignado->ap_materno
                        ];

                        $cuenta->creadoPor = null;

                        $this->cuentasAsignadas[] = $cuenta;

                    }

                    $registroSolicitado ++;

                }

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "Las cuentas se asignaron correctamente al valuador."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al asignar cuentas prediales por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);

            $this->reset(['localidad', 'tipo', 'observaciones', 'cantidad', 'valuador', 'origen', 'cuentasAsignadas']);

        }

        $this->reset(['localidad', 'tipo', 'observaciones', 'cantidad', 'valuador', 'origen']);

    }

    public function buscarCuentas(){

        $this->validate([
            'localidad_busqueda' => 'required',
            'oficina_busqueda' => 'required',
            'tipo_busqueda' => 'required',
            'registro_inicio' => 'required',
            'registro_final' => 'required',
        ]);

        $this->cuentasAsignadas = AsignarCuenta::with('valuadorAsignado', 'creadoPor')
                                                    ->where('localidad', $this->localidad_busqueda)
                                                    ->where('oficina', $this->oficina_busqueda)
                                                    ->where('tipo_predio', $this->tipo_busqueda)
                                                    ->whereBetween('numero_registro', [$this->registro_inicio, $this->registro_final])
                                                    ->orderBy('numero_registro', 'desc')
                                                    ->latest()
                                                    ->get();

        if(count($this->cuentasAsignadas) == 0)
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "No hay resultados con los datos ingresado."]);

    }

    public function updatedOficina(){

        $this->valuadores = User::where('status', 'activo')
                                        ->where('valuador', 1)
                                        ->where('oficina', $this->oficina)
                                        ->orderBy('ap_paterno')
                                        ->get();

        $this->reset('valuador');

    }

    public function mount(){

        if(auth()->user()->hasRole('Administrador')){

            $this->valuadores = User::where('status', 'activo')
                                        ->where('valuador', 1)
                                        ->orderBy('ap_paterno')
                                        ->get();
        }else{

            $this->valuadores = User::where('status', 'activo')
                                    ->where('oficina', auth()->user()->oficina_id)
                                    ->where('valuador', 1)
                                    ->orderBy('ap_paterno')
                                    ->get();
        }


        $this->oficina = auth()->user()->oficina->oficina;

        $this->oficina_busqueda = $this->oficina;

    }

    public function render()
    {
        return view('livewire.valuacion.asignacion-cuenta-predial')->extends('layouts.admin');
    }
}
