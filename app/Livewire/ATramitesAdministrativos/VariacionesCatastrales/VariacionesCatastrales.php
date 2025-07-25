<?php

namespace App\Livewire\ATramitesAdministrativos\VariacionesCatastrales;

use App\Models\User;
use App\Models\Oficina;
use App\Models\Tramite;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Constantes\Constantes;
use Illuminate\Validation\Rule;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use App\Models\VariacionCatastral;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class VariacionesCatastrales extends Component
{

    use ComponentesTrait;
    use WithPagination;
    use WithFileUploads;

    public $años;
    public $taño;
    public $tfolio;
    public $tusuario;
    public $usuarios;
    public $oficinas;
    public $valuadores;
    public $estados;

    public $tramite;
    public $requerimiento;
    public $file;
    public $estado;

    public $modalHacerRequerimiento = false;
    public $modalVerRequerimiento = false;
    public $modalAsignarValuador = false;
    public $modalSubirArchivo = false;
    public $modalCambiarEstado = false;

    public VariacionCatastral $modelo_editar;

    public $filters = [
        'estado' => '',
        'año' => '',
        'folio' => '',
        'taño' => '',
        'tfolio' => '',
        'tusuario' => ''
    ];

    protected function rules(){

        return [
            'taño' => 'required',
            'tfolio' => 'required',
            'tusuario' => 'required',
            'modelo_editar.promovente' => 'required',
            'modelo_editar.finado' => 'required',
            'modelo_editar.oficina_id' => Rule::requiredIf(!auth()->user()->hasRole('Oficina rentistica')),
            'modelo_editar.valuador' => 'nullable',
            'modelo_editar.estado' => 'nullable',
        ];

    }

    protected $validationAttributes  = [
        'modelo_editar.oficina_id' => 'oficina',
        'file' => 'archivo'
    ];

    public function crearModeloVacio(){
        $this->modelo_editar = VariacionCatastral::make();
    }

    public function buscarTramite(){

        $this->tramite = Tramite::with('predios')
                                    ->where('año', $this->taño)
                                    ->where('folio', $this->tfolio)
                                    ->where('usuario', $this->tusuario)
                                    ->first();

        if(!$this->tramite){

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no existe."]);

            return true;

        }

        $variacion = VariacionCatastral::where('tramite_id', $this->tramite->id)->first();

        if($variacion){

            $this->dispatch('mostrarMensaje', ['warning', "El trámite ya esta usado por una variación catastral."]);

            return true;

        }

        if(!in_array($this->tramite->servicio->clave_ingreso, ['DM27', 'DM27'])){

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no corresponde a una variación catastral."]);

            return true;

        }

        if($this->tramite->estado != 'pagado'){

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no esta pagado."]);

            return true;

        }

        if($this->tramite->estado === 'concluido'){

            $this->dispatch('mostrarMensaje', ['warning', "El trámite esta concluido."]);

            return true;

        }

        return false;

    }

    public function guardar(){

        $this->validate();

        if($this->buscarTramite()) return;

        try {

            DB::transaction(function () {

                if(auth()->user()->hasRole('Oficina rentistica')){

                    $this->modelo_editar->estado = 'revisión';
                    $this->modelo_editar->oficina_id = auth()->user()->oficina_id;

                }else{

                    $this->modelo_editar->estado = 'nuevo';
                    $this->modelo_editar->folio = (VariacionCatastral::where('año', now()->format('Y'))->max('folio') ?? 0) + 1;

                }

                $this->modelo_editar->tramite_id = $this->tramite->id;
                $this->modelo_editar->año = now()->format('Y');
                $this->modelo_editar->creado_por = auth()->id();
                $this->modelo_editar->save();

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "La variación catastral se creó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al crear variación catastral por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            DB::transaction(function () {

                $variacion = VariacionCatastral::find($this->selected_id);

                if($variacion->archivo !== null)
                    Storage::disk('variacionescatastrales')->delete($variacion->archivo);

                $variacion->delete();

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "La variación catastral se eliminó con exito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al borrar variación catastral por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function abrirHacerRequerimiento(VariacionCatastral $modelo){

        $this->reset('requerimiento');

        $this->modalHacerRequerimiento = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function requerir(){

        $this->validate(['requerimiento' => 'required']);

        try {

            DB::transaction(function () {

                $this->modelo_editar->requerimientos()->create([
                    'estado' => 'nuevo',
                    'descripcion' => $this->requerimiento,
                    'creado_por' => auth()->id()
                ]);

                $this->modelo_editar->update(['estado' => 'requerimineto']);

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "El requerimiento se creó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al crear requerimiento en variación catastral por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function abrirVerRequerimiento(VariacionCatastral $modelo){

        $this->modalVerRequerimiento = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->modelo_editar->load('requerimientos.creadoPor');

    }

    public function abrirAsignarValuador(VariacionCatastral $modelo){

        $this->modalAsignarValuador = true;

        $this->valuadores = User::where('valuador', true)
                                    ->where('estado', 'activo')
                                    ->whereHas('oficina', function($q) {
                                        $q->where('oficina', 101);
                                    })
                                    ->orderBy('name')
                                    ->get();

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function asignar(){

        $this->validate(['modelo_editar.valuador' => 'required']);

        try {

            $this->modelo_editar->estado = 'valuación';
            $this->modelo_editar->actualizado_por = auth()->id();
            $this->modelo_editar->save();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "Se asignó el valuador con éxito."]);


        } catch (\Throwable $th) {

            Log::error("Error al asignar valuador en variación catastral por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function abrirSubirArchivo(VariacionCatastral $modelo){

        $this->dispatch('removeFiles');

        $this->modalSubirArchivo = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;
    }

    public function anexar(){

        $this->validate(['file' => 'required|mimes:pdf']);

        try {

            if(!$this->modelo_editar->archivo){

                $this->modelo_editar->archivo  = $this->file->store('/', 'variacionescatastrales');

            }else{

                $aux  = $this->file->store('/', 'variacionescatastrales');

                $oMerger = PDFMerger::init();

                $oMerger->addPDF(Storage::path('variacionescatastrales/'. $this->modelo_editar->archivo), 'all');

                $oMerger->addPDF(Storage::path('variacionescatastrales/'. $aux), 'all');

                $oMerger->merge();

                $nombre = $this->modelo_editar->archivo;

                Storage::disk('variacionescatastrales')->delete($this->modelo_editar->archivo);

                Storage::disk('variacionescatastrales')->delete($aux);

                Storage::put('variacionescatastrales/' . $nombre, $oMerger->output());

            }

            $this->modelo_editar->estado = 'actualizado';
            $this->modelo_editar->actualizado_por = auth()->id();
            $this->modelo_editar->save();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "Se subio el archivo con éxito."]);


        } catch (\Throwable $th) {

            Storage::disk('variacionescatastrales')->delete($aux);

            Log::error("Error al subir archivo en variación catastral por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
            $this->resetearTodo();


        }

    }

    public function abrirCambiarEstado(VariacionCatastral $modelo){

        $this->modalCambiarEstado = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;
    }

    public function actualizar(){

        $this->validate(['estado' => 'required']);

        try {

            DB::transaction(function () {

                if($this->estado === 'concluido'){

                    $this->modelo_editar->tramite->update(['estado' => 'concluido']);

                }

                $this->modelo_editar->estado = $this->estado;
                $this->modelo_editar->actualizado_por = auth()->id();
                $this->modelo_editar->save();

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "Se actualizó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualizar variación catastral por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
            $this->resetearTodo();

        }

    }

    public function asignarFolio(VariacionCatastral $modelo){

        try {

            $modelo->folio = (VariacionCatastral::where('año', now()->format('Y'))->max('folio') ?? 0) + 1;
            $modelo->año = now()->format('Y');
            $modelo->estado = 'nuevo';
            $modelo->actualizado_por = auth()->id();
            $modelo->save();

            $this->dispatch('mostrarMensaje', ['success', "La varicación catastral se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al asignar folio a varicación catastral por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function mount(){

        array_push($this->fields, 'requerimiento', 'tramite', 'modalHacerRequerimiento', 'tfolio', 'tusuario', 'modalVerRequerimiento', 'modalAsignarValuador', 'modalSubirArchivo', 'file', 'modalCambiarEstado');

        $this->años = Constantes::AÑOS;

        $this->taño = now()->format('Y');

        $this->usuarios = User::select('id', 'name')->orderBy('name')->get();

        $this->oficinas = Oficina::select('id', 'nombre')->orderBy('nombre')->get();

        $this->crearModeloVacio();

        $this->estados = [
            'nuevo',
            'requerimineto',
            'valuación',
            'actualizado',
            'publicación',
            'oposición',
            'concluido',
            'firma',
            'revisión',
        ];

    }

    #[Computed]
    public function variaciones(){

        if(auth()->user()->hasRole('Oficina rentistica')){

            $variaciones = VariacionCatastral::with('creadoPor', 'actualizadoPor', 'tramite:id,año,folio,usuario', 'oficina:id,nombre')
                                            ->where(function($q){
                                                $q->where('promovente', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere('finado', 'LIKE', '%' . $this->search . '%');
                                            })
                                            ->when($this->filters['estado'], fn($q, $estado) => $q->where('estado', $estado))
                                            ->when($this->filters['año'], fn($q, $taño) => $q->where('año', $taño))
                                            ->when($this->filters['folio'], fn($q, $tfolio) => $q->where('folio', $tfolio))
                                            ->when($this->filters['taño'], fn($q, $taño) => $q->whereHas('tramite', function($q) use($taño){ $q->where('año', $taño); }))
                                            ->when($this->filters['tfolio'], fn($q, $tfolio) => $q->whereHas('tramite', function($q) use($tfolio){ $q->where('folio', $tfolio); }))
                                            ->when($this->filters['tusuario'], fn($q, $tusuario) => $q->whereHas('tramite', function($q) use($tusuario){ $q->where('usuario', $tusuario); }))
                                            ->where('oficina_id', auth()->user()->oficina_id)
                                            ->whereIn('estado', ['requerimineto', 'revisión'])
                                            ->orderBy($this->sort, $this->direction)
                                            ->paginate($this->pagination);

        }elseif(auth()->user()->hasRole('Valuador')){

            $variaciones = VariacionCatastral::with('creadoPor', 'actualizadoPor', 'tramite:id,año,folio,usuario', 'oficina:id,nombre')
                                            ->where(function($q){
                                                $q->where('promovente', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere('finado', 'LIKE', '%' . $this->search . '%');
                                            })
                                            ->when($this->filters['estado'], fn($q, $estado) => $q->where('estado', $estado))
                                            ->when($this->filters['año'], fn($q, $taño) => $q->where('año', $taño))
                                            ->when($this->filters['folio'], fn($q, $tfolio) => $q->where('folio', $tfolio))
                                            ->when($this->filters['taño'], fn($q, $taño) => $q->whereHas('tramite', function($q) use($taño){ $q->where('año', $taño); }))
                                            ->when($this->filters['tfolio'], fn($q, $tfolio) => $q->whereHas('tramite', function($q) use($tfolio){ $q->where('folio', $tfolio); }))
                                            ->when($this->filters['tusuario'], fn($q, $tusuario) => $q->whereHas('tramite', function($q) use($tusuario){ $q->where('usuario', $tusuario); }))
                                            ->where('valuador', auth()->id())
                                            ->orderBy($this->sort, $this->direction)
                                            ->paginate($this->pagination);

        }elseif(auth()->user()->can('Variaciones catastrales')){

            $variaciones = VariacionCatastral::with('creadoPor', 'actualizadoPor', 'tramite:id,año,folio,usuario', 'oficina:id,nombre')
                                                ->where(function($q){
                                                    $q->where('promovente', 'LIKE', '%' . $this->search . '%')
                                                        ->orWhere('finado', 'LIKE', '%' . $this->search . '%');
                                                })
                                                ->when($this->filters['estado'], fn($q, $estado) => $q->where('estado', $estado))
                                                ->when($this->filters['año'], fn($q, $taño) => $q->where('año', $taño))
                                                ->when($this->filters['folio'], fn($q, $tfolio) => $q->where('folio', $tfolio))
                                                ->when($this->filters['taño'], fn($q, $taño) => $q->whereHas('tramite', function($q) use($taño){ $q->where('año', $taño); }))
                                                ->when($this->filters['tfolio'], fn($q, $tfolio) => $q->whereHas('tramite', function($q) use($tfolio){ $q->where('folio', $tfolio); }))
                                                ->when($this->filters['tusuario'], fn($q, $tusuario) => $q->whereHas('tramite', function($q) use($tusuario){ $q->where('usuario', $tusuario); }))
                                                ->orderBy($this->sort, $this->direction)
                                                ->paginate($this->pagination);

        }

        return $variaciones;

    }

    public function render()
    {
        return view('livewire.a-tramites-administrativos.variaciones-catastrales.variaciones-catastrales')->extends('layouts.admin');
    }
}
