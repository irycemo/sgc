<?php

namespace App\Livewire\Certificaciones\Consulta;

use App\Models\Predio;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Certificacion;
use App\Constantes\Constantes;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;
use App\Enums\Certificaciones\CertificacionesEnum;
use App\Http\Controllers\Certificaciones\CertificadoHistoriaController;
use App\Http\Controllers\Certificaciones\CertificadoNegativoController;
use App\Http\Controllers\Certificaciones\CertificadoRegistroController;
use App\Http\Controllers\Certificaciones\CedulaActualizcacionController;
use App\Http\Controllers\Certificaciones\NotificacionValorCatastralController;

class ConsultaCertificacion extends Component
{

    public $año;
    public $folio;
    public $usuario;

    public $localidad;
    public $oficina;
    public $t_predio;
    public $registro;

    public $años;

    public $tramite;
    public $predio;

    public function buscarTramite(){

        $this->validate([
            'año' => 'required',
            'folio' => 'required',
            'usuario' => 'required',
        ]);

        $this->tramite = Tramite::where('año', $this->año)
                            ->where('folio', $this->folio)
                            ->where('usuario', $this->usuario)
                            ->first();

        if(!$this->tramite){

            $this->dispatch('mostrarMensaje', ['warning', 'El trámtie no existe']);

            return;

        }

    }

    public function buscarCuentaPredial(){

        $this->validate([
            'localidad' => 'required',
            'oficina' => 'required',
            't_predio' => 'required',
            'registro' => 'required',
        ]);

        $this->predio = Predio::where('localidad', $this->localidad)
                            ->where('oficina', $this->oficina)
                            ->where('tipo_predio', $this->t_predio)
                            ->where('numero_registro', $this->registro)
                            ->first();

        if(!$this->predio){

            $this->dispatch('mostrarMensaje', ['warning', 'El predio no existe']);

            return;

        }

        if($this->predio->status == 'bloqueado'){

            $this->dispatch('mostrarMensaje', ['warning', 'El predio esta bloqueado']);

            return;

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

        if($this->tramite)
            return Certificacion::with('predio:id,localidad,oficina,tipo_predio,numero_registro', 'oficina:id,nombre', 'tramite:id,año,folio,usuario', 'creadoPor:id,name', 'actualizadoPor:id,name')->where('tramite_id', $this->tramite->id)->get();

        if($this->predio)
            return Certificacion::with('predio:id,localidad,oficina,tipo_predio,numero_registro', 'oficina:id,nombre', 'tramite:id,año,folio,usuario', 'creadoPor:id,name', 'actualizadoPor:id,name')->where('predio_id', $this->predio->id)->get();

        return [];

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.certificaciones.consulta.consulta-certificacion')->extends('layouts.admin');
    }
}
