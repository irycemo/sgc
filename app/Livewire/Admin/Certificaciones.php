<?php

namespace App\Livewire\Admin;

use App\Models\Oficina;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Certificacion;
use App\Constantes\Constantes;
use App\Enums\Certificaciones\CertificacionesEnum;
use App\Http\Controllers\Certificaciones\CedulaActualizcacionController;
use App\Http\Controllers\Certificaciones\CertificacionesController;
use App\Http\Controllers\Certificaciones\CertificadoHistoriaController;
use App\Http\Controllers\Certificaciones\CertificadoNegativoController;
use App\Http\Controllers\Certificaciones\CertificadoRegistroController;
use App\Http\Controllers\Certificaciones\NotificacionValorCatastralController;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;

class Certificaciones extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $años;
    public $año;
    public $documentos;
    public $oficinas;

    public $imagen;

    public $filters = [
        'año' => '',
        'folio' => '',
        'documento' => '',
        'estado' => '',
        'oficina' => '',
        'tAño' => '',
        'tFolio' => '',
        'tUsuario' => '',
        'localidad' => '',
        'p_oficina' => '',
        't_predio' => '',
        'registro' => '',
    ];

    public Certificacion $modelo_editar;

    public function updatedFilters() { $this->resetPage(); }

    public function crearModeloVacio(){
        $this->modelo_editar = Certificacion::make();
    }

    public function abrirModalEditar(Certificacion $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function actualizar(){

        $this->validate();

        try{

            $this->modelo_editar->actualizado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La certificación se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar certificación por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function reimprimir(Certificacion $modelo){

        try {

            if($modelo->tipo == CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL){

                $pdf = (new NotificacionValorCatastralController())->reimprimirNotifiacionValorCatastral($modelo);

            }elseif($modelo->tipo == CertificacionesEnum::CERTIFICADO_HISTORIA){

                $pdf = (new CertificadoHistoriaController())->reimprimirCertificado($modelo);

            }elseif($modelo->tipo == CertificacionesEnum::CEDULA_CATASTRAL){

                $pdf = (new CedulaActualizcacionController())->reimprimirCedula($modelo);

            }elseif($modelo->tipo == CertificacionesEnum::CERTIFICADO_NEGATIVO){

                $pdf = (new CertificadoNegativoController())->reimprimirCertificado($modelo);

            }elseif($modelo->tipo == CertificacionesEnum::CERTIFICADO_REGISTRO){

                $pdf = (new CertificadoRegistroController())->reimprimirCertificado($modelo);

            }

            return response()->streamDownload(
                fn () => print($pdf->output()),
                $modelo->tipo->label() . '-' . $modelo->año . '-' .$modelo->folio . '.pdf'
            );

        } catch (\Throwable $th) {

            Log::error("Error al reimiprimir certificación por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    #[Computed]
    public function certificaciones(){

        return Certificacion::select('id', 'uuid', 'tipo', 'año', 'folio', 'estado', 'oficina_id', 'tramite_id', 'predio_id', 'creado_por', 'actualizado_por', 'created_at', 'updated_at')
                                ->with(
                                    'creadoPor:id,name',
                                    'actualizadoPor:id,name',
                                    'tramite:id,año,folio,usuario',
                                    'oficina:id,nombre',
                                    'predio:id,localidad,oficina,tipo_predio,numero_registro'
                                )
                                ->when($this->filters['año'], fn($q, $año) => $q->where('año', $año))
                                ->when($this->filters['folio'], fn($q, $folio) => $q->where('folio', $folio))
                                ->when($this->filters['estado'], fn($q, $estado) => $q->where('estado', $estado))
                                ->when($this->filters['documento'], fn($q, $documento) => $q->where('tipo', $documento))
                                ->when($this->filters['oficina'], fn($q, $oficina) => $q->where('oficina_id', $oficina))
                                ->when($this->filters['tAño'], function($q, $tAño){
                                    $q->WhereHas('tramite', function($q) use($tAño){
                                        $q->where('año', $tAño);
                                    });
                                })
                                ->when($this->filters['tFolio'], function($q, $tFolio){
                                    $q->WhereHas('tramite', function($q) use($tFolio){
                                        $q->where('folio', $tFolio);
                                    });
                                })
                                ->when($this->filters['tUsuario'], function($q, $tUsuario){
                                    $q->WhereHas('tramite', function($q) use($tUsuario){
                                        $q->where('usuario', $tUsuario);
                                    });
                                })
                                ->when($this->filters['localidad'], function($q, $localidad){
                                    $q->WhereHas('predio', function($q) use($localidad){
                                        $q->where('localidad', $localidad);
                                    });
                                })
                                ->when($this->filters['p_oficina'], function($q, $oficina){
                                    $q->WhereHas('predio', function($q) use($oficina){
                                        $q->where('oficina', $oficina);
                                    });
                                })
                                ->when($this->filters['t_predio'], function($q, $t_predio){
                                    $q->WhereHas('predio', function($q) use($t_predio){
                                        $q->where('tipo_predio', $t_predio);
                                    });
                                })
                                ->when($this->filters['registro'], function($q, $registro){
                                    $q->WhereHas('predio', function($q) use($registro){
                                        $q->where('numero_registro', $registro);
                                    });
                                })
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);
    }

    public function mount(): void
    {

        $this->crearModeloVacio();

        $this->años = Constantes::AÑOS;

        $this->documentos = CertificacionesEnum::cases();

        $this->oficinas = Oficina::select('id','nombre','oficina')->orderBy('nombre')->get();

        $this->filters['año'] = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.admin.certificaciones')->extends('layouts.admin');
    }
}
