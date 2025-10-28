<?php

namespace App\Livewire\Tramites\ReactivarTramite;

use App\Models\Tramite;
use Livewire\Component;
use App\Models\Traslado;
use App\Models\Certificacion;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReactivarTramite extends Component
{

    public $años;
    public $año;
    public $folio;
    public $usuario;

    public $oficina;
    public $cantidad;

    public $tramite;

    public $modal;
    public $selected_id;
    public $observaciones;

    public function buscarTramite(){

        $this->validate([
            'año' => 'required',
            'folio' => 'required',
            'usuario' => 'required',
        ]);

        try {

            $this->tramite = Tramite::with('predios')
                                        ->where('año', $this->año)
                                        ->where('folio', $this->folio)
                                        ->where('usuario', $this->usuario)
                                        ->firstOrFail();

            if($this->tramite->estado === 'nuevo'){

                $this->dispatch('mostrarMensaje', ['warning', "El trámite no esta pagado."]);

                $this->reset('tramite');

                return;

            }

            $this->reset(['folio', 'usuario']);


        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no existe."]);

        } catch (\Throwable $th) {
            Log::error("Error al buscar trámite para reactivar por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }


    }

    public function abrirReactivarModal($id){

        $this->modal = true;

        $this->selected_id = $id;

    }

    public function reactivarPredio(){

        $this->validate([
            'observaciones' => 'required'
        ]);

        try {

            DB::transaction(function (){


                $certificacion = Certificacion::where('tramite_id', $this->tramite->id)->where('predio_id', $this->selected_id)->where('estado', 'activo')->first();

                if($certificacion){

                    $traslado = Traslado::where('certificacion_id', $certificacion->id)->where('estado', '!=', 'operado')->first();

                    if($traslado){

                        throw new GeneralException('El certificado esta ligado a un aviso no es posible reactivarlo.');

                    }

                    $certificacion->update([
                        'estado' => 'cancelado',
                        'observaciones' => $this->observaciones,
                        'actualizado_por' => auth()->id()
                    ]);

                    $certificacion->audits()->latest()->first()->update(['tags' => 'Canceló certificado']);

                }else{

                    $this->dispatch('mostrarMensaje', ['warning', "No se encontro la certificación"]);

                    return;

                }

                $this->tramite->predios()->updateExistingPivot($this->selected_id, ['estado' => 'A']);

                if($this->tramite->estado === 'concluido') $this->tramite->update(['estado' => 'pagado']);

                $this->tramite->audits()->latest()->first()->update(['tags' => 'Reactivó cuenta predial']);

                $this->tramite->load('predios');

                $this->reset('selected_id', 'modal', 'observaciones');

                $this->dispatch('mostrarMensaje', ['warning', "La cuenta predial se reactivó con éxito, si tenia un certificado este ha sido cancelado."]);

            });

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar permisos usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function reactivarCantidad(){

        $this->validate([
            'cantidad' => 'required|numeric|min:1',
        ]);

        if($this->cantidad > $this->tramite->cantidad){

            $this->dispatch('mostrarMensaje', ['warning', "La cantidad a reactivar no puede ser mayor a la cantidad que avala el trámite."]);

            return;

        }

        if($this->cantidad > $this->tramite->usados){

            $this->dispatch('mostrarMensaje', ['warning', "La cantidad a reactivar no puede ser mayor a la cantidad ya usada por el trámite."]);

            return;

        }

        try {

            DB::transaction(function (){

                if($this->tramite->estado === 'concluido') $this->tramite->update(['estado' => 'pagado']);

                $this->tramite->update(['usados' => $this->tramite->usados - $this->cantidad]);

                $this->dispatch('mostrarMensaje', ['success', "Se reactivó la cantidad con éxito."]);

                $this->tramite->audits()->latest()->first()->update(['tags' => 'Reactivo cantidad disponible']);

                $this->reset(['cantidad']);

            });

        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no existe."]);

        } catch (\Throwable $th) {
            Log::error("Error al reactivar cantidad en trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function autorizarTramite(){

        try {

            DB::transaction(function (){

                $this->tramite->update(['estado' => 'autorizado']);

                $this->dispatch('mostrarMensaje', ['success', "Se autorizó el trámite con éxito."]);

                $this->tramite->audits()->latest()->first()->update(['tags' => 'Autorizo entrega anticipada']);

            });

        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no existe."]);

        } catch (\Throwable $th) {
            Log::error("Error al autorizar trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.tramites.reactivar-tramite.reactivar-tramite')->extends('layouts.admin');
    }
}
