<?php

namespace App\Http\Controllers\Certificaciones;

use App\Models\User;
use App\Models\Certificacion;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpCfdi\Credentials\Credential;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras;
use App\Traits\Certificaciones\GeneradorQRTrait;
use App\Enums\Certificaciones\CertificacionesEnum;
use App\Traits\Certificaciones\CrearImagenTrait;
use App\Traits\Certificaciones\NotificacionValorCatastral;

class CertificacionesController extends Controller
{

    use GeneradorQRTrait;
    use CrearImagenTrait;
    use NotificacionValorCatastral;

    public $formatter;
    public $director;
    public $jefe_departamento_valuacion;
    public $jefe_departamento_gestion;

    public function __construct()
    {

        $this->formatter = new NumeroALetras();

        $this->director = User::where('estado', 'activo')
                            ->whereHas('roles', function($q){
                                $q->where('name', 'Director');
                            })
                            ->first();

        $this->jefe_departamento_valuacion = User::where('estado', 'activo')
                                    ->where('area', 'Departamento de Valuación')
                                    ->whereHas('roles', function($q){
                                        $q->where('name', 'Jefe de departamento');
                                    })
                                    ->first();

        $this->jefe_departamento_gestion = User::where('estado', 'activo')
                                    ->where('area', 'Departamento de Gestión Catastral')
                                    ->whereHas('roles', function($q){
                                        $q->where('name', 'Jefe de departamento');
                                    })
                                    ->first();

    }

    public function notifiacionValorCatastral($avaluos, $tramite_inspeccion, $tramite_desglose){

        $datos_control = (object)[];

        $datos_control->tramite_inspeccion = $tramite_inspeccion?->año . '-' . $tramite_inspeccion?->folio . '-' . $tramite_inspeccion?->usuario;
        $datos_control->tramite_desglose = $tramite_desglose?->año . '-' . $tramite_desglose?->folio . '-' . $tramite_desglose?->usuario;
        $datos_control->jefe_departamento = $this->jefe_departamento_valuacion->name;
        $datos_control->director = $this->director->name;
        $datos_control->impreso_por = auth()->user()->name;
        $datos_control->impreso_en = now()->format('d/m/Y H:i:s');
        $datos_control->numero_avaluos = count($avaluos);
        $datos_control->numero_avaluos_letra = $this->formatter->toWords($datos_control->numero_avaluos);
        $datos_control->valuador = auth()->user()->name;

        $object = (object)[];

        $object->avaluos = $this->avaluos($avaluos);

        if(auth()->user()->hasRole(['Convenio municipal'])){

            $datos_control->autoridad_municipal = auth()->user()->oficina->autoridad_municipal;

            $object->datos_control = $datos_control;

            $certificacion = Certificacion::create([
                                                    'año' => now()->format('Y'),
                                                    'tipo' => CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL,
                                                    'folio' => (Certificacion::where('año', now()->format('Y'))->where('tipo', CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL)->max('folio') ?? 0) + 1,
                                                    'cadena_original' => json_encode($object),
                                                    'estado' => 'activo',
                                                    'oficina_id' => auth()->user()->oficina_id,
                                                    'creado_por' => auth()->id()
                                                ]);

            $qr = $this->generadorQr($certificacion->uuid);

        }elseif(auth()->user()->oficina->oficina == 101){

            $fielDirector = Credential::openFiles(
                                                    Storage::disk('efirmas')->path($this->director->efirma->cer),
                                                    Storage::disk('efirmas')->path($this->director->efirma->key),
                                                    $this->director->efirma->contraseña
                                                );

            $fielJefeDepartamento = Credential::openFiles(
                                                    Storage::disk('efirmas')->path($this->jefe_departamento_valuacion->efirma->cer),
                                                    Storage::disk('efirmas')->path($this->jefe_departamento_valuacion->efirma->key),
                                                    $this->jefe_departamento_valuacion->efirma->contraseña
                                                );

            $firmaDirector = $fielDirector->sign(json_encode($object));

            $firmaJefeDepartamento = $fielJefeDepartamento->sign(json_encode($object));

            $datos_control->firma_director = base64_encode($firmaDirector);

            $datos_control->firma_jefe_departamento = base64_encode($firmaJefeDepartamento);

            $datos_control->imagen_director = $this->director->efirma->imagen;

            $object->datos_control = $datos_control;

            $certificacion = Certificacion::create([
                                                        'año' => now()->format('Y'),
                                                        'tipo' => CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL,
                                                        'folio' => (Certificacion::where('año', now()->format('Y'))->where('tipo', CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL)->max('folio') ?? 0) + 1,
                                                        'cadena_original' => json_encode($object),
                                                        'cadena_encriptada' => base64_encode($firmaDirector),
                                                        'estado' => 'activo',
                                                        'oficina_id' => auth()->user()->oficina_id,
                                                        'tramite_id' => $tramite_inspeccion?->id,
                                                        'creado_por' => auth()->id()
                                                    ]);

            $qr = $this->generadorQr($certificacion->uuid);

        }else{

            $datos_control->titular = auth()->user()->oficina->titular;

            $datos_control->titular_cargo = auth()->user()->oficina->tipo == 'ADMINISTRACIÓN' ? 'ADMINISTRADOR' : 'RECEPTOR(A) DE RENTAS';

            $object->datos_control = $datos_control;

            $certificacion = Certificacion::create([
                                                        'año' => now()->format('Y'),
                                                        'tipo' => CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL,
                                                        'folio' => (Certificacion::where('año', now()->format('Y'))->where('tipo', CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL)->max('folio') ?? 0) + 1,
                                                        'cadena_original' => json_encode($object),
                                                        'estado' => 'activo',
                                                        'oficina_id' => auth()->user()->oficina_id,
                                                        'tramite_id' => $tramite_inspeccion?->id,
                                                        'creado_por' => auth()->id()
                                                    ]);

            $qr = $this->generadorQr($certificacion->uuid);

        }

        $this->crearImagenConMarcaDeAgua($object, $qr, $certificacion);

        $pdf = Pdf::loadView('certificaciones.notificacion_valor_catastral', [
            'datos_control' => $object->datos_control,
            'avaluos' => $object->avaluos,
            'qr' => $qr,
            'certificacion' => $certificacion
        ]);

        $pdf->render();

        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(480, 745, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

        $canvas->page_text(35, 745, $certificacion->tipo->label() . '-' . $certificacion->año .'-' . $certificacion->folio, null, 9, array(1, 1, 1));

        return $pdf;

    }

    public function reimprimirNotifiacionValorCatastral(Certificacion $certificacion){

        $object = json_decode($certificacion->cadena_original);

        $qr = $this->generadorQr($certificacion->uuid);

        $pdf = Pdf::loadView('certificaciones.notificacion_valor_catastral', [
            'datos_control' => $object->datos_control,
            'avaluos' => $object->avaluos,
            'qr' => $qr,
            'certificacion' => $certificacion
        ]);

        $pdf->render();

        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(480, 745, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

        $canvas->page_text(35, 745, $certificacion->tipo->label() . '-' . $certificacion->año .'-' . $certificacion->folio, null, 9, array(1, 1, 1));

        return $pdf;

    }

}
