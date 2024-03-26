<?php

namespace App\Livewire\Ventanilla;

use App\Models\Tramite;
use Livewire\Component;
use App\Models\Certificacion;
use Illuminate\Support\Facades\DB;
use App\Http\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReactivarTramites extends Component
{

    public $años;
    public $año;
    public $folio;
    public $usuario;

    public $oficina;
    public $cantidad;

    public $tramite;

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

            if($this->tramite->estado != 'pagado'){

                $this->dispatch('mostrarMensaje', ['error', "El trámite no esta pagado."]);

                $this->reset('tramite');

                return;

            }

            $this->reset(['folio', 'usuario']);


        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['error', "El trámite no existe."]);

        } catch (\Throwable $th) {
            Log::error("Error al buscar certificado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }


    }

    public function reactivarPredio($id){

        try {

            DB::transaction(function () use ($id){

                $certificacion = Certificacion::where('tramite_id', $this->tramite->id)->where('predio_id', $id)->first();

                if($certificacion){

                    $certificacion->update(['estado' => 'cancelado']);

                }

                $this->tramite->predios()->updateExistingPivot($id, ['estado' => 'A']);

                if($this->tramite->estado === 'concluido') $this->tramite->update(['estado' => 'pagado']);

                $this->tramite->audits()->latest()->first()->update(['tags' => 'Reactivo cuenta predial']);

                $this->tramite->load('predios');

                $this->dispatch('mostrarMensaje', ['warning', "La cuenta predial se reactivó con éxito, si tenia un certificado este ha sido cancelado."]);

            });

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

            $this->dispatch('mostrarMensaje', ['error', "La cantidad a reactivar no puede ser mayor a la cantidad que avala el trámite."]);

            return;

        }

        if($this->cantidad > $this->tramite->usados){

            $this->dispatch('mostrarMensaje', ['error', "La cantidad a reactivar no puede ser mayor a la cantidad ya usada por el trámite."]);

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

            $this->dispatch('mostrarMensaje', ['error', "El trámite no existe."]);

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

            $this->dispatch('mostrarMensaje', ['error', "El trámite no existe."]);

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
        return view('livewire.ventanilla.reactivar-tramites')->extends('layouts.admin');
    }
}
