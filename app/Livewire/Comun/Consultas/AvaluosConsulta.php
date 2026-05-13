<?php

namespace App\Livewire\Comun\Consultas;

use App\Http\Controllers\Valuacion\AvaluoImpresionController;
use App\Models\Avaluo;
use App\Models\Predio;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AvaluosConsulta extends Component
{

    public $predio_id;
    public $avaluos;
    public Predio $predio;

    public function imprimirAvaluo(Avaluo $avaluo){

        try {

            $pdf = (new AvaluoImpresionController())->generarAvaluo($avaluo, auth()->user());

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'avaluo.pdf'
            );

       } catch (\Throwable $th) {

            Log::error("Error al imprimir avaluo en avaluos consultas por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

       }

    }

    public function mount(){

        $this->predio = Predio::find($this->predio_id);

        $this->avaluos = Avaluo::with('notificador')->where('predio', $this->predio_id)->get();

    }

    public function render()
    {
        return view('livewire.comun.consultas.avaluos-consulta');
    }
}
