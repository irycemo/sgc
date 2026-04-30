<?php

namespace App\Livewire\Admin;

use App\Constantes\Constantes;
use App\Http\Controllers\Valuacion\AvaluoImpresionController;
use App\Models\Avaluo;
use App\Models\Certificacion;
use App\Models\File;
use App\Models\PredioAvaluo;
use App\Models\PredioIgnorado;
use App\Models\User;
use App\Models\VariacionCatastral;
use App\Traits\ComponentesTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Avaluos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public Avaluo $modelo_editar;

    public $seleccionados = [];
    public $idsEnPagina = [];

    public $valuadores;

    public $valuador_id;

    public $años;

    public $modalReasignar = false;
    public $modalVerArchivos = false;

    public $modelo_administrativo;

    public $filters = [
        'año' => '',
        'folio' => '',
        'usuario' => '',
        'valuador' => '',
        'localidad' => '',
        'oficina' => '',
        'tipo' => '',
        'registro' => '',
        'estado' => '',
        'tAño' => '',
        'tFolio' => '',
        'tUsuario' => '',
    ];

    public function updatedFilters() { $this->resetPage(); }

    public function crearModeloVacio(){
        $this->modelo_editar = Avaluo::make();
    }

    public function abrirModalVerArchivos($id, $modelo){

        $this->resetearTodo();

        if($modelo === 'variacion'){

            $this->modelo_administrativo = VariacionCatastral::with('archivos')->find($id);

        }else{

            $this->modelo_administrativo = PredioIgnorado::with('archivos')->find($id);

        }


        $this->modalVerArchivos = true;

    }

    public function abrirModal(Avaluo $avaluo){

        $this->modelo_editar = $avaluo;

        $this->modalReasignar = true;

    }

    public function reasignar(){

        $this->validate(['valuador_id' => 'required'],['valuador_id' => 'El campo valuador es obligatorio']);

        try{

            DB::transaction(function () {

                $this->modelo_editar->update(['asignado_a' => $this->valuador_id]);

                $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Reasignó valuador']);

                $this->dispatch('mostrarMensaje', ['success', "Se reasigno valuador con éxito."]);

                $this->resetearTodo($borrado = true);

            });

        } catch (\Throwable $th) {

            Log::error("Error al reasignar valuador por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function imprimirAvaluo(Avaluo $avaluo){

       try {

            $pdf = (new AvaluoImpresionController())->generarAvaluo($avaluo);

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'avaluo.pdf'
            );

       } catch (\Throwable $th) {

            Log::error("Error al imprimir avaluo en administracion por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

       }

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

                    $avaluo->bloques()->delete();

                    $files = File::where('fileable_id', $avaluo->id)->where('fileable_type', 'App\Models\Avaluo')->get();

                    foreach ($files as $file) {

                        if(app()->isProduction()){

                            if (Storage::disk('s3')->exists(config('services.ses.ruta_avaluos_fotos') . $file->url)) {

                                Storage::disk('s3')->delete(config('services.ses.ruta_avaluos_fotos') . $file->url);

                            }

                        }else{

                            if (Storage::disk('avaluos')->exists($file->url)) {

                                Storage::disk('avaluos')->delete($file->url);

                            }

                        }

                    }

                    $avaluo->delete();

                    $predio->delete();

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

        return Avaluo::select('id', 'año', 'folio', 'usuario', 'estado', 'asignado_a', 'tramite_inspeccion', 'variacion_catastral_id', 'predio_ignorado_id', 'predio_avaluo', 'creado_por', 'actualizado_por', 'created_at', 'updated_at')
                            ->with(
                                'actualizadoPor:id,name',
                                'predioAvaluo:id,localidad,oficina,tipo_predio,numero_registro',
                                'tramiteInspeccion:id,año,folio,usuario',
                                'asignadoA:id,name',
                                'predioIgnorado:id,año,folio',
                                'variacionCatastral:id,año,folio'
                            )
                            ->when($this->filters['año'] != '', function($q, $año) {
                                $q->where('año', (int)$this->filters['año']);
                            })
                            ->when($this->filters['folio'] != '', function($q) {
                                $q->where('folio', (int)$this->filters['folio']);
                            })
                            ->when($this->filters['usuario'] != '', function($q, $usuario) {
                                $q->where('usuario', (int)$this->filters['usuario']);
                            })
                            ->when($this->filters['valuador'] != '', function($q, $valuador) {
                                $q->where('asignado_a', (int)$this->filters['valuador']);
                            })
                            ->when($this->filters['estado'] != '', function($q, $estado) {
                                $q->where('estado', $this->filters['estado']);
                            })
                            ->when($this->filters['tAño'] != '', function($q, $localidad) {
                                $q->whereHas('tramiteInspeccion', function($q){
                                    $q->where('año', (int)$this->filters['tAño']);
                                });
                            })
                            ->when($this->filters['tFolio'] != '', function($q, $localidad) {
                                $q->whereHas('tramiteInspeccion', function($q){
                                    $q->where('folio', (int)$this->filters['tFolio']);
                                });
                            })
                            ->when($this->filters['tUsuario'] != '', function($q, $localidad) {
                                $q->whereHas('tramiteInspeccion', function($q){
                                    $q->where('usuario', (int)$this->filters['tUsuario']);
                                });
                            })
                            ->when($this->filters['localidad'] != '', function($q, $localidad) {
                                $q->whereHas('predioAvaluo', function($q){
                                    $q->where('localidad', (int)$this->filters['localidad']);
                                });
                            })
                            ->when($this->filters['oficina'] != '', function($q, $oficina) {
                                $q->whereHas('predioAvaluo', function($q){
                                    $q->where('oficina', (int)$this->filters['oficina']);
                                });
                            })
                            ->when($this->filters['tipo'] != '', function($q, $tipo) {
                                $q->whereHas('predioAvaluo', function($q){
                                    $q->where('tipo_predio', (int)$this->filters['tipo']);
                                });
                            })
                            ->when($this->filters['registro'] != '', function($q, $registro) {
                                $q->whereHas('predioAvaluo', function($q){
                                    $q->where('numero_registro', (int)$this->filters['registro']);
                                });
                            })
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

    }

    public function mount(){

        array_push($this->fields, 'modalReasignar', 'valuador_id');

        $this->valuadores = User::select('id', 'name')->whereNotNull('valuador')->orderBy('name')->get();

        $this->años = Constantes::AÑOS;

        $this->filters['año'] = now()->format('Y');

        $this->filters['estado'] = request()->query('estado');

        $this->crearModeloVacio();

    }

    public function render()
    {
        return view('livewire.admin.avaluos')->extends('layouts.admin');
    }
}
