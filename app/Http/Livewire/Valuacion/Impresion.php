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
    public $folioInspeccion;
    public $tramiteAvaluo;
    public $folioAvaluo;
    public $autoridad_municipal;
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
    public $director;
    public $jefe_departamento;
    public $notificador;
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
            'folioInspeccion' => 'required',
            'folioAvaluo' => 'nullable',
            'valuador_municipal' => 'nullable',
            'notificador' => 'nullable',
            'ciudad' => 'nullable',
            'hora' => 'nullable',
            'dia' => 'nullable',
            'mes' => 'nullable',
            'año' => 'nullable',
            'nombre' => 'nullable',
            'calidad' => 'nullable',
            'cantidad' => 'nullable',
         ];
    }

    protected $validationAttributes  = [
        'tramiteInspeccion' => 'trámte de inspección'
    ];

    public function updatedLocalidad(){

        $this->updatedOficina();

    }

    public function updatedOficina(){

        $this->validate(['localidad' => 'required','oficina' => 'required']);

        $oficina = Oficina::where('oficina', $this->oficina)->where('localidad', $this->localidad)->first();

        if(!$oficina){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La localidad no correspoonde a la oficina."]);

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

    public function validaciones(){

        if(!auth()->user()->hasRole('Convenio municipal')){

            $this->tramiteInspeccion  = Tramite::where('folio', $this->folioInspeccion)->first();

            if($this->tramiteInspeccion && $this->tramiteInspeccion->estado != 'pagado'){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El trámite de inspección no esta pagado o ha sido concluido."]);

                return true;

            }

            if(( $this->cantidad + $this->tramiteInspeccion->usados) > $this->tramiteInspeccion->cantidad){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La cantidad de inspecciones que avala el trámite ya se usó o es insuficiente."]);

                return true;

            }

            if($this->tramiteInspeccion->avaluo_para){

                $this->tramiteAvaluo = Tramite::where('folio', $this->folioAvaluo)->first();

                if($this->tramiteAvaluo && $this->tramiteInspeccion->estado != 'pagado'){

                    $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El trámite de impresión no esta pagado o ha sido concluido."]);

                    return true;

                }

                if(( $this->cantidad + $this->tramiteAvaluo->usados) > $this->tramiteAvaluo->cantidad){

                    $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La cantidad de avaluos que avala el trámite ya se usó."]);

                    return true;

                }

                if($this->tramiteInspeccion->avaluo_para == 46 || $this->tramiteInspeccion->avaluo_para == 45){

                    if($this->tramiteAvaluo->servicio_id != 46 && $this->tramiteAvaluo->servicio_id != 45){

                        $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El trámite de impresión no corresponde a una variación."]);

                        return true;

                    }


                }elseif($this->tramiteInspeccion->avaluo_para == 43 || $this->tramiteInspeccion->avaluo_para == 44){

                    if($this->tramiteAvaluo->servicio_id != 43 && $this->tramiteAvaluo->servicio_id != 44){

                        $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El trámite de impresión no corresponde a un desglose."]);

                        return true;

                    }

                }elseif($this->tramiteInspeccion->avaluo_para == 47){

                    if($this->tramiteAvaluo->servicio_id != 47){

                        $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El trámite de impresión no corresponde a un avlúo predio ignorado."]);

                        return true;

                    }

                }

            }else{

                $this->tramiteAvaluo = 0;

            }

        }else{

            $this->tramiteInspeccion = 'Convenio municipal';

            $this->tramiteAvaluo = 'Convenio municipal';

        }

    }

    public function actualizarTramites(){

        $this->tramiteInspeccion  = Tramite::where('folio', $this->folioInspeccion)->first();

        if($this->tramiteInspeccion){

            if($this->tramiteInspeccion->avaluo_para != null){

                $this->tramiteAvaluo = Tramite::where('folio', $this->folioAvaluo)->first();

                $this->tramiteAvaluo->update([
                                    'usados' => $this->cantidad + $this->tramiteAvaluo->usados,
                                    'parcial_usado' => $this->tramiteInspeccion->id
                                    ]);

                $this->tramiteInspeccion->update([
                    'usados' => $this->cantidad + $this->tramiteInspeccion->usados,
                    'parcial_usado' => $this->tramiteAvaluo->id
                ]);

                if($this->tramiteAvaluo->cantidad == $this->tramiteAvaluo->usados)
                    $this->tramiteAvaluo->update(['estado' => 'concluido']);

                if($this->tramiteInspeccion->cantidad == $this->tramiteInspeccion->usados)
                    $this->tramiteInspeccion->update(['estado' => 'concluido']);

            }else{

                $this->tramiteInspeccion->update([
                    'usados' => $this->cantidad + $this->tramiteInspeccion->usados,
                ]);

                $this->tramiteInspeccion->refresh();

                if($this->tramiteInspeccion->cantidad == $this->tramiteInspeccion->usados)
                    $this->tramiteInspeccion->update(['estado' => 'concluido']);

            }

        }

    }

    public function resetCuentaPredial(){

        $this->reset(['tipo', 'registro_inicio', 'registro_final']);

    }

    public function resetClaveCatastral(){

        $this->reset(['region_catastral', 'municipio', 'zona_catastral', 'sector', 'manzana', 'predio', 'edificio', 'departamento']);

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

        if($this->validaciones())
            return;

        if($this->region_catastral || $this->municipio || $this->zona_catastral || $this->sector || $this->manzana || $this->predio || $this->edificio || $this->departamento){

            $this->validate([
                'director' => 'required',
                'jefe_departamento' => 'required',
                'tramiteInspeccion' => 'required',
                'tramiteAvaluo' => 'nullable',
                'localidad' => 'required',
                'region_catastral' => 'required',
                'municipio' => 'required',
                'zona_catastral' => 'required',
                'sector' => 'required',
                'valuador' => 'required',
                'notificador' => 'required',
                'manzana' => 'nullable',
                'predio' => 'nullable',
                'edificio' => 'nullable',
                'departamento' => 'nullable',
            ]);

            $predios = PredioAvaluo::with('avaluo', 'propietarios.persona', 'colindancias', 'terrenos', 'condominioTerrenos', 'condominioConstrucciones', 'construcciones')
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

            if($predios->count() == 0){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "No se encontraron avaluos para la clave catastral."]);

                return;

            }

        }else{

            $this->validate([
                'director' => 'required',
                'jefe_departamento' => 'required',
                'tramiteInspeccion' => 'required',
                'tramiteAvaluo' => 'nullable',
                'localidad' => 'required',
                'oficina' => 'required',
                'tipo' => 'required',
                'registro_inicio' => 'required',
                'registro_final' => 'required',
            ]);

            $predios = PredioAvaluo::with('avaluo', 'propietarios.persona', 'colindancias', 'terrenos', 'condominioTerrenos', 'condominioConstrucciones', 'construcciones')
                                        ->where('localidad', $this->localidad)
                                        ->where('oficina', $this->oficina)
                                        ->where('tipo_predio', $this->tipo)
                                        ->whereBetween('numero_registro', [$this->registro_inicio, $this->registro_final])
                                        ->whereHas('avaluo', function($q){
                                            $q->where('estado', '!=', 'notificado');
                                        })
                                        ->get();

            if($predios->count() == 0){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "No se encontraron avaluos para el rango de cuentas prediales."]);

                return;

            }

        }

        if($this->revisarAvaluosCompletos($predios))
            return;

        $path = null;

        DB::transaction(function () use(&$path, $predios){

            $path = (new AvaluosController())->imprime(
                                                        $predios,
                                                        $this->tramiteInspeccion,
                                                        $this->tramiteAvaluo,
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

                $predio->avaluo->update([
                            'tramite_id' => $this->tramiteInspeccion->id,
                            'estado' => 'impreso'
                        ]);

                $predio->avaluo->audits()->latest()->first()->update(['tags' => 'Imprimio avalúo']);

            }

            if(!auth()->user()->hasRole('Convenio municipal')){

                $this->actualizarTramites();

            }

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

            /* if(!$predio->terrenos->count()){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "El avaluo con folio: " . $predio->avaluo->folio . ", cuenta predial: " . $predio->localidad . "-" . $predio->oficina . "-" . $predio->tipo_predio . "-" . $predio->numero_registro . " no tiene terrenos."]);

                return true;

            } */

            if($predio->edificio != 0 && $predio->condominioTerrenos->count() == 0){

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

        $this->oficina = auth()->user()->oficina->oficina;

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

        $this->valuador = auth()->user()->name;

    }

    public function render()
    {
        return view('livewire.valuacion.impresion')->extends('layouts.admin');
    }
}
