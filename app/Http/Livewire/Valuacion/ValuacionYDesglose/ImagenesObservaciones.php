<?php

namespace App\Http\Livewire\Valuacion\ValuacionYDesglose;

use App\Models\File;
use Livewire\Component;
use App\Models\PredioAvaluo;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImagenesObservaciones extends Component
{

    use WithFileUploads;

    public PredioAvaluo $predio;

    public $encabezado;
    public $fachada;
    public $foto2;
    public $foto3;
    public $foto4;
    public $macrolocalizacion;
    public $microlocalizacion;
    public $poligonoDwg;
    public $poligonoImagen;
    public $observaciones;
    public $editar = false;

    protected function rules(){
        return [
            'encabezado' => 'image|nullable',
            'fachada' => 'image|nullable',
            'foto2' => 'image|nullable',
            'foto3' => 'image|nullable',
            'foto4' => 'image|nullable',
            'macrolocalizacion' => 'image|nullable',
            'poligonoDwg' => 'nullable|mimes:dwg',
            'poligonoImagen' => 'image|nullable',
            'predio' => 'required',
            'predio.avaluo.observaciones' => 'required'
         ];
    }

    protected $messages = [
        'predio.required' => '. Primero debe cargar el avaluo'
    ];

    protected $validationAttributes  = [
        'predio.avaluo.observaciones' => 'observaciones',
    ];

    protected $listeners = ['cargarPredio'];

    public function cargarPredio($id){

        $this->predio = PredioAvaluo::with('avaluo.imagenes')->find($id);

    }

    public function actualizar(){

        $this->validate();

        try {

            DB::transaction(function () {

                if($this->encabezado){

                    $file = File::where('fileable_id', $this->predio->avaluo->id)->where('descripcion' , 'encabezado')->first();

                    $encabezado = $this->encabezado->store('/', 'avaluos');

                    if(!$file)

                        File::create([
                            'fileable_id' => $this->predio->avaluo->id,
                            'fileable_type' => 'App\Models\Avaluo',
                            'url' => $encabezado,
                            'descripcion' => 'encabezado'
                        ]);

                    else{

                        Storage::disk('avaluos')->delete($file->url);

                        $file->update(['url' => $encabezado]);

                    }

                }

                if($this->fachada){

                    $file = File::where('fileable_id', $this->predio->avaluo->id)->where('descripcion' , 'fachada')->first();

                    $fachada = $this->fachada->store('/', 'avaluos');

                    if(!$file)

                        File::create([
                            'fileable_id' => $this->predio->avaluo->id,
                            'fileable_type' => 'App\Models\Avaluo',
                            'url' => $fachada,
                            'descripcion' => 'fachada'
                        ]);

                    else{

                        Storage::disk('avaluos')->delete($file->url);

                        $file->update(['url' => $fachada]);

                    }

                }

                if($this->foto2){

                    $file = File::where('fileable_id', $this->predio->avaluo->id)->where('descripcion' , 'foto2')->first();

                    $foto2 = $this->foto2->store('/', 'avaluos');

                    if(!$file)

                        File::create([
                            'fileable_id' => $this->predio->avaluo->id,
                            'fileable_type' => 'App\Models\Avaluo',
                            'url' => $foto2,
                            'descripcion' => 'foto2'
                        ]);

                    else{

                        Storage::disk('avaluos')->delete($file->url);

                        $file->update(['url' => $foto2]);

                    }


                }

                if($this->foto3){

                    $file = File::where('fileable_id', $this->predio->avaluo->id)->where('descripcion' , 'foto3')->first();

                    $foto3 = $this->foto3->store('/', 'avaluos');

                    if(!$file)

                        File::create([
                            'fileable_id' => $this->predio->avaluo->id,
                            'fileable_type' => 'App\Models\Avaluo',
                            'url' => $foto3,
                            'descripcion' => 'foto3'
                        ]);

                    else{

                        Storage::disk('avaluos')->delete($file->url);

                        $file->update(['url' => $foto3]);

                    }

                }

                if($this->foto4){

                    $file = File::where('fileable_id', $this->predio->avaluo->id)->where('descripcion' , 'foto4')->first();

                    $foto4 = $this->foto4->store('/', 'avaluos');

                    if(!$file)

                        File::create([
                            'fileable_id' => $this->predio->avaluo->id,
                            'fileable_type' => 'App\Models\Avaluo',
                            'url' => $foto4,
                            'descripcion' => 'foto4'
                        ]);

                    else{

                        Storage::disk('avaluos')->delete($file->url);

                        $file->update(['url' => $foto4]);
                    }

                }

                if($this->macrolocalizacion){

                    $file = File::where('fileable_id', $this->predio->avaluo->id)->where('descripcion' , 'macrolocalizacion')->first();

                    $macrolocalizacion = $this->macrolocalizacion->store('/', 'avaluos');

                    if(!$file)

                        File::create([
                            'fileable_id' => $this->predio->avaluo->id,
                            'fileable_type' => 'App\Models\Avaluo',
                            'url' => $macrolocalizacion,
                            'descripcion' => 'macrolocalizacion'
                        ]);

                    else{

                        Storage::disk('avaluos')->delete($file->url);

                        $file->update(['url' => $macrolocalizacion]);

                    }

                }

                if($this->microlocalizacion){

                    $file = File::where('fileable_id', $this->predio->avaluo->id)->where('descripcion' , 'microlocalizacion')->first();

                    $microlocalizacion = $this->microlocalizacion->store('/', 'avaluos');

                    if(!$file)

                        File::create([
                            'fileable_id' => $this->predio->avaluo->id,
                            'fileable_type' => 'App\Models\Avaluo',
                            'url' => $microlocalizacion,
                            'descripcion' => 'microlocalizacion'
                        ]);

                    else{

                        Storage::disk('avaluos')->delete($file->url);

                        $file->update(['url' => $microlocalizacion]);

                    }

                }

                if($this->poligonoImagen){

                    $file = File::where('fileable_id', $this->predio->avaluo->id)->where('descripcion' , 'poligonoImagen')->first();

                    $poligonoImagen = $this->poligonoImagen->store('/', 'avaluos');

                    if(!$file)

                        File::create([
                            'fileable_id' => $this->predio->avaluo->id,
                            'fileable_type' => 'App\Models\Avaluo',
                            'url' => $poligonoImagen,
                            'descripcion' => 'poligonoImagen'
                        ]);

                    else{

                        Storage::disk('avaluos')->delete($file->url);

                        $file->update(['url' => $poligonoImagen]);

                    }

                }

                if($this->poligonoDwg){

                    $file = File::where('fileable_id', $this->predio->avaluo->id)->where('descripcion' , 'poligonoDwg')->first();

                    $poligonoDwg = $this->poligonoDwg->store('/', 'avaluos');

                    if(!$file)

                        File::create([
                            'fileable_id' => $this->predio->avaluo->id,
                            'fileable_type' => 'App\Models\Avaluo',
                            'url' => $poligonoDwg,
                            'descripcion' => 'poligonoDwg'
                        ]);

                    else{

                        Storage::disk('avaluos')->delete($file->url);

                        $file->update(['url' => $poligonoDwg]);

                    }

                }

                $this->predio->avaluo->save();

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "La información se guardaró con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al guardar imagenes de avaluo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function render()
    {
        return view('livewire.valuacion.valuacion-y-desglose.imagenes-observaciones');
    }

}
