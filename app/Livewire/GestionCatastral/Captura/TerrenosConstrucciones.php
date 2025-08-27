<?php

namespace App\Livewire\GestionCatastral\Captura;

use App\Models\Predio;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Traits\Predios\TerrenosTrait;
use App\Models\ValoresUnitariosRusticos;
use App\Traits\Predios\TerrenosComunTrait;
use App\Traits\Predios\ConstruccionesTrait;
use App\Models\ValoresUnitariosConstruccion;
use App\Traits\Predios\ConstruccionesComunTrait;

class TerrenosConstrucciones extends Component
{

    use TerrenosTrait;
    use TerrenosComunTrait;
    use ConstruccionesTrait;
    use ConstruccionesComunTrait;

    public $predio;

    public $valores_rusticos;
    public $valores_construccion;

    protected $validationAttributes  = [
        'terrenos.*.superficie' => 'superficie',
        'terrenos.*.valor_unitario' => 'valor unitario',
        'construcciones.*.referencia' => 'referencia',
        'construcciones.*.valor_unitario' => 'valor unitario',
        'construcciones.*.niveles' => 'niveles',
        'construcciones.*.superficie' => 'superficie',
        'construccionesComun.*.area_comun_construccion' => 'área común de construcción',
        'construccionesComun.*.indiviso_construccion' => 'indiviso de construcción',
        'terrenosComun.*.area_terreno_comun' => 'área de terreno común',
        'terrenosComun.*.indiviso_terreno' => 'indiviso de terreno',
        'terrenosComun.*.valor_unitario' => 'valor unitario',
        'construccionesComun.*.valor_clasificacion_construccion' => 'valor de clasificación',
    ];

    #[On('cargarPredioPadron')]
    public function cargarPredio($id){

        $this->predio = Predio::find($id);

        $this->cargarTerrenos();

        $this->cargarConstrucciones();

        $this->cargarTerrenosComun();

        $this->cargarConstruccionesComun();

    }

    public function mount(){

        $this->valores_rusticos = ValoresUnitariosRusticos::all();

        $this->valores_construccion = ValoresUnitariosConstruccion::all();

        if(!$this->predio){

            $this->predio = Predio::make();

        }

    }

    public function render()
    {
        return view('livewire.gestion-catastral.captura.terrenos-construcciones');
    }
}
