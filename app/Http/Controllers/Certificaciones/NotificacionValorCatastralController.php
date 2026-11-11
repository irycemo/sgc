<?php

namespace App\Http\Controllers\Certificaciones;

use App\Models\User;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\Certificacion;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpCfdi\Credentials\Credential;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras;
use App\Traits\Certificaciones\CrearImagenTrait;
use App\Traits\Certificaciones\GeneradorQRTrait;
use App\Enums\Certificaciones\CertificacionesEnum;
use App\Enums\Tramites\AvaluoPara;
use App\Exceptions\GeneralException;
use App\Traits\Certificaciones\NotificacionValorCatastral;

class NotificacionValorCatastralController extends Controller
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

    public function general($avaluos, $tramite_inspeccion, $user){

        $datos_control = (object)[];

        $datos_control->tramite_inspeccion = $tramite_inspeccion?->año . '-' . $tramite_inspeccion?->folio . '-' . $tramite_inspeccion?->usuario;
        $datos_control->impreso_por = $user->name;
        $datos_control->impreso_en = now()->format('d/m/Y H:i:s');
        $datos_control->numero_avaluos = count($avaluos);
        $datos_control->numero_avaluos_letra = $this->formatter->toWords($datos_control->numero_avaluos);
        $datos_control->valuador = $user->name;
        $datos_control->titular = $user->oficina->titular;

        $object = (object)[];

        $avaluos = Avaluo::with('predioAvaluo', 'predioPadron')->whereKey($avaluos)->get();

        $object->avaluos = $this->avaluos($avaluos);

        if($user->hasRole(['Convenio municipal'])){

            $datos_control->autoridad_municipal = $user->oficina->autoridad_municipal;

            $object->datos_control = $datos_control;

            $certificacion = $this->certificacionConvenioMunicipal($datos_control, $object, $user);

        }elseif($user->oficina->oficina == 101 || $tramite_inspeccion->oficina->oficina === 101){

            $datos_control->jefe_departamento = $this->jefe_departamento_valuacion->name;

            $datos_control->titular = $tramite_inspeccion->oficina->titular;

            $datos_control->titular_cargo = 'Director de catastro';

            $object->datos_control = $datos_control;

            $certificacion = $this->certificacionOficinaCentral($datos_control, $object, $tramite_inspeccion, $user);

        }else{

            $datos_control->titular_cargo = $user->oficina->tipo == 'ADMINISTRACIÓN' ? 'ADMINISTRADOR' : 'RECEPTOR(A) DE RENTAS';

            $object->datos_control = $datos_control;

            $certificacion = $this->certificacionInteriorEstado($datos_control, $object, $tramite_inspeccion, $user);

        }

        $qr = $this->generadorQr('verificacion_certificacion', $certificacion->uuid);

        /* $this->crearImagenConMarcaDeAgua($object, $qr, $certificacion); */

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

    public function certificacionConvenioMunicipal($datos_control, $object, $user){

        $datos_control->autoridad_municipal = $user->oficina->autoridad_municipal;

        $object->datos_control = $datos_control;

        return Certificacion::create([
                                    'año' => now()->format('Y'),
                                    'tipo' => CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL,
                                    'folio' => (Certificacion::where('año', now()->format('Y'))->where('tipo', CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL)->max('folio') ?? 0) + 1,
                                    'cadena_original' => json_encode($object),
                                    'estado' => 'activo',
                                    'oficina_id' => $user->oficina_id,
                                    'creado_por' => $user->id
                                ]);

    }

    public function certificacionOficinaCentral($datos_control, $object, $tramite_inspeccion, $user){

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

        return Certificacion::create([
                                    'año' => now()->format('Y'),
                                    'tipo' => CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL,
                                    'folio' => (Certificacion::where('año', now()->format('Y'))->where('tipo', CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL)->max('folio') ?? 0) + 1,
                                    'cadena_original' => json_encode($object),
                                    'cadena_encriptada' => base64_encode($firmaDirector),
                                    'estado' => 'activo',
                                    'oficina_id' => $user->oficina_id,
                                    'tramite_id' => $tramite_inspeccion?->id,
                                    'creado_por' => $user->id
                                    ]);

    }

    public function certificacionInteriorEstado($datos_control, $object, $tramite_inspeccion, $user){

        return Certificacion::create([
                                    'año' => now()->format('Y'),
                                    'tipo' => CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL,
                                    'folio' => (Certificacion::where('año', now()->format('Y'))->where('tipo', CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL)->max('folio') ?? 0) + 1,
                                    'cadena_original' => json_encode($object),
                                    'estado' => 'activo',
                                    'oficina_id' => $user->oficina_id,
                                    'tramite_id' => $tramite_inspeccion?->id,
                                    'creado_por' => $user->id
                                ]);

    }

    public function desglose($avaluos, $tramite_inspeccion, $tramite_desglose, $predio_padre_id, $user){

        $datos_control = (object)[];

        $datos_control->tramite_inspeccion = $tramite_inspeccion?->año . '-' . $tramite_inspeccion?->folio . '-' . $tramite_inspeccion?->usuario;
        $datos_control->tramite_desglose = $tramite_desglose?->año . '-' . $tramite_desglose?->folio . '-' . $tramite_desglose?->usuario;
        $datos_control->titular_cargo = 'Director de catastro';
        $datos_control->impreso_por = $user->name;
        $datos_control->impreso_en = now()->format('d/m/Y H:i:s');
        $datos_control->numero_avaluos = count($avaluos);
        $datos_control->numero_avaluos_letra = $this->formatter->toWords($datos_control->numero_avaluos);
        $datos_control->valuador = $user->name;
        $datos_control->titular = $user->oficina->titular;

        $avaluos = Avaluo::with('predioAvaluo', 'predioPadron')->whereKey($avaluos)->get();

        if(! in_array($tramite_inspeccion->avaluo_para, [AvaluoPara::CAMBIO_REGIMEN, AvaluoPara::CAMBIO_DE_REGIMEN_Y_DESGLOSE])){

            $avaluo_predio_padre = $avaluos->where('predio', $predio_padre_id)->first();

            if(!$avaluo_predio_padre){

                throw new GeneralException('El predio origen no tiene un avalúo valido.');

            }

            $datos_control->predio_padre = $avaluo_predio_padre->predioAvaluo->cuentaPredial();
            $datos_control->predio_padre_superficie = $avaluo_predio_padre->predioAvaluo->superficie_total_terreno_formateada;
            $datos_control->predio_padre_unidad = $avaluo_predio_padre->predioAvaluo->tipo_predio == 1 ? 'metros cuadrados' : 'hectáreas';

        }

        $object = (object)[];

        $object->avaluos = $this->avaluos($avaluos);

        if($user->hasRole(['Convenio municipal'])){

            $datos_control->autoridad_municipal = $user->oficina->autoridad_municipal;

            $object->datos_control = $datos_control;

            $certificacion = $this->certificacionConvenioMunicipal($datos_control, $object, $user);

        }elseif($user->oficina->oficina == 101 || $tramite_inspeccion->oficina->oficina === 101){

            $datos_control->jefe_departamento = $this->jefe_departamento_valuacion->name;

            $datos_control->titular = $tramite_inspeccion->oficina->titular;

            $datos_control->titular_cargo = 'Director de catastro';

            $object->datos_control = $datos_control;

            $certificacion = $this->certificacionOficinaCentral($datos_control, $object, $tramite_inspeccion, $user);

        }else{

            $datos_control->titular_cargo = $user->oficina->tipo == 'ADMINISTRACIÓN' ? 'ADMINISTRADOR' : 'RECEPTOR(A) DE RENTAS';

            $object->datos_control = $datos_control;

            $certificacion = $this->certificacionInteriorEstado($datos_control, $object, $tramite_inspeccion, $user);

        }

        if($avaluos->first()->predioAvaluo->oficina === 101){

            $datos_control->jefe_departamento = $this->jefe_departamento_valuacion->name;

        }

        $qr = $this->generadorQr('verificacion_certificacion', $certificacion->uuid);

        /* $this->crearImagenConMarcaDeAgua($object, $qr, $certificacion); */

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

    public function fusion($avaluos, $tramite_inspeccion, $predios_fusionantes, $user){

        $datos_control = (object)[];

        $datos_control->tramite_inspeccion = $tramite_inspeccion?->año . '-' . $tramite_inspeccion?->folio . '-' . $tramite_inspeccion?->usuario;
        $datos_control->impreso_por = $user->name;
        $datos_control->impreso_en = now()->format('d/m/Y H:i:s');
        $datos_control->numero_avaluos = count($avaluos);
        $datos_control->numero_avaluos_letra = $this->formatter->toWords($datos_control->numero_avaluos);
        $datos_control->valuador = $user->name;
        $datos_control->titular = $user->oficina->titular;

        $avaluos = Avaluo::with('predioAvaluo', 'predioPadron')->whereKey($avaluos)->get();

        $predios_fusionantes = Predio::whereKey($predios_fusionantes)->get();

        $datos_control->predios_fusionantes = [];

        foreach ($predios_fusionantes as $predio) {

            array_push($datos_control->predios_fusionantes, $predio->cuentaPredial());

        }

        $object = (object)[];

        $object->avaluos = $this->avaluos($avaluos);

        $object->avaluos = $this->avaluos($avaluos);

        if($user->hasRole(['Convenio municipal'])){

            $datos_control->autoridad_municipal = $user->oficina->autoridad_municipal;

            $object->datos_control = $datos_control;

            $certificacion = $this->certificacionConvenioMunicipal($datos_control, $object, $user);

        }elseif($user->oficina->oficina == 101 || $tramite_inspeccion->oficina->oficina === 101){

            $datos_control->jefe_departamento = $this->jefe_departamento_valuacion->name;

            $datos_control->titular = $tramite_inspeccion->oficina->titular;

            $datos_control->titular_cargo = 'Director de catastro';

            $object->datos_control = $datos_control;

            $certificacion = $this->certificacionOficinaCentral($datos_control, $object, $tramite_inspeccion, $user);

        }else{

            $datos_control->titular_cargo = $user->oficina->tipo == 'ADMINISTRACIÓN' ? 'ADMINISTRADOR' : 'RECEPTOR(A) DE RENTAS';

            $object->datos_control = $datos_control;

            $certificacion = $this->certificacionInteriorEstado($datos_control, $object, $tramite_inspeccion, $user);

        }

        $qr = $this->generadorQr('verificacion_certificacion', $certificacion->uuid);

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

        if($certificacion->pdf){

            File::where('fileable_type', Certificacion::class)
                        ->where('fileable_id', $certificacion->id)
                        ->where('descripcion', 'pdf')
                        ->get()
                        ->each(function(File $anterior){

                            if(app()->isProduction()){

                                Storage::disk('s3')->delete(config('services.ses.ruta_pdfs_certificaciones'). $anterior->url);

                            }else{

                                Storage::disk('s3')->delete('certificaciones/'. $anterior->url);

                            }

                            $anterior->delete();

                        });

        }

        $object = json_decode($certificacion->cadena_original);

        $qr = $this->generadorQr('verificacion_certificacion', $certificacion->uuid);

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

        $filename = 'notificacion_valor_catastral-' . $certificacion->folio . '_' . now()->format('Ymd_His') . '.pdf';

        if(app()->isProduction()){

            Storage::disk('s3')->put(
                config('services.ses.ruta_pdfs_certificaciones'),
                $pdf->output(),
                [
                    'ContentType' => 'application/pdf',
                    'ContentDisposition' => 'attachment; filename="' . $filename . '"',
                ]
            );

        }else{

            Storage::put('certificaciones/' . $filename, $pdf->output());

        }

        File::create([
            'fileable_type' => Certificacion::class,
            'fileable_id' => $certificacion->id,
            'url' => $filename,
            'descripcion' => 'pdf',
        ]);

        return $pdf;

    }

}
