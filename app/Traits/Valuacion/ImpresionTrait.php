<?php

namespace App\Traits\Valuacion;

use App\Models\Avaluo;
use App\Models\Predio;
use App\Models\Oficina;
use App\Models\Tramite;
use Livewire\Attributes\On;
use App\Enums\Tramites\AvaluoPara;
use App\Exceptions\GeneralException;

trait ImpresionTrait
{

    public int|null $avaluo_para;
    public $lista_avaluo_para;

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
    public $numero_registro;
    public $municipio;
    public $sector;
    public $zona_catastral;
    public $manzana;
    public $predio;
    public $edificio;
    public $departamento;

    public $predios_cuentas = [];
    public $predios_fusionantes;

    protected $validationAttributes  = [
        'predios_cuentas.*.localidad' => 'localidad',
        'predios_cuentas.*.oficina' => 'oficina',
        'predios_cuentas.*.tipo_predio' => 'tipo de predio',
        'predios_cuentas.*.numero_registro' => 'número de registro',
    ];

    #[On('changeAvaluoPara')]
    public function changeAvaluoPara($value){

        $this->avaluo_para = $value;

    }

    public function resetarTodo(){

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
            'predios_cuentas'
        ]);

        $this->inspeccion_año  = now()->format('Y');

        $this->desglose_año = now()->format('Y');

        $this->dispatch('resetAvaluoPara');

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

        /* Desgloses */
        if(in_array($this->avaluo_para, [3, 4, 5, 9])){

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

        $this->numero_avaluos = $this->registro_final - $this->registro_inicio + 1 + count($this->predios_cuentas);

        if($this->registro_final == $this->registro_inicio) $this->numero_avaluos = 1;

        if($this->numero_avaluos < 0) throw new GeneralException('El registro inicial no puede ser mayor al registro final.');

    }

    public function validarPredio(){

        if(!$this->predio_padre){

            throw new GeneralException('El predio origen no existe.');

        }

        if($this->predio_padre->status != 'activo'){

            throw new GeneralException('El predio origen no esta activo.');

        }

        if(!$this->predio_padre->superficie_notarial){

            throw new GeneralException('El predio origen no tiene superficie notarial.');

        }

    }

    public function validarPredioPadre(){

        $this->validarPredio();

        $superficie_terreno = 0;

        foreach ($this->avaluos as $avaluo) {

            if($avaluo->predioAvaluo->numero_registro == $this->predio_padre->numero_registro) continue;

            $superficie_terreno += $avaluo->predioAvaluo->superficie_total_terreno;

        }

        if($this->predio_padre->superficie_notarial < $superficie_terreno){

            throw new GeneralException('La suma de la superfice de terreno de los avalúos es mayor a la superficie del predio padre.');

        }

        if($this->tramite_inspeccion->predios()->count()){

            $predio = $this->tramite_inspeccion->predios()->first();

            if($this->predio_padre->id != $predio->id){

                throw new GeneralException('El trámite de inspección tiene asociado un predio origen diferente.');

            }

        }

    }

    public function buscarPredios(){

        if($this->avaluo_para != AvaluoPara::PREDIO_IGNORADO->value){

            $this->avaluos = Avaluo::withWhereHas('predioAvaluo', function($q){
                                    $q->where('localidad', $this->localidad)
                                        ->where('oficina', $this->oficina)
                                        ->where('tipo_predio', $this->tipo)
                                        ->whereBetween('numero_registro', [$this->registro_inicio, $this->registro_final]);
                                })
                                ->where('estado', '!=', 'notificado')
                                ->get();

            if(in_array($this->avaluo_para, [3, 4, 5, 9])){

                $this->predio_padre = Predio::where('localidad', $this->localidad)
                                        ->where('oficina', $this->oficina)
                                        ->where('tipo_predio', $this->tipo)
                                        ->where('numero_registro', $this->registro_padre)
                                        ->first();

                $this->validarPredioPadre();

                $avaluo_predio_padre = Avaluo::with('predioAvaluo')->where('estado', '!=', 'notificado')->where('predio', $this->predio_padre->id)->get();

                $this->avaluos = $this->avaluos->merge($avaluo_predio_padre);

            }

            if(count($this->predios_cuentas)){

                $avaluos_extra = Avaluo::withWhereHas('predioAvaluo', function($q){
                                        $q->where('localidad', $this->localidad)
                                            ->where('oficina', $this->oficina)
                                            ->where('tipo_predio', $this->tipo)
                                            ->whereIn('numero_registro', collect($this->predios_cuentas)->pluck('numero_registro'))
                                            ->whereHas('avaluo', function($q){
                                                $q->where('estado', '!=', 'notificado');
                                            });
                                    })
                                    ->get();

                $this->avaluos = $this->avaluos->merge($avaluos_extra);

            }

            if($this->avaluos->count() == 0) throw new GeneralException('No se encontraron avalúos en el rango de cuentas prediales.');

            foreach($this->avaluos as $avaluo){

                $this->revisarAvaluoCompleto($avaluo);

                if($avaluo->asignado_a != auth()->id()) throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' esta asignado a otro valuador.');

            }

            $this->numero_avaluos = $this->avaluos->count();

            if(!auth()->user()->hasRole(['Convenio municipal'])){

                if(in_array($this->avaluo_para, [3, 4, 5])){

                    $this->numero_avaluos --;

                    if(($this->numero_avaluos + $this->tramite_desglose->usados) > $this->tramite_desglose->cantidad){

                        throw new GeneralException('La cantidad de avalúos que avala el trámite de desglose ocular no es suficiente.');

                    }

                }

                if($this->avaluo_para !== AvaluoPara::FUSION->value){

                    if(($this->numero_avaluos + $this->tramite_inspeccion->usados) > $this->tramite_inspeccion->cantidad){

                        throw new GeneralException('La cantidad de avalúos que avala el trámite de inspección ocular no es suficiente.');

                    }

                }

            }

        }else{

             $this->avaluos = Avaluo::where('estado', '!=', 'notificado')
                                    ->withWhereHas('predioAvaluo', function($q){
                                        $q->where('localidad', $this->localidad)
                                            ->where('oficina', $this->oficina)
                                            ->where('tipo_predio', $this->tipo)
                                            ->where('numero_registro', $this->numero_registro);
                                    })
                                    ->get();

            $this->avaluo_predio_ignorado = $this->avaluos->first();

            if(!$this->avaluo_predio_ignorado) throw new GeneralException('No se encontró el avalúo para la cuenta predial.');

            if($this->avaluo_predio_ignorado->asignado_a != auth()->id()) throw new GeneralException('El avalúo: ' . $this->avaluo_predio_ignorado->año . '-' . $this->avaluo_predio_ignorado->folio . '-' . $this->avaluo_predio_ignorado->usuario . ' esta asignado a otro valuador.');

            $this->numero_avaluos = 1;

        }

    }

    public function revisarAvaluoCompleto(Avaluo $avaluo){

        $avaluo->predioAvaluo->load('colindancias', 'terrenos', 'terrenosComun', 'propietarios');

        if($avaluo->predioAvaluo->propietarios->count() == 0)
            throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' no tiene propietarios.');

        if($avaluo->predioAvaluo->colindancias->count() == 0)
            throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' no tiene colindancias.');

        if(!$avaluo->clasificacion_zona)
            throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' no tiene caracteristicas.');

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

        if($this->tramite_desglose){

            $this->tramite_desglose->update([
                'usados' => $this->numero_avaluos + $this->tramite_desglose->usados,
                'ligado_a' => $this->tramite_inspeccion->id
            ]);

            if($this->tramite_desglose->cantidad == $this->tramite_desglose->usados)
                $this->tramite_desglose->update(['estado' => 'concluido']);

        }

        $this->tramite_inspeccion->update([
            'usados' => $this->numero_avaluos + $this->tramite_inspeccion->usados,
            'ligado_a' => $this->tramite_desglose?->id
        ]);

        if($this->tramite_inspeccion->usados >= $this->tramite_inspeccion->cantidad){

            $this->tramite_inspeccion->update(['estado' => 'concluido']);

        }

    }

    public function agregarPredio(){

        $this->predios_cuentas[] = ['localidad' => $this->localidad, 'oficina' => $this->oficina, 'tipo_predio' => $this->tipo, 'numero_registro' => null];

    }

    public function borrarPredio($index){

        unset($this->predios_cuentas[$index]);

        $this->predios_cuentas = array_values($this->predios_cuentas);

    }

}
