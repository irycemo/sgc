<?php

namespace App\Livewire\Valuacion;

use App\Models\User;
use App\Models\Oficina;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\PredioAvaluo;
use App\Models\Certificacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Constantes\Constantes;
use Endroid\QrCode\Builder\Builder;
use PhpCfdi\Credentials\Credential;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Font\NotoSans;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class ImpresionAvaluo extends Component
{

    public $tramiteInspeccion;
    public $usuarioInspeccion;
    public $añoInspeccion;
    public $folioInspeccion;
    public $tramiteAvaluo;
    public $añoAvaluo;
    public $folioAvaluo;
    public $usuarioAvaluo;

    public $director;
    public $jefe_departamento;

    public $localidad;
    public $oficina;
    public $tipo;
    public $registro_inicio;
    public $registro_final;
    public $region_catastral;
    public $municipio;
    public $sector;
    public $zona_catastral;
    public $manzana;
    public $predio;
    public $edificio;
    public $departamento;

    public $predios;

    public $pdf;

    public $cantidad;
    public $años;

    public $cadena;

    protected function rules(){
        return [
            'folioInspeccion' => 'nullable',
            'usuarioInspeccion' => 'nullable',
            'folioAvaluo' => Rule::requiredIf(!auth()->user()->hasRole('Convenio municipal')),
            'usuarioAvaluo' => Rule::requiredIf(!auth()->user()->hasRole('Convenio municipal'))
         ];
    }

    protected $validationAttributes  = [
        'tramiteInspeccion' => 'trámte de inspección',
        'usuarioInspeccion' => 'trámte de inspección'
    ];

    public function updatedLocalidad(){

        $this->updatedOficina();

    }

    public function updatedOficina(){

        $this->validate(['localidad' => 'required','oficina' => 'required']);

        $oficina = Oficina::where('oficina', $this->oficina)->where('localidad', $this->localidad)->first();

        if(!$oficina){

            $this->dispatch('mostrarMensaje', ['error', "La localidad no correspoonde a la oficina."]);

            $this->reset(['localidad']);

            return;

        }

    }

    public function updatedRegistroInicio(){

        $this->resetClaveCatastral();

    }

    public function updatedRegionCatastral(){

        $this->resetCuentaPredial();

    }

    public function resetCuentaPredial(){

        $this->reset(['tipo', 'registro_inicio', 'registro_final']);

    }

    public function resetClaveCatastral(){

        $this->reset(['region_catastral', 'municipio', 'zona_catastral', 'sector', 'manzana', 'predio', 'edificio', 'departamento']);

    }

    public function actualizarTramites(){

        $this->tramiteAvaluo->update([
                            'usados' => $this->cantidad + $this->tramiteAvaluo->usados,
                            'parcial_usado' => $this->tramiteInspeccion?->id
                            ]);

        if($this->tramiteAvaluo->cantidad == $this->tramiteAvaluo->usados)
            $this->tramiteAvaluo->update(['estado' => 'concluido']);

        if($this->tramiteInspeccion){

            $this->tramiteInspeccion->update([
                'usados' => $this->cantidad + $this->tramiteInspeccion->usados,
                'parcial_usado' => $this->tramiteAvaluo->id
            ]);

            if($this->tramiteInspeccion->cantidad == $this->tramiteInspeccion->usados)
                $this->tramiteInspeccion->update(['estado' => 'concluido']);

        }

    }

    public function validaciones(){

        if(!auth()->user()->hasRole('Convenio municipal')){

            $this->tramiteAvaluo = Tramite::where('año', $this->añoAvaluo)->where('folio', $this->folioAvaluo)->where('usuario', $this->usuarioAvaluo)->first();

            if(!$this->tramiteAvaluo){

                $this->dispatch('mostrarMensaje', ['error', "El trámite de impresión no existe."]);

                return true;

            }

            if($this->tramiteAvaluo->estado != 'pagado'){

                $this->dispatch('mostrarMensaje', ['error', "El trámite de impresión no esta pagado o ha sido concluido."]);

                return true;

            }

            if(!in_array($this->tramiteAvaluo->servicio_id, [43, 44, 45, 46, 47, 37, 38, 38, 40])){

                $this->dispatch('mostrarMensaje', ['error', "El trámite no corresponde a un avalúo."]);

                return true;

            }

            if(in_array($this->tramiteAvaluo->servicio_id, [37, 38, 38, 40]) && !in_array($this->tramiteAvaluo->avaluo_para, [1,2,3,4])){

                $this->dispatch('mostrarMensaje', ['error', "El trámite de impresión no es para valúo de actualización, fusión ó cambio de régimen."]);

                return true;

            }

            if(($this->cantidad + $this->tramiteAvaluo->usados) > $this->tramiteAvaluo->cantidad){

                $this->dispatch('mostrarMensaje', ['error', "La cantidad de avaluos que avala el trámite ya se usó."]);

                return true;

            }

            if(in_array($this->tramiteAvaluo->servicio_id, [43, 44, 46, 47])){

                $this->tramiteInspeccion = Tramite::where('año', $this->añoInspeccion)->where('folio', $this->folioInspeccion)->where('usuario', $this->usuarioInspeccion)->first();

                if(!$this->tramiteInspeccion){

                    $this->dispatch('mostrarMensaje', ['error', "El trámite de inspección no existe."]);

                    return true;

                }

                if(!in_array($this->tramiteInspeccion->servicio_id, [37, 38, 39, 40])){

                    $this->dispatch('mostrarMensaje', ['error', "El trámite no corresponde a una inspección."]);

                    return true;

                }

                if($this->tramiteInspeccion->estado != 'pagado'){

                    $this->dispatch('mostrarMensaje', ['error', "El trámite de inspección no esta pagado o ha sido concluido."]);

                    return true;

                }

                if(($this->cantidad + $this->tramiteInspeccion->usados) > $this->tramiteInspeccion->cantidad){

                    $this->dispatch('mostrarMensaje', ['error', "La cantidad de inspecciones que avala el trámite ya se usó o es insuficiente."]);

                    return true;

                }

                if($this->tramiteInspeccion->avaluo_para == 46 && $this->tramiteAvaluo->servicio_id != 46){

                    $this->dispatch('mostrarMensaje', ['error', "El trámite de impresión no corresponde a una variación catastral de otro tipo de inmueble."]);

                    return true;

                }elseif($this->tramiteInspeccion->avaluo_para == 43  && $this->tramiteAvaluo->servicio_id != 43){

                    $this->dispatch('mostrarMensaje', ['error', "El trámite de impresión no corresponde a un desglose."]);

                    return true;

                }elseif($this->tramiteInspeccion->avaluo_para == 44  && $this->tramiteAvaluo->servicio_id != 44){

                    $this->dispatch('mostrarMensaje', ['error', "El trámite de impresión no corresponde a un desglose."]);

                    return true;

                }elseif($this->tramiteInspeccion->avaluo_para == 47 && $this->tramiteAvaluo->servicio_id != 47){

                    $this->dispatch('mostrarMensaje', ['error', "El trámite de impresión no corresponde a un avlúo predio ignorado."]);

                    return true;

                }

            }

            if($this->tramiteAvaluo->parcial_usado){

                if(!$this->tramiteInspeccion){

                    $this->dispatch('mostrarMensaje', ['error', "El trámite de impresión esta ligado a un trámite de inspección, es necesario ingresarlo."]);

                    return true;

                }

                if($this->tramiteAvaluo->parcial_usado != $this->tramiteInspeccion->id){

                    $this->dispatch('mostrarMensaje', ['error', "El trámite de impresión no esta ligado al trámite de inspección."]);

                    return true;

                }

            }

        }else{

            $this->tramiteInspeccion = 'Convenio municipal';

            $this->tramiteAvaluo = 'Convenio municipal';

        }

        $this->cantidad = $this->registro_final - $this->registro_inicio + 1;

        if($this->registro_final == $this->registro_inicio)
            $this->cantidad = 1;

        if($this->cantidad < 0){

            $this->dispatch('mostrarMensaje', ['error', "El registro inicial no puede ser mayor al registro final."]);

            return true;

        }

    }

    public function revisarAvaluosCompletos(){

        foreach($this->predios as $predio){

            if(!$predio->colindancias->count()){

                $this->dispatch('mostrarMensaje', ['error', "El avaluo con folio: " . $predio->avaluo->año . '-' . $predio->avaluo->folio . ", cuenta predial: " . $predio->localidad . "-" . $predio->oficina . "-" . $predio->tipo_predio . "-" . $predio->numero_registro . " no tiene colindancias."]);

                return true;

            }

            if(!$predio->avaluo->clasificacion_zona){

                $this->dispatch('mostrarMensaje', ['error', "El avaluo con folio: " . $predio->avaluo->año . '-' . $predio->avaluo->folio . ", cuenta predial: " . $predio->localidad . "-" . $predio->oficina . "-" . $predio->tipo_predio . "-" . $predio->numero_registro . " no tiene caracteristicas."]);

                return true;

            }

            if(!$predio->uso_1){

                $this->dispatch('mostrarMensaje', ['error', "El avaluo con folio: " . $predio->avaluo->año . '-' . $predio->avaluo->folio . ", cuenta predial: " . $predio->localidad . "-" . $predio->oficina . "-" . $predio->tipo_predio . "-" . $predio->numero_registro . " no tiene uso de predio."]);

                return true;

            }

            if($predio->edificio == 0 && $predio->terrenos->count() == 0){

                $this->dispatch('mostrarMensaje', ['error', "El avaluo con folio: " . $predio->avaluo->año . '-' . $predio->avaluo->folio . ", cuenta predial: " . $predio->localidad . "-" . $predio->oficina . "-" . $predio->tipo_predio . "-" . $predio->numero_registro . " no tiene terrenos."]);

                return true;

            }

            if($predio->edificio != 0 && $predio->condominioTerrenos->count() == 0){

                $this->dispatch('mostrarMensaje', ['error', "El avaluo con folio: " . $predio->avaluo->año . '-' . $predio->avaluo->folio . " no tiene terrenos de área común."]);

                return true;

            }

            if($predio->valor_catastral == null){

                $this->dispatch('mostrarMensaje', ['error', "El avaluo con folio: " . $predio->avaluo->año . '-' . $predio->avaluo->folio . " no tiene valor catastral."]);

                return true;

            }

        }

    }

    public function buscarPredios(){

        if($this->region_catastral || $this->municipio || $this->zona_catastral || $this->sector || $this->manzana || $this->predio || $this->edificio || $this->departamento){

            $this->validate([
                'tramiteInspeccion' => 'nullable',
                'tramiteAvaluo' => 'required',
                'localidad' => 'required',
                'region_catastral' => 'required',
                'municipio' => 'required',
                'zona_catastral' => 'required',
                'sector' => 'required',
                'manzana' => 'nullable',
                'predio' => 'nullable',
                'edificio' => 'nullable',
                'departamento' => 'nullable',
            ]);

            $this->predios = PredioAvaluo::with('avaluo', 'propietarios.persona')
                                        ->where('localidad', $this->localidad)
                                        ->where('region_catastral', $this->region_catastral)
                                        ->where('municipio', $this->municipio)
                                        ->where('zona_catastral', $this->zona_catastral)
                                        ->where('sector', $this->sector)
                                        ->where('manzana', $this->manzana)
                                        ->where('predio', $this->predio)
                                        ->where('edificio', $this->edificio)
                                        ->where('departamento', $this->departamento)
                                        ->whereHas('avaluo', function($q){
                                            $q->where('estado', '!=', 'notificado');
                                        })
                                        ->get();

            if($this->predios->count() == 0){

                $this->dispatch('mostrarMensaje', ['error', "No se encontraron avaluos para la clave catastral."]);

                return true;

            }

        }else{

            $this->validate([
                'tramiteInspeccion' => 'nullable',
                'tramiteAvaluo' => 'required',
                'localidad' => 'required',
                'oficina' => 'required',
                'tipo' => 'required',
                'registro_inicio' => 'required',
                'registro_final' => 'required',
            ]);

            $this->predios = PredioAvaluo::with('avaluo.asignadoA', 'propietarios.persona', 'colindancias', 'condominioTerrenos', 'condominioConstrucciones', 'terrenos', 'construcciones')
                                        ->where('localidad', $this->localidad)
                                        ->where('oficina', $this->oficina)
                                        ->where('tipo_predio', $this->tipo)
                                        ->whereBetween('numero_registro', [$this->registro_inicio, $this->registro_final])
                                        ->whereHas('avaluo', function($q){
                                            $q->where('estado', '!=', 'notificado');
                                        })
                                        ->get();

            $this->cantidad = $this->predios->count();

            if($this->predios->count() == 0){

                $this->dispatch('mostrarMensaje', ['error', "No se encontraron avaluos para el rango de cuentas prediales."]);

                return true;

            }

            $valuador = $this->predios->first()->avaluo->asignadoA->id;

            foreach ($this->predios as $predio) {

                if($valuador != $predio->avaluo->asignadoA->id){

                    $this->dispatch('mostrarMensaje', ['error', "El avalúo del predio " . $predio->cuentaPredial() . ' esta asigando a un valuador distinto.']);

                    return true;

                }

            }

        }

    }

    public function imprimir(){

        $this->validate();

        if($this->validaciones()) return;

        if($this->buscarPredios()) return;

        if($this->revisarAvaluosCompletos()) return;

        $pdf = null;

        DB::transaction(function () use (&$pdf){

            $this->cadena = 'impreso_por: ' . auth()->user()->nombreCompleto();

            foreach($this->predios as $predio){

                $sociedad = $predio->sociedad ? ' y soc.' : '';

                $this->cadena = $this->cadena . '|' . 'folio_avaluo=' . $predio->avaluo->año . '-' . $predio->avaluo->folio . '%Cuenta predial=' . $predio->cuentaPredial() . '%Clave catastral=' . $predio->claveCatastral() . '%Propietario=' . $predio->primerPropietario() . $sociedad . '%Valor catastral=' . $predio->valor_catastral;

                $predio->update(['status' => 'impreso']);

                $predio->avaluo->update([
                            'tramite_id' => $this->tramiteAvaluo->id,
                            'estado' => 'impreso'
                        ]);

                $predio->avaluo->audits()->latest()->first()->update(['tags' => 'Imprimió avalúo']);

            }

            if($this->tramiteInspeccion && $this->tramiteInspeccion != 'Convenio municipal'){

                $this->cadena = $this->cadena . '|' . 'tramite_de_inspeccion: ' . $this->tramiteInspeccion->año . '-' . $this->tramiteInspeccion->folio . '-'. $this->tramiteInspeccion->usuario . '|' . 'recibo_inspeccion: ' . $this->tramiteInspeccion->folio_pago;

            }else{

                $this->cadena = $this->cadena . '|' . 'convenio_municipal: Convenio municipal';

            }

            if($this->tramiteAvaluo != 'convenio_municipal'){

                $this->cadena = $this->cadena . '|' . 'tramite_de_avaluo: ' . $this->tramiteAvaluo->año . '-' . $this->tramiteAvaluo->folio . '-'. $this->tramiteAvaluo->usuario  . '|' . 'recibo_avaluo: ' . $this->tramiteAvaluo->folio_pago;

            }

            $this->cadena = $this->cadena . '|' . 'valuador: ' . $predio->avaluo->asignadoA->nombreCompleto();

            $pdf = $this->revisarOficina($pdf);

            if(!auth()->user()->hasRole('Convenio municipal')) $this->actualizarTramites();

        });

        return response()->streamDownload(
            fn () => print($pdf),
            'notificacion_de_valor_catastral.pdf'
        );

    }

    public function revisarOficina($pdf){

        $formatter = new NumeroALetras();

        $numero_avaluos_letra = $formatter->toWords($this->predios->count());

        $this->cadena = $this->cadena . '|' . 'numero: ' . $this->predios->count() . ' ' . $numero_avaluos_letra;

        $fechaImpresion = now()->format('d-m-Y H:i:s');

        $this->cadena = $this->cadena . '|' . 'impreso_en: ' . $fechaImpresion;

        if(auth()->user()->hasRole('Convenio municipal')){

            $oficina = Oficina::where('oficina', $this->oficina)->first();

            $this->cadena = $this->cadena . '|' . 'autoridad_municipal: ' . $oficina->autoridad_municipal;

            $certificacion = Certificacion::create([
                'año' => now()->format('Y'),
                'folio' => (Certificacion::where('año', now()->format('Y'))->where('documento', 'NOTIFICACIÓN DE VALOR CATASTRAL')->max('folio') ?? 0) + 1,
                'documento' => 'NOTIFICACIÓN DE VALOR CATASTRAL',
                'cadena_originial' => $this->cadena,
                'estado' => 'activo',
                'oficina_id' => $oficina->id,
                'creado_por' => auth()->id(),
                'actualizado_por' => auth()->id(),
            ]);

            $pdf = Pdf::loadview('avaluos.notificacion', [
                'predios' => $this->predios,
                'numero_avaluos_letra' => $numero_avaluos_letra,
                'autoridad_municipal' => $oficina->autoridad_municipal,
                'qr' => $this->generadorQr($certificacion),
                'certificacion' => $certificacion,
                'fecha_impresion' => $fechaImpresion,
                'convenio' => 'Convenio municipal',
                'impreso_por' => auth()->user()->nombreCompleto()
            ]);


        }elseif($this->oficina == 101){

            $this->cadena = $this->cadena . '|' . 'titular: ' . $this->director->nombreCompleto() . '|' . 'cargo: Director de catastro';

            $this->cadena = $this->cadena . '|' . 'jefe_de_departamento: ' . $this->jefe_departamento->nombreCompleto();

            $fielDirector = Credential::openFiles(Storage::disk('efirma')->path($this->director->efirma->cer), Storage::disk('efirma')->path($this->director->efirma->key), $this->director->efirma->contraseña);

            $fielJefe = Credential::openFiles(Storage::disk('efirma')->path($this->jefe_departamento->efirma->cer), Storage::disk('efirma')->path($this->jefe_departamento->efirma->key), $this->jefe_departamento->efirma->contraseña);

            $firmaDirector = $fielDirector->sign($this->cadena);

            $firmaJefe = $fielJefe->sign($this->cadena);

            $this->cadena = $this->cadena . '|' . 'firma_jefe_de_departamento: ' . base64_encode($firmaJefe);

            $certificacion = Certificacion::create([
                'año' => now()->format('Y'),
                'folio' => (Certificacion::where('año', now()->format('Y'))->where('documento', 'NOTIFICACIÓN DE VALOR CATASTRAL')->max('folio') ?? 0) + 1,
                'documento' => 'NOTIFICACIÓN DE VALOR CATASTRAL',
                'cadena_originial' => $this->cadena,
                'cadena_encriptada' => base64_encode($firmaDirector),
                'estado' => 'activo',
                'oficina_id' => Oficina::where('oficina', 101)->first()->id,
                'tramite_id' => $this->tramiteAvaluo->id,
                'creado_por' => auth()->id(),
                'actualizado_por' => auth()->id(),
            ]);

            $pdf = Pdf::loadview('avaluos.notificacion', [
                                'predios' => $this->predios,
                                'numero_avaluos_letra' => $numero_avaluos_letra,
                                'tramiteInspeccion' => $this->tramiteInspeccion,
                                'tramiteAvaluo' => $this->tramiteAvaluo,
                                'director' => $this->director->nombreCompleto(),
                                'jefe_departamento' => $this->jefe_departamento->nombreCompleto(),
                                'firmaDirector' => base64_encode($firmaDirector),
                                'firmaJefe' => base64_encode($firmaJefe),
                                'qr' => $this->generadorQr($certificacion),
                                'certificacion' => $certificacion,
                                'fecha_impresion' => $fechaImpresion,
                                'impreso_por' => auth()->user()->nombreCompleto(),
                                'imagen' => $this->director->efirma->imagen
                            ]);

        }else{

            $oficina = Oficina::where('oficina', $this->oficina)->first();

            $this->cadena = $this->cadena . '|' . 'titular: ' . $oficina->titular;

            $cargo = $oficina->tipo == 'ADMINISTRACIÓN' ? 'ADMINISTRADOR' : 'RECEPTOR(A) DE RENTAS';

            $this->cadena = $this->cadena . '|' . 'cargo: ' . $cargo;

            $certificacion = Certificacion::create([
                'año' => now()->format('Y'),
                'folio' => (Certificacion::where('año', now()->format('Y'))->where('documento', 'NOTIFICACIÓN DE VALOR CATASTRAL')->max('folio') ?? 0) + 1,
                'documento' => 'NOTIFICACIÓN DE VALOR CATASTRAL',
                'cadena_originial' => $this->cadena,
                'estado' => 'activo',
                'oficina_id' => $oficina->id,
                'tramite_id' => $this->tramiteAvaluo->id,
                'creado_por' => auth()->id(),
                'actualizado_por' => auth()->id(),
            ]);

            $pdf = Pdf::loadview('avaluos.notificacion', [
                                'predios' => $this->predios,
                                'numero_avaluos_letra' => $numero_avaluos_letra,
                                'tramiteInspeccion' => $this->tramiteInspeccion,
                                'tramiteAvaluo' => $this->tramiteAvaluo,
                                'cargo' => $cargo,
                                'titular' => $oficina->titular,
                                'qr' => $this->generadorQr($certificacion),
                                'fecha_impresion' => $fechaImpresion,
                                'certificacion' => $certificacion,
                                'impreso_por' => auth()->user()->nombreCompleto()
                            ]);

        }

        $pdf->render();

        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(480, 796, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 7, array(1, 1, 1));

        $canvas->page_text(35, 796, $certificacion->documento . "-" . $certificacion->año . '-' .$certificacion->folio , null, 7, array(1, 1, 1));

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

        $this->años = Constantes::AÑOS;

        $this->añoInspeccion = $this->añoAvaluo = now()->format('Y');

        $this->director = User::with('efirma')->where('status', 'activo')
                ->whereHas('roles', function($q){
                    $q->where('name', 'Director');
                })
                ->first();

        $this->jefe_departamento = User::with('efirma')->where('status', 'activo')
                            ->whereHas('roles', function($q){
                                $q->where('name', 'Jefe de departamento');
                            })
                            ->where('area', 'Departamento de Valuación')
                            ->first();

        $this->oficina = auth()->user()->oficina->oficina;

        if(!$this->director->efirma || !$this->director->efirma->cer || !$this->director->efirma->key || !$this->director->efirma->imagen) abort(500, message:"Es necesario actualizar la firma electrónica del director");

        if(!$this->jefe_departamento->efirma || !$this->jefe_departamento->efirma->cer || !$this->jefe_departamento->efirma->key) abort(500, message:"Es necesario actualizar la firma electrónica del jefe de departamento de valuación");

    }

    public function render()
    {
        return view('livewire.valuacion.impresion-avaluo')->extends('layouts.admin');
    }
}
