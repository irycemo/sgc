<?php

namespace App\Livewire\Admin;

use App\Models\File;
use App\Models\User;
use App\Models\Avaluo;
use Livewire\Component;
use App\Models\PredioAvaluo;
use Livewire\WithPagination;
use App\Constantes\Constantes;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Avaluos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public PredioAvaluo $modelo_editar;

    public $seleccionados = [];
    public $idsEnPagina = [];

    public $valuadores;

    public $valuador_id;

    public $años;

    public $modalReasignar = false;

    public $filters = [
        'año' => '',
        'folio' => '',
        'usuario' => '',
        'valuador' => '',
        'localidad' => '',
        'oficina' => '',
        'tipo' => '',
        'registro' => '',
        'estado' => ''
    ];

    public function crearModeloVacio(){
        $this->modelo_editar = PredioAvaluo::make();
    }

    public function abrirModal(PredioAvaluo $predio){

        $this->modelo_editar = $predio;

        $this->modalReasignar = true;

    }

    public function reasignar(){

        $this->validate(['valuador_id' => 'required'],['valuador_id' => 'El campo valuador es obligatorio']);

        try{

            DB::transaction(function () {

                $this->modelo_editar->avaluo->update(['asignado_a' => $this->valuador_id]);

                $this->modelo_editar->avaluo->audits()->latest()->first()->update(['tags' => 'Reasignó valuador']);

                $this->dispatch('mostrarMensaje', ['success', "Se reasigno valuador con éxito."]);

                $this->resetearTodo($borrado = true);

            });

        } catch (\Throwable $th) {

            Log::error("Error al reasignar valuador por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function imprimirAvaluo(PredioAvaluo $predio){

        $predio = $predio->load('propietarios.persona');

        $pdf = Pdf::loadView('avaluos.avaluo', compact('predio'));

        $pdf->render();

        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(480, 794, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

        $canvas->page_text(35, 794, "Avalúo: " . $predio->avaluo->año . "-" . $predio->avaluo->folio , null, 10, array(1, 1, 1));

        $pdf = $dom_pdf->output();

        return response()->streamDownload(
            fn () => print($pdf),
            'avaluo.pdf'
        );

    }

    public function eliminar(){

        try{

            DB::transaction(function () {

                $avaluos = Avaluo::with('predioAvaluo.propietarios', 'predioAvaluo.colindancias', 'predioAvaluo.terrenosComun', 'predioAvaluo.construccionesComun', 'predioAvaluo.terrenos', 'predioAvaluo.construcciones')->whereKey($this->seleccionados)->get();

                foreach ($avaluos as $avaluo) {

                    if($avaluo->estado == 'notificado'){

                        $this->dispatch('mostrarMensaje', ['error', "El avalúo con folio " . $avaluo->folio . ' no se puede eliminar, esta notificado.']);

                        return;

                    }

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

                }

                $this->dispatch('mostrarMensaje', ['success', "La información seleccionada se eliminó con éxito."]);

                $this->resetearTodo($borrado = true);

            });

        } catch (\Throwable $th) {

            Log::error("Error al avaluos usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    #[Computed]
    public function predios(){

        return PredioAvaluo::with('actualizadoPor', 'avaluo.asignadoA')
                            ->when($this->filters['año'], function($q, $año) {
                                $q->whereHas('avaluo', function($q) use($año){
                                        $q->where('año', $this->filters['año']);
                                });
                            })
                            ->when($this->filters['folio'], function($q, $folio) {
                                $q->whereHas('avaluo', function($q) use($folio){
                                        $q->where('folio', $this->filters['folio']);
                                });
                            })
                            ->when($this->filters['usuario'], function($q, $usuario) {
                                $q->whereHas('avaluo', function($q) use($usuario){
                                        $q->where('usuario', $this->filters['usuario']);
                                });
                            })
                            ->when($this->filters['valuador'], function($q, $valuador) {
                                $q->whereHas('avaluo', function($q) use($valuador){
                                        $q->where('asignado_a', $this->filters['valuador']);
                                });
                            })
                            ->when($this->filters['estado'], function($q, $estado) {
                                $q->whereHas('avaluo', function($q) use($estado){
                                        $q->where('estado', $this->filters['estado']);
                                });
                            })
                            ->when($this->filters['localidad'], fn($q, $localidad) => $q->where('localidad', $this->filters['localidad']))
                            ->when($this->filters['oficina'], fn($q, $oficina) => $q->where('oficina', $this->filters['oficina']))
                            ->when($this->filters['tipo'], fn($q, $tipo) => $q->where('tipo_predio', $this->filters['tipo']))
                            ->when($this->filters['registro'] != '', fn($q, $registro) => $q->where('numero_registro', $this->filters['registro']))
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

    }

    public function mount(){

        array_push($this->fields, 'modalReasignar', 'valuador_id');

        $this->valuadores = User::whereNotNull('valuador')->orderBy('name')->get();

        $this->años = Constantes::AÑOS;

        $this->filters['año'] = now()->format('Y');

        $this->crearModeloVacio();

    }

    public function render()
    {
        return view('livewire.admin.avaluos')->extends('layouts.admin');
    }
}
