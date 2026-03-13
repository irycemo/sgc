<?php

namespace App\Livewire\Comun\Consultas;

use Livewire\Component;
use App\Models\Certificacion;
use Illuminate\Support\Facades\Log;
use App\Enums\Certificaciones\CertificacionesEnum;
use App\Http\Controllers\Certificaciones\CertificacionesController;
use App\Http\Controllers\Certificaciones\CertificadoHistoriaController;
use App\Http\Controllers\Certificaciones\CertificadoNegativoController;
use App\Http\Controllers\Certificaciones\CertificadoRegistroController;
use App\Http\Controllers\Certificaciones\CedulaActualizcacionController;

class CertificacionesConsulta extends Component
{

    public $predio_id;
    public $certificaciones;

    public function imprimirCertificacion(Certificacion $modelo){

        try {

            if($modelo->tipo == CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL){

                $pdf = (new CertificacionesController())->reimprimirNotifiacionValorCatastral($modelo);

            }elseif($modelo->tipo == CertificacionesEnum::CERTIFICADO_CATASTRAL){

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

            Log::error("Error al reimiprimir certificación en consulta por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        $this->certificaciones = Certificacion::where('predio_id', $this->predio_id)
                                                    ->where('estado', 'activo')
                                                    ->get();

    }

    public function render()
    {
        return view('livewire.comun.consultas.certificaciones-consulta');
    }
}
