<?php

namespace App\Livewire\GestionCatastral\RevisionTraslados;

use Exception;
use App\Models\Persona;
use Livewire\Component;
use App\Models\Traslado;
use Illuminate\Support\Facades\DB;
use App\Http\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class RevisarTraslado extends Component
{

    public Traslado $traslado;

    public $aviso;

    public $avaluo;

    public $rechazos;
    public $rechazo;
    public $observaciones;
    public $modalRechazar = false;
    public $modalAutorizar = false;
    public $modalOperar = false;

    public $transmitentes = [];

    public function seleccionarMotivo($key){

        $this->rechazo['key'] = $key;
        $this->rechazo['value'] = $this->rechazos[$key];

    }

    public function updatedTransmitentes($value, $index){

        $i = explode('.', $index);

        if($this->transmitentes[$i[0]][$i[1]] == ''){

            $this->transmitentes[$i[0]][$i[1]] = 0;

        }

    }

    public function rechazarTraslado(){

        $this->validate(['observaciones' => 'required']);

        try {

            $response = Http::acceptJson()
                                ->withToken(env('SISTEMA_TRAMITES_EN_LINEA_TOKEN'))
                                ->withQueryParameters([
                                    'oficina_sgc' => auth()->user()->oficina->oficina,
                                    'aviso_id' => $this->traslado->aviso_stl,
                                    'entidad_id' => $this->traslado->entidad_stl,
                                    'observacion' => "<p>" . $this->rechazo['key'] . "</p><p>Observaciones:</p><p>" . $this->observaciones . "</p>"
                                ])
                                ->get(env('SISTEMA_TRAMITES_EN_LINEA_RECHAZAR_AVISO'));

            if($response->status() === 200){

                $this->traslado->update(['estado' => 'rechazado', 'actualizado_por' => auth()->id()]);

                $this->traslado->audits()->latest()->first()->update(['tags' => 'Rechazó traslado']);

                return redirect()->route('revision_traslados');

            }else{

                $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

                return true;

            }

        } catch (\Throwable $th) {

            Log::error("Error al rechazar aviso en Sistema de Trámties en línea por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function autorizarTraslado(){

        $this->validate(['observaciones' => 'nullable']);

        try {

            $response = Http::acceptJson()
                                ->withToken(env('SISTEMA_TRAMITES_EN_LINEA_TOKEN'))
                                ->withQueryParameters([
                                    'aviso_id' => $this->traslado->aviso_stl,
                                    'observaciones' => $this->observaciones
                                ])
                                ->get(env('SISTEMA_TRAMITES_EN_LINEA_AUTORIZAR_AVISO'));

            if($response->status() === 200){

                $this->traslado->update(['estado' => 'autorizado', 'actualizado_por' => auth()->id()]);

                $this->traslado->audits()->latest()->first()->update(['tags' => 'Autorizó traslado']);

                return redirect()->route('revision_traslados');

            }else{

                $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

                return true;

            }

        } catch (\Throwable $th) {

            Log::error("Error al autorizar aviso en Sistema de Trámties en línea por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function operarTraslado(){

        try {

            $this->revisarProcentajes();

            DB::transaction(function () {


                $response = Http::acceptJson()
                                    ->withToken(env('SISTEMA_PERITOS_EXTERNOS_TOKEN'))
                                    ->withQueryParameters([
                                        'id' => $this->traslado->avaluo_spe
                                    ])
                                    ->get(env('SISTEMA_PERITOS_EXTERNOS_OPERAR_AVALUO'));

                if($response->status() === 200){

                    $response = Http::acceptJson()
                                    ->withToken(env('SISTEMA_TRAMITES_EN_LINEA_TOKEN'))
                                    ->withQueryParameters([
                                        'aviso_id' => $this->traslado->aviso_stl
                                    ])
                                    ->get(env('SISTEMA_TRAMITES_EN_LINEA_OPERAR_AVISO'));

                    if($response->status() === 200){

                        $this->actualizarPredio();

                        $this->traslado->update(['estado' => 'operado', 'actualizado_por' => auth()->id()]);

                        $this->traslado->audits()->latest()->first()->update(['tags' => 'Operó traslado']);

                        return redirect()->route('revision_traslados');

                    }else{

                        $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

                        return true;

                    }

                }else{

                    $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

                    return true;

                }

            });

        } catch (\Exception $th) {

            Log::error("Error al operar traslado: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', $th->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al operar traslado: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function actualizarPredio(){

        $this->traslado->predio->update([
            'codigo_postal' => $this->aviso['codigo_postal'] ?? null,
            'nombre_asentamiento' => $this->aviso['nombre_asentamiento']  ?? null,
            'tipo_asentamiento' => $this->aviso['tipo_asentamiento']  ?? null,
            'nombre_vialidad' => $this->aviso['nombre_vialidad']  ?? null,
            'tipo_vialidad' => $this->aviso['tipo_vialidad']  ?? null,
            'numero_exterior' => $this->aviso['numero_exterior']  ?? null,
            'numero_exterior_2' => $this->aviso['numero_exterior_2']  ?? null,
            'numero_interior' => $this->aviso['numero_interior']  ?? null,
            'numero_adicional' => $this->aviso['numero_adicional']  ?? null,
            'numero_adicional_2' => $this->aviso['numero_adicional_2']  ?? null,
            'numero_interior' => $this->aviso['numero_interior']  ?? null,
            'lote_fraccionador' => $this->aviso['lote_fraccionador']  ?? null,
            'manzana_fraccionador' => $this->aviso['manzana_fraccionador']  ?? null,
            'etapa_fraccionador' => $this->aviso['etapa_fraccionador']  ?? null,
            'nombre_predio' => $this->aviso['nombre_predio']  ?? null,
            'nombre_edificio' => $this->aviso['nombre_edificio']  ?? null,
            'clave_edificio' => $this->aviso['clave_edificio']  ?? null,
            'departamento_edificio' => $this->aviso['departamento_edificio']  ?? null,
            'xutm' => $this->aviso['xutm']  ?? null,
            'yutm' => $this->aviso['yutm']  ?? null,
            'zutm' => $this->aviso['zutm']  ?? null,
            'lon' => $this->aviso['lon']  ?? null,
            'lat' => $this->aviso['lat']  ?? null,
            'uso_1' => $this->avaluo['uso_1']  ?? null,
            'uso_2' => $this->avaluo['uso_2']  ?? null,
            'uso_3' => $this->avaluo['uso_3']  ?? null,
            'superficie_terreno' => $this->avaluo['superficie_terreno']  ?? null,
            'superficie_construccion' => $this->avaluo['superficie_construccion']  ?? null,
            'area_comun_terreno' => $this->avaluo['area_comun_terreno']  ?? null,
            'area_comun_construccion' => $this->avaluo['area_comun_construccion']  ?? null,
            'valor_total_terreno' => $this->avaluo['valor_total_terreno']  ?? null,
            'valor_total_construccion' => $this->avaluo['valor_total_construccion']  ?? null,
            'valor_catastral' => $this->aviso['valor_catastral']  ?? null,
        ]);

        $this->traslado->predio->audits()->latest()->first()->update(['tags' => 'Actualizó mediante traslado de dominio']);

        $this->traslado->predio->colindancias()->delete();

        foreach($this->aviso['colindancias'] as $colindancia){

            $this->traslado->predio->colindancias()->create([
                'viento' => $colindancia['viento'],
                'longitud' => $colindancia['longitud'],
                'descripcion' => $colindancia['descripcion'],
            ]);

        }

        $this->traslado->predio->terrenos()->delete();

        foreach($this->avaluo['terrenos'] as $terreno){

            $this->traslado->predio->terrenos()->create([
                'superficie' => $terreno['superficie'],
                'demerito' => $terreno['demerito'],
                'valor_demeritado' => $terreno['valor_demeritado'],
                'valor_unitario' => $terreno['valor_unitario'],
                'valor_terreno' => $terreno['valor_terreno'],
                'valor_terreno' => $terreno['valor_terreno'],
            ]);

        }

        $this->traslado->predio->construcciones()->delete();

        foreach($this->avaluo['construcciones'] as $construccion){

            $this->traslado->predio->construcciones()->create([
                'referencia' => $construccion['referencia'],
                'tipo' => $construccion['tipo'],
                'uso' => $construccion['uso'],
                'estado' => $construccion['estado'],
                'calidad' => $construccion['calidad'],
                'niveles' => $construccion['niveles'],
                'superficie' => $construccion['superficie'],
                'valor_unitario' => $construccion['valor_unitario'],
                'valor_construccion' => $construccion['valor_construccion'] ?? 0,
            ]);

        }

        $this->traslado->predio->condominioTerrenos()->delete();

        foreach($this->avaluo['terrenos_comun'] as $terrenoComun){

            $this->traslado->predio->condominioTerrenos()->create([
                'area_terreno_comun' => $terrenoComun['area_terreno_comun'],
                'indiviso_terreno' => $terrenoComun['indiviso_terreno'],
                'valor_unitario' => $terrenoComun['valor_unitario'],
                'valor_terreno_comun' => $terrenoComun['valor_terreno_comun']
            ]);

        }

        $this->traslado->predio->condominioConstrucciones()->delete();

        foreach($this->avaluo['construcciones_comun'] as $construccionComun){

            $this->traslado->predio->condominioConstrucciones()->create([
                'area_comun_construccion' => $construccionComun['area_comun_construccion'],
                'indiviso_construccion' => $construccionComun['indiviso_construccion'],
                'valor_clasificacion_construccion' => $construccionComun['valor_clasificacion_construccion'],
                'valor_construccion_comun' => $construccionComun['valor_construccion_comun']
            ]);

        }

        $this->traslado->predio->movimientos()->create([
            'nombre' => $this->aviso['acto'],
            'fecha' => now()->toDateString(),
            'descripcion' => 'Se actualiza predio mediante aviso.',
            'creado_por' => auth()->id()
        ]);

        foreach($this->transmitentes as $propietario){

            if($propietario['porcentaje'] == 0 && $propietario['porcentaje_nuda'] == 0 && $propietario['porcentaje_usufructo'] == 0){

                $this->traslado->predio->propietarios()->whereHas('persona', function($q) use($propietario){
                                                                                $q->where('nombre', $propietario['nombre'])
                                                                                    ->where('ap_paterno', $propietario['ap_paterno'])
                                                                                    ->where('ap_materno', $propietario['ap_materno'])
                                                                                    ->where('razon_social', $propietario['razon_social']);
                                                                                })
                                                                                ->delete();

            }else{

                 $aux = $this->traslado->predio->propietarios()->whereHas('persona', function($q) use($propietario){
                                                                                    $q->where('nombre', $propietario['nombre'])
                                                                                        ->where('ap_paterno', $propietario['ap_paterno'])
                                                                                        ->where('ap_materno', $propietario['ap_materno'])
                                                                                        ->where('razon_social', $propietario['razon_social']);
                                                                                    })
                                                                                    ->first();

                $aux->update([
                    'porcentaje' => $propietario['porcentaje'],
                    'porcentaje_nuda' => $propietario['porcentaje_nuda'],
                    'porcentaje_usufructo' => $propietario['porcentaje_usufructo'],
                ]);

            }

        }

        foreach($this->aviso['adquirientes'] as $adquiriente){

            $persona = Persona::where('nombre', $adquiriente['nombre'])
                                ->where('ap_paterno', $adquiriente['ap_paterno'])
                                ->where('ap_materno', $adquiriente['ap_materno'])
                                ->where('razon_social', $adquiriente['razon_social'])
                                ->where('rfc', $adquiriente['rfc'])
                                ->where('curp', $adquiriente['curp'])
                                ->first();

            if(!$persona){

                $persona = Persona::create([
                    'tipo' =>  $adquiriente['tipo_persona'],
                    'nombre' => $adquiriente['nombre'],
                    'ap_paterno' => $adquiriente['ap_paterno'],
                    'ap_materno' => $adquiriente['ap_materno'],
                    'razon_social' => $adquiriente['razon_social'],
                    'rfc' => $adquiriente['rfc'],
                    'curp' => $adquiriente['curp'],
                    'nombre' => $adquiriente['nombre'],
                    'fecha_nacimiento' => $adquiriente['fecha_nacimiento'],
                    'nacionalidad' => $adquiriente['nacionalidad'],
                    'estado_civil' => $adquiriente['estado_civil'],
                    'calle' => $adquiriente['calle'],
                    'numero_exterior' => $adquiriente['numero_exterior'],
                    'numero_interior' => $adquiriente['numero_interior'],
                    'colonia' => $adquiriente['colonia'],
                    'cp' => $adquiriente['cp'],
                    'entidad' => $adquiriente['entidad'],
                    'municipio' => $adquiriente['municipio'],
                    'ciudad' => $adquiriente['ciudad'],
                ]);

            }

            $this->traslado->predio->propietarios()->create([
                'persona_id' => $persona->id,
                'tipo' => 'PROPIETARIO',
                'porcentaje' => $adquiriente['porcentaje'],
                'porcentaje_nuda' => $adquiriente['porcentaje_nuda'],
                'porcentaje_usufructo' => $adquiriente['porcentaje_usufructo'],
                'creado_por' => auth()->id()
            ]);

        }

    }

    public function revisarProcentajes(){

        $pn_adquirientes = 0;

        $pn_transmitentes = 0;

        $pu_adquirientes = 0;

        $pu_transmitentes = 0;

        $pp_adquirientes = 0;

        $pp_transmitentes = 0;

        $pu = 0;

        $pp = 0;

        $pn = 0;

        foreach($this->aviso['adquirientes'] as $adquiriente){

            $pn_adquirientes = $pn_adquirientes + $adquiriente['porcentaje_nuda'];

            $pu_adquirientes = $pu_adquirientes + $adquiriente['porcentaje_usufructo'];

            $pp_adquirientes = $pp_adquirientes + $adquiriente['porcentaje'];

        }

        foreach($this->aviso['transmitentes'] as $transmitente){

            $pn_transmitentes = $pn_transmitentes + $transmitente['porcentaje_nuda'];

            $pu_transmitentes = $pu_transmitentes + $transmitente['porcentaje_usufructo'];

            $pp_transmitentes = $pp_transmitentes + $transmitente['porcentaje'];

        }

        foreach($this->transmitentes as $transmitente){

            $pn = $pn + floatval($transmitente['porcentaje_nuda']);

            $pu = $pu + floatval($transmitente['porcentaje_usufructo']);

            $pp = $pp + floatval($transmitente['porcentaje']);

        }

        dd($pp_adquirientes, $pp,  $pp_transmitentes, $pn_adquirientes, $pn,  $pn_transmitentes, $pu_adquirientes, $pu,  $pu_transmitentes);

        dd(($pp_adquirientes + $pp) > $pp_transmitentes);

        if(($pp_adquirientes + $pp) > $pp_transmitentes){

            throw new Exception("La suma de los porcentajes de propiedad no puede superar el " . $pp_transmitentes . '%.');

        }

        if(($pn_adquirientes + $pn) > $pn_transmitentes){

            throw new Exception("La suma de los porcentajes de nuda no puede superar el " . $pn_transmitentes . '%.');

        }

        if(($pu_adquirientes + $pu) > $pu_transmitentes){

            throw new Exception("La suma de los porcentajes de usufructo no puede superar el " . $pu_transmitentes . '%.');

        }

        /* if($pp_transmitentes == 0){

            if(($pn_adquirientes + $pn) != $pn_transmitentes){

                throw new Exception("La suma de los porcentajes de nuda debe ser " . $pn_transmitentes . '%.');

            }

            if(($pu_adquirientes + $pu) != $pu_transmitentes){

                throw new Exception("La suma de los porcentajes de usufructo debe ser " . $pu_transmitentes . '%.');

            }

        }else{

            if(($pp_adquirientes + $pp) != 0){

                if(($pn_adquirientes + $pn + $pp_adquirientes + $pp) != $pp_transmitentes){

                    throw new Exception("La suma de los porcentajes de nuda debe ser " . $pp_transmitentes . '%.');

                }

                if(($pu_adquirientes + $pu + $pp_adquirientes + $pp) != $pp_transmitentes){

                    throw new Exception("La suma de los porcentajes de nuda debe ser " . $pp_transmitentes . '%.');

                }

            }else{

                if(($pn_adquirientes + $pn) != $pp_transmitentes){

                    throw new Exception("La suma de los porcentajes de nuda debe ser " . $pp_transmitentes . '%.');

                }

                if(($pu_adquirientes + $pu) != $pp_transmitentes){

                    throw new Exception("La suma de los porcentajes de usufructo debe ser " . $pp_transmitentes . '%.');

                }

            }

        }
 */
    }

    public function mount(){

        try {

            $response = Http::acceptJson()
                                ->withToken(env('SISTEMA_TRAMITES_EN_LINEA_TOKEN'))
                                ->withQueryParameters([
                                    'id' => $this->traslado->aviso_stl
                                ])
                                ->get(env('SISTEMA_TRAMITES_EN_LINEA_CONSULTAR_AVISO'));


            $data = json_decode($response, true);

            if($response->status() === 200){

                $this->aviso = $data['data'];

                foreach ($this->aviso['transmitentes'] as $transmitente) {
                    $this->transmitentes[] = [
                        'id' => $transmitente['id'],
                        'nombre' => $transmitente['nombre'],
                        'ap_paterno' => $transmitente['ap_paterno'],
                        'ap_materno' => $transmitente['ap_materno'],
                        'razon_social' => $transmitente['razon_social'],
                        'porcentaje' => $transmitente['porcentaje'],
                        'porcentaje_nuda' => $transmitente['porcentaje_nuda'],
                        'porcentaje_usufructo' => $transmitente['porcentaje_usufructo'],
                    ];
                }

            }else{

                abort(500, message:"Error al consultar aviso");

            }

        } catch (\Throwable $th) {

            abort(500, message:"Error al conectar con Sistema de Trámties en Línea");
            Log::error("Error al consultar aviso en Sistema de Trámties en línea por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

        }

        try {

            $response = Http::acceptJson()
                                ->withToken(env('SISTEMA_PERITOS_EXTERNOS_TOKEN'))
                                ->withQueryParameters([
                                    'id' => $this->traslado->avaluo_spe
                                ])
                                ->get(env('SISTEMA_PERITOS_EXTERNOS_CONSULTAR_AVALUO'));


            $data = json_decode($response, true);

            if($response->status() === 200){

                $this->avaluo = $data['data'];

                $this->traslado->load('predio.propietarios.persona');

                $this->rechazos = Constantes::RECHAZOS_AVISOS;

            }else{

                abort(500, message:"Error al consultar avalúo de aviso");

            }

        } catch (\Throwable $th) {

            abort(500, message:"Error al conectar con Sistema de Peritos Externos");
            Log::error("Error al consultar avaluo en Sistema de Peritos Externos por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

        }

    }

    public function render()
    {
        return view('livewire.gestion-catastral.revision-traslados.revisar-traslado')->extends('layouts.admin');
    }
}
