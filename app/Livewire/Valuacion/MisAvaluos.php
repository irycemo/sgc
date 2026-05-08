<?php

namespace App\Livewire\Valuacion;

use App\Constantes\Constantes;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Valuacion\AvaluoImpresionController;
use App\Jobs\Valuacion\GenerarAvaluoJob;
use App\Models\Avaluo;
use App\Models\Certificacion;
use App\Models\File;
use App\Models\PredioIgnorado;
use App\Models\Tramite;
use App\Models\VariacionCatastral;
use App\Traits\ComponentesTrait;
use App\Traits\Predios\ValidarCuentaAsignada;
use App\Traits\Predios\ValidarDisponibilidad;
use App\Traits\Predios\ValidarManzanaAsignada;
use App\Traits\Predios\ValidarSector;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class MisAvaluos extends Component
{

    use WithPagination;
    use ComponentesTrait;
    use ValidarCuentaAsignada;
    use ValidarManzanaAsignada;
    use ValidarSector;
    use ValidarDisponibilidad;

    public $seleccionados = [];
    public $idsEnPagina = [];
    public $paginaSeleccionada = false;
    public $todosSelecionados = false;
    public $modal = false;
    public $modal_imprimir = false;
    public $modalCorregir = false;
    public $modalVerArchivos = false;
    public $modalClonar = false;
    public $años;
    public $modelo_administrativo;

    public $region_catastral;
    public $municipio;
    public $localidad;
    public $sector;
    public $zona_catastral;
    public $manzana;
    public $predio;
    public $edificio;
    public $departamento;
    public $oficina;
    public $tipo_predio;
    public $numero_registro;

    public $año;
    public $folio;
    public $usuario;
    public $batch_id;
    public $concluido = false;
    public $generando = false;
    public $nombres = [];

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

    public function abrirModalClonar(Avaluo $modelo){

        $this->resetearTodo();

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->editar = true;
        $this->modalClonar = true;

    }

    public function abrirModalCorreccion(Avaluo $modelo){

        $this->resetearTodo();

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->editar = true;
        $this->modalCorregir = true;

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

                $avaluos = Avaluo::where('tramite_inspeccion', $tramiteInspeccion->id)->where('estado', '!=', 'notificado')->get();

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

                $cantidad = ($tramiteInspeccion->usados - $avaluos->count()) < 0 ? 0 : ($tramiteInspeccion->usados - $avaluos->count());

                $tramiteInspeccion->update([
                    'usados' => $cantidad,
                    'estado' => 'pagado'
                ]);

                $tramiteInspeccion->audits()->latest()->first()->update(['tags' => 'Reactivó para corrección']);

                if($tramiteDesglose){

                    $cantidad = ($tramiteInspeccion->usados - $avaluos->count()) < 0 ? 0 : ($tramiteInspeccion->usados - $avaluos->count());

                    $tramiteDesglose->update([
                        'usados' => $cantidad,
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

        try {

            if(! $avaluo->uuid){

                $avaluo->update(['uuid' => (string)Str::uuid()]);

            }

            $pdf = (new AvaluoImpresionController())->generarAvaluo($avaluo);

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'avaluo.pdf'
            );

       } catch (\Throwable $th) {

            Log::error("Error al imprimir avaluo en mis avaluos por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

       }

    }

    public function imprimirAvaluos(){

        $this->validate([
            'año' => 'required',
            'folio' => 'required',
            'usuario' => 'required',
        ]);

        try {

            $tramite = Tramite::where('año', $this->año)
                                    ->where('folio', $this->folio)
                                    ->where('usuario', $this->usuario)
                                    ->first();

            if(! $tramite) throw new GeneralException("El trámite no existe");

            $avaluos = Avaluo::where('tramite_inspeccion', $tramite->id)
                                ->where('estado', '!=', 'nuevo')
                                ->get();

            if(! $avaluos->count()) throw new GeneralException(("No hay avalúos asociados a el trámite ingresado."));

            $jobs = [];

            foreach($avaluos as $avaluo){

                $nombre = $avaluo->id . '.' . now()->format('d-m-Y H:i:s');

                array_push($this->nombres, $nombre);

                $jobs[] = new GenerarAvaluoJob($avaluo->id, $nombre);

            }

            $bus = Bus::batch($jobs)->dispatch();

            $this->batch_id = $bus->id;

            $this->generando = true;

       } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

       } catch (\Throwable $th) {

            Log::error("Error al imprimir avaluo en mis avaluos por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

       }

    }

    public function getBatchProperty()
    {

        if (!$this->batch_id) {

            return null;

        }

        return Bus::findBatch($this->batch_id);

    }

    public function updateProgress(){

        $this->concluido = $this->batch->finished();

        if ($this->concluido) {

            $this->generando = false;

        }

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

    public function clonar(){

        $this->validate([
            'region_catastral' => 'required|numeric',
            'municipio' => 'required|numeric',
            'localidad' => 'required|numeric',
            'sector' => 'required|numeric',
            'zona_catastral' => 'required|numeric',
            'manzana' => 'required|numeric',
            'predio' => 'required|numeric',
            'edificio' => 'required|numeric',
            'departamento' => 'required|numeric',
            'oficina' => 'required|numeric',
            'tipo_predio' => 'required|numeric',
            'numero_registro' => 'required',
        ]);

        try {

            DB::transaction(function () {

                $predio_id = $this->clonarPredio();

                $nuevo_avaluo = $this->modelo_editar->replicate();

                $nuevo_avaluo->folio = (Avaluo::where('año', now()->format('Y'))->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1;
                $nuevo_avaluo->predio_avaluo = $predio_id;
                $nuevo_avaluo->predio = null;
                $nuevo_avaluo->estado = 'nuevo';
                $nuevo_avaluo->save();

                foreach($this->modelo_editar->bloques as $bloque){

                    $nuevo_bloque = $bloque->replicate();
                    $nuevo_bloque->avaluo_id = $nuevo_avaluo->id;
                    $nuevo_bloque->save();

                }

                foreach($this->modelo_editar->imagenes as $imagen){

                    if(app()->isProduction()){

                        $nombre = '2' . $imagen->url;

                        if (Storage::disk('s3')->exists(config('services.ses.ruta_avaluos_fotos') . $imagen->url)){

                            Storage::disk('s3')->copy(config('services.ses.ruta_avaluos_fotos') . $imagen->url, config('services.ses.ruta_avaluos_fotos') .  $nombre);

                        }else{

                            return;

                        }

                    }else{

                        $nombre = '2' . $imagen->url;

                        Storage::disk('avaluos')->copy($imagen->url, $nombre);

                    }

                    $nueva_imagen = $imagen->replicate();
                    $nueva_imagen->url = $nombre;
                    $nueva_imagen->fileable_id = $nuevo_avaluo->id;
                    $nueva_imagen->save();

                }

            });

            $this->dispatch('mostrarMensaje', ['success', 'El avalúo se clono con éxito']);

            $this->reset(['localidad', 'oficina', 'tipo_predio', 'numero_registro', 'modalClonar']);


        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al clonar avalúo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function clonarPredio(){

        $this->validarSectorNoBinding($this->localidad, $this->oficina, $this->municipio, $this->sector);

        $this->validarCuentaAsignadaNoBindings($this->localidad, $this->oficina, $this->tipo_predio, $this->numero_registro, auth()->id());

        $this->validarManzanaAsignadaNoBindings($this->municipio, $this->zona_catastral, $this->localidad, $this->sector, $this->manzana, auth()->id());

        $this->validarDisponibilidadPredioAvaluo($this->region_catastral, $this->municipio, $this->zona_catastral, $this->localidad, $this->sector, $this->manzana, $this->predio, $this->edificio, $this->departamento, $this->oficina, $this->tipo_predio, $this->numero_registro);

        $predio = $this->modelo_editar->predioAvaluo->replicate();

        $predio->region_catastral = $this->region_catastral;
        $predio->municipio = $this->municipio;
        $predio->zona_catastral = $this->zona_catastral;
        $predio->localidad = $this->localidad;
        $predio->sector = $this->sector;
        $predio->manzana = $this->manzana;
        $predio->predio = $this->predio;
        $predio->edificio = $this->edificio;
        $predio->departamento = $this->departamento;
        $predio->oficina = $this->oficina;
        $predio->tipo_predio = $this->tipo_predio;
        $predio->numero_registro = $this->numero_registro;
        $predio->status = 'activo';

        $predio->save();

        foreach($this->modelo_editar->predioAvaluo->colindancias as $colindancia){

            $nueva_colindancia = $colindancia->replicate();

            $nueva_colindancia->colindanciaable_id = $predio->id;

            $nueva_colindancia->colindanciaable_type = 'App\Models\PredioAvaluo';

            $nueva_colindancia->save();

        }

        foreach($this->modelo_editar->predioAvaluo->propietarios as $propietario){

            $propietario_nuevo = $propietario->replicate();

            $propietario_nuevo->propietarioable_id = $predio->id;

            $propietario_nuevo->propietarioable_type = 'App\Models\PredioAvaluo';

            $propietario_nuevo->save();

        }


        foreach($this->modelo_editar->predioAvaluo->terrenos as $terreno){

            $terreno_nuevo = $terreno->replicate();

            $terreno_nuevo->terrenoable_id = $predio->id;

            $terreno_nuevo->terrenoable_type = 'App\Models\PredioAvaluo';

            $terreno_nuevo->save();

        }

        foreach($this->modelo_editar->predioAvaluo->construcciones as $construccion){

            $construccion_nueva = $construccion->replicate();

            $construccion_nueva->construccionable_id = $predio->id;

            $construccion_nueva->construccionable_type = 'App\Models\PredioAvaluo';

            $construccion_nueva->save();

        }

        if($predio->edifici0 > 0){

            foreach($this->modelo_editar->predioAvaluo->construccionesComun as $construccioneComun){

                $construccion_comun_nueva = $construccioneComun->replicate();

                $construccion_comun_nueva->construcciones_comunsable_id = $predio->id;

                $construccion_comun_nueva->construcciones_comunsable_type = 'App\Models\PredioAvaluo';

                $construccion_comun_nueva->save();

            }

            foreach($this->modelo_editar->predioAvaluo->terrenosComun as $terrenoComun){

                $terreno_comun_nuevo = $terrenoComun->replicate();

                $terreno_comun_nuevo->terrenos_comunsable_id = $predio->id;

                $terreno_comun_nuevo->terrenos_comunsable_type = 'App\Models\PredioAvaluo';

                $terreno_comun_nuevo->save();

            }

        }

        return $predio->id;

    }

    public function actualizarPropietarios(Avaluo $avaluo){

        try {

            if($avaluo->predio){

                $avaluo->predioAvaluo->propietarios()->delete();

                foreach ($avaluo->predioPadron->propietarios as $propietario) {

                    $nuevo_propietario = $propietario->replicate();

                    $nuevo_propietario->propietarioable_id = $avaluo->predio_avaluo;
                    $nuevo_propietario->propietarioable_type = 'App\Models\PredioAvaluo';

                    $nuevo_propietario->save();

                }

                $this->dispatch('mostrarMensaje', ['success', 'Los propietarios se actualizarón con éxito.']);

            }else{

                throw new GeneralException('El avalúo no tiene relacionado un predio origen.');

            }


        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar propietarios en avalúo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function mount(){

        $this->modelo_editar = $this->crearModeloVacio();

        $this->años = Constantes::AÑOS;

        $this->filters['año'] = now()->format('Y');

    }

    #[Computed]
    public function avaluos(){

        return Avaluo::select('id', 'año', 'folio', 'usuario', 'predio', 'estado', 'asignado_a', 'tramite_inspeccion', 'variacion_catastral_id', 'predio_ignorado_id', 'predio_avaluo', 'creado_por', 'actualizado_por', 'created_at', 'updated_at')
                        ->with(
                            'creadoPor:id,name',
                            'actualizadoPor:id,name',
                            'predioAvaluo:id,localidad,oficina,tipo_predio,numero_registro,estado,region_catastral,municipio,zona_catastral,sector,manzana,predio,edificio,departamento',
                            'tramiteInspeccion:id,año,folio,usuario',
                            'predioIgnorado:id,año,folio',
                            'variacionCatastral:id,año,folio'
                        )
                        ->where('asignado_a', auth()->id())
                        ->when($this->filters['año'] != '', function($q, $año) {
                            $q->where('año', (int)$this->filters['año']);
                        })
                        ->when($this->filters['folio'] != '', function($q) {
                            $q->where('folio', (int)$this->filters['folio']);
                        })
                        ->when($this->filters['usuario'] != '', function($q, $usuario) {
                            $q->where('usuario', (int)$this->filters['usuario']);
                        })
                        ->when($this->filters['estado'] != '', function($q, $estado) {
                            $q->where('estado', $this->filters['estado']);
                        })
                        ->when($this->filters['localidad'] != '', function($q, $localidad) {
                            $q->whereHas('predioAvaluo', function($q){
                                $q->where('localidad', (int)$this->filters['localidad']);
                            });
                        })
                        ->when($this->filters['p_oficina'] != '', function($q, $oficina) {
                            $q->whereHas('predioAvaluo', function($q){
                                $q->where('oficina', (int)$this->filters['p_oficina']);
                            });
                        })
                        ->when($this->filters['t_predio'] != '', function($q, $tipo) {
                            $q->whereHas('predioAvaluo', function($q){
                                $q->where('tipo_predio', (int)$this->filters['t_predio']);
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

    public function render()
    {

        $this->idsEnPagina = $this->avaluos->map(fn ($avaluo) => (string)$avaluo->id)->toArray();

        return view('livewire.valuacion.mis-avaluos')->extends('layouts.admin');

    }

}