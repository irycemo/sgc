<?php

namespace App\Http\Livewire\Valuacion;

use App\Models\User;
use App\Models\Oficina;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\PredioAvaluo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Valuacion\AvaluosController;

class Impresion extends Component
{

    public $tramiteInspeccion;
    public $tramiteAvaluo;
    public $formato;
    public $autoridad_municipal;
    public $localidad;
    public $oficina;
    public $tipo;
    public $registro_inicio;
    public $registro_final;
    public $director;
    public $jefe_departamento;
    public $notificador;
    public $valuadores;
    public $valuador;
    public $valuador_municipal;
    public $ciudad;
    public $hora;
    public $dia;
    public $mes;
    public $año;
    public $nombre;
    public $calidad;
    public $cantidad;

    protected function rules(){
        return [
            'tramiteInspeccion' => 'required',
            'tramiteAvaluo' => 'required',
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo' => 'required',
            'registro_inicio' => 'required',
            'registro_final' => 'required',
            'valuador' => 'required_if:formato,0',
            'notificador' => 'required_if:formato,0',
            'ciudad' => 'nullable',
            'hora' => 'nullable',
            'dia' => 'nullable',
            'año' => 'nullable',
            'mes' => 'nullable',
            'nombre' => 'nullable',
            'calidad' => 'nullable',
         ];
    }

    public function updatedLocalidad(){

        $this->updatedOficina();

    }

    public function updatedFormato(){

        if(!$this->formato)
            $this->oficina = 101;
        else{
            $this->oficina = auth()->user()->oficina;
        }

    }

    public function updatedOficina(){

        $this->validate(['localidad' => 'required','oficina' => 'required']);

        $oficina = Oficina::where('oficina', $this->oficina)->where('localidad', $this->localidad)->first();

        if(!$oficina){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Oficina incorrecta."]);

            return;

        }

        $this->autoridad_municipal = $oficina->autoridad_municipal;

        $this->valuador_municipal = $oficina->valuador_municipal;


    }

    public function imprimir(){

        $this->validate();

        $this->cantidad = $this->registro_final - $this->registro_inicio + 1;

        if($this->registro_final == $this->registro_inicio)
            $this->cantidad = 1;

        if($this->cantidad < 0){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El registro inicial no puede ser mayor al registro final."]);

            return;

        }

        $tramiteInspeccion  = Tramite::where('folio', $this->tramiteInspeccion)->first();

        if($tramiteInspeccion->estado != 'pagado'){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El trámite de inspección no esta pagado o ha sido concluido."]);

            return;

        }

        if(( $this->cantidad + $tramiteInspeccion->usados) > $tramiteInspeccion->cantidad){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La cantidad de inspecciones que avala el trámite ya se usó o es insuficiente."]);

            return;

        }

        $tramiteAvaluo = Tramite::where('folio', $this->tramiteAvaluo)->first();

        if($tramiteInspeccion->estado != 'pagado'){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El trámite de impresión no esta pagado o ha sido concluido."]);

            return;

        }

        if(( $this->cantidad + $tramiteAvaluo->usados) > $tramiteAvaluo->cantidad){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La cantidad de avaluos que avala el trámite ya se usó."]);

            return;

        }

        if($tramiteInspeccion->avaluo_para == 46 || $tramiteInspeccion->avaluo_para == 45){

            if($tramiteAvaluo->servicio_id != 46 && $tramiteAvaluo->servicio_id != 45){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El trámite de impresión no corresponde a una variación."]);

                return;

            }


        }elseif($tramiteInspeccion->avaluo_para == 43 || $tramiteInspeccion->avaluo_para == 44){

            if($tramiteAvaluo->servicio_id != 43 || $tramiteAvaluo->servicio_id != 44){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El trámite de impresión no corresponde a un desglose."]);

                return;

            }

        }elseif($tramiteInspeccion->avaluo_para == 47){

            if($tramiteAvaluo->servicio_id != 47){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El trámite de impresión no corresponde a un avlúo predio ignorado."]);

                return;

            }

        }

        $path = null;

        $predios = PredioAvaluo::with('avaluo', 'propietarios.persona', 'colindancias', 'terrenos', 'condominioTerrenos', 'condominioConstrucciones', 'construcciones')
                                        ->where('localidad', $this->localidad)
                                        ->where('oficina', $this->oficina)
                                        ->where('tipo_predio', $this->tipo)
                                        ->whereBetween('numero_registro', [$this->registro_inicio, $this->registro_final])
                                        ->get();

        if($predios->count() == 0){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "No se encontraron avaluos para el rango de cuentas prediales."]);

            return;

        }

        if($this->revisarAvaluosCompletos($predios))
            return;

        DB::transaction(function () use($tramiteInspeccion, $tramiteAvaluo, &$path, $predios){

            $tramiteInspeccion->update([
                            'usados' => $this->cantidad + $tramiteInspeccion->usados,
                            'parcial_usado' => $tramiteAvaluo->id
            ]);

            if($tramiteInspeccion->avaluo_para != null){

                $tramiteAvaluo->update([
                                    'usados' => $this->cantidad + $tramiteAvaluo->usados,
                                    'parcial_usado' => $tramiteAvaluo->id
                                    ]);
            }

            $path = (new AvaluosController())->imprime(
                                                        $predios,
                                                        $tramiteInspeccion,
                                                        $tramiteAvaluo,
                                                        $this->ciudad,
                                                        $this->hora,
                                                        $this->dia,
                                                        $this->mes,
                                                        $this->año,
                                                        $this->nombre,
                                                        $this->calidad,
                                                        $this->director,
                                                        $this->jefe_departamento,
                                                        $this->valuador,
                                                        $this->valuador_municipal,
                                                        $this->autoridad_municipal,
                                                    );

            foreach($predios as $predio){

                $predio->update(['status' => 'impreso']);

                $predio->avaluo->update(['tramite_id' => $tramiteInspeccion->id]);

            }

            if($tramiteInspeccion->cantidad == $tramiteInspeccion->usados)
                $tramiteInspeccion->update(['estado' => 'concluido']);

            if($tramiteAvaluo->cantidad == $tramiteAvaluo->usados)
                $tramiteAvaluo->update(['estado' => 'concluido']);

        });

        return response()->download(storage_path($path));

    }

    public function revisarAvaluosCompletos($predios){

        foreach($predios as $predio){

            if(!$predio->colindancias->count()){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El avaluo con folio: " . $predio->avaluo->folio . ", cuenta predial: " . $predio->localidad . "-" . $predio->oficina . "-" . $predio->tipo_predio . "-" . $predio->numero_registro . " no tiene colindancias."]);

                return true;

            }

            if(!$predio->avaluo->clasificacion_zona){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El avaluo con folio: " . $predio->avaluo->folio . ", cuenta predial: " . $predio->localidad . "-" . $predio->oficina . "-" . $predio->tipo_predio . "-" . $predio->numero_registro . " no tiene caracteristicas."]);

                return true;

            }

            if(!$predio->uso_1){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El avaluo con folio: " . $predio->avaluo->folio . ", cuenta predial: " . $predio->localidad . "-" . $predio->oficina . "-" . $predio->tipo_predio . "-" . $predio->numero_registro . " no tiene uso de predio."]);

                return true;

            }

            if(!$predio->terrenos->count()){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El avaluo con folio: " . $predio->avaluo->folio . ", cuenta predial: " . $predio->localidad . "-" . $predio->oficina . "-" . $predio->tipo_predio . "-" . $predio->numero_registro . " no tiene terrenos."]);

                return true;

            }

            if(!$predio->construcciones->count()){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El avaluo con folio: " . $predio->avaluo->folio . ", cuenta predial: " . $predio->localidad . "-" . $predio->oficina . "-" . $predio->tipo_predio . "-" . $predio->numero_registro . " no tiene construcciones."]);

                return true;

            }

            if($predio->edificio != 0 && !$predio->condominioTerrenos->count()){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El avaluo con folio: " . $predio->avaluo->folio . " no tiene terrenos de área común."]);

                return true;

            }

            if($predio->valor_catastral == null){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El avaluo con folio: " . $predio->avaluo->folio . " no tiene valor catastral."]);

                return true;

            }

        }

    }

    public function mount(){

        $this->oficina = auth()->user()->oficina;

        if($this->oficina != 101){

            $this->formato = 1;

        }

        $this->director = User::where('status', 'activo')
                                    ->whereHas('roles', function($q){
                                        $q->where('name', 'Director');
                                    })
                                    ->first();

        $this->director = $this->director->name . ' ' . $this->director->ap_paterno . ' ' . $this->director->ap_materno;

        $this->jefe_departamento = User::where('status', 'activo')
                                            ->whereHas('roles', function($q){
                                                $q->where('name', 'Jefe de departamento');
                                            })
                                            ->where('area', 'Departamento de Valuación')
                                            ->first();

        $this->jefe_departamento = $this->jefe_departamento->name . ' ' . $this->jefe_departamento->ap_paterno . ' ' . $this->jefe_departamento->ap_materno;

        $this->notificador = "Temo";

        $this->valuadores = User::where('status', 'activo')
                                    ->where('valuador', 1)
                                    ->orderBy('name')
                                    ->get();

    }

    public function render()
    {
        return view('livewire.valuacion.impresion')->extends('layouts.admin');
    }
}
