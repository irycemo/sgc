<?php

namespace App\Livewire\ATramitesAdministrativos\TramitesTransicion;

use App\Constantes\Constantes;
use App\Exceptions\GeneralException;
use App\Models\Audit;
use App\Models\File;
use App\Models\Oficina;
use App\Models\Tramite;
use App\Models\TramiteAdministrativo;
use App\Models\User;
use App\Services\Tramites\TramiteService;
use App\Traits\ComponentesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TramtiesTransicion extends Component
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

    public $localidad;
    public $oficina;
    public $tipo_predio;
    public $numero_registro;

    public $modalHacerRequerimiento = false;
    public $modalVerRequerimiento = false;
    public $modalAsignarValuador = false;
    public $modalSubirArchivo = false;
    public $modalCambiarEstado = false;
    public $modalVerArchivos = false;
    public $modalVerAudits = false;

    public TramiteAdministrativo $modelo_editar;

    public $descripcion_documento;
    public $documentos;
    public $audits = [];

    public $filters = [
        'estado' => '',
        'año' => '',
        'folio' => '',
        'taño' => '',
        'tfolio' => '',
        'tusuario' => ''
    ];

    protected $validationAttributes  = [
        'modelo_editar.oficina_id' => 'oficina',
        'file' => 'archivo',
        'descripcion_documento' => 'descripción'
    ];

    protected function rules(){

        return [
            'taño' => 'required',
            'tfolio' => 'required',
            'tusuario' => 'required',
            'modelo_editar.tipo' => 'required',
            'modelo_editar.promovente' => 'required',
            'modelo_editar.finado' => Rule::requiredIf($this->modelo_editar->tipo === 'variacion'),
            'modelo_editar.oficina_id' => Rule::requiredIf(!auth()->user()->hasRole('Oficina rentistica')),
            'modelo_editar.valuador' => 'nullable',
            'modelo_editar.estado' => 'nullable',
            'modelo_editar.localidad' => 'required',
            'modelo_editar.oficina' => 'required',
            'modelo_editar.tipo_predio' => 'required',
            'modelo_editar.numero_registro' => 'required',
        ];

    }

    public function crearModeloVacio(){
        $this->modelo_editar = TramiteAdministrativo::make();
    }

    public function buscarTramite(){

        try {

            $this->tramite = Tramite::with('predios')
                                        ->where('año', $this->taño)
                                        ->where('folio', $this->tfolio)
                                        ->where('usuario', $this->tusuario)
                                        ->first();

            if(!$this->tramite){

                $this->dispatch('mostrarMensaje', ['error', "El trámite no existe."]);

                return true;

            }

            $tramite_administrativo = TramiteAdministrativo::where('tramite_id', $this->tramite->id)->first();

            if($tramite_administrativo){

                $this->dispatch('mostrarMensaje', ['error', "El trámite ya esta usado."]);

                return true;

            }

            if($this->tramite->servicio->clave_ingreso !== 'DM27'){

                $this->dispatch('mostrarMensaje', ['error', "El trámite no corresponde a un predio ignorado o variación catastral."]);

                return true;

            }

            if($this->tramite->estado != 'pagado'){

                (new TramiteService($this->tramite))->procesarPago();

            }

            if($this->tramite->estado === 'concluido'){

                $this->dispatch('mostrarMensaje', ['error', "El trámite esta concluido."]);

                return true;

            }

            return false;

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no esta pagado."]);

            $this->reset('tramite');

        }

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
                    $this->modelo_editar->folio = (TramiteAdministrativo::where('año', now()->format('Y'))->max('folio') ?? 0) + 1;

                }

                $this->modelo_editar->tramite_id = $this->tramite->id;
                $this->modelo_editar->año = now()->format('Y');
                $this->modelo_editar->creado_por = auth()->id();
                $this->modelo_editar->save();

                $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Generó predio trámite administrativo']);

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "El trámite se creó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al crear predio ignorado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function abrirAsignarValuador(TramiteAdministrativo $modelo){

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->valuadores = User::where('valuador', true)
                                    ->where('estado', 'activo')
                                    ->where('oficina_id', $this->modelo_editar->oficina_id)
                                    ->orderBy('name')
                                    ->get();


        $this->modalAsignarValuador = true;

    }

    public function asignar(){

        $this->validate(['modelo_editar.valuador' => 'required']);

        try {

            $this->modelo_editar->estado = 'valuación';
            $this->modelo_editar->actualizado_por = auth()->id();
            $this->modelo_editar->save();

            $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Asignó valuador']);

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "Se asignó el valuador con éxito."]);


        } catch (\Throwable $th) {

            Log::error("Error al asignar valuador en predio ignorado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function abrirHacerRequerimiento(TramiteAdministrativo $modelo){

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
                    'descripcion' => $this->requerimiento,
                    'creado_por' => auth()->id(),
                    'estado' => 'nuevo'
                ]);

                $this->modelo_editar->update(['estado' => 'requerimineto']);

                $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Hizó requerimiento']);

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "El requerimiento se creó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al crear requerimiento en predio ignorado catastral por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function abrirVerRequerimiento(TramiteAdministrativo $modelo){

        $this->modalVerRequerimiento = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->modelo_editar->load('requerimientos.creadoPor');

    }

    public function abrirVerArchivos(TramiteAdministrativo $modelo){

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->modalVerArchivos = true;

    }

    public function abrirModalAuditoria(TramiteAdministrativo $modelo){

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->audits = Audit::with('user:id,name')->where('auditable_type', 'App\Models\TramiteAdministrativo')->where('auditable_id', $this->modelo_editar->id)->get();

        $this->modalVerAudits = true;

    }

    public function abrirSubirArchivo(TramiteAdministrativo $modelo){

        $this->dispatch('removeFiles');

        $this->modalSubirArchivo = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;
    }

    public function guardarArchivo(){

        $this->validate(['file' => 'required|mimes:pdf', 'descripcion_documento' => 'required']);

        try {

            DB::transaction(function () {

                $archivo = $this->modelo_editar->archivos()->where('descripcion', $this->descripcion_documento)->first();

                if($archivo){

                    if(app()->isProduction()){

                        Storage::disk('s3')->delete(config('services.ses.ruta_predios') . $archivo->url);

                    }else{

                        Storage::disk('prediosignorados')->delete($archivo->url);

                    }

                    $archivo->delete();

                }

                if(app()->isProduction()){

                    $file  = $this->file->store('sgc/predios_archivo', 's3');

                }else{

                    $file  = $this->file->store('/', 'prediosignorados');

                }

                $url = Str::replace('sgc/predios_archivo/', '' , $file);

                File::create([
                    'fileable_id' => $this->modelo_editar->id,
                    'fileable_type' => 'App\Models\TramiteAdministrativo',
                    'descripcion' => $this->descripcion_documento,
                    'url' => $url
                ]);

                $this->modelo_editar->estado = 'actualizado';
                $this->modelo_editar->actualizado_por = auth()->id();
                $this->modelo_editar->save();

                $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Subio archivo: ' . $this->descripcion_documento]);

            });

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "Se subio el archivo con éxito."]);

        } catch (\Throwable $th) {
            Log::error("Error al subir archivo en variación catastral por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
            $this->resetearTodo();
        }

    }

    public function abrirCambiarEstado(TramiteAdministrativo $modelo){

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

                $this->modelo_editar->audits()->latest()->first()->update(['tags' => 'Cambio estado a: ' . $this->estado]);

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "Se actualizó con éxito."]);

            });

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar predio ignorado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "El archivo no es compatible."]);
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

        $this->modelo_editar->oficina_id = auth()->user()->oficina_id;

        $this->estados = [
            'nuevo',
            'requerimineto',
            'valuación',
            'actualizado',
            'publicación',
            'periódico oficial',
            'oposición',
            'concluido',
            'firma',
            'revisión',
            'asignar clave'
        ];

        $this->filters['estado'] = request()->query('estado');

        $this->documentos = Constantes::PREDIOS_IGNORADOS_DOCUMENTOS;

    }

    #[Computed]
    public function tramitesAdministrativos(){

        if(auth()->user()->area == 'Oficina de rentas'){

            $prediosIgnorados = TramiteAdministrativo::select('id', 'año', 'folio', 'estado', 'tramite_id', 'promovente', 'archivo', 'oficina_id', 'creado_por', 'actualizado_por', 'created_at', 'updated_at', 'localidad', 'oficina', 'tipo_predio', 'numero_registro', 'finado')
                                            ->with('creadoPor:id,name', 'actualizadoPor:id,name', 'tramite:id,año,folio,usuario', 'oficinaRentistica:id,nombre')
                                            ->withCount('archivos')
                                            ->where(function($q){
                                                $q->where('promovente', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere('finado', 'like', '%'. $this->search . '%');
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

            $prediosIgnorados = TramiteAdministrativo::select('id', 'año', 'folio', 'estado', 'tramite_id', 'promovente', 'archivo', 'oficina_id', 'creado_por', 'actualizado_por', 'created_at', 'updated_at', 'localidad', 'oficina', 'tipo_predio', 'numero_registro', 'finado')
                                            ->with('creadoPor:id,name', 'actualizadoPor:id,name', 'tramite:id,año,folio,usuario', 'oficinaRentistica:id,nombre')
                                            ->withCount('archivos')
                                            ->where(function($q){
                                                $q->where('promovente', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere('finado', 'like', '%'. $this->search . '%');
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

            $prediosIgnorados = TramiteAdministrativo::select('id', 'año', 'folio', 'estado', 'tramite_id', 'promovente', 'archivo', 'oficina_id', 'creado_por', 'actualizado_por', 'created_at', 'updated_at', 'localidad', 'oficina', 'tipo_predio', 'numero_registro', 'finado')
                                                ->with('creadoPor:id,name', 'actualizadoPor:id,name', 'tramite:id,año,folio,usuario', 'oficinaRentistica:id,nombre')
                                                ->withCount('archivos')
                                                ->where(function($q){
                                                    $q->where('promovente', 'LIKE', '%' . $this->search . '%')
                                                        ->orWhere('finado', 'like', '%'. $this->search . '%');
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

        return $prediosIgnorados;

    }

    public function render()
    {
        return view('livewire.a-tramites-administrativos.tramites-transicion.tramties-transicion')->extends('layouts.admin');
    }
}
