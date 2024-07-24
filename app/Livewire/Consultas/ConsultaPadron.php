<?php

namespace App\Livewire\Consultas;

use App\Models\Predio;
use App\Models\Oficina;
use Livewire\Component;
use App\Models\Propietario;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;

class ConsultaPadron extends Component
{

    use WithPagination;

    public Predio $predio;
    public $predios;

    public $radio = 'clave';

    public $nombre;
    public $ap_paterno;
    public $ap_materno;
    public $razon_social;
    public $rfc;
    public $curp;
    public $ubicacion;
    public $diez = false;
    public $prediosIds;
    public $flag = false;
    public $buscarClave = true;

    protected function rules(){
        return [
            'predio.numero_registro' => 'required|numeric|min:1',
            'predio.region_catastral' => 'required|numeric|min:1',
            'predio.municipio' => 'required|numeric|min:1',
            'predio.localidad' => 'required|numeric|min:1',
            'predio.sector' => 'required|numeric|min:1',
            'predio.zona_catastral' => 'required|numeric|min:1,|same:predio.localidad',
            'predio.manzana' => 'required|numeric|min:1',
            'predio.tipo_predio' => 'required|numeric|min:1|max:2',
            'predio.oficina' => 'required|numeric|min:1',
         ];
    }

    public function updated($property, $value){

        if($value == ''){

            $this->$property = null;

        }

    }

    public function crearModeloVacio(){
        $this->predio = Predio::make();
    }

    public function updatedRadio(){

        $this->reset([
            'predio',
            'predios',
            'nombre',
            'ap_paterno',
            'ap_materno',
            'razon_social',
            'rfc',
            'curp',
            'ubicacion'
        ]);

        $this->crearModeloVacio();

        $this->predio->oficina = auth()->user()->oficina->oficina;

        $this->predio->municipio = auth()->user()->oficina->municipio;

    }

    public function updatedPredioOficina(){

        $this->predio->municipio = Oficina::where('oficina', $this->predio->oficina)->first()?->municipio;

    }

    public function buscarCuentaPredial(){

        $this->predio->id = null;

        $this->validate([
            'predio.numero_registro' => 'required|numeric|min:1',
            'predio.tipo_predio' => 'required|numeric|min:1|max:2',
            'predio.oficina' => 'required|numeric|min:1',
            'predio.localidad' => 'required|numeric|min:1',
        ]);

        if(!$this->diez){

            try {

                $this->predio = Predio::with(
                                            'propietarios.persona',
                                            'condominioTerrenos',
                                            'condominioConstrucciones',
                                            'terrenos',
                                            'construcciones',
                                            'colindancias',
                                        )
                                        ->where('numero_registro', $this->predio->numero_registro)
                                        ->where('tipo_predio', $this->predio->tipo_predio)
                                        ->where('localidad', $this->predio->localidad)
                                        ->where('oficina', $this->predio->oficina)
                                        ->firstOrFail();

                if($this->predio->bloqueadoActivo()){

                    $this->dispatch('mostrarMensaje', ['error', "El predio se encuentra bloqueado."]);
                    $this->predio = $this->crearModeloVacio();
                    return;

                }

                if($this->predioInactivo()) return;

                $this->flag = true;

            } catch (\Throwable $th) {

                $this->dispatch('mostrarMensaje', ['error', "No se encontro predio con la cuenta predial ingresada."]);

            }

        }else{

            $this->predios = Predio::with(
                                        'propietarios.persona',
                                        'condominioTerrenos',
                                        'condominioConstrucciones',
                                        'terrenos',
                                        'construcciones',
                                        'colindancias',
                                        'propietarioInicial'
                                    )
                                    ->where('tipo_predio', $this->predio->tipo_predio)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('oficina', $this->predio->oficina)
                                    ->whereBetween('numero_registro', [($this->predio->numero_registro - 10), ($this->predio->numero_registro + 10)])
                                    ->get();

        }

    }

    public function buscarClaveCatastral(){

        /* $this->predio->id = null; */

        $this->validate([
            'predio.region_catastral' => 'required|numeric|min:1',
            'predio.municipio' => 'required|numeric|min:1',
            'predio.localidad' => 'required|numeric|min:1',
            'predio.sector' => 'required|numeric|min:1',
            'predio.zona_catastral' => 'required|numeric|min:1,|same:predio.localidad',
            'predio.manzana' => 'required|numeric|min:1',
        ]);

        try {

            $this->predios = Predio::with('propietarioInicial')
                                    ->where('status', 'activo')
                                    ->where('estado', 16)
                                    ->where('region_catastral', $this->predio->region_catastral)
                                    ->where('municipio', $this->predio->municipio)
                                    ->where('zona_catastral', $this->predio->zona_catastral)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('sector', $this->predio->sector)
                                    ->where('manzana', $this->predio->manzana)
                                    ->when($this->predio->oficina != 101, function($q){
                                        $q->where('oficina', $this->predio->oficina);
                                    })
                                    ->get();

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "No se encontro predio con la clave catastral ingresada."]);

        }

    }

    public function buscarPorPropietario(){

        $this->predio->id = null;

        $this->validate([
            'nombre' => Rule::requiredIf($this->ap_paterno != null || $this->ap_materno != null),
            'ap_paterno' => Rule::requiredIf($this->ap_materno != null || $this->nombre != null),
            'ap_materno' => Rule::requiredIf($this->nombre != null || $this->ap_materno != null),
            'razon_social' => Rule::requiredIf($this->nombre == null && $this->ap_materno == null && $this->ap_paterno == null && $this->rfc == null && $this->curp == null),
            'rfc' => Rule::requiredIf($this->nombre == null && $this->ap_materno == null && $this->ap_paterno == null && $this->razon_social == null && $this->curp == null),
            'curp' => Rule::requiredIf($this->nombre == null && $this->ap_materno == null && $this->ap_paterno == null && $this->rfc == null && $this->razon_social == null),
        ]);

        try {

            $propietarios = Propietario::whereHas('persona', function($q){
                                                    $q->when($this->nombre != '' && $this->nombre != null, function($q){
                                                        $q->where('nombre', $this->nombre);
                                                    })
                                                    ->when($this->ap_paterno != '' && $this->ap_paterno != null, function($q){
                                                        $q->where('ap_paterno', $this->ap_paterno);
                                                    })
                                                    ->when($this->ap_materno != '' && $this->ap_materno != null, function($q){
                                                        $q->where('ap_materno', $this->ap_materno);
                                                    })
                                                    ->when($this->razon_social != '' && $this->razon_social != null, function($q){
                                                        $q->where('razon_social', $this->razon_social);
                                                    })
                                                    ->when($this->rfc != '' && $this->rfc != null, function($q){
                                                        $q->where('rfc', $this->rfc);
                                                    })
                                                    ->when($this->curp != '' && $this->curp != null, function($q){
                                                        $q->where('curp', $this->curp);
                                                    });
                                            })
                                            ->where('propietarioable_type', 'App\Models\Predio')
                                            ->get();



                $this->predios = Predio::with('propietarioInicial')
                                            ->whereIn('id', $propietarios->pluck('propietarioable_id'))
                                            ->when($this->predio->oficina != 101, function($q){
                                                $q->where('oficina', $this->predio->oficina);
                                            })
                                            ->orderBy('oficina')
                                            ->get();



        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', $th->getMessage()]);

        }

    }

    public function buscarPorUbicacion(){

        $this->predio->id = null;

        $this->validate(['ubicacion' => 'required']);

        try {

            $this->predios = Predio::whereAny([
                                            'tipo_vialidad',
                                            'tipo_asentamiento',
                                            'nombre_vialidad',
                                            'nombre_asentamiento',
                                            'nombre_predio',
                                            'nombre_edificio',
                                            'clave_edificio',
                                            'departamento_edificio',
                                        ],
                                        'like', '%' . $this->ubicacion . '%'
                                    )
                                    ->when($this->predio->oficina != 101, function($q){
                                        $q->where('oficina', $this->predio->oficina);
                                    })
                                    ->get();

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', $th->getMessage()]);

        }

    }

    public function verPredio(Predio $predio){

        $this->predio = $predio;

        $this->predio->load(
                            'propietarios.persona',
                            'condominioTerrenos',
                            'condominioConstrucciones',
                            'terrenos',
                            'construcciones',
                            'colindancias',
                            'movimientos'
                            );

        $this->flag = true;

    }

    public function predioInactivo(){

        if($this->predio->status != 'activo'){

            $this->dispatch('mostrarMensaje', ['error', "El predio no esta activo."]);

            $this->predio = $this->crearModeloVacio();

            return true;

        }

    }

    /* #[Computed]
    public function prediosLista(){

        return Predio::with('propietarioInicial')
                        ->where('status', 'activo')
                        ->where('estado', 16)
                        ->where('region_catastral', $this->predio->region_catastral)
                        ->where('municipio', $this->predio->municipio)
                        ->where('zona_catastral', $this->predio->zona_catastral)
                        ->where('localidad', $this->predio->localidad)
                        ->where('sector', $this->predio->sector)
                        ->where('manzana', $this->predio->manzana)
                        ->when($this->predio->oficina != 101, function($q){
                            $q->where('oficina', $this->predio->oficina);
                        })->get();

    } */

    public function mount(){

        $this->crearModeloVacio();

        $this->predio->oficina = auth()->user()->oficina->oficina;

        $this->predio->municipio = auth()->user()->oficina->municipio;

    }

    public function render()
    {
        return view('livewire.consultas.consulta-padron')->extends('layouts.admin');
    }
}
