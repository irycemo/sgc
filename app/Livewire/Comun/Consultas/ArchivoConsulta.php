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
    public $fotos;

    public function placeholder()
    {
        return view('livewire.comun.consultas.archivo-consulta-placeholder');
    }

    public function mount(){

        $this->predio = Predio::find($this->predio_id);

        if(!$this->predio->archivos->where('descripcion', 'archivo')->first()){

            try {

                $response = Http::accept('application/json')
                                    ->get(
                                        config('services.consulta_archivos_anterior.archivos_url') .
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

        }else{



        }

    }

    public function render()
    {
        return view('livewire.comun.consultas.archivo-consulta');
    }
}
