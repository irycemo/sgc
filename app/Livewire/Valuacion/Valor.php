<?php

namespace App\Livewire\Valuacion;

use App\Models\Uma;
use App\Models\Avaluo;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PredioAvaluo;
use App\Constantes\Constantes;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Traits\Predios\TerrenosTrait;
use App\Models\ValoresUnitariosRusticos;
use App\Traits\Predios\TerrenosComunTrait;
use App\Traits\Predios\ConstruccionesTrait;
use App\Models\ValoresUnitariosConstruccion;
use App\Traits\Predios\ConstruccionesComunTrait;

class Valor extends Component
{

    use TerrenosTrait;
    use TerrenosComunTrait;
    use ConstruccionesTrait;
    use ConstruccionesComunTrait;

    public $predio;
    public $avaluo_id;

    public $usos;
    public $ubicaciones;
    public $valores_rusticos;
    public $valores_construccion;

    protected function rules(){
        return [
            'predio' => 'required',
            'predio.superficie_total_terreno' => 'required',
            'predio.superficie_total_construccion' => 'nullable',
            'predio.valor_catastral' => 'nullable',
         ];
    }

    protected $messages = [
        'predio.required' => 'Primero debe cargar el predio.',
        'predio.superficie_total_terreno.required' => 'Debe tener una superficie de terreno.',
    ];

    protected $validationAttributes  = [
        'predio.uso_1' => 'uso de predio',
        'predio.ubicacion_en_manzana' => 'ubicación en manzana',
        'predio.area_comun_terreno' => 'No se han guardado los terrenos de área común',
        'predio.area_comun_construccion' => 'No se han guardado las construcciones de área común',
        'predio.valor_terreno_comun' => 'No se han guardado los terrenos de área común',
        'predio.valor_construccion_comun' => 'No se han guardado las construcciones de área común',
        'terrenos.*.superficie' => 'superficie',
        'terrenos.*.valor_unitario' => 'valor unitario',
        'construcciones.*.referencia' => 'referencia',
        'construcciones.*.valor_unitario' => 'valor unitario',
        'construcciones.*.niveles' => 'niveles',
        'construcciones.*.superficie' => 'superficie',
        'construccionesComun.*.area_comun_construccion' => 'área común de construcción',
        'construccionesComun.*.superficie_proporcional' => 'superficie proporcional',
        'construccionesComun.*.indiviso_construccion' => 'indiviso de construcción',
        'terrenosComun.*.area_terreno_comun' => 'área de terreno común',
        'terrenosComun.*.indiviso_terreno' => 'indiviso de terreno',
        'terrenosComun.*.valor_unitario' => 'valor unitario',
        'construccionesComun.*.valor_clasificacion_construccion' => 'valor de clasificación',
    ];

    #[On('cargarPredio')]
    public function cargarPredio($id){

        $this->predio = PredioAvaluo::with('avaluo')->find($id);

        $this->cargarTerrenos();

        $this->cargarConstrucciones();

        $this->cargarTerrenosComun();

        $this->cargarConstruccionesComun();

    }

    #[On('valorDemerito')]
    public function valorDemerito($valor){

        $this->porcentajeDemerito = $valor;

        foreach ($this->terrenos as &$terreno) {

            $terreno['demerito'] = $this->porcentajeDemerito;

        }

    }

    public function guardar(){

        if($this->predio?->avaluo?->estado == 'notificado'){

            $this->dispatch('mostrarMensaje', ['error', "No puedes modificar un avalúo notificado."]);

            return;

        }

        $this->validate();

        $this->validate([
            'predio.area_comun_terreno' => Rule::requiredIf($this->predio->valor_total_terreno == null),
            'predio.area_comun_construccion' => 'nullable',
        ]);

        try {

/*             $this->predio->superficie_total_terreno =  $this->predio->superficie_terreno + $this->predio->terrenosComun->sum('superficie_proporcional');
            $this->predio->superficie_total_construccion = $this->predio->superficie_construccion  + $this->predio->construccionesComun->sum('superficie_proporcional'); */

            $this->predio->valor_catastral = $this->predio->valor_total_terreno +
                                                $this->predio->valor_total_construccion;

            if($this->predio->ubicacion_en_manzana == 'ESQUINA'){

                $this->predio->valor_catastral = ($this->predio->valor_total_terreno + $this->predio->valor_total_construccion) +
                                                    ($this->predio->valor_total_terreno + $this->predio->valor_total_construccion) * 0.15;

            }

            $this->predio->valor_catastral = $this->revisarValorMinimo($this->predio->valor_catastral);

            $this->predio->save();

            $this->predio->audits()->latest()->first()->update(['tags' => 'Actualizó valor del predio']);

            $this->dispatch('mostrarMensaje', ['success', "La información se guardó con éxito"]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar el valor del predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function revisarValorMinimo($valor){

        $uma = Uma::where('año', now()->format('Y'))->first();

        if($this->predio->tipo_predio == 1 && $this->predio->valor_catastral < $uma->minimo_urbano) return $uma->minimo_urbano;

        if($this->predio->tipo_predio == 2 && $this->predio->valor_catastral < $uma->minimo_rustico) return $uma->minimo_rustico;

        return ceil($valor);

    }

    public function mount(){

        $this->usos = Constantes::USO_PREDIO;

        $this->ubicaciones = Constantes::UBICACION_PREDIO;

        $this->valores_rusticos = ValoresUnitariosRusticos::all();

        $this->valores_construccion = ValoresUnitariosConstruccion::all();

        if($this->avaluo_id){

            $avaluo = Avaluo::with('predioAvaluo')->find($this->avaluo_id);

            $this->cargarPredio($avaluo->predio_avaluo);

        }

    }

    public function render()
    {
        return view('livewire.valuacion.valor');
    }
}
