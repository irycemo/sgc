<?php

namespace App\Livewire\Certificaciones;

use App\Models\User;
use App\Models\Oficina;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Certificacion;
use Barryvdh\DomPDF\Facade\Pdf;
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

class CedulaActualizacion extends Component
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

            if(!in_array($this->tramite->servicio->id, [64, 65])){

                $this->dispatch('mostrarMensaje', ['error', "El trámite no corresponde a una cedula de actualización."]);

                $this->reset('tramite');

                return;

            }

            if($this->tramite->estado === 'concluido'){

                $this->dispatch('mostrarMensaje', ['error', "El trámite esta concluido."]);

                $this->reset('tramite');

                return;

            }

            if($this->tramite->estado != 'pagado'){

                $this->dispatch('mostrarMensaje', ['error', "El trámite no esta pagado."]);

                $this->reset('tramite');

                return;

            }

            $this->predio = $this->tramite->predios()->first();

            if($this->predio->bloqueadoActivo()){

                $this->dispatch('mostrarMensaje', ['error', "El predio se encuentra bloqueado."]);
                $this->predio = null;
                return;

            }

            $this->oficina = Oficina::where('oficina', $this->predio->oficina)->first()->oficina;

            $this->reset(['folio', 'usuario']);


        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['error', "El trámite no existe."]);

        } catch (\Throwable $th) {
            Log::error("Error al buscar cedula por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }


    }

    public function construirCadena(){

        $this->cadena = 'cuenta_predial: ' . $this->predio->cuentaPredial();

        $this->cadena = $this->cadena . '|' . 'clave_catastral: ' . $this->predio->claveCatastral();

        $this->cadena = $this->cadena . '|' . 'tramite: ' . $this->tramite->año . '-' . $this->tramite->folio . '-'. $this->tramite->usuario . '|' . 'recibo: ' . $this->tramite->folio_pago;

        $this->cadena = $this->cadena . '|' . 'solicitante: ' . $this->tramite->nombre_solicitante;

        if($this->predio->tipo_asentamiento) $this->cadena = $this->cadena . '|' . 'tipo_asentamiento: ' . $this->predio->tipo_asentamiento;
        if($this->predio->nombre_asentamiento) $this->cadena = $this->cadena . '|' . 'nombre_asentamiento: ' . $this->predio->nombre_asentamiento;
        if($this->predio->tipo_vialidad) $this->cadena = $this->cadena . '|' . 'tipo_vialidad: ' . $this->predio->tipo_vialidad;
        if($this->predio->nombre_vialidad) $this->cadena = $this->cadena . '|' . 'nombre_vialidad: ' . $this->predio->nombre_vialidad;
        if($this->predio->numero_interior) $this->cadena = $this->cadena . '|' . 'numero_interior: ' . $this->predio->numero_interior;
        if($this->predio->numero_exterior) $this->cadena = $this->cadena . '|' . 'numero_exterior: ' . $this->predio->numero_exterior;
        if($this->predio->numero_exterior_2) $this->cadena = $this->cadena . '|' . 'numero_exterior_2: ' . $this->predio->numero_exterior_2;
        if($this->predio->numero_adicional) $this->cadena = $this->cadena . '|' . 'numero_adicional: ' . $this->predio->numero_adicional;
        if($this->predio->numero_adicional_2) $this->cadena = $this->cadena . '|' . 'numero_adicional_2: ' . $this->predio->numero_adicional_2;
        if($this->predio->codigo_postal) $this->cadena = $this->cadena . '|' . 'codigo_postal: ' . $this->predio->codigo_postal;
        if($this->predio->nombre_edificio) $this->cadena = $this->cadena . '|' . 'nombre_edificio: ' . $this->predio->nombre_edificio;
        if($this->predio->clave_edificio) $this->cadena = $this->cadena . '|' . 'clave_edificio: ' . $this->predio->clave_edificio;
        if($this->predio->departamento_edificio) $this->cadena = $this->cadena . '|' . 'departamento_edificio: ' . $this->predio->departamento_edificio;
        if($this->predio->lote_fraccionador) $this->cadena = $this->cadena . '|' . 'lote_fraccionador: ' . $this->predio->lote_fraccionador;
        if($this->predio->manzana_fraccionador) $this->cadena = $this->cadena . '|' . 'manzana_fraccionador: ' . $this->predio->manzana_fraccionador;
        if($this->predio->etapa_fraccionador) $this->cadena = $this->cadena . '|' . 'etapa_fraccionador: ' . $this->predio->etapa_fraccionador;
        if($this->predio->ubicacion_en_manzana) $this->cadena = $this->cadena . '|' . 'ubicacion_en_manzana: ' . $this->predio->ubicacion_en_manzana;
        if($this->predio->nombre_predio) $this->cadena = $this->cadena . '|' . 'nombre_predio: ' . $this->predio->nombre_predio;
        if($this->predio->xutm) $this->cadena = $this->cadena . '|' . 'xutm: ' . $this->predio->xutm;
        if($this->predio->yutm) $this->cadena = $this->cadena . '|' . 'yutm: ' . $this->predio->yutm;
        if($this->predio->zutm) $this->cadena = $this->cadena . '|' . 'zutm: ' . $this->predio->zutm;
        if($this->predio->lat) $this->cadena = $this->cadena . '|' . 'lat: ' . $this->predio->lat;
        if($this->predio->lon) $this->cadena = $this->cadena . '|' . 'lon: ' . $this->predio->lon;
        if($this->predio->superficie_terreno > 0) $this->cadena = $this->cadena . '|' . 'superficie_terreno: ' . $this->predio->superficie_terreno;
        if($this->predio->superficie_notarial > 0) $this->cadena = $this->cadena . '|' . 'superficie_notarial: ' . $this->predio->superficie_notarial;
        if($this->predio->superficie_judicial > 0) $this->cadena = $this->cadena . '|' . 'superficie_judicial: ' . $this->predio->superficie_judicial;
        if($this->predio->superficie_construccion > 0) $this->cadena = $this->cadena . '|' . 'superficie_construccion: ' . $this->predio->superficie_construccion;
        if($this->predio->area_comun_terreno > 0) $this->cadena = $this->cadena . '|' . 'area_comun_terreno: ' . $this->predio->area_comun_terreno;
        if($this->predio->area_comun_construccion > 0) $this->cadena = $this->cadena . '|' . 'area_comun_construccion: ' . $this->predio->area_comun_construccion;
        if($this->predio->valor_catastral) $this->cadena = $this->cadena . '|' . 'valor_catastral: ' . $this->predio->valor_catastral;
        if($this->predio->observaciones) $this->cadena = $this->cadena . '|' . 'observaciones: ' . $this->predio->observaciones;

        $sociedad = $this->predio->propietarios()->count() > 1 ? ' y soc.' : '';

        $this->cadena = $this->cadena . '|' . 'propietario: ' . $this->predio->primerPropietario() . $sociedad;

    }

    public function revisarOficina(){

        $fechaImpresion = now()->format('d-m-Y H:i:s');

        $this->cadena = $this->cadena . '|' . 'impreso_en: ' . $fechaImpresion;

        $this->cadena = $this->cadena . '|' . 'impreso_por: ' . auth()->user()->nombreCompleto();

        if($this->oficina === 101 || $this->impresionDirector){

            $fielDirector = Credential::openFiles(Storage::disk('efirma')->path($this->director->efirma->cer), Storage::disk('efirma')->path($this->director->efirma->key), $this->director->efirma->contraseña);

            $oficina = Oficina::where('oficina', 101)->first();

            $this->cadena = $this->cadena . '|' . 'oficina: ' . $oficina->nombre;

            $this->cadena = $this->cadena . '|' . 'suscrito: ' . $this->director->nombreCompleto();

            $this->cadena = $this->cadena . '|' . 'cargo: Director de catastro';

            $firmaDirector = $fielDirector->sign($this->cadena);

            $certificacion = Certificacion::create([
                'año' => now()->format('Y'),
                'folio' => (Certificacion::where('año', now()->format('Y'))->where('documento', 'CEDULA DE ACTUALIZACIÓN CATASTRAL')->max('folio') ?? 0) + 1,
                'documento' => 'CEDULA DE ACTUALIZACIÓN CATASTRAL',
                'cadena_originial' => $this->cadena,
                'cadena_encriptada' => base64_encode($firmaDirector),
                'estado' => 'activo',
                'oficina_id' => $oficina->id,
                'tramite_id' => $this->tramite->id,
                'predio_id' => $this->predio->id,
                'creado_por' => auth()->id(),
                'actualizado_por' => auth()->id(),
            ]);

            $pdf = Pdf::loadview('certificados.cedula', [
                'predio' => $this->predio,
                'tramite' => $this->tramite,
                'director' => $this->director->nombreCompleto(),
                'firmaDirector' => base64_encode($firmaDirector),
                'qr' => $this->generadorQr($certificacion->uuid),
                'oficina' => $oficina->nombre,
                'certificacion' => $certificacion,
                'fecha_impresion' => $fechaImpresion,
                'impreso_por' => auth()->user()->nombreCompleto(),
                'tipo_certificado' => 'CEDULA DE ACTUALIZACIÓN CATASTRAL',
                'imagen' => $this->director->efirma->imagen
            ]);

        }else{

            $oficina = Oficina::where('oficina', $this->predio->oficina)->first();

            $this->cadena = $this->cadena . '|' . 'oficina: ' . $oficina->nombre;

            $this->cadena = $this->cadena . '|' . 'suscrito: ' . $oficina->titular;

            $cargo = $oficina->tipo == 'ADMINISTRACIÓN' ? 'ADMINISTRADOR' : 'RECEPTOR(A) DE RENTAS';

            $this->cadena = $this->cadena . '|' . 'cargo: ' . $cargo;

            $certificacion = Certificacion::create([
                'año' => now()->format('Y'),
                'folio' => (Certificacion::where('año', now()->format('Y'))->where('documento', 'CEDULA DE ACTUALIZACIÓN CATASTRAL')->max('folio') ?? 0) + 1,
                'documento' => 'CEDULA DE ACTUALIZACIÓN CATASTRAL',
                'cadena_originial' => $this->cadena,
                'estado' => 'activo',
                'oficina_id' => $oficina->id,
                'tramite_id' => $this->tramite->id,
                'predio_id' => $this->predio->id,
                'creado_por' => auth()->id(),
                'actualizado_por' => auth()->id(),
            ]);

            $pdf = Pdf::loadview('certificados.cedula', [
                'predio' => $this->predio,
                'tramite' => $this->tramite,
                'oficina' => $oficina->nombre,
                'cargo' => $cargo,
                'titular' => $oficina->titular,
                'qr' => $this->generadorQr($certificacion->uuid),
                'fecha_impresion' => $fechaImpresion,
                'certificacion' => $certificacion,
                'impreso_por' => auth()->user()->nombreCompleto(),
                'tipo_certificado' => 'CEDULA DE ACTUALIZACIÓN CATASTRAL'
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

    public function generarCedula(){

        if($this->predio->sector === 88 || $this->predio->sector === 99){

            $this->dispatch('mostrarMensaje', ['error', "El predio se encuentra en sector 88 o 99 es necesario conciliarlo."]);

            return;

        }

        $this->construirCadena();

        $pdf = $this->revisarOficina();

        $this->tramite->update(['estado' => 'concluido']);

        $this->tramite->predios()->updateExistingPivot($this->predio->id, ['estado' => 'I']);

        $this->tramite->audits()->latest()->first()->update(['tags' => 'Finalizó trámite']);

        return response()->streamDownload(
            fn () => print($pdf),
            'cedula_actualizacion.pdf'
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
       return view('livewire.certificaciones.cedula-actualizacion')->extends('layouts.admin');
    }
}
