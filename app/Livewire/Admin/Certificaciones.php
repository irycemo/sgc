<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Oficina;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\Certificacion;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Constantes\Constantes;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Support\Facades\Log;
use Endroid\QrCode\Writer\PngWriter;
use App\Http\Traits\ComponentesTrait;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class Certificaciones extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $años;
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
        'oficina' => '',
        't_predio' => '',
        'registro' => '',
    ];

    public Certificacion $modelo_editar;

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

    public function imprimir(Certificacion $certificacion){

        $this->modelo_editar = $certificacion;

        if($this->modelo_editar->documento == 'CERTIFICADO DE HISTORIA CATASTRAL'){

            $pdf = $this->certificadoHistoria($this->certificadoHistoriaPartes($this->modelo_editar->cadena_originial));

        }elseif($this->modelo_editar->documento == 'NOTIFICACIÓN DE VALOR CATASTRAL'){

            $pdf = $this->notificacionValorCatastral($this->notificacionValorCatastralPartes($this->modelo_editar->cadena_originial));

        }elseif(in_array($this->modelo_editar->documento, ['CERTIFICADO DE REGISTRO ELECTRÓNICO', 'CERTIFICADO DE REGISTRO CON COLINDANCIAS', 'CERTIFICADO DE REGISTRO'])){

            $pdf = $this->certificadoRegistro($this->certificadoRegistroPartes($this->modelo_editar->cadena_originial));

        }elseif($this->modelo_editar->documento == 'CEDULA DE ACTUALIZACIÓN CATASTRAL'){

            $pdf = $this->cedulaActualizacion($this->cedulaActualizacionPartes($this->modelo_editar->cadena_originial));

        }elseif($this->modelo_editar->documento == 'CERTIFICADO NEGATIVO DE REGISTRO'){

            $pdf = $this->certificadoNegativo($this->certificadoNegativoPartes($this->modelo_editar->cadena_originial));

        }

        $pdf->render();

        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(480, 794, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

        $pdf =  $dom_pdf->output();

        return response()->streamDownload(
            fn () => print($pdf),
            'certificacion.pdf'
        );

    }

    public function certificadoHistoria($partes){

        return Pdf::loadview('certificados.historia-reimpresion', [
            'objeto' => $partes,
            'qr' => $this->generadorQr($this->modelo_editar),
            'certificacion' => $this->modelo_editar,
            'imagen' => $this->imagen
        ]);

    }

    public function notificacionValorCatastral($partes){

        return Pdf::loadview('avaluos.notificacion-reimpresion', [
            'objeto' => $partes,
            'qr' => $this->generadorQr($this->modelo_editar),
            'certificacion' => $this->modelo_editar,
            'imagen' => $this->imagen
        ]);

    }

    public function certificadoRegistro($partes){

        return Pdf::loadview('certificados.registro-reimpresion', [
            'objeto' => $partes,
            'qr' => $this->generadorQr($this->modelo_editar),
            'certificacion' => $this->modelo_editar,
            'imagen' => $this->imagen
        ]);

    }

    public function cedulaActualizacion($partes){

        return Pdf::loadview('certificados.cedula-reimpresion', [
            'objeto' => $partes,
            'qr' => $this->generadorQr($this->modelo_editar),
            'certificacion' => $this->modelo_editar,
            'imagen' => $this->imagen
        ]);

    }

    public function certificadoNegativo($partes){

        return Pdf::loadview('certificados.negativo-reimpresion', [
            'objeto' => $partes,
            'qr' => $this->generadorQr($this->modelo_editar),
            'certificacion' => $this->modelo_editar,
            'imagen' => $this->imagen
        ]);

    }

    public function generadorQr($certificacion)
    {

        $ruta = route('verificacion', $certificacion);

        $result = Builder::create()
                            ->writer(new PngWriter())
                            ->writerOptions([])
                            ->data($ruta)
                            ->encoding(new Encoding('UTF-8'))
                            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                            ->size(100)
                            ->margin(0)
                            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
                            ->labelText('Escanea para verificar')
                            ->labelFont(new NotoSans(7))
                            ->labelAlignment(new LabelAlignmentCenter())
                            ->validateResult(false)
                            ->build();

        return $result->getDataUri();
    }

    public function certificadoHistoriaPartes($cadena){

        $object = (object)[];

        $array = explode('|', $cadena);

        foreach ($array as $item) {

            $aux =  explode(': ', $item);

            $historia = null;

            if($aux[0] === 'historia'){

                foreach($aux as $item){

                    if($item === 'historia') continue;

                    $historia = $historia . ' ' . $item;

                }

                $object->{$aux[0]} = $historia;

                continue;

            }

            $object->{$aux[0]} = $aux[1];

        }

        return $object;

    }

    public function notificacionValorCatastralPartes($cadena){

        $object = (object)[
            'avaluos' => collect(),
        ];

        $array = explode('|', $cadena);

        foreach ($array as $item) {

            $aux =  explode(': ', $item);

            $aux2 = explode('%', $item);

            if(count($aux2) === 5){

                $avaluo = (object)[];

                $avaluo->folio = str_replace('folio_avaluo=' , '', $aux2[0]);

                $avaluo->cuenta_predial = str_replace('Cuenta predial=' , '', $aux2[1]);

                $avaluo->clave_catastral = str_replace('Clave catastral=' , '', $aux2[2]);

                $avaluo->propietario = str_replace('Propietario=' , '', $aux2[3]);

                $avaluo->valor_catastral = str_replace('Valor catastral=' , '', $aux2[4]);

                $object->avaluos->push($avaluo);

                continue;

            }

            $object->{$aux[0]} = $aux[1];

        }

        return $object;

    }

    public function certificadoRegistroPartes($cadena){

        $object = (object)[
            'propietarios' => collect(),
            'colindancias' => collect(),
        ];

        $array = explode('|', $cadena);

        foreach ($array as $item) {

            $aux =  explode(': ', $item);

            $aux2 = explode('%', $item);

            if(count($aux2) === 5){

                $propietario = (object)[];

                $propietario->nombre = str_replace('Nombre=' , '', $aux2[0]);

                $propietario->tipo = str_replace('Tipo=' , '', $aux2[1]);

                $propietario->porcentaje = str_replace('Porcentaje propiedad=' , '', $aux2[2]);

                $propietario->porcentaje_nuda = str_replace('Porcentaje nuda=' , '', $aux2[3]);

                $propietario->porcentaje_usufructo = str_replace('Porcentaje usufructo=' , '', $aux2[4]);

                $object->propietarios->push($propietario);

                continue;

            }

            if(count($aux2) === 3){

                $colindancia = (object)[];

                $colindancia->viento = str_replace('Viento=' , '', $aux2[0]);

                $colindancia->longitud = str_replace('Longitud=' , '', $aux2[1]);

                $colindancia->descripcion = str_replace('Descripcion=' , '', $aux2[2]);

                $object->colindancias->push($colindancia);

                continue;

            }

            $object->{$aux[0]} = $aux[1];

        }

        return $object;

    }

    public function cedulaActualizacionPartes($cadena){

        $object = (object)[];

        $array = explode('|', $cadena);

        foreach ($array as $item) {

            $aux =  explode(': ', $item);

            $object->{$aux[0]} = $aux[1];

        }

        return $object;

    }

    public function certificadoNegativoPartes($cadena){

        $object = (object)[];

        $array = explode('|', $cadena);

        foreach ($array as $item) {

            $aux =  explode(': ', $item);

            $object->{$aux[0]} = $aux[1];

        }

        return $object;

    }

    public function mount(): void
    {

        $this->crearModeloVacio();

        $this->años = Constantes::AÑOS;

        $this->documentos = Constantes::CERTIFICACIONES;

        $this->oficinas = Oficina::orderBy('nombre')->get();

        $director = User::with('efirma')->where('status', 'activo')
                ->whereHas('roles', function($q){
                    $q->where('name', 'Director');
                })
                ->first();

        if(!$director->efirma?->imagen) abort(500, message:"Es necesario actualizar la imagen de la firma electrónica del director");

    }

    public function render()
    {

        $certificaciones = Certificacion::with('creadoPor', 'actualizadoPor', 'tramite', 'oficina')
                                            ->with('predio:id,localidad,oficina,tipo_predio,numero_registro')
                                            ->when($this->filters['año'], fn($q, $año) => $q->where('año', $año))
                                            ->when($this->filters['folio'], fn($q, $folio) => $q->where('folio', $folio))
                                            ->when($this->filters['estado'], fn($q, $estado) => $q->where('estado', $estado))
                                            ->when($this->filters['documento'], fn($q, $documento) => $q->where('documento', $documento))
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
                                            ->when($this->filters['oficina'], function($q, $oficina){
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

        return view('livewire.Admin.certificaciones', compact('certificaciones'))->extends('layouts.admin');
    }
}
