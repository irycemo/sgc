<?php

namespace App\Livewire\Valuacion;

use App\Models\File;
use App\Models\Avaluo;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PredioAvaluo;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Imagenes extends Component
{

    use WithFileUploads;

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

    public $predio;
    public $avaluo_id;

    protected function rules(){
        return [
            'fachada' => 'nullable|image|max:5000',
            'foto2' => 'nullable|image|max:5000',
            'foto3' => 'nullable|image|max:5000',
            'foto4' => 'nullable|image|max:5000',
            'macrolocalizacion' => 'nullable|image|max:5000',
            'microlocalizacion' => 'nullable|image|max:5000',
            'poligonoDwg' => 'nullable|mimes:dwg',
            'poligonoImagen' => 'nullable|image|max:5000',
            'predio' => 'required',
            'predio.avaluo.observaciones' => 'nullable',
         ];
    }

    protected $messages = [
        'predio.required' => 'Primero debe cargar el avalúo'
    ];

    protected $validationAttributes  = [
        'predio.avaluo.observaciones' => 'observaciones',
    ];

    #[On('cargarPredio')]
    public function cargarPredio($id){

        $this->predio = PredioAvaluo::with('avaluo.imagenes')->find($id);

    }

    public function guardar(){

        $this->validate();

        try {

            DB::transaction(function () {

                if($this->encabezado){

                    $file = File::where('fileable_id', $this->predio->avaluo->id)
                                    ->where('fileable_type', 'App\Models\Avaluo')
                                    ->where('descripcion' , 'encabezado')
                                    ->first();

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

                    $file = File::where('fileable_id', $this->predio->avaluo->id)
                                    ->where('fileable_type', 'App\Models\Avaluo')
                                    ->where('descripcion' , 'fachada')
                                    ->first();

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

                    $file = File::where('fileable_id', $this->predio->avaluo->id)
                                    ->where('fileable_type', 'App\Models\Avaluo')
                                    ->where('descripcion' , 'foto2')
                                    ->first();

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

                    $file = File::where('fileable_id', $this->predio->avaluo->id)
                                    ->where('fileable_type', 'App\Models\Avaluo')
                                    ->where('descripcion' , 'foto3')
                                    ->first();

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

                    $file = File::where('fileable_id', $this->predio->avaluo->id)
                                    ->where('fileable_type', 'App\Models\Avaluo')
                                    ->where('descripcion' , 'foto4')
                                    ->first();

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

                    $file = File::where('fileable_id', $this->predio->avaluo->id)
                                    ->where('fileable_type', 'App\Models\Avaluo')
                                    ->where('descripcion' , 'macrolocalizacion')
                                    ->first();

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

                    $file = File::where('fileable_id', $this->predio->avaluo->id)
                                    ->where('fileable_type', 'App\Models\Avaluo')
                                    ->where('descripcion' , 'microlocalizacion')
                                    ->first();

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

                    $file = File::where('fileable_id', $this->predio->avaluo->id)
                                    ->where('fileable_type', 'App\Models\Avaluo')
                                    ->where('descripcion' , 'poligonoImagen')
                                    ->first();

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

                    $file = File::where('fileable_id', $this->predio->avaluo->id)
                                    ->where('fileable_type', 'App\Models\Avaluo')
                                    ->where('descripcion' , 'poligonoDwg')
                                    ->first();

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

                $this->predio->audits()->latest()->first()->update(['tags' => 'Actualizó imágenes']);

                $this->dispatch('mostrarMensaje', ['success', "La información se guardó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al guardar imagenes de avaluo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function mount(){

        if($this->avaluo_id){

            $avaluo = Avaluo::with('predioAvaluo')->find($this->avaluo_id);

            $this->cargarPredio($avaluo->predio_avaluo);

        }

    }

    public function render()
    {
        return view('livewire.valuacion.imagenes');
    }
}
