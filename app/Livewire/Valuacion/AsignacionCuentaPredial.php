<?php

namespace App\Livewire\Valuacion;

use App\Models\User;
use App\Models\Predio;
use Livewire\Component;
use App\Models\AsignarCuenta;
use Illuminate\Validation\Rule;
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

            $cuenta = AsignarCuenta::where('tipo_titulo', $this->tipo_titulo)
                            ->where('titulo_propiedad', $this->titulo)
                            ->first();

            if($cuenta){

                $this->dispatch('mostrarMensaje', ['error', "El título de propiedad ya esta registrado con el predio: " . $cuenta->localidad . '-'  . $cuenta->oficina . '-'  . $cuenta->tipo_predio . '-' . $cuenta->numero_registro]);

                return;

            }

        }

        $ultimaCuentaAsignada = AsignarCuenta::where('localidad', $this->localidad)
                                            ->where('oficina', $this->oficina)
                                            ->where('tipo_predio', $this->tipo)
                                            ->latest()
                                            ->orderBy('numero_registro','desc')
                                            ->first();

        if(!$ultimaCuentaAsignada){

            $this->dispatch('mostrarMensaje', ['error', "No hay cuentas asignadas a la oficina " . $this->oficina . " localidad: " . $this->localidad]);

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

                        $cuenta = AsignarCuenta::create([
                            'localidad' => $this->localidad,
                            'oficina' => $this->oficina,
                            'tipo_predio' => $this->tipo,
                            'numero_registro' => $registroSolicitado,
                            'estatus' => 1,
                            'predio_origen' => $this->origen ? $this->origen : null,
                            'observaciones' => 'Cuenta preexistente',
                            'titulo_propiedad' => $this->cantidad == 1 ? $this->titulo : null,
                            'tipo_titulo' => $this->tipo_titulo,
                            'oficio' => $this->oficio,
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
                            'tipo_titulo' => $this->tipo_titulo,
                            'oficio' => $this->oficio,
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

        $this->cuentasAsignadas = AsignarCuenta::with('valuadorAsignado', 'creadoPor')
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

    public function buscarCampos(){

        $this->cuentasAsignadas = AsignarCuenta::with('valuadorAsignado', 'creadoPor')
                                                    ->when($this->titulo_busqueda != '' || $this->titulo_busqueda != null, function($q){
                                                        $q->where('titulo_propiedad', $this->titulo_busqueda);
                                                    })
                                                    ->when($this->oficio_busqueda != '' || $this->oficio_busqueda != null, function($q){
                                                        $q->where('oficio', $this->oficio_busqueda);
                                                    })
                                                    ->when($this->observaciones_busqueda != '' || $this->observaciones_busqueda != null, function($q){
                                                        $q->where('observaciones', 'LIKE' . '%' . $this->observaciones_busqueda . '%');
                                                    })
                                                    ->when($this->valuador_busqueda != '' || $this->valuador_busqueda != null, function($q){
                                                        $q->where('valuador', $this->valuador_busqueda);
                                                    })
                                                    ->orderBy('numero_registro', 'desc')
                                                    ->latest()
                                                    ->get();

        if(count($this->cuentasAsignadas) == 0)
            $this->dispatch('mostrarMensaje', ['error', "No hay resultados con los datos ingresado."]);

    }

    public function updatedOficina(){

        $this->valuadores = User::where('status', 'activo')
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

            $this->valuadores = User::where('status', 'activo')
                                        ->where('valuador', 1)
                                        ->orderBy('ap_paterno')
                                        ->get();
        }else{

            $this->valuadores = User::where('status', 'activo')
                                    ->where('oficina_id', auth()->user()->oficina_id)
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
