<?php

namespace App\Http\Livewire\Valuacion\ValuacionYDesglose;

use App\Models\Avaluo;
use App\Models\Terreno;
use Livewire\Component;
use App\Models\Referencia;
use App\Models\PredioAvaluo;
use Illuminate\Support\Facades\DB;
use App\Http\Constantes\Constantes;
use App\Models\Condominioconstruccion;
use Illuminate\Support\Facades\Log;
use App\Models\ValoresUnitariosRusticos;
use Luecano\NumeroALetras\NumeroALetras;
use App\Models\ValoresUnitariosConstruccion;

class Valor extends Component
{

    public $usos;
    public $ubicaciones;
    public $terrenos = [];
    public $construcciones = [];
    public $construccionesCondominio = [];
    public $valores_rusticos;
    public $valores_construccion;
    public $porcentajeDemerito;

    public Avaluo $avaluo;

    public PredioAvaluo $predio;

    protected $listeners = ['cargarPredio'];

    protected function rules(){
        return [
            'predio.uso_1' => 'required',
            'predio.uso_2' => 'nullable',
            'predio.uso_3' => 'nullable',
            'predio.superficie_terreno' => 'nullable',
            'predio.superficie_construccion' => 'nullable',
            'predio.ubicacion_en_manzana' => 'required',
            'predio.valor_catastral' => 'nullable',
            'predio' => 'required',
            'avaluo.area_comun_terreno' => 'required',
            'avaluo.indiviso_terreno' => 'required',
            'avaluo.valor_unitario' => 'required',
            'avaluo.valor_terreno_comun' => 'required',
            'avaluo.valor_construcción_comun' => 'required',
         ];
    }

    protected $messages = [
        'predio.required' => '. Primero debe cargar el avaluo'
    ];

    protected $validationAttributes  = [
        'terrenos.*.superficie' => 'superficie',
        'terrenos.*.valor_unitario' => 'valor unitario',
        'construcciones.*.referencia' => 'referencia',
        'construcciones.*.valor_unitario' => 'valor unitario',
        'construcciones.*.niveles' => 'niveles',
        'construcciones.*.superficie' => 'superficie',
        'predio.uso_1' => 'uso de predio 1',
        'predio.ubicacion_en_manzana' => 'ubicación en manzana',
        'construccionesCondominio.*.area_comun_construccion' => 'área común de construcción',
        'construccionesCondominio.*.indiviso_construccion' => 'indiviso de construcción',
        'construccionesCondominio.*.valor_clasificacion_construccion' => 'valor de clasificación',
    ];

    public function updatedTerrenos($value, $index){

        $this->validate(['predio' => 'required']);

        $i = explode('.', $index);

        if(isset($this->terrenos[$i[0]]['demerito']) && $this->terrenos[$i[0]]['demerito'] == 0){

            $this->terrenos[$i[0]]['valor_demeritado'] = 0;

        }

        if(isset($this->terrenos[$i[0]]['superficie']) && isset($this->terrenos[$i[0]]['valor_unitario']) && isset($this->terrenos[$i[0]]['demerito']) && $this->terrenos[$i[0]]['demerito'] != 0){

            $this->terrenos[$i[0]]['valor_demeritado'] = (float)$this->terrenos[$i[0]]['valor_unitario'] - (float)$this->terrenos[$i[0]]['valor_unitario'] * (float)$this->terrenos[$i[0]]['demerito'] / 100;

            if($this->predio->tipo_predio == 2){

                $this->terrenos[$i[0]]['valor_terreno'] = (float)$this->terrenos[$i[0]]['superficie'] * (float)$this->terrenos[$i[0]]['valor_demeritado'] / 10000;

            }else{

                $this->terrenos[$i[0]]['valor_terreno'] = (float)$this->terrenos[$i[0]]['superficie'] * (float)$this->terrenos[$i[0]]['valor_demeritado'];
            }


        }elseif(isset($this->terrenos[$i[0]]['superficie']) && isset($this->terrenos[$i[0]]['valor_unitario'])){

            $this->terrenos[$i[0]]['valor_terreno'] = (float)$this->terrenos[$i[0]]['superficie'] * (float)$this->terrenos[$i[0]]['valor_unitario'];

        }

    }

    public function updatedConstrucciones($value, $index){

        $i = explode('.', $index);

        if($i[1] == 'valores'){

            $aux = json_decode($this->construcciones[$i[0]]['valores'], true);

            $this->construcciones[$i[0]]['uso'] = $aux['uso'];

            $this->construcciones[$i[0]]['tipo'] = $aux['tipo'];

            $this->construcciones[$i[0]]['estado'] = $aux['estado'];

            $this->construcciones[$i[0]]['calidad'] = $aux['calidad'];

            $this->construcciones[$i[0]]['valor_unitario'] = $aux['valor'];

        }

    }

    public function updatedConstruccionesCondominio($value, $index){

        $i = explode('.', $index);

        if(isset($this->construccionesCondominio[$i[0]]['area_comun_construccion']) &&
            isset($this->construccionesCondominio[$i[0]]['indiviso_construccion']) &&
            isset($this->construccionesCondominio[$i[0]]['valor_clasificacion_construccion']))
        {

            $this->construccionesCondominio[$i[0]]['valor_construcción_comun'] = (float)$this->construccionesCondominio[$i[0]]['area_comun_construccion'] *
                                                                                    (float)$this->construccionesCondominio[$i[0]]['indiviso_construccion'] *
                                                                                    (float)$this->construccionesCondominio[$i[0]]['valor_clasificacion_construccion'] ;

        }

    }

    public function updatedAvaluo(){

        if($this->avaluo->area_comun_terreno  && $this->avaluo->indiviso_terreno  && $this->avaluo->valor_unitario )
            $this->avaluo->valor_terreno_comun = $this->avaluo->area_comun_terreno * $this->avaluo->indiviso_terreno * $this->avaluo->valor_unitario;

        if($this->avaluo->area_comun_construccion && $this->avaluo->indiviso_construccion && $this->avaluo->valor_clasificacion_construccion)
            $this->avaluo->valor_construcción_comun = $this->avaluo->area_comun_construccion * $this->avaluo->indiviso_construccion * $this->avaluo->valor_clasificacion_construccion;

    }

    public function updatedPredioValorCatastral(){

        $formatter = new NumeroALetras();

        $formatter->toWords($this->predio->valor_catastral);

    }

    public function cargarPredio($id){

        $this->reset(['terrenos', 'construcciones']);

        $this->predio = PredioAvaluo::with('construcciones', 'terrenos', 'avaluo')->find($id);

        foreach ($this->predio->terrenos as $terreno) {

            $this->terrenos[] = [
                'id' => $terreno->id,
                'superficie' => $terreno->superficie,
                'valor_unitario' => $terreno->valor_unitario,
                'demerito' => $terreno->demerito,
                'valor_demeritado' => $terreno->valor_demeritado,
                'valor_terreno' => $terreno->valor_terreno
            ];

        }

        foreach ($this->predio->construcciones as $construccion) {

            $this->construcciones[] = [
                'id' => $construccion->id,
                'referencia' => $construccion->referencia,
                'niveles' => $construccion->niveles,
                'superficie' => $construccion->superficie,
                'valor_unitario' => $construccion->valor_unitario,
                'tipo' => $construccion->tipo,
                'uso' => $construccion->uso,
                'calidad' => $construccion->calidad,
                'estado' => $construccion->estado,
            ];
        }

        $this->avaluo = $this->predio->avaluo;

        $this->porcentajeDemerito = null;

        if(!$this->avaluo->agua)
            $this->porcentajeDemerito = 5;
        if(!$this->avaluo->drenaje)
            $this->porcentajeDemerito = $this->porcentajeDemerito + 5;
        if(!$this->avaluo->pavimento)
            $this->porcentajeDemerito = $this->porcentajeDemerito + 5;
        if(!$this->avaluo->energia_electrica)
            $this->porcentajeDemerito = $this->porcentajeDemerito + 5;
        if(!$this->avaluo->alumbrado_publico)
            $this->porcentajeDemerito = $this->porcentajeDemerito + 5;
        if(!$this->avaluo->banqueta)
            $this->porcentajeDemerito = $this->porcentajeDemerito + 5;

        foreach ($this->terrenos as $terreno) {

            $terreno['demerito'] = $this->porcentajeDemerito;

        }

    }

    public function agregarConstruccion(){

        $this->construcciones[] = ['superficie' => null, 'niveles' => null, 'referencia' => null, 'id' => null, 'valor_unitario' => null, 'valores' => null, 'uso' => null, 'tipo' => null, 'categoria' => null, 'calidad' => null];

    }

    public function agregarTerreno(){

        $this->terrenos[] = ['superficie' => null, 'valor_unitario' => null, 'demerito' => $this->porcentajeDemerito, 'id' => null , 'valor_demeritado' => null, 'valor_terreno' => null];

    }

    public function agregarCondominioConstruccion(){

        $this->construccionesCondominio[] = ['area_comun_construccion' => null, 'indiviso_construccion' => null, 'valor_clasificacion_construccion' => null, 'id' => null, 'valor_construcción_comun' => null,];

    }

    public function borrarConstruccion($index){

        $this->validate(['predio' => 'required']);

        try {

            if($this->construcciones[$index]['id'] != null)
                $this->predio->construcciones()->where('id', $this->construcciones[$index]['id'])->delete();

        } catch (\Throwable $th) {
            Log::error("Error al borrar construccion por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);
        }

        unset($this->construcciones[$index]);

        $this->construcciones = array_values($this->construcciones);

    }

    public function borrarTerreno($index){

        $this->validate(['predio' => 'required']);

        try {

            if($this->terrenos[$index]['id'] != null)
                $this->predio->terrenos()->where('id', $this->terrenos[$index]['id'])->delete();

        } catch (\Throwable $th) {
            Log::error("Error al borrar terreno por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);
        }

        unset($this->terrenos[$index]);

        $this->terrenos = array_values($this->terrenos);

    }

    public function borrarCondominioConstruccion($index){

        $this->validate(['predio' => 'required']);

        try {

            if($this->construccionesCondominio[$index]['id'] != null)
                $this->predio->condominioConstrucciones()->where('id', $this->construccionesCondominio[$index]['id'])->delete();

        } catch (\Throwable $th) {
            Log::error("Error al borrar terreno por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);
        }

        unset($this->construccionesCondominio[$index]);

        $this->construccionesCondominio = array_values($this->construccionesCondominio);

    }

    public function guardarConstrucciones(){

        $this->validate([
            'predio' => 'required',
            'construcciones.*.referencia' => 'required',
            'construcciones.*.valor_unitario' => 'required',
            'construcciones.*.niveles' => 'required',
            'construcciones.*.superficie' => 'required',
            'construcciones.*.tipo' => 'required',
            'construcciones.*.uso' => 'required',
            'construcciones.*.estado' => 'required',
            'construcciones.*.calidad' => 'required',
        ]);

        try {

            DB::transaction(function () {

                $sum = 0;
                $sum2 = 0;

                foreach ($this->construcciones as $key => $construccion) {

                    if($construccion['id'] == null){

                        $aux = $this->predio->construcciones()->create([
                            'referencia' => $construccion['referencia'],
                            'valor_unitario' => $construccion['valor_unitario'],
                            'niveles' => $construccion['niveles'],
                            'superficie' => $construccion['superficie'],
                            'uso' => $construccion['uso'],
                            'tipo' => $construccion['tipo'],
                            'calidad' => $construccion['calidad'],
                            'estado' => $construccion['estado'],
                        ]);

                        $this->construcciones[$key]['id'] = $aux->id;

                    }else{

                        Referencia::find($construccion['id'])->update([
                            'referencia' => $construccion['referencia'],
                            'valor_unitario' => $construccion['valor_unitario'],
                            'niveles' => $construccion['niveles'],
                            'superficie' => $construccion['superficie'],
                            'uso' => $construccion['uso'],
                            'tipo' => $construccion['tipo'],
                            'calidad' => $construccion['calidad'],
                            'estado' => $construccion['estado'],
                        ]);

                    }

                    $sum = $sum + (float)$construccion['valor_unitario'] * (float)$construccion['superficie'];

                    $sum2 = $sum2 + (float)$construccion['superficie'];

                }

                $this->predio->update([
                    'superficie_construccion' => $sum2,
                    'valor_construccion' => $sum,
                ]);

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "Las construcciones se guardaron con éxito"]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al crear construccion por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function guardarTerrenos(){

        $this->validate([
            'predio' => 'required',
            'terrenos.*.superficie' => 'required',
            'terrenos.*.valor_unitario' => 'required',
            'terrenos.*.demerito' => 'nullable|numeric|min:0',
        ]);

        try {

            DB::transaction(function () {

                $sum = 0;

                $sum2 = 0;

                foreach ($this->terrenos as $key => $terreno) {

                    if($terreno['id'] == null){

                        $aux = $this->predio->terrenos()->create([
                            'superficie' => $terreno['superficie'],
                            'valor_unitario' => $terreno['valor_unitario'],
                            'demerito' => $terreno['demerito'],
                            'valor_demeritado' => $terreno['valor_demeritado'],
                            'valor_terreno' => $terreno['valor_terreno'],
                        ]);

                        $this->terrenos[$key]['id'] = $aux->id;

                    }else{

                        Terreno::find($terreno['id'])->update([
                            'superficie' => $terreno['superficie'],
                            'valor_unitario' => $terreno['valor_unitario'],
                            'demerito' => $terreno['demerito'],
                            'valor_demeritado' => $terreno['valor_demeritado'],
                            'valor_terreno' => $terreno['valor_terreno'],
                        ]);

                    }

                    $sum = $sum + (float)$terreno['valor_terreno'];

                    $sum2 = $sum2 + (float)$terreno['superficie'];

                }

                $this->predio->update([
                    'superficie_terreno' => $sum2,
                    'valor_total_terreno' => $sum
                ]);

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "Los terrenos se guardaron con éxito"]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al crear valor catastral por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function guardarCondominio(){

        $this->validate([
            'predio' => 'required',
            'avaluo.area_comun_terreno' => 'required',
            'avaluo.indiviso_terreno' => 'required',
            'avaluo.valor_unitario' => 'required',
            'avaluo.valor_terreno_comun' => 'required',
            'construccionesCondominio.*.area_comun_construccion' => 'required',
            'construccionesCondominio.*.indiviso_construccion' => 'required',
            'construccionesCondominio.*.valor_clasificacion_construccion' => 'required',
        ]);

        try {

            DB::transaction(function () {

                $sum = 0;

                $sum2 = 0;

                foreach ($this->construccionesCondominio as $key => $construccion) {

                    if($construccion['id'] == null){

                        $aux = $this->predio->condominioConstrucciones()->create([
                            'area_comun_construccion' => $construccion['area_comun_construccion'],
                            'indiviso_construccion' => $construccion['indiviso_construccion'],
                            'valor_clasificacion_construccion' => $construccion['valor_clasificacion_construccion'],
                            'valor_construcción_comun' => $construccion['valor_construcción_comun'],
                        ]);

                        $this->construccionesCondominio[$key]['id'] = $aux->id;

                    }else{

                        Condominioconstruccion::find($construccion['id'])->update([
                            'area_comun_construccion' => $construccion['area_comun_construccion'],
                            'indiviso_construccion' => $construccion['indiviso_construccion'],
                            'valor_clasificacion_construccion' => $construccion['valor_clasificacion_construccion'],
                            'valor_construcción_comun' => $construccion['valor_construcción_comun'],
                        ]);

                    }

                    $sum = $sum + (float)$construccion['valor_construcción_comun'];

                    $sum2 = $sum2 + (float)$construccion['area_comun_construccion'];

                }

                $this->predio->update([
                    'valor_construccion' => $sum,
                ]);

                $this->avaluo->area_comun_construccion = $sum2;
                $this->avaluo->valor_construcción_comun = $sum;

                $this->avaluo->save();

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "La información de condominio se guardó con éxito"]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualizar el valor de condominio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function guardar(){

        $this->validate();

        try {

            $this->predio->valor_catastral = $this->predio->valor_total_terreno + $this->avaluo->valor_terreno_comun + $this->predio->valor_construccion;
            $this->predio->save();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "La información se guardó con éxito"]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar el valor del predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function mount(){

        $this->usos = Constantes::USO_PREDIO;

        $this->ubicaciones = Constantes::UBICACION_PREDIO;

        $this->terrenos = [
            ['superficie' => null, 'valor_unitario' => null, 'demerito' => null, 'id' => null, 'valor_demeritado' => null, 'valor_terreno' => null]
        ];

        $this->construcciones = [
            ['codigo' => null, 'niveles' => null, 'superficie' => null, 'id' => null, 'valor_unitario' => null, 'valores' => null, 'uso' => null, 'tipo' => null, 'categoria' => null, 'calidad' => null]
        ];

        $this->construccionesCondominio = [
            ['area_comun_construccion' => null, 'indiviso_construccion' => null, 'valor_clasificacion_construccion' => null, 'id' => null, 'valor_construcción_comun' => null,]
        ];

        $this->valores_rusticos = ValoresUnitariosRusticos::all();

        $this->valores_construccion = ValoresUnitariosConstruccion::all();

        $this->avaluo = Avaluo::make();

    }

    public function render()
    {
        return view('livewire.valuacion.valuacion-y-desglose.valor');
    }
}
