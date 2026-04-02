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
        'terrenosComun.*.superficie_proporcional' => 'superficie proporcional',
        'construccionesComun.*.valor_clasificacion_construccion' => 'valor de clasificación',
    ];

    public function updatedConstrucciones($value, $index){

        $i = explode('.', $index);

        if(isset($this->construcciones[$i[0]]['valor_unitario']) && isset($this->construcciones[$i[0]]['superficie'])){

            $this->construcciones[$i[0]]['valor_construccion'] = (float)$this->construcciones[$i[0]]['valor_unitario'] * (float)$this->construcciones[$i[0]]['superficie'];

        }

    }

    public function updatedConstruccionesComun($value, $index){

        $i = explode('.', $index);

        if(isset($this->construccionesComun[$i[0]]['indiviso_construccion'])){

            if(!is_numeric($this->construccionesComun[$i[0]]['indiviso_construccion']) || $this->construccionesComun[$i[0]]['indiviso_construccion'] > 100 || $this->construccionesComun[$i[0]]['indiviso_construccion'] < 0){

                $this->construccionesComun[$i[0]]['indiviso_construccion'] = 0;

                return;

            }

            $this->construccionesComun[$i[0]]['indiviso_construccion'] = round($this->construccionesComun[$i[0]]['indiviso_construccion'], 4);

        }

        if(isset($this->construccionesComun[$i[0]]['area_comun_construccion']) &&
            isset($this->construccionesComun[$i[0]]['indiviso_construccion']) &&
            isset($this->construccionesComun[$i[0]]['valor_clasificacion_construccion']))
        {

            $this->construccionesComun[$i[0]]['superficie_proporcional'] = ((float)$this->construccionesComun[$i[0]]['area_comun_construccion'] * (float)$this->construccionesComun[$i[0]]['indiviso_construccion']) / 100;

            $this->construccionesComun[$i[0]]['valor_construccion_comun'] = ((float)$this->construccionesComun[$i[0]]['area_comun_construccion'] *
                                                                                    (float)$this->construccionesComun[$i[0]]['indiviso_construccion'] *
                                                                                    (float)$this->construccionesComun[$i[0]]['valor_clasificacion_construccion']) / 100 ;

        }

    }

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
