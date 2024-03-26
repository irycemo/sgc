<?php

namespace App\Livewire\Certificaciones;

use App\Models\User;
use App\Models\Predio;
use App\Models\Oficina;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\Movimiento;
use App\Models\Certificacion;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Constantes\Constantes;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Support\Facades\Log;
use PhpCfdi\Credentials\Credential;
use Endroid\QrCode\Writer\PngWriter;
use App\Http\Traits\ComponentesTrait;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Font\NotoSans;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class CertificadoHistoria extends Component
{

    use ComponentesTrait;

    public $radio;
    public $acciones_padron;
    public $años;
    public $director;

    public $año;
    public $folio;
    public $usuario;

    public $predio;

    public $numero_registro;
    public $region_catastral;
    public $municipio;
    public $localidad;
    public $sector;
    public $zona_catastral;
    public $manzana;
    public $predio_clave;
    public $edificio;
    public $departamento;
    public $tipo_predio;
    public $oficina;
    public $estado;

    public $nombre;
    public $fecha;
    public $descripcion;

    public $certificado;
    public $tramite;
    public $cadena;

    public $impresionDirector = false;

    public Movimiento $modelo_editar;

    public function crearModeloVacio(){
        $this->modelo_editar = Movimiento::make();
    }

    public function buscarCuentaPredial(){

        $this->validate([
            'numero_registro' => 'required',
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo_predio' => 'required',
        ]);

        try {

            $this->predio = Predio::with('movimientos')
                                    ->where('estado', '!=', 'notificado')
                                    ->where('numero_registro', $this->numero_registro)
                                    ->where('tipo_predio', $this->tipo_predio)
                                    ->where('localidad', $this->localidad)
                                    ->where('oficina', $this->oficina)
                                    ->firstOrFail();

            if($this->predio->bloqueadoActivo()){

                $this->dispatch('mostrarMensaje', ['error', "El predio se encuentra bloqueado."]);
                $this->predio = null;
                return;

            }

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "No se encontro predio con la cuenta predial ingresada."]);

        }

    }

    public function buscarClaveCatastral(){

        $this->validate([
            'region_catastral' => 'required',
            'municipio' => 'required',
            'localidad' => 'required',
            'sector' => 'required',
            'zona_catastral' => 'required',
            'manzana' => 'required',
            'predio_clave' => 'required',
            'edificio' => 'required',
            'departamento' => 'required',
        ]);

        try {

            $this->predio = Predio::with('movimientos')
                                    ->where('estado', 16)
                                    ->where('status', '!=', 'notificado')
                                    ->where('region_catastral', $this->region_catastral)
                                    ->where('municipio', $this->municipio)
                                    ->where('zona_catastral', $this->zona_catastral)
                                    ->where('localidad', $this->localidad)
                                    ->where('sector', $this->sector)
                                    ->where('manzana', $this->manzana)
                                    ->where('predio', $this->predio_clave)
                                    ->where('edificio', $this->edificio)
                                    ->where('departamento', $this->departamento)
                                    ->firstOrFail();

            if($this->predio->bloqueadoActivo()){

                $this->dispatch('mostrarMensaje', ['error', "El predio se encuentra bloqueado."]);
                $this->predio = null;
                return;

            }

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "No se encontro predio con la clave catastral ingresada."]);

        }

    }

    public function buscarTramite(){

        $this->validate([
            'año' => 'required',
            'folio' => 'required',
            'usuario' => 'required',
        ]);

        try {

            $this->reset(['certificado', 'predio']);

            $this->tramite = Tramite::where('año', $this->año)
                                        ->where('folio', $this->folio)
                                        ->where('usuario', $this->usuario)
                                        ->firstOrFail();

            if(!in_array($this->tramite->servicio->clave_ingreso, ['D927', 'D926', 'D925', 'D924'])){

                $this->dispatch('mostrarMensaje', ['error', "El trámite no corresponde a una historia catastral."]);

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

            $cantidad = match($this->tramite->servicio->clave_ingreso){
                'D924' => 5,
                'D925' => 10,
                'D926' => 15,
                'D927' => 100
            };

            $movimientos = $this->predio->movimientos->sortByDesc('fecha');

            $count = 0;

            foreach ($movimientos as $movimiento) {

                if($count == $cantidad) break;

                $this->certificado = $this->certificado . '<br>' . 'Movmiento: ' . $movimiento->nombre . '<br>' . 'Fecha: ' . $movimiento->fecha->format('d-m-Y') . '<br>' . 'Descripción: ' . '<br>' . $movimiento->descripcion . '<br>';

                $count ++;
            }

            $this->reset(['folio', 'usuario']);


        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['error', "El trámite no existe."]);

        } catch (\Throwable $th) {
            dd($th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }


    }

    public function abrirModalCrear():void
    {

        $this->modal = true;
        $this->crear =true;

        if($this->modelo_editar->getKey())
            $this->crearModeloVacio();

    }

    public function abrirModalEditar(Movimiento $modelo){

        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->nombre = $this->modelo_editar->nombre;
        $this->fecha = $this->modelo_editar->fecha;
        $this->descripcion = $this->modelo_editar->descripcion;

    }

    public function guardar(){

        $this->validate([
            'nombre' => 'required',
            'fecha' => 'required',
            'descripcion' => 'required'
        ]);

        try {

            $this->predio->movimientos()->create([
                'nombre' => $this->nombre,
                'fecha' => $this->fecha,
                'descripcion' => $this->descripcion,
                'creado_por' => auth()->id()
            ]);

            $this->predio->load('movimientos');

            $this->reset('modal');

            $this->dispatch('mostrarMensaje', ['success', "El movimiento se creó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al crear movimiento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function actualizar(){

        $this->validate([
            'nombre' => 'required',
            'fecha' => 'required',
            'descripcion' => 'required'
        ]);

        try{

            $this->modelo_editar->nombre = $this->nombre;
            $this->modelo_editar->fecha = $this->fecha;
            $this->modelo_editar->descripcion = $this->descripcion;
            $this->modelo_editar->actualizado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->predio->load('movimientos');

            $this->reset('modal');

            $this->dispatch('mostrarMensaje', ['success', "El movimiento se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar movimiento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    public function borrar(){

        try{

            $usuario = Movimiento::find($this->selected_id);

            $usuario->delete();

            $this->predio->load('movimientos');

            $this->reset('modalBorrar');

            $this->crearModeloVacio();

            $this->dispatch('mostrarMensaje', ['success', "El movimiento se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar movimiento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    public function generarCertificado(){

        $pdf = $this->revisarOficina();

        $this->tramite->update(['estado' => 'concluido']);

        $this->tramite->adicionaA->update(['estado' => 'concluido']);

        $this->tramite->audits()->latest()->first()->update(['tags' => 'Finalizó trámite']);

        return response()->streamDownload(
            fn () => print($pdf),
            'certificado_de_historia.pdf'
        );

    }

    public function revisarOficina(){

        $fechaImpresion = now()->format('d-m-Y H:i:s');

        $this->cadena = 'cuenta_predial: ' . $this->predio->cuentaPredial();

        $this->cadena = $this->cadena . '|' . 'clave_catastral: ' . $this->predio->claveCatastral();

        $this->cadena = $this->cadena . '|' . 'propietario: ' . $this->predio->primerPropietario();

        $this->cadena = $this->cadena . '|' . 'historia: ' . $this->certificado;

        $this->cadena = $this->cadena . '|' . 'impreso_en: ' . $fechaImpresion;

        $this->cadena = $this->cadena . '|' . 'impreso_por: ' . auth()->user()->nombreCompleto();

        $this->cadena = $this->cadena . '|' . 'tramite: ' . $this->tramite->año . '-' . $this->tramite->folio . '-'. $this->tramite->usuario . '|' . 'recibo: ' . $this->tramite->folio_pago;

        $this->cadena = $this->cadena . '|' . 'solicitante: ' . $this->tramite->nombre_solicitante;

        if($this->predio->oficina == 101 || $this->impresionDirector){

            $fielDirector = Credential::openFiles(Storage::disk('efirma')->path($this->director->efirma->cer), Storage::disk('efirma')->path($this->director->efirma->key), $this->director->efirma->contraseña);

            $oficina = Oficina::where('oficina', 101)->first();

            $this->cadena = $this->cadena . '|' . 'oficina: ' . $oficina->nombre;

            $this->cadena = $this->cadena . '|' . 'suscrito: ' . $this->director->nombreCompleto();

            $this->cadena = $this->cadena . '|' . 'cargo: Director de catastro';

            $firmaDirector = $fielDirector->sign($this->cadena);

            $certificacion = Certificacion::create([
                'año' => now()->format('Y'),
                'folio' => (Certificacion::where('año', now()->format('Y'))->where('documento', 'CERTIFICADO DE HISTORIA CATASTRAL')->max('folio') ?? 0) + 1,
                'documento' => 'CERTIFICADO DE HISTORIA CATASTRAL',
                'cadena_originial' => $this->cadena,
                'cadena_encriptada' => base64_encode($firmaDirector),
                'estado' => 'activo',
                'oficina_id' => $oficina->id,
                'tramite_id' => $this->tramite->id,
                'predio_id' => $this->predio->id,
                'creado_por' => auth()->id(),
                'actualizado_por' => auth()->id(),
            ]);

            $pdf = Pdf::loadview('certificados.historia', [
                                'predio' => $this->predio,
                                'certificado' => $this->certificado,
                                'tramite' => $this->tramite,
                                'director' => $this->director->nombreCompleto(),
                                'firmaDirector' => base64_encode($firmaDirector),
                                'qr' => $this->generadorQr($certificacion->uuid),
                                'oficina' => $oficina->nombre,
                                'certificacion' => $certificacion,
                                'fecha_impresion' => $fechaImpresion,
                                'impreso_por' => auth()->user()->nombreCompleto(),
                                'imagen' => $this->director->efirma->imagen
            ]);

        }else{

            $oficina = Oficina::where('oficina', $this->predio->oficina)->first();

            $this->cadena = $this->cadena . '|' . 'oficina: ' . $oficina->nombre;

            $this->cadena = $this->cadena . '|' . 'suscrito: ' . $oficina->titular;

            $cargo = $oficina->tipo == 'ADMINISTRACIÓN' ? 'ADMINISTRADOR' : 'RECEPTOR(A) DE RENTAS';

            $this->cadena = $this->cadena . '|' . 'cargo: ' .  $cargo;

            $certificacion = Certificacion::create([
                'año' => now()->format('Y'),
                'folio' => (Certificacion::where('año', now()->format('Y'))->where('documento', 'CERTIFICADO DE HISTORIA CATASTRAL')->max('folio') ?? 0) + 1,
                'documento' => 'CERTIFICADO DE HISTORIA CATASTRAL',
                'cadena_originial' => $this->cadena,
                'estado' => 'activo',
                'oficina_id' => $oficina->id,
                'tramite_id' => $this->tramite->id,
                'predio_id' => $this->predio->id,
                'creado_por' => auth()->id(),
                'actualizado_por' => auth()->id(),
            ]);

            $pdf = Pdf::loadview('certificados.historia', [
                                'predio' => $this->predio,
                                'certificado' => $this->certificado,
                                'tramite' => $this->tramite,
                                'oficina' => $oficina->nombre,
                                'cargo' => $cargo,
                                'titular' => $oficina->titular,
                                'qr' => $this->generadorQr($certificacion->uuid),
                                'fecha_impresion' => $fechaImpresion,
                                'certificacion' => $certificacion,
                                'impreso_por' => auth()->user()->nombreCompleto()
                            ]);

        }

        /* $pdf->setEncryption('c3rt1f1c4d0h1st0r14.' . $this->tramite->año . '-' . $this->tramite->folio . '-' . $this->tramite->usuario, 'c3rt1f1c4d0h1st0r14.' . $this->tramite->año . '-' . $this->tramite->folio . '-' . $this->tramite->usuario, ['modify']); */

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

    public function mount(){

        array_push($this->fields, 'nombre', 'fecha', 'descripcion', 'predio', 'numero_registro', 'region_catastral', 'municipio', 'localidad', 'sector', 'zona_catastral', 'manzana', 'predio_clave', 'edificio', 'departamento', 'tipo_predio', 'oficina', 'estado');

        $this->crearModeloVacio();

        $this->acciones_padron = Constantes::ACCIONES_PADRON;

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

        $this->director = User::with('efirma')->where('status', 'activo')
                ->whereHas('roles', function($q){
                    $q->where('name', 'Director');
                })
                ->first();

        $this->oficina =  auth()->user()->oficina->oficina;

        if(!$this->director->efirma || !$this->director->efirma->cer || !$this->director->efirma->key || !$this->director->efirma->imagen) abort(500, message:"Es necesario actualizar la firma electrónica del director");

    }

    public function render()
    {
        return view('livewire.certificaciones.certificado-historia')->extends('layouts.admin');
    }
}

