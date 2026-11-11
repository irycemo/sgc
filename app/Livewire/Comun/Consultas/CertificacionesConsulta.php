<?php

namespace App\Livewire\Comun\Consultas;

use App\Enums\Certificaciones\CertificacionesEnum;
use App\Http\Controllers\Certificaciones\CedulaActualizcacionController;
use App\Http\Controllers\Certificaciones\CertificadoHistoriaController;
use App\Http\Controllers\Certificaciones\CertificadoNegativoController;
use App\Http\Controllers\Certificaciones\CertificadoRegistroController;
use App\Http\Controllers\Certificaciones\NotificacionValorCatastralController;
use App\Models\Certificacion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class CertificacionesConsulta extends Component
{

    public $predio_id;
    public $certificaciones;

    public function imprimirCertificacion(Certificacion $modelo){

        if($modelo->pdf){

            if(app()->isProduction()){

                $this->js('window.open(\' '. Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_pdfs_certificaciones') . $modelo->pdf->url, now()->addMinutes(10)) . '\', \'_blank\');');

            }else{

                $this->js('window.open(\' '. Storage::disk('certificaciones')->url($modelo->pdf->url) . '\', \'_blank\');');

            }

            return;

        }

        try {

            if($modelo->tipo == CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL){

                (new NotificacionValorCatastralController())->reimprimirNotifiacionValorCatastral($modelo);

            }elseif($modelo->tipo == CertificacionesEnum::CERTIFICADO_HISTORIA){

                (new CertificadoHistoriaController())->reimprimirCertificado($modelo);

            }elseif($modelo->tipo == CertificacionesEnum::CEDULA_CATASTRAL){

                (new CedulaActualizcacionController())->reimprimirCedula($modelo);

            }elseif($modelo->tipo == CertificacionesEnum::CERTIFICADO_NEGATIVO){

                (new CertificadoNegativoController())->reimprimirCertificado($modelo);

            }elseif($modelo->tipo == CertificacionesEnum::CERTIFICADO_REGISTRO){

                (new CertificadoRegistroController())->reimprimirCertificado($modelo);

            }

            if(app()->isProduction()){

                $this->js('window.open(\' '. Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_pdfs_certificaciones') . $modelo->pdf->url, now()->addMinutes(10)) . '\', \'_blank\');');

            }else{

                $this->js('window.open(\' '. Storage::disk('certificaciones')->url($modelo->pdf->url) . '\', \'_blank\');');

            }

        } catch (\Throwable $th) {

            Log::error("Error al reimiprimir certificación en consulta por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    #[On('actualizarPredio')]
    public function actualizarPredio($id){

        $this->certificaciones = Certificacion::where('predio_id', $id)
                                                    ->where('estado', 'activo')
                                                    ->get();

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
