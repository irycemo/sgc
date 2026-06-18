<?php

namespace App\Livewire\Cartografia\CartografiaArchivo;

use App\Models\Cartografia;
use App\Models\Oficina;
use App\Traits\ComponentesTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CartografiaArchivo extends Component
{

    use ComponentesTrait;
    use WithFileUploads;

    public $oficinas;
    public $oficina;
    public $sector;
    public $cartografia = [];
    public $documento;

    protected function rules(){
        return [
            'modelo_editar.manzana' => 'required',
            'documento' => 'nullable'
         ];
    }

    public Cartografia $modelo_editar;

    public function crearModeloVacio(){
        $this->modelo_editar =  Cartografia::make();
    }

    public function abrirModalEditar(Cartografia $modelo){

        $this->resetearTodo();
        $this->modal = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function buscarCartografia(){

        try {

            $this->cartografia = Cartografia::with('oficina:id,nombre', 'actualizadoPor:id,name')
                                                ->whereHas('oficina', function($q){
                                                    $q->where('oficina', $this->oficina);
                                                })
                                                ->where('sector', $this->sector)
                                                ->get();

        } catch (\Throwable $th) {

            Log::error("Error al buscar cartografía por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function actualizar(){

        $this->validate();

        try {

            if($this->documento){

                $ruta = config('services.ses.ruta_cartografia') . $this->oficina . '/cartografia';

                $url = $this->oficina . '/cartografia/' . str_pad($this->sector, 2, '0', STR_PAD_LEFT) . '-' . str_pad($this->modelo_editar->manzana, 3, '0', STR_PAD_LEFT) . '.pdf';

                if(app()->isProduction()){

                    $this->documento->storeAs($ruta, $url, 's3');

                }else{

                    $this->documento->storeAs('/', $url, 'cartografia');

                }

                if(app()->isProduction()){

                    if (Storage::disk('s3')->exists($this->modelo_editar->url)) {

                        Storage::disk('s3')->delete($this->modelo_editar->url);

                    }

                }else{

                    if (Storage::disk('avaluos')->exists($this->modelo_editar->url)) {

                        Storage::disk('avaluos')->delete($this->modelo_editar->url);

                    }

                }

            }else{

                $url = $this->modelo_editar->url;
            }

            $this->modelo_editar->update([
                'manzana' => $this->modelo_editar->manzana,
                'url' => $url,
                'actualizado_por' => auth()->id()
            ]);

            $this->modal = false;

            $this->dispatch('mostrarMensaje', ['success', "La cartografía se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar cartografía por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function borrarCartografia(Cartografia $cartografia){

        try {

            if(app()->isProduction()){

                if (Storage::disk('s3')->exists($cartografia->url)) {

                    Storage::disk('s3')->delete($cartografia->url);

                }

            }else{

                if (Storage::disk('avaluos')->exists($cartografia->url)) {

                    Storage::disk('avaluos')->delete($cartografia->url);

                }

            }

            $cartografia->delete();

            $this->dispatch('mostrarMensaje', ['success', "La cartografía se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al eliminar cartografía por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        $this->crearModeloVacio();

        if(auth()->user()->oficina->oficina != 101){

            $this->oficina = auth()->user()->oficina->oficina;

        }else{

            $this->oficinas = Oficina::select('id', 'oficina', 'nombre')->orderBy('nombre')->get();

        }

    }

    public function render()
    {
        return view('livewire.cartografia.cartografia-archivo.cartografia-archivo')->extends('layouts.admin');
    }
}
