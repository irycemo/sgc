<?php

namespace App\Livewire\Valuacion;

use App\Models\File;
use App\Models\Avaluo;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;
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

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "La información seleccionada se eliminó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al avaluos usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

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
