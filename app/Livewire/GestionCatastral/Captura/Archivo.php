<?php

namespace App\Livewire\GestionCatastral\Captura;

use App\Models\Predio;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Services\Predio\ArchivoPredioService;

class Archivo extends Component
{

    use WithFileUploads;

    public $predio;

    public $documento;

    #[On('cargarPredioPadron')]
    public function cargarPredio($id){

        $this->predio = Predio::find($id);

    }

    public function guardar(){

        $this->validate(['documento' => 'required']);

        try {

            (new ArchivoPredioService($this->predio, $this->documento))->guardar();

            $this->dispatch('mostrarMensaje', ['success', "El archivo se guradó con éxito."]);

            $this->predio->refresh();

            $this->dispatch('removeFiles');

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al guardar archivo en captura gestión catastral usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function render()
    {
        return view('livewire.gestion-catastral.captura.archivo');
    }
}
