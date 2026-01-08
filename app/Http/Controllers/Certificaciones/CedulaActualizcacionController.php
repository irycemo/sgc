<?php

namespace App\Http\Controllers\Certificaciones;

use App\Models\User;
use App\Models\Certificacion;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpCfdi\Credentials\Credential;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Traits\Certificaciones\PredioTrait;
use App\Traits\Certificaciones\CrearImagenTrait;
use App\Traits\Certificaciones\GeneradorQRTrait;
use App\Enums\Certificaciones\CertificacionesEnum;

class CedulaActualizcacionController extends Controller
{

    use GeneradorQRTrait;
    use CrearImagenTrait;
    use PredioTrait;

    public $formatter;
    public $director;
    public $jefe_departamento_valuacion;
    public $jefe_departamento_gestion;

    public function __construct()
    {

        $this->director = User::where('estado', 'activo')
                            ->whereHas('roles', function($q){
                                $q->where('name', 'Director');
                            })
                            ->first();

    }

    public function cedula($tramite, $predio){

        $datos_control = (object)[];

        $datos_control->tramite = $tramite->año . '-' . $tramite->folio . '-' . $tramite->usuario;
        $datos_control->solicitante = $tramite->nombre_solicitante;
        $datos_control->director = $this->director->name;
        $datos_control->titular_cargo = 'Director general';
        $datos_control->impreso_por = auth()->user()->name;
        $datos_control->impreso_en = now()->format('d/m/Y H:i:s');

        $object = (object)[];

        $object->predio = $this->predio($predio);

        $ultimo_movimiento = (object)[];

        $ultimo_movimiento->nombre = $predio->movimientos->first()->nombre;
        $ultimo_movimiento->fecha = $predio->movimientos->first()->fecha;
        $ultimo_movimiento->descripcion = $predio->movimientos->first()->descripcion;

        $object->ultimo_movimiento = $ultimo_movimiento;

        /* if(auth()->user()->oficina->oficina == 101){ */

            $fielDirector = Credential::openFiles(
                                                    Storage::disk('efirmas')->path($this->director->efirma->cer),
                                                    Storage::disk('efirmas')->path($this->director->efirma->key),
                                                    $this->director->efirma->contraseña
                                                );

            $firmaDirector = $fielDirector->sign(json_encode($object));

            $datos_control->firma_director = base64_encode($firmaDirector);

            $datos_control->imagen_director = $this->director->efirma->imagen;

            $datos_control->oficina = auth()->user()->oficina->nombre;

            $object->datos_control = $datos_control;

            $certificacion = Certificacion::create([
                                                        'año' => now()->format('Y'),
                                                        'tipo' => CertificacionesEnum::CEDULA_CATASTRAL,
                                                        'folio' => (Certificacion::where('año', now()->format('Y'))->where('tipo', CertificacionesEnum::CEDULA_CATASTRAL)->max('folio') ?? 0) + 1,
                                                        'cadena_original' => json_encode($object),
                                                        'cadena_encriptada' => base64_encode($firmaDirector),
                                                        'estado' => 'activo',
                                                        'oficina_id' => auth()->user()->oficina_id,
                                                        'tramite_id' => $tramite->id,
                                                        'predio_id' => $predio->id,
                                                        'creado_por' => auth()->id()
                                                    ]);

            $qr = $this->generadorQr($certificacion->uuid);

        /* }else{

            $datos_control->titular = auth()->user()->oficina->titular;

            $datos_control->titular_cargo = auth()->user()->oficina->tipo == 'ADMINISTRACIÓN' ? 'ADMINISTRADOR' : 'RECEPTOR(A) DE RENTAS';

            $object->datos_control = $datos_control;

            $datos_control->oficina = auth()->user()->oficina->nombre;

            $certificacion = Certificacion::create([
                                                        'año' => now()->format('Y'),
                                                        'tipo' => CertificacionesEnum::CERTIFICADO_REGISTRO,
                                                        'folio' => (Certificacion::where('año', now()->format('Y'))->where('tipo', CertificacionesEnum::CERTIFICADO_REGISTRO)->max('folio') ?? 0) + 1,
                                                        'cadena_original' => json_encode($object),
                                                        'estado' => 'activo',
                                                        'predio_id' => $predio->id,
                                                        'oficina_id' => auth()->user()->oficina_id,
                                                        'tramite_id' => $tramite->id,
                                                        'creado_por' => auth()->id()
                                                    ]);

            $qr = $this->generadorQr($certificacion->uuid);

        } */

        $this->crearImagenConMarcaDeAgua($object, $qr, $certificacion);

        $pdf = Pdf::loadView('certificaciones.cedula_actualizacion', [
            'datos_control' => $object->datos_control,
            'qr' => $qr,
            'predio' => $object->predio,
            'ultimo_movimiento' => $object->ultimo_movimiento,
            'certificacion' => $certificacion
        ]);

        $pdf->render();

        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(480, 745, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

        $canvas->page_text(35, 745, $certificacion->tipo->label() . '-' . $certificacion->año .'-' . $certificacion->folio, null, 9, array(1, 1, 1));

        return $pdf;

    }

    public function reimprimirCedula(Certificacion $certificacion){

        $object = json_decode($certificacion->cadena_original);

        $qr = $this->generadorQr($certificacion->uuid);

        $pdf = Pdf::loadView('certificaciones.cedula_actualizacion', [
            'datos_control' => $object->datos_control,
            'qr' => $qr,
            'predio' => $object->predio,
            'ultimo_movimiento' => $object->ultimo_movimiento,
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
