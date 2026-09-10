<?php

namespace App\Livewire\Valuacion\ConvenioMunicipal;

use App\Constantes\Constantes;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Certificaciones\NotificacionValorCatastralController;
use App\Jobs\Certificaciones\GenerarImagenVerificacionJob;
use App\Models\Avaluo;
use App\Models\Certificacion;
use App\Models\Predio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Impresion extends Component
{

    public $predios_cuentas = [];
    public $localidad;
    public $oficina;
    public $tipo;
    public $registro_inicio;
    public $registro_final;
    public $avaluos;

    protected function rules(){
        return [
            'localidad' => 'required',
            'tipo' => 'required',
            'registro_inicio' => ['required', 'lte:registro_final'],
            'registro_final' => ['required', 'gte:registro_inicio'],
            'predios_cuentas.*.localidad' => 'localidad',
            'predios_cuentas.*.oficina' => 'oficina',
            'predios_cuentas.*.tipo_predio' => 'tipo de predio',
            'predios_cuentas.*.numero_registro' => 'número de registro',
         ];
    }

    public function agregarPredio(){

        $this->predios_cuentas[] = ['localidad' => $this->localidad, 'oficina' => $this->oficina, 'tipo_predio' => $this->tipo, 'numero_registro' => null];

    }

    public function borrarPredio($index){

        unset($this->predios_cuentas[$index]);

        $this->predios_cuentas = array_values($this->predios_cuentas);

    }

    public function buscarPredios(){

        $this->avaluos = Avaluo::withWhereHas('predioAvaluo', function($q){
                                $q->where('localidad', $this->localidad)
                                    ->where('oficina', $this->oficina)
                                    ->where('tipo_predio', $this->tipo)
                                    ->whereBetween('numero_registro', [$this->registro_inicio, $this->registro_final]);
                            })
                            ->where('estado', '!=', 'notificado')
                            ->get();

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

        }

    }

    public function revisarAvaluoCompleto(Avaluo $avaluo){

        $avaluo->predioAvaluo->load('colindancias', 'terrenos', 'terrenosComun', 'propietarios');

        if($avaluo->predioAvaluo->propietarios->count() == 0)
            throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' no tiene propietarios.');

        if($avaluo->predioAvaluo->colindancias->count() == 0)
            throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' no tiene colindancias.');

        if(!$avaluo->predioAvaluo->tipo_asentamiento)
            throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' no tiene información de ubicación completa.');

        if(!$avaluo->clasificacion_zona)
            throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' no tiene caracteristicas.');

        if(!$avaluo->predioAvaluo->valor_catastral)
            throw new GeneralException('El avalúo: ' . $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' del predio: ' . $avaluo->predioAvaluo->cuentaPredial() . ' no tiene valor catastral.');

    }

    public function imprimir(){

        $this->validate();

        try {

            $this->buscarPredios();

            $pdf = retry(5, function() {

                return DB::transaction(function (){

                    foreach ($this->avaluos as $avaluo) {

                        $avaluo->update([
                            'actualizado_por' => auth()->id(),
                            'estado' => 'impreso'
                        ]);

                        $predio_padron = Predio::where('localidad', $avaluo->predioAvaluo->localidad)
                                                    ->where('oficina', $avaluo->predioAvaluo->oficina)
                                                    ->where('tipo_predio', $avaluo->predioAvaluo->tipo_predio)
                                                    ->where('numero_registro', $avaluo->predioAvaluo->numero_registro)
                                                    ->first();

                        if(! $predio_padron){

                            throw new GeneralException('El predio del avalúo: '. $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . ' no esxiste en el padrón. El predio debe existir en el padrón para trámites de avalúo de actualización.');

                        }

                        $avaluo->predioAvaluo->update(['status' => 'impreso']);

                        $avaluo->audits()->latest()->first()?->update(['tags' => 'Imprimió avalúo']);

                    }

                    $avaluo_ids = $this->avaluos->pluck('id');

                    return (new NotificacionValorCatastralController())->general($avaluo_ids, null);

                });

            });

            $certificacion = Certificacion::where('creado_por', auth()->id())->where('estado', 'activo')->latest()->first();

            GenerarImagenVerificacionJob::dispatch($certificacion->id);

            $this->reset([
                'predios_cuentas',
                'localidad',
                'oficina',
                'tipo',
                'registro_inicio',
                'registro_final',
                'avaluos',
            ]);

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'notificacion_de_valor_catastral.pdf'
            );

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al imprimir notificación de avalúo usuario covenio municipal por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        $this->oficina = auth()->user()->oficina->oficina;

    }

    public function render()
    {
        return view('livewire.valuacion.convenio-municipal.impresion')->extends('layouts.admin');
    }

}
