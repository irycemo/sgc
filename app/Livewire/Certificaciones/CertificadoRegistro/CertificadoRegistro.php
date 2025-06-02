<?php

namespace App\Livewire\Certificaciones\CertificadoRegistro;

use App\Models\Tramite;
use Livewire\Component;
use App\Constantes\Constantes;
use App\Http\Controllers\Certificaciones\CertificadoRegistroController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CertificadoRegistro extends Component
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

    public $tipo_certificado;

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

            if(!in_array($this->tramite->servicio->clave_ingreso, ['DM31', 'DM34', 'D934'])){

                $this->dispatch('mostrarMensaje', ['warning', "El trámite no corresponde a un certificado de registro."]);

                $this->reset('tramite');

                return;

            }

            if($this->tramite->estado === 'concluido'){

                $this->dispatch('mostrarMensaje', ['warning', "El trámite esta concluido."]);

                $this->reset('tramite');

                return;

            }

            if($this->tramite->estado != 'pagado' && $this->tramite->estado != 'autorizado'){

                $this->dispatch('mostrarMensaje', ['warning', "El trámite no esta pagado."]);

                $this->reset('tramite');

                return;

            }

            if($this->tramite->estado !== 'autorizado' && $this->tramite->fecha_entrega >= now()){

                $this->dispatch('mostrarMensaje', ['warning', "La fecha de entrega del trámite es: " . $this->tramite->fecha_entrega->format('d-m-Y')]);

                $this->reset('tramite');

                return;

            }

            $this->tipo_certificado = mb_strtoupper($this->tramite->servicio->nombre, 'utf-8');

            if($this->tramite->predios()->count() === 1){

                $this->predio = $this->tramite->predios()->first();

                if($this->predio->status == 'bloqueado'){

                    $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra bloqueado."]);
                    $this->predio = null;
                    return;

                }

                $this->oficina = $this->predio->oficina;

                $this->predio->load('propietarios.persona', 'colindancias');

            }

            $this->reset(['folio', 'usuario']);


        } catch (ModelNotFoundException $th) {

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no existe."]);

        } catch (\Throwable $th) {
            Log::error("Error al buscar certificado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }


    }

    public function seleccionarPredio($id){

        $this->predio = $this->tramite->predios()->wherePivot('predio_id', $id)->wherePivot('estado', 'A')->first();

        if($this->predio){

            if($this->predio->status == 'bloqueado'){

                $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra bloqueado."]);
                $this->predio = null;
                return;

            }

            $this->oficina = $this->predio->oficina;

            $this->predio->load('propietarios.persona', 'colindancias');

        }

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
                'folio' => (Certificacion::where('año', now()->format('Y'))->where('documento', $this->tipo_certificado)->max('folio') ?? 0) + 1,
                'documento' => $this->tipo_certificado,
                'cadena_originial' => $this->cadena,
                'cadena_encriptada' => base64_encode($firmaDirector),
                'estado' => 'activo',
                'oficina_id' => $oficina->id,
                'tramite_id' => $this->tramite->id,
                'predio_id' => $this->predio->id,
                'creado_por' => auth()->id(),
                'actualizado_por' => auth()->id(),
            ]);

            $pdf = Pdf::loadview('certificados.registro', [
                'predio' => $this->predio,
                'tramite' => $this->tramite,
                'director' => $this->director->nombreCompleto(),
                'firmaDirector' => base64_encode($firmaDirector),
                'qr' => $this->generadorQr($certificacion->uuid),
                'oficina' => $oficina->nombre,
                'certificacion' => $certificacion,
                'fecha_impresion' => $fechaImpresion,
                'impreso_por' => auth()->user()->nombreCompleto(),
                'tipo_certificado' => $this->tipo_certificado,
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
                'folio' => (Certificacion::where('año', now()->format('Y'))->where('documento', $this->tipo_certificado)->max('folio') ?? 0) + 1,
                'documento' => $this->tipo_certificado,
                'cadena_originial' => $this->cadena,
                'estado' => 'activo',
                'oficina_id' => $oficina->id,
                'tramite_id' => $this->tramite->id,
                'predio_id' => $this->predio->id,
                'creado_por' => auth()->id(),
                'actualizado_por' => auth()->id(),
            ]);

            $pdf = Pdf::loadview('certificados.registro', [
                'predio' => $this->predio,
                'tramite' => $this->tramite,
                'oficina' => $oficina->nombre,
                'cargo' => $cargo,
                'titular' => $oficina->titular,
                'qr' => $this->generadorQr($certificacion->uuid),
                'fecha_impresion' => $fechaImpresion,
                'certificacion' => $certificacion,
                'impreso_por' => auth()->user()->nombreCompleto(),
                'tipo_certificado' => $this->tipo_certificado
            ]);

        }

        $pdf->render();

        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(480, 796, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 7, array(1, 1, 1));

        $canvas->page_text(35, 796, $certificacion->documento . "-" . $certificacion->año . '-' .$certificacion->folio , null, 7, array(1, 1, 1));

        return $dom_pdf->output();

    }

    public function generarCertificado(){

        if($this->predio->sector === 88 || $this->predio->sector === 99){

            $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra en sector 88 o 99 es necesario conciliarlo."]);

            return;

        }

        try {

            $pdf = null;

            DB::transaction(function () use(&$pdf){

                $this->tramite->predios()->updateExistingPivot($this->predio->id, ['estado' => 'I']);

                $usados = $this->tramite->predios()->wherePivot('estado', 'I')->count();

                $this->tramite->update(['usados' => $usados]);

                $this->tramite->audits()->latest()->first()->update(['tags' => 'Generó certificado del predio ' . $this->predio->cuentaPredial()]);

                if($this->tramite->cantidad === $usados){

                    $this->tramite->update(['estado' => 'concluido']);

                    $this->tramite->audits()->latest()->first()->update(['tags' => 'Finalizó trámite']);

                }

                $pdf = (new CertificadoRegistroController())->certificado($this->tramite, $this->predio, $this->tipo_certificado);

            });

            $this->reset('predio');

            $this->tramite->load('predios');

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'certificado_de_registro.pdf'
            );

        } catch (\Throwable $th) {

            Log::error("Error al generar certificado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.certificaciones.certificado-registro.certificado-registro')->extends('layouts.admin');
    }
}
