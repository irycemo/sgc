<?php

namespace App\Livewire\Certificaciones\CertificadoHistoria;

use App\Models\Predio;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Movimiento;
use App\Constantes\Constantes;
use App\Traits\ComponentesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Certificaciones\CertificadoHistoriaController;

class CertificadoHistoria extends Component
{

    use ComponentesTrait;

    public $radio;
    public $acciones_padron;
    public $años;
    public $director;

    public $año;
    public $folio;
    public $usuario;

    public $predio;

    public $numero_registro;
    public $region_catastral;
    public $municipio;
    public $localidad;
    public $sector;
    public $zona_catastral;
    public $manzana;
    public $predio_clave;
    public $edificio;
    public $departamento;
    public $tipo_predio;
    public $oficina;
    public $estado;

    public $nombre;
    public $fecha;
    public $descripcion;

    public $historia;
    public $tramite;
    public $cadena;

    public $impresionDirector = false;

    public Movimiento $modelo_editar;

    public function crearModeloVacio(){
        $this->modelo_editar = Movimiento::make();
    }

    public function buscarCuentaPredial(){

        $this->validate([
            'numero_registro' => 'required',
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo_predio' => 'required',
        ]);

        try {

            $this->predio = Predio::with('movimientos')
                                    ->where('numero_registro', $this->numero_registro)
                                    ->where('tipo_predio', $this->tipo_predio)
                                    ->where('localidad', $this->localidad)
                                    ->where('oficina', $this->oficina)
                                    ->firstOrFail();

            if($this->predio->status == 'bloqueado'){

                $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra bloqueado."]);
                $this->predio = null;
                return;

            }

        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['warning', "El predio no existe."]);

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function buscarClaveCatastral(){

        $this->validate([
            'region_catastral' => 'required',
            'municipio' => 'required',
            'localidad' => 'required',
            'sector' => 'required',
            'zona_catastral' => 'required',
            'manzana' => 'required',
            'predio_clave' => 'required',
            'edificio' => 'required',
            'departamento' => 'required',
        ]);

        try {

            $this->predio = Predio::with('movimientos')
                                    ->where('estado', 16)
                                    ->where('region_catastral', $this->region_catastral)
                                    ->where('municipio', $this->municipio)
                                    ->where('zona_catastral', $this->zona_catastral)
                                    ->where('localidad', $this->localidad)
                                    ->where('sector', $this->sector)
                                    ->where('manzana', $this->manzana)
                                    ->where('predio', $this->predio_clave)
                                    ->where('edificio', $this->edificio)
                                    ->where('departamento', $this->departamento)
                                    ->firstOrFail();

            if($this->predio->status == 'bloqueado'){

                $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra bloqueado."]);
                $this->predio = null;
                return;

            }

        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['warning', "El predio no existe."]);

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function buscarTramite(){

        $this->validate([
            'año' => 'required',
            'folio' => 'required',
            'usuario' => 'required',
        ]);

        try {

            $this->reset(['historia', 'predio']);

            $this->tramite = Tramite::where('año', $this->año)
                                        ->where('folio', $this->folio)
                                        ->where('usuario', $this->usuario)
                                        ->firstOrFail();

            if(!in_array($this->tramite->servicio->clave_ingreso, ['D927', 'D926', 'D925', 'D924'])){

                $this->dispatch('mostrarMensaje', ['warning', "El trámite no corresponde a una historia catastral."]);

                $this->reset('tramite');

                return;

            }

            if($this->tramite->estado === 'concluido'){

                $this->dispatch('mostrarMensaje', ['warning', "El trámite esta concluido."]);

                $this->reset('tramite');

                return;

            }

            if($this->tramite->estado != 'pagado' && $this->tramite->estado != 'autorizado'){

                $this->dispatch('mostrarMensaje', ['warning', "El trámite no esta pagado."]);

                $this->reset('tramite');

                return;

            }

            $this->predio = $this->tramite->ligadoA->predios()->first();

            $cantidad = match($this->tramite->servicio->clave_ingreso){
                'D924' => 5,
                'D925' => 10,
                'D926' => 15,
                'D927' => 100
            };

            $movimientos = $this->predio->movimientos->sortByDesc('fecha')->take($cantidad)->reverse();

            foreach ($movimientos as $movimiento) {

                $this->historia = $this->historia . ' ' . '<strong>Movmiento:</strong> ' . $movimiento->nombre . ' ' . '<br>' . '<strong>Fecha:</strong> ' . $movimiento->fecha->format('d-m-Y') . '<br>' . $movimiento->descripcion . '<br><br>';
            }

            $this->reset(['folio', 'usuario']);


        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no existe."]);

        } catch (\Throwable $th) {
            Log::error("Error al actualizar movimiento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }


    }

    public function abrirModalCrear():void
    {

        $this->modal = true;
        $this->crear =true;

        if($this->modelo_editar->getKey())
            $this->crearModeloVacio();

    }

    public function abrirModalEditar(Movimiento $modelo){

        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->nombre = $modelo->nombre;
        $this->fecha = $modelo->fecha->format('Y-m-d');
        $this->descripcion = $modelo->descripcion;

    }

    public function guardar(){

        $this->validate([
            'nombre' => 'required',
            'fecha' => 'required',
            'descripcion' => 'required'
        ]);

        try {

            $this->predio->movimientos()->create([
                'nombre' => $this->nombre,
                'fecha' => $this->fecha,
                'descripcion' => $this->descripcion,
                'creado_por' => auth()->id()
            ]);

            $this->predio->load('movimientos');

            $this->reset('modal');

            $this->dispatch('mostrarMensaje', ['success', "El movimiento se creó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al crear movimiento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function actualizar(){

        $this->validate([
            'nombre' => 'required',
            'fecha' => 'required',
            'descripcion' => 'required'
        ]);

        try{

            $this->modelo_editar->nombre = $this->nombre;
            $this->modelo_editar->fecha = $this->fecha;
            $this->modelo_editar->descripcion = $this->descripcion;
            $this->modelo_editar->actualizado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->predio->load('movimientos');

            $this->reset('modal');

            $this->dispatch('mostrarMensaje', ['success', "El movimiento se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar movimiento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    public function borrar(){

        try{

            $usuario = Movimiento::find($this->selected_id);

            $usuario->delete();

            $this->predio->load('movimientos');

            $this->reset('modalBorrar');

            $this->crearModeloVacio();

            $this->dispatch('mostrarMensaje', ['success', "El movimiento se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar movimiento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    public function generarCertificado(){

        if($this->predio->sector === 88 || $this->predio->sector === 99){

            $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra en sector 88 o 99 es necesario conciliarlo, acuda al departamento de cartografía."]);

            return;

        }

        $pdf = null;

        DB::transaction(function () use(&$pdf){

            $this->tramite->update(['estado' => 'concluido']);

            $this->tramite->ligadoA->update(['estado' => 'concluido']);

            $this->tramite->predios()->updateExistingPivot($this->predio->id, ['estado' => 'I']);

            $this->tramite->audits()->latest()->first()->update(['tags' => 'Finalizó trámite']);

            $pdf = (new CertificadoHistoriaController())->certificado($this->tramite, $this->tramite->ligadoA, $this->predio, $this->historia);

        });

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $this->predio->cuentaPredial() . '-certificado_de_historia.pdf'
        );

    }

    public function mount(){

        array_push($this->fields, 'nombre', 'fecha', 'descripcion', 'predio', 'numero_registro', 'region_catastral', 'municipio', 'localidad', 'sector', 'zona_catastral', 'manzana', 'predio_clave', 'edificio', 'departamento', 'tipo_predio', 'oficina', 'estado');

        $this->crearModeloVacio();

        $this->acciones_padron = array_keys(Constantes::MOVIMIENTOS);

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

        $this->oficina =  auth()->user()->oficina->oficina;

    }

    public function render()
    {
        return view('livewire.certificaciones.certificado-historia.certificado-historia')->extends('layouts.admin');
    }
}
