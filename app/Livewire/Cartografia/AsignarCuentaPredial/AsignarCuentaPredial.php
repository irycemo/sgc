<?php

namespace App\Livewire\Cartografia\AsignarCuentaPredial;

use App\Models\User;
use App\Models\Predio;
use Livewire\Component;
use App\Models\CuentaAsignada;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AsignarCuentaPredial extends Component
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
    public $cuentas_preexistentes = 0;
    public $tipo_titulo;
    public $oficio;
    public $titulo_busqueda;
    public $oficio_busqueda;
    public $observaciones_busqueda;
    public $valuador_busqueda;

    protected function rules(){
        return [
            'valuador' => 'required',
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo' => 'required|numeric|min:1|max:2',
            'titulo' => Rule::requiredIf($this->tipo_titulo != null),
            'tipo_titulo' => 'nullable',
            'oficio' => 'nullable',
            'cantidad' => 'required',
            'origen' => 'nullable',
            'observaciones' => 'required',
         ];
    }

    public function updatedTipoTitulo(){

        if($this->tipo_titulo != ''){

            $this->cantidad = 1;

        }

    }

    public function crearCuentas(){

        $this->reset(['cuentasAsignadas']);

        $this->validate();

        if($this->tipo_titulo && $this->titulo){

            $cuenta = CuentaAsignada::where('tipo_titulo', $this->tipo_titulo)
                            ->where('titulo_propiedad', $this->titulo)
                            ->first();

            if($cuenta){

                $this->dispatch('mostrarMensaje', ['warning', "El título de propiedad ya esta registrado con el predio: " . $cuenta->localidad . '-'  . $cuenta->oficina . '-'  . $cuenta->tipo_predio . '-' . $cuenta->numero_registro]);

                return;

            }

        }

        $ultimaCuentaAsignada = CuentaAsignada::where('localidad', $this->localidad)
                                            ->where('oficina', $this->oficina)
                                            ->where('tipo_predio', $this->tipo)
                                            ->latest()
                                            ->orderBy('numero_registro','desc')
                                            ->first();

        if(!$ultimaCuentaAsignada){

            $this->dispatch('mostrarMensaje', ['warning', "No hay cuentas asignadas a la oficina " . $this->oficina . " localidad: " . $this->localidad]);

            return;

        }

        $registroSolicitado = $ultimaCuentaAsignada->numero_registro + 1;

        $predio = null;

        if($this->tipo_titulo != ''){

            $this->cantidad = 1;

        }

        try {

            DB::transaction(function () use($predio, $registroSolicitado){

                for ($i = 0; $i < $this->cantidad; $i++) {

                    $predio = Predio::where('localidad', $this->localidad)
                                        ->where('oficina', $this->oficina)
                                        ->where('tipo_predio', $this->tipo)
                                        ->where('numero_registro', $registroSolicitado)
                                        ->first();

                    if($predio){

                        $cuenta = CuentaAsignada::create([
                            'localidad' => $this->localidad,
                            'oficina' => $this->oficina,
                            'tipo_predio' => $this->tipo,
                            'numero_registro' => $registroSolicitado,
                            'estatus' => 1,
                            'predio_origen' => $this->origen ? $this->origen : null,
                            'observaciones' => 'Cuenta preexistente',
                            'asignado_a' => $this->valuador,
                            'creado_por' => auth()->user()->id
                        ]);

                        $cuenta->valuadorAsignado = $cuenta->asignadoA->name;

                        $this->cuentasAsignadas[] = $cuenta;

                        $this->cuentas_preexistentes ++;

                        $i--;

                    }else{

                        $cuenta = CuentaAsignada::create([
                            'localidad' => $this->localidad,
                            'oficina' => $this->oficina,
                            'tipo_predio' => $this->tipo,
                            'numero_registro' => $registroSolicitado,
                            'observaciones' => $this->observaciones,
                            'titulo_propiedad' => $this->cantidad == 1 ? $this->titulo : null,
                            'tipo_titulo' => $this->tipo_titulo,
                            'oficio' => $this->oficio,
                            'asignado_a' => $this->valuador,
                            'predio_origen' => $this->origen ? $this->origen : null,
                            'creado_por' => auth()->user()->id
                        ]);

                        $cuenta->valuadorAsignado = $cuenta->asignadoA->name;

                        $this->cuentasAsignadas[] = $cuenta;

                    }

                    $registroSolicitado ++;

                }

                $this->dispatch('mostrarMensaje', ['success', "Las cuentas se asignaron correctamente al valuador."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al asignar cuentas prediales por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

            $this->reset(['localidad', 'tipo', 'observaciones', 'cantidad', 'valuador', 'origen', 'titulo', 'cuentasAsignadas', 'tipo_titulo', 'oficio']);

        }

        $this->reset(['localidad', 'tipo', 'observaciones', 'cantidad', 'valuador', 'origen', 'titulo', 'tipo_titulo', 'oficio']);

    }

    public function buscarCuentas(){

        $this->validate([
            'localidad_busqueda' => 'nullable',
            'oficina_busqueda' => Rule::requiredIf($this->localidad_busqueda != null),
            'tipo_busqueda' => Rule::requiredIf($this->localidad_busqueda != null),
            'registro_inicio' => Rule::requiredIf($this->localidad_busqueda != null),
            'registro_final' => Rule::requiredIf($this->localidad_busqueda != null),
        ]);

        $this->cuentasAsignadas = CuentaAsignada::with('valuadorAsignado', 'creadoPor')
                                                    ->where('localidad', $this->localidad_busqueda)
                                                    ->where('oficina', $this->oficina_busqueda)
                                                    ->where('tipo_predio', $this->tipo_busqueda)
                                                    ->whereBetween('numero_registro', [$this->registro_inicio, $this->registro_final])
                                                    ->orderBy('numero_registro', 'desc')
                                                    ->latest()
                                                    ->get();

        if(count($this->cuentasAsignadas) == 0)
            $this->dispatch('mostrarMensaje', ['error', "No hay resultados con los datos ingresado."]);

    }

    public function updatedOficina(){

        $this->valuadores = User::where('estado', 'activo')
                                        ->where('valuador', 1)
                                        ->whereHas('oficina', function($q){
                                            $q->where('oficina', $this->oficina);
                                        })
                                        ->orderBy('ap_paterno')
                                        ->get();

        $this->reset('valuador');

    }

    public function mount(){

        if(auth()->user()->hasRole('Administrador')){

            $this->valuadores = User::where('estado', 'activo')
                                        ->where('valuador', 1)
                                        ->orderBy('name')
                                        ->get();
        }else{

            $this->valuadores = User::where('status', 'activo')
                                    ->where('oficina_id', auth()->user()->oficina_id)
                                    ->where('valuador', 1)
                                    ->orderBy('name')
                                    ->get();
        }


        $this->oficina = auth()->user()->oficina->oficina;

        $this->oficina_busqueda = $this->oficina;

    }

    public function render()
    {
        return view('livewire.cartografia.asignar-cuenta-predial.asignar-cuenta-predial')->extends('layouts.admin');
    }
}
