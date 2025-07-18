<?php

namespace App\Livewire\Comun\Consultas;

use App\Models\Predio;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ArchivoConsulta extends Component
{

    public $predio_id;
    public Predio $predio;
    public $archivos = [];

    public function placeholder()
    {
        return view('livewire.comun.consultas.archivo-consulta-placeholder');
    }

    public function mount(){

        $this->predio = Predio::find($this->predio_id);

        try {

            $response = Http::accept('application/json')
                                ->get(
                                    'http://10.0.253.223:8095/sgcpredio.asmx/sgc_predio?tipo=2&locl=' .
                                    $this->predio->localidad .
                                    '&ofna=' . $this->predio->oficina .
                                    '&tpre=' . $this->predio->tipo_predio .
                                    '&nreg=' . $this->predio->numero_registro
                                );

            if($response->status() !== 200){

                $this->archivos = [];

            }else{


                $this->archivos = json_decode($response, true);

                if(!isset($this->archivos['avaluos'])){

                    $this->archivos = [];

                }

            }

        } catch (\Throwable $th) {

            $this->archivos = [];

        }

    }

    public function render()
    {
        return view('livewire.comun.consultas.archivo-consulta');
    }
}
