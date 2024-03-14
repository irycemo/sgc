<?php

namespace App\Livewire\Admin\Avaluos;

use App\Models\File;
use App\Models\User;
use App\Models\Avaluo;
use Livewire\Component;
use App\Models\PredioAvaluo;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Http\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;
use Illuminate\Support\Facades\Storage;

class Avaluos extends Component
{

    use WithPagination;
    use ComponentesTrait;

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
        'valuador' => '',
        'localidad' => '',
        'oficina' => '',
        'tipo' => '',
        'registro' => '',
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

    public function eliminar(){

        try{

            DB::transaction(function () {

                $avaluos = Avaluo::with('predioAvaluo.propietarios', 'predioAvaluo.colindancias', 'predioAvaluo.condominioTerrenos', 'predioAvaluo.condominioConstrucciones', 'predioAvaluo.terrenos', 'predioAvaluo.construcciones')->whereKey($this->seleccionados)->get();

                foreach ($avaluos as $avaluo) {

                    if($avaluo->estado == 'notificado'){

                        $this->dispatch('mostrarMensaje', ['error', "El avalúo con folio " . $avaluo->folio . ' no se puede eliminar, esta notificado.']);

                        return;

                    }

                    $predio = $avaluo->predioAvaluo;

                    $predio->propietarios()->delete();

                    $predio->colindancias()->delete();

                    $predio->condominioTerrenos()->delete();

                    $predio->condominioConstrucciones()->delete();

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

    public function mount(){

        array_push($this->fields, 'modalReasignar', 'valuador_id');

        $this->valuadores = User::whereNotNull('valuador')->orderBy('ap_paterno')->get();

        $this->años = Constantes::AÑOS;

        $this->crearModeloVacio();

    }

    public function render()
    {

        $predios = PredioAvaluo::with('actualizadoPor', 'avaluo.asignadoA')
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
                            ->when($this->filters['valuador'], function($q, $valuador) {
                                $q->whereHas('avaluo', function($q) use($valuador){
                                        $q->where('asignado_a', $this->filters['valuador']);
                                });
                            })
                            ->when($this->filters['localidad'], fn($q, $localidad) => $q->where('localidad', $this->filters['localidad']))
                            ->when($this->filters['oficina'], fn($q, $oficina) => $q->where('oficina', $this->filters['oficina']))
                            ->when($this->filters['tipo'], fn($q, $tipo) => $q->where('tipo_predio', $this->filters['tipo']))
                            ->when($this->filters['registro'], fn($q, $registro) => $q->where('numero_registro', $this->filters['registro']))
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        $this->idsEnPagina = $predios->map(fn ($predio) => (string)$predio->avaluo->id)->toArray();

        return view('livewire.Admin.avaluos.avaluos', compact('predios'))->extends('layouts.admin');

    }
}
