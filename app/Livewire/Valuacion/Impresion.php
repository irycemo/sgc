<?php

namespace App\Livewire\Valuacion;

use App\Models\Avaluo;
use App\Models\Oficina;
use App\Models\Tramite;
use Livewire\Component;
use App\Constantes\Constantes;
use Illuminate\Validation\Rule;
use App\Enums\Tramites\AvaluoPara;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Certificaciones\CertificacionesController;

class Impresion extends Component
{

    public $lista_avaluo_para;
    public int|null $avaluo_para;
    public $años;
    public $numero_avaluos;

    public $avaluos;
    public $avaluo_predio_ignorado;

    public $inspeccion_año;
    public $inspeccion_folio;
    public $inspeccion_usuario;
    public $tramite_inspeccion;

    public $desglose_año;
    public $desglose_folio;
    public $desglose_usuario;
    public $tramite_desglose;

    public $estado = 16;
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

    protected function rules(){
        return [
            'inspeccion_año' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_folio' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'inspeccion_usuario' => Rule::requiredIf(!auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_año' => Rule::requiredIf(in_array($this->avaluo_para, [3, 4, 5 , 6, 9]) && !auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_folio' => Rule::requiredIf(in_array($this->avaluo_para, [3, 4, 5 , 6, 9]) && !auth()->user()->hasRole(['Convenio municipal'])),
            'desglose_usuario' => Rule::requiredIf(in_array($this->avaluo_para, [3, 4, 5 , 6, 9]) && !auth()->user()->hasRole(['Convenio municipal'])),
            'localidad' => 'required',
            'tipo' => Rule::requiredIf($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO),
            'registro_inicio' => Rule::requiredIf($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO),
            'registro_final' => Rule::requiredIf($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO),
            'region_catastral' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'municipio' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'zona_catastral' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'sector' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'manzana' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'predio' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'edificio' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'departamento' => Rule::requiredIf($this->avaluo_para === AvaluoPara::PREDIO_IGNORADO),
            'registro_inicio' => ['nullable', 'lte:registro_final'],
            'registro_final' => ['nullable', 'gte:registro_inicio']
         ];
    }

    public function updatedAvaluoPara(){

        if($this->avaluo_para === '') $this->avaluo_para = null;

        $this->reset([
            'inspeccion_año',
            'inspeccion_folio',
            'inspeccion_usuario',
            'tramite_inspeccion',
            'desglose_año',
            'desglose_folio',
            'desglose_usuario',
            'tramite_desglose',
            'localidad',
            'oficina',
            'tipo',
            'registro_inicio',
            'registro_final',
            'region_catastral',
            'municipio',
            'sector',
            'zona_catastral',
            'manzana',
            'predio',
            'edificio',
            'departamento',
        ]);

    }

    public function updatedOficina(){

        $this->validate(['localidad' => 'required','oficina' => 'required']);

        $oficina = Oficina::where('oficina', $this->oficina)->where('localidad', $this->localidad)->first();

        if(!$oficina){

            $this->dispatch('mostrarMensaje', ['warning', "La localidad no correspoonde a la oficina."]);

            $this->reset(['localidad']);

            return;

        }

    }

    public function updatedLocalidad(){

        $this->updatedOficina();

    }

    public function resetCuentaPredial(){

        $this->reset(['tipo', 'registro_inicio', 'registro_final']);

    }

    public function resetClaveCatastral(){

        $this->reset(['region_catastral', 'municipio', 'zona_catastral', 'sector', 'manzana', 'predio', 'edificio', 'departamento']);

    }

    public function validarTramites(){

        if(auth()->user()->hasRole(['Convenio municipal'])) return;

        $this->tramite_inspeccion = Tramite::where('año', $this->inspeccion_año)
                                            ->where('folio', $this->inspeccion_folio)
                                            ->where('usuario', $this->inspeccion_usuario)
                                            ->first();

        if(!$this->tramite_inspeccion) throw new GeneralException('El trámite de inspección ocular no existe.');

        if(!$this->tramite_inspeccion->avaluo_para) throw new GeneralException('El trámite ingresado para inspección ocular no corresponde a una inspección ocular.');

        if($this->tramite_inspeccion->estado != 'pagado') throw new GeneralException('El trámite de inspección ocular no esta pagado o ha sido concluido.');

        if($this->tramite_inspeccion->avaluo_para->value != $this->avaluo_para) throw new GeneralException('El trámite de inspección ocular no corresponde a un avalúo para ' . $this->lista_avaluo_para[$this->avaluo_para - 1]->label());

        if(in_array($this->avaluo_para, [3, 4, 5 , 6, 9])){

            $this->tramite_desglose = Tramite::where('año', $this->desglose_año)
                                            ->where('folio', $this->desglose_folio)
                                            ->where('usuario', $this->desglose_usuario)
                                            ->first();

            if(!$this->tramite_desglose) throw new GeneralException('El trámite de desglose no existe.');

            if($this->tramite_desglose->servicio->categoria->nombre != 'Desglose de predios y valuación') throw new GeneralException('El trámite ingresado para desglose no corresponde a un desglose.');

            if($this->tramite_desglose->estado != 'pagado') throw new GeneralException('El trámite de desglose no esta pagado o ha sido concluido.');

            if($this->tramite_inspeccion->ligado_a && ($this->tramite_inspeccion->ligado_a != $this->tramite_desglose->id)) throw new GeneralException('El trámite de inspección ocular esta ligado a otro trámite.');

        }

        if($this->tramite_inspeccion->ligado_a && !$this->tramite_desglose) throw new GeneralException('El trámite de inspección ocular esta ligado a otro trámite.');

        $this->numero_avaluos = $this->registro_final - $this->registro_inicio + 1;

        if($this->registro_final == $this->registro_inicio) $this->numero_avaluos = 1;

        if($this->numero_avaluos < 0) throw new GeneralException('El registro inicial no puede ser mayor al registro final.');

    }

    public function buscarPredios(){

        if($this->avaluo_para != 6){

            $this->avaluos = Avaluo::withWhereHas('predioAvaluo', function($q){
                                    $q->where('localidad', $this->localidad)
                                        ->where('oficina', $this->oficina)
                                        ->where('tipo_predio', $this->tipo)
                                        ->whereBetween('numero_registro', [$this->registro_inicio, $this->registro_final])
                                        ->whereHas('avaluo', function($q){
                                            $q->where('estado', '!=', 'notificado');
                                        });
                                })
                                ->get();

            if($this->avaluos->count() == 0) throw new GeneralException('No se encontraron avaluos en el rango de cuentas prediales.');

            foreach($this->avaluos as $avaluo){

                $this->revisarAvaluoCompleto($avaluo);

                if($avaluo->asignado_a != auth()->id()) throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' esta asignado a otro valuador.');

            }

            $this->numero_avaluos = $this->avaluos->count();

            if(!auth()->user()->hasRole(['Convenio municipal'])){

                if(($this->numero_avaluos + $this->tramite_inspeccion->usados) > $this->tramite_inspeccion->cantidad)

                    throw new GeneralException('La cantidad de avaluos que avala el trámite de inspección ocular no es suficiente.');

            }

        }else{

            $this->avaluo_predio_ignorado = Avaluo::withWhereHas('predioAvaluo', function($q){
                                                $q->where('localidad', $this->localidad)
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
                                                    });
                                            })
                                            ->first();

            if(!$this->avaluo_predio_ignorado) throw new GeneralException('No se encontró el avalúo para la clave catastral.');

            if($this->avaluo_predio_ignorado->asignado_a != auth()->id()) throw new GeneralException('El avalúo: ' . $this->avaluo_predio_ignorado->año . '-' . $this->avaluo_predio_ignorado->folio . '-' . $this->avaluo_predio_ignorado->usuario . ' esta asignado a otro valuador.');

            $this->numero_avaluos = 1;

        }

    }

    public function revisarAvaluoCompleto(Avaluo $avaluo){

        $avaluo->predioAvaluo->load('colindancias');

        if($avaluo->predioAvaluo->colindancias->count() == 0)
            throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' no tiene colindancias.');

        if(!$avaluo->clasificacion_zona)
            throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' no tiene caracteristicas.');

        if(!$avaluo->predioAvaluo->uso_1)
            throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' no tiene uso de predio.');

        if($avaluo->predioAvaluo->edificio === 0 && $avaluo->predioAvaluo->terrenos->count() === 0)
            throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' no tiene terrenos.');

        if($avaluo->predioAvaluo->edificio !== 0 && $avaluo->predioAvaluo->terrenosComun->count() === 0)
            throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' no tiene terrenos en común.');

        if(!$avaluo->predioAvaluo->valor_catastral)
            throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' no tiene valor catastral.');

    }

    public function validaciones(){

        $this->validarTramites();

        $this->buscarPredios();

    }

    public function actualizarTramites(){

        $this->tramite_inspeccion->update([
            'usados' => $this->numero_avaluos + $this->tramite_inspeccion->usados,
            'ligado_a' => $this->tramite_desglose?->id
        ]);

        if($this->tramite_inspeccion->cantidad == $this->tramite_inspeccion->usados){

            $this->tramite_inspeccion->update(['estado' => 'concluido']);

        }

        if($this->tramite_desglose){

            $this->tramite_desglose->update([
                'usados' => $this->numero_avaluos + $this->tramite_desglose->usados,
                'ligado_a' => $this->tramite_inspeccion->id
            ]);

            if($this->tramite_desglose->cantidad == $this->tramite_desglose->usados)
                $this->tramite_desglose->update(['estado' => 'concluido']);

        }

    }

    public function imprimir(){

        $this->validate();

        try {

            $this->validaciones();

            $pdf = null;

            DB::transaction(function () use (&$pdf){

                foreach ($this->avaluos as $avaluo) {

                    $avaluo->update([
                        'tramite_inspeccion' => $this->tramite_inspeccion?->id,
                        'tramite_desglose' => $this->tramite_desglose?->id,
                        'actualizado_por' => auth()->id(),
                        'estado' => 'impreso'
                    ]);

                    $avaluo->predioAvaluo->update(['status' => 'impreso']);

                    $avaluo->audits()->latest()->first()->update(['tags' => 'Imprimió avalúo', 'tramite_id' => $this->tramite_inspeccion?->id]);

                }

                if(!auth()->user()->hasRole('Convenio municipal')) $this->actualizarTramites();

                $avaluo_ids = $this->avaluos->pluck('id');

                $pdf = (new CertificacionesController())->notifiacionValorCatastral($avaluo_ids, $this->tramite_inspeccion, $this->tramite_desglose);

            });

            $this->avaluo_para = null;

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'notificacion_de_valor_catastral.pdf'
            );


        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al imprimir notificación de avalúo usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        $this->oficina = auth()->user()->oficina->oficina;

        $this->lista_avaluo_para = AvaluoPara::cases();

        $this->inspeccion_año  = now()->format('Y');

        $this->desglose_año = now()->format('Y');

        $this->años = Constantes::AÑOS;

    }

    public function render()
    {
        return view('livewire.valuacion.impresion')->extends('layouts.admin');
    }
}

