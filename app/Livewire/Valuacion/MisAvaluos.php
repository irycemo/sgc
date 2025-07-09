<?php

namespace App\Livewire\Valuacion;

use App\Models\File;
use App\Models\Avaluo;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\ComponentesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MisAvaluos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $seleccionados = [];
    public $idsEnPagina = [];
    public $paginaSeleccionada = false;
    public $todosSelecionados = false;
    public $modal = false;

    public Avaluo $modelo_editar;

    public function crearModeloVacio(){
        return Avaluo::make();
    }

    public function eliminar(){

        try{

            $avaluos = Avaluo::with('predioAvaluo')->whereKey($this->seleccionados)->get();

            foreach ($avaluos as $avaluo) {

                if(in_array($avaluo->estado, ['impreso', 'notificado', 'concluido'])){

                    $this->dispatch('mostrarMensaje', ['warning', "El avalúo: " . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' no se puede eliminar.']);

                    return;

                }

                DB::transaction(function () use($avaluo){

                    $predio = $avaluo->predioAvaluo;

                    $predio->propietarios()->delete();

                    $predio->colindancias()->delete();

                    $predio->terrenosComun()->delete();

                    $predio->construccionesComun()->delete();

                    $predio->construcciones()->delete();

                    $predio->terrenos()->delete();

                    $avaluo->delete();

                    $predio->delete();

                    $files = File::where('fileable_id', $avaluo->id)->where('fileable_type', 'App\Models\Avaluo')->get();

                    foreach ($files as $file) {
                        Storage::disk('avaluos')->delete($file->url);
                    }

                });

            }

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La información seleccionada se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar mis avaluos usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function imprimirAvaluo(Avaluo $avaluo){

        $predio = $avaluo->predioAvaluo;

        $predio->load('propietarios.persona');

        $pdf = Pdf::loadView('avaluos.avaluo', compact('predio'));

        $pdf->render();

        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(480, 745, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

        $canvas->page_text(35, 745, "Avalúo: " . $avaluo->año . "-" . $avaluo->folio . "-" . $avaluo->usuario , null, 9, array(1, 1, 1));

        $pdf = $dom_pdf->output();

        return response()->streamDownload(
            fn () => print($pdf),
            'avaluo.pdf'
        );

    }

    public function mount(){

        $this->modelo_editar = $this->crearModeloVacio();

    }

    public function render()
    {

        $avaluos = Avaluo::with('predioAvaluo', 'creadoPor', 'actualizadoPor')
                            ->where('asignado_a', auth()->user()->id)
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        $this->idsEnPagina = $avaluos->map(fn ($avaluo) => (string)$avaluo->id)->toArray();

        return view('livewire.valuacion.mis-avaluos', compact('avaluos'))->extends('layouts.admin');

    }
}
