<?php

namespace App\Livewire\Valuacion;

use App\Constantes\Constantes;
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
    public $años;

    public Avaluo $modelo_editar;

    public $filters = [
        'año' => '',
        'folio' => '',
        'usuario' => '',
        'estado' => '',
        'tipoTramite' => '',
        'servicio' => '',
        'localidad' => '',
        'p_oficina' => '',
        't_predio' => '',
        'registro' => '',
        'estado' => ''
    ];

    public function updatedFilters() { $this->resetPage(); }

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

        if($this->modelo_editar->estado === 'notificado'){

            $this->dispatch('mostrarMensaje', ['warning', "El avalúo: " . $this->modelo_editar->año . '-' . $this->modelo_editar->folio . '-' . $this->modelo_editar->usuario . ' esta notificado no se puede corregir.']);

            return;

        }

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

                    if($avaluo->estado == 'notificado'){

                        throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' esta notificado no es posible enviar a corrección.');

                    }

                    $avaluo->update([
                        'tramite_inspeccion' => null,
                        'tramite_desglose' => null,
                        'actualizado_por' => auth()->id(),
                        'estado' => 'nuevo'
                    ]);

                    $avaluo->audits()->latest()->first()->update(['tags' => 'Reactivó para corrección']);

                }

                $tramiteInspeccion->decrement('usados', $avaluos->count());

                $tramiteInspeccion->update([
                    'estado' => 'pagado'
                ]);

                $tramiteInspeccion->audits()->latest()->first()->update(['tags' => 'Reactivó para corrección']);

                if($tramiteDesglose){

                    $tramiteDesglose->decrement('usados', $avaluos->count());

                    $tramiteDesglose->update([
                        'estado' => 'pagado'
                    ]);

                    $tramiteDesglose->audits()->latest()->first()->update(['tags' => 'Reactivó para corrección']);

                }

            });

            $this->modalCorregir = false;

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

                if($avaluo->estado !== 'nuevo'){

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

                    $avaluo->bloques()->delete();

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

        if(!$avaluo->predioAvaluo->lat){

            $this->dispatch('mostrarMensaje', ['warning', "El avalúo no tiene coordenadas geográficas."]);

            return;

        }

        if(!$avaluo->predioAvaluo->colindancias->count()){

            $this->dispatch('mostrarMensaje', ['warning', "El avalúo no tiene colindancias."]);

            return;

        }

        if(!$avaluo->predioAvaluo->propietarios->count()){

            $this->dispatch('mostrarMensaje', ['warning', "El avalúo no tiene propietarios."]);

            return;

        }

        if(!$avaluo->clasificacion_zona){

            $this->dispatch('mostrarMensaje', ['warning', "El avalúo no tiene caracteristicas."]);

            return;

        }

        if(!$avaluo->predioAvaluo->valor_catastral){

            $this->dispatch('mostrarMensaje', ['warning', "El avalúo no tiene valor catastral."]);

            return;

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

        $this->años = Constantes::AÑOS;

        $this->filters['año'] = now()->format('Y');

    }

    public function render()
    {

        $avaluos = Avaluo::with('predioAvaluo', 'creadoPor', 'actualizadoPor', 'predioIgnorado', 'variacionCatastral')
                            ->where('asignado_a', auth()->user()->id)
                            ->when($this->filters['estado'], function($q, $estado){
                                    $q->where('estado', $estado);
                            })
                            ->when($this->filters['año'], function($q, $año){
                                    $q->where('año', $año);
                            })
                            ->when($this->filters['folio'], function($q, $folio){
                                $q->where('folio', $folio);
                            })
                            ->when($this->filters['usuario'], function($q, $usuario){
                                $q->where('usuario', $usuario);
                            })
                            ->when($this->filters['localidad'], function($q, $localidad){
                                $q->WhereHas('predioAvaluo', function($q) use($localidad){
                                    $q->where('localidad', $localidad);
                                });
                            })
                            ->when($this->filters['p_oficina'], function($q, $oficina){
                                $q->WhereHas('predioAvaluo', function($q) use($oficina){
                                    $q->where('oficina', $oficina);
                                });
                            })
                            ->when($this->filters['t_predio'], function($q, $t_predio){
                                $q->WhereHas('predioAvaluo', function($q) use($t_predio){
                                    $q->where('tipo_predio', $t_predio);
                                });
                            })
                            ->when($this->filters['registro'], function($q, $registro){
                                $q->WhereHas('predioAvaluo', function($q) use($registro){
                                    $q->where('numero_registro', $registro);
                                });
                            })
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        $this->idsEnPagina = $avaluos->map(fn ($avaluo) => (string)$avaluo->id)->toArray();

        return view('livewire.valuacion.mis-avaluos', compact('avaluos'))->extends('layouts.admin');

    }
}
