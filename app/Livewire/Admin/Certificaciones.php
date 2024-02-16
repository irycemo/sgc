<?php

namespace App\Livewire\Admin;

use App\Models\Oficina;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Certificacion;
use App\Http\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Builder\Builder;
use Barryvdh\DomPDF\Facade\Pdf;

class Certificaciones extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $años;
    public $documentos;
    public $oficinas;

    public $filters = [
        'año' => '',
        'folio' => '',
        'documento' => '',
        'estado' => '',
        'oficina' => '',
        'tAño' => '',
        'tFolio' => '',
        'tUsuario' => ''
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

        $partes = null;

        if($this->modelo_editar->documento == 'CERTIFICADO DE HISTORIA CATASTRAL'){

            $pdf = $this->certificadoHistoria($this->certificadoHistoriaPartes($this->modelo_editar->cadena_originial));

        }elseif($this->modelo_editar->documento == 'NOTIFICACIÓN DE VALOR CATASTRAL'){

            $pdf = $this->notificacionValorCatastral($this->notificacionValorCatastralPartes($this->modelo_editar->cadena_originial));

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
            'array' => $partes,
            'qr' => $this->generadorQr($this->modelo_editar),
            'certificacion' => $this->modelo_editar,
        ]);

    }

    public function notificacionValorCatastral($partes){

        return Pdf::loadview('avaluos.notificacion-reimpresion', [
            'array' => $partes,
            'qr' => $this->generadorQr($this->modelo_editar),
            'certificacion' => $this->modelo_editar,
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

    private function certificadoHistoriaPartes($cadena){

        $array = explode('|', $cadena);

        return array_map(function($array){

            $aux =  explode(': ', $array);

            $historia = null;

            if($aux[0] === 'Historia'){

                foreach($aux as $item){

                    if($item === 'Historia') continue;

                    $historia = $historia . ' ' . $item;

                }

                return[$aux[0] => $historia];

            }

            return[$aux[0] => $aux[1]];

        }, $array);

    }

    public function notificacionValorCatastralPartes($cadena){

        $array = explode('|', $cadena);

        return array_map(function($array){

            $aux =  explode(': ', $array);

            $aux2 = explode('%', $array);

            if(count($aux2) === 5){

                return $aux2;

            }

            return[$aux[0] => $aux[1]];

        }, $array);

    }

    public function mount(): void
    {

        $this->crearModeloVacio();

        $this->años = Constantes::AÑOS;

        $this->documentos = Constantes::CERTIFICACIONES;

        $this->oficinas = Oficina::orderBy('nombre')->get();

    }

    public function render()
    {

        $certificaciones = Certificacion::with('creadoPor', 'actualizadoPor', 'tramite', 'oficina')
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
                                            ->orderBy($this->sort, $this->direction)
                                            ->paginate($this->pagination);

        return view('livewire.admin.certificaciones', compact('certificaciones'))->extends('layouts.admin');
    }
}
