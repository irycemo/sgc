<?php

namespace App\Livewire\Certificaciones;

use App\Models\User;
use App\Models\Oficina;
use App\Models\Persona;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Propietario;
use App\Models\Certificacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use App\Http\Constantes\Constantes;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Support\Facades\Log;
use PhpCfdi\Credentials\Credential;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Font\NotoSans;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class CertificadoNegativo extends Component
{

    public $años;
    public $director;

    public $año;
    public $folio;
    public $usuario;

    public $oficina;

    public $tramite;
    public $predio;

    public $cadena;

    public $impresionDirector = false;

    public $nombre;
    public $ap_paterno;
    public $ap_materno;
    public $razon_social;

    public $predioFlag = false;
    public $tramiteFlag = false;

    public function buscarTramite(){

        $this->validate([
            'año' => 'required',
            'folio' => 'required',
            'usuario' => 'required',
        ]);

        try {

            $this->reset('predio');

            $this->tramite = Tramite::with('predios')
                                        ->where('año', $this->año)
                                        ->where('folio', $this->folio)
                                        ->where('usuario', $this->usuario)
                                        ->firstOrFail();

            if($this->tramite->servicio->id !== 5){

                $this->dispatch('mostrarMensaje', ['error', "El trámite no corresponde a un certificado negativo de registro."]);

                $this->reset('tramite');

                return;

            }

            if($this->tramite->estado === 'concluido'){

                $this->dispatch('mostrarMensaje', ['error', "El trámite esta concluido."]);

                $this->reset('tramite');

                return;

            }

            if($this->tramite->estado != 'pagado' && $this->tramite->estado != 'autorizado'){

                $this->dispatch('mostrarMensaje', ['error', "El trámite no esta pagado."]);

                $this->reset('tramite');

                return;

            }

            /* if($this->tramite->fecha_entrega >= now()){

                $this->dispatch('mostrarMensaje', ['error', "La fecha de entrega del trámite es: " . $this->tramite->fecha_entrega->format('d-m-Y')]);

                $this->reset('tramite');

                return;

            } */


        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['error', "El trámite no existe."]);

        } catch (\Throwable $th) {
            Log::error("Error al buscar cedula por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }


    }

    public function buscarPropietario(){

        $this->validate([
            'nombre' => Rule::requiredIf($this->razon_social === null || $this->razon_social === ''),
            'ap_paterno' => Rule::requiredIf($this->razon_social === null || $this->razon_social === ''),
            'ap_materno' => Rule::requiredIf($this->razon_social === null || $this->razon_social === ''),
            'razon_social' => 'nullable'
        ]);

        $propietario = Persona::when($this->nombre, fn($q) => $q->where('nombre', $this->nombre))
                                ->when($this->ap_paterno, fn($q) => $q->where('ap_paterno', $this->ap_paterno))
                                ->when($this->ap_materno, fn($q) => $q->where('ap_materno', $this->ap_materno))
                                ->when($this->razon_social, fn($q) => $q->where('razon_social', $this->razon_social))
                                ->first();

        if($propietario){

            $propietario = Propietario::where('persona_id', $propietario->id)->first();

            $this->predio = $propietario->predio;

            $this->predioFlag = true;

        }else{

            $this->tramiteFlag = true;

            $this->reset('predio');

        }

    }

    public function construirCadena(){

        if($this->nombre){

            $this->cadena = 'nombre: ' . $this->nombre;

            $this->cadena =  $this->cadena . '|' . 'ap_paterno: ' . $this->ap_paterno;

            $this->cadena =  $this->cadena . '|' . 'ap_materno: ' . $this->ap_materno;

        }elseif($this->razon_social){

            $this->cadena =  $this->cadena . '|' . 'razon_social: ' . $this->razon_social;

        }

        $this->cadena = $this->cadena . '|' . 'solicitante: ' . $this->tramite->nombre_solicitante;

        $this->cadena = $this->cadena . '|' . 'tramite: ' . $this->tramite->año . '-' . $this->tramite->folio . '-'. $this->tramite->usuario . '|' . 'recibo: ' . $this->tramite->folio_pago;

    }

    public function revisarOficina(){

        $fechaImpresion = now()->format('d-m-Y H:i:s');

        $this->cadena = $this->cadena . '|' . 'impreso_en: ' . $fechaImpresion;

        $this->cadena = $this->cadena . '|' . 'impreso_por: ' . auth()->user()->nombreCompleto();

        if(auth()->user()->oficina->oficina === 101 || $this->impresionDirector){

            $fielDirector = Credential::openFiles(Storage::disk('efirma')->path($this->director->efirma->cer), Storage::disk('efirma')->path($this->director->efirma->key), $this->director->efirma->contraseña);

            $oficina = Oficina::where('oficina', 101)->first();

            $this->cadena = $this->cadena . '|' . 'oficina: ' . $oficina->nombre;

            $this->cadena = $this->cadena . '|' . 'suscrito: ' . $this->director->nombreCompleto();

            $this->cadena = $this->cadena . '|' . 'cargo: Director de catastro';

            $firmaDirector = $fielDirector->sign($this->cadena);

            $certificacion = Certificacion::create([
                'año' => now()->format('Y'),
                'folio' => (Certificacion::where('año', now()->format('Y'))->where('documento', 'CERTIFICADO NEGATIVO DE REGISTRO')->max('folio') ?? 0) + 1,
                'documento' => 'CERTIFICADO NEGATIVO DE REGISTRO',
                'cadena_originial' => $this->cadena,
                'cadena_encriptada' => base64_encode($firmaDirector),
                'estado' => 'activo',
                'oficina_id' => $oficina->id,
                'tramite_id' => $this->tramite->id,
                'creado_por' => auth()->id(),
                'actualizado_por' => auth()->id(),
            ]);

            $pdf = Pdf::loadview('certificados.negativo', [
                'tramite' => $this->tramite,
                'director' => $this->director->nombreCompleto(),
                'firmaDirector' => base64_encode($firmaDirector),
                'qr' => $this->generadorQr($certificacion->uuid),
                'oficina' => $oficina->nombre,
                'certificacion' => $certificacion,
                'fecha_impresion' => $fechaImpresion,
                'impreso_por' => auth()->user()->nombreCompleto(),
                'tipo_certificado' => 'CERTIFICADO NEGATIVO DE REGISTRO',
                'imagen' => $this->director->efirma->imagen,
                'nombre' => $this->nombre,
                'ap_paterno' => $this->ap_paterno,
                'ap_materno' => $this->ap_materno,
                'razon_social' => $this->razon_social,
            ]);

        }else{

            $oficina = Oficina::find(auth()->user()->oficina_id);

            $this->cadena = $this->cadena . '|' . 'oficina: ' . $oficina->nombre;

            $this->cadena = $this->cadena . '|' . 'suscrito: ' . $oficina->titular;

            $cargo = $oficina->tipo == 'ADMINISTRACIÓN' ? 'ADMINISTRADOR' : 'RECEPTOR(A) DE RENTAS';

            $this->cadena = $this->cadena . '|' . 'cargo: ' . $cargo;

            $certificacion = Certificacion::create([
                'año' => now()->format('Y'),
                'folio' => (Certificacion::where('año', now()->format('Y'))->where('documento', 'CERTIFICADO NEGATIVO DE REGISTRO')->max('folio') ?? 0) + 1,
                'documento' => 'CERTIFICADO NEGATIVO DE REGISTRO',
                'cadena_originial' => $this->cadena,
                'estado' => 'activo',
                'oficina_id' => $oficina->id,
                'tramite_id' => $this->tramite->id,
                'creado_por' => auth()->id(),
                'actualizado_por' => auth()->id(),
            ]);

            $pdf = Pdf::loadview('certificados.negativo', [
                'tramite' => $this->tramite,
                'oficina' => $oficina->nombre,
                'cargo' => $cargo,
                'titular' => $oficina->titular,
                'qr' => $this->generadorQr($certificacion->uuid),
                'fecha_impresion' => $fechaImpresion,
                'certificacion' => $certificacion,
                'impreso_por' => auth()->user()->nombreCompleto(),
                'tipo_certificado' => 'CERTIFICADO NEGATIVO DE REGISTRO',
                'nombre' => $this->nombre,
                'ap_paterno' => $this->ap_paterno,
                'ap_materno' => $this->ap_materno,
                'razon_social' => $this->razon_social,
            ]);

        }

        $pdf->render();

        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(480, 794, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

        return $dom_pdf->output();

    }

    public function generadorQr($certificacion)
    {

        $rute = route('verificacion', $certificacion);

        $result = Builder::create()
                            ->writer(new PngWriter())
                            ->writerOptions([])
                            ->data($rute)
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


    public function generarCertificado(){

        $this->construirCadena();

        $pdf = $this->revisarOficina();

        $this->tramite->update(['estado' => 'concluido']);

        $this->tramite->audits()->latest()->first()->update(['tags' => 'Finalizó trámite']);

        return response()->streamDownload(
            fn () => print($pdf),
            'certificado_negativo.pdf'
        );

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

        $this->director = User::with('efirma')->where('status', 'activo')
                ->whereHas('roles', function($q){
                    $q->where('name', 'Director');
                })
                ->first();

        if(!$this->director->efirma || !$this->director->efirma->cer || !$this->director->efirma->key || !$this->director->efirma->imagen) abort(500, message:"Es necesario actualizar la firma electrónica del director");

    }

    public function render()
    {
        return view('livewire.certificaciones.certificado-negativo')->extends('layouts.admin');
    }
}
