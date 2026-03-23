<?php

namespace App\Livewire\Comun\Consultas;

use App\Models\File;
use App\Models\Predio;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class ArchivoConsulta extends Component
{

    public $predio_id;
    public $predio;
    public $archivos = [];
    public $fotos;
    public $archivos_anteriores;
    public $flag_borrar = true;

    public function placeholder()
    {
        return view('livewire.comun.consultas.archivo-consulta-placeholder');
    }

    #[On('refresh')]
    public function refresh(){

        if($this->predio)
            $this->predio->refresh();

    }

    public function borrarArchivo(File $archivo){

        try {

            if(app()->isProduction()){

                if (Storage::disk('s3')->exists(config('services.ses.ruta_predios') . $archivo->url)) {

                    Storage::disk('s3')->delete(config('services.ses.ruta_predios') . $archivo->url);

                }

            }else{

                if (Storage::disk('predios_archivo')->exists($archivo->url)) {

                    Storage::disk('predios_archivo')->delete($archivo->url);

                }

            }

            $archivo->delete();

        } catch (\Throwable $th) {
            Log::error("Error al borrar archivo en captura al padron por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function mount(){

        $this->predio = Predio::find($this->predio_id);

        if(!$this->predio){

            $this->dispatch('mostrarMensaje', ['warning', "Debe cargar primero el predio."]);

            return;

        }

        $this->archivos_anteriores = File::where('fileable_id', $this->predio->id)
                                        ->where('fileable_type', 'App\Models\Predio')
                                        ->where(function($q){
                                            $q->where('descripcion', 'LIKE' , '%archivo_anterior%')
                                                ->orWhere('descripcion', 'LIKE' , '%traslado_anterior%')
                                                ->orWhere('descripcion', 'LIKE' , '%avaluo_anterior%')
                                                ->orWhere('descripcion', 'LIKE' , '%foto_anterior%');
                                        })
                                        ->first();

        if(!$this->archivos_anteriores){

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

        }

        $this->flag_borrar = url()->previous() == route('captura_padron');

    }

    public function render()
    {
        return view('livewire.comun.consultas.archivo-consulta');
    }
}
