<?php

namespace App\Livewire\Valuacion;

use App\Exceptions\GeneralException;
use App\Models\File;
use App\Models\Avaluo;
use App\Models\Certificacion;
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
    public $modalCorregir = false;

    public Avaluo $modelo_editar;

    public function crearModeloVacio(){
        return Avaluo::make();
    }

    public function abrirModalCorreccion(Avaluo $modelo){

        $this->resetearTodo();

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->editar = true;
        $this->modalCorregir = true;

    }

    public function corregir(){


        try {

            $this->revisarProcesosConcluidos();

            DB::transaction(function () {

            $tramiteInspeccion = $this->modelo_editar->tramiteInspeccion;

            $tramiteDesglose = $this->modelo_editar->tramiteDesglose;

            $notificacionDeValorCatastral = Certificacion::where('tramite_id', $tramiteInspeccion->id)->first();

                $notificacionDeValorCatastral->update([
                    'estado' => 'cancelado',
                    'observaciones' => 'Cancelado para corrección de avalúo',
                    'actualizado_por' => auth()->id()
                ]);

                $notificacionDeValorCatastral->audits()->latest()->first()->update(['tags' => 'Canceló para corrección de avalúo']);

                $avaluos = Avaluo::where('tramite_inspeccion', $tramiteInspeccion->id)->get();

                foreach ($avaluos as $avaluo) {

                    $avaluo->update([
                        'tramite_inspeccion' => null,
                        'tramite_desglose' => null,
                        'actualizado_por' => auth()->id(),
                        'estado' => 'nuevo'
                    ]);

                    $avaluo->audits()->latest()->first()->update(['tags' => 'Reactivó para corrección']);

                }

                $tramiteInspeccion->update([
                    'usados' => 0,
                    'estado' => 'pagado'
                ]);

                $tramiteInspeccion->audits()->latest()->first()->update(['tags' => 'Reactivó para corrección']);

                if($tramiteDesglose){

                    $tramiteDesglose->update([
                        'usados' => 0,
                        'estado' => 'pagado'
                    ]);

                    $tramiteDesglose->audits()->latest()->first()->update(['tags' => 'Reactivó para corrección']);

                }

            });

            $this->modalCorregir = true;

            $this->dispatch('mostrarMensaje', ['success', "Los avaluos y trámites han sido reactivados con éxito. La notificación de valor catastral ha sido cancelada"]);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {
            Log::error("Error al corregir avalúo usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

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

    public function imprimirAvaluoPredioIgnorado(Avaluo $avaluo){

        if(!$avaluo->predioAvaluo->colindancias->count()){

            $this->dispatch('mostrarMensaje', ['warning', "El avalúo no tiene colindancias."]);

        }

        if(!$avaluo->predioAvaluo->propietarios->count()){

            $this->dispatch('mostrarMensaje', ['warning', "El avalúo no tiene propietarios."]);

        }

        if(!$avaluo->predioAvaluo->valor_catastral){

            $this->dispatch('mostrarMensaje', ['warning', "El avalúo no tiene valor catastral."]);

        }

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

    public function revisarProcesosConcluidos(){

        if($this->modelo_editar->predioIgnorado?->estado == 'concluido'){

            throw new GeneralException('El proceso de predio ignorado ha sido conlcuido, no es posible enviar a corrección.');

        }

        if($this->modelo_editar->variacionCatastral?->estado == 'concluido'){

            throw new GeneralException('El proceso de variación catastral ha sido conlcuido, no es posible enviar a corrección.');

        }

    }

    public function mount(){

        $this->modelo_editar = $this->crearModeloVacio();

    }

    public function render()
    {

        $avaluos = Avaluo::with('predioAvaluo', 'creadoPor', 'actualizadoPor', 'predioIgnorado', 'variacionCatastral')
                            ->where('asignado_a', auth()->user()->id)
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        $this->idsEnPagina = $avaluos->map(fn ($avaluo) => (string)$avaluo->id)->toArray();

        return view('livewire.valuacion.mis-avaluos', compact('avaluos'))->extends('layouts.admin');

    }
}
