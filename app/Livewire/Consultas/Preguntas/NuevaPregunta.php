<?php

namespace App\Livewire\Consultas\Preguntas;

use App\Constantes\Constantes;
use App\Models\File;
use App\Models\Pregunta;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class NuevaPregunta extends Component
{

    use WithFileUploads;

    public Pregunta $pregunta;

    public $titulo;
    public $contenido;
    public $images = [];
    public $categorias;
    public $categoria;
    public $video;

    protected function rules(){
        return [
            'titulo' => 'required',
            'contenido' => 'required',
         ];
    }

    public function completeUplad($uploadedUrl, $eventName){

            foreach($this->images as $image){

                if($image->getFileName() === $uploadedUrl){

                    $newFileName = $image->store('/', 'preguntas');

                    $url = Storage::disk('preguntas')->url($newFileName);

                    $this->dispatch($eventName, ['url' => $url, 'href' => $url]);

                    return;

                }

            }

    }

    public function deleteImage($url){

            $name = substr($url, strrpos($url, '/') + 1);

            Storage::disk('preguntas')->delete($name);

    }

    public function revisarContenido(){

        if(isset($this->pregunta)){

            $this->dispatch('loadInitial', $this->contenido);

        }

    }

    public function guardar(){

        $this->validate();

        try {

            $pregunta = Pregunta::create([
                'titulo' => $this->titulo,
                'contenido' => $this->contenido,
                'categoria' => $this->categoria,
                'creado_por' => auth()->id()
            ]);

            if($this->video){

                $video = $this->video->store('sgc/videos', 's3');

                File::create([
                    'fileable_id' => $pregunta->id,
                    'fileable_type' => Pregunta::class,
                    'descripcion' => 'video',
                    'url' => $video
                ]);

            }

            return redirect()->route('preguntas_frecuentes');


        } catch (\Throwable $th) {

            Log::error("Error al crear pregunta por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function actualizar(){

        $this->validate();

        try {

            $this->pregunta->update([
                'titulo' => $this->titulo,
                'contenido' => $this->contenido,
                'categoria' => $this->categoria
            ]);

            if($this->video){

                if($this->pregunta->video){

                    $this->pregunta->video->delete();

                }

                $video = $this->video->store('sgc/videos', 's3');

                File::create([
                    'fileable_id' => $this->pregunta->id,
                    'fileable_type' => Pregunta::class,
                    'descripcion' => 'video',
                    'url' => $video
                ]);

            }

            return redirect()->route('preguntas_frecuentes');


        } catch (\Throwable $th) {

            Log::error("Error al crear pregunta por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        if(isset($this->pregunta)){

            $this->titulo = $this->pregunta->titulo;
            $this->contenido = $this->pregunta->contenido;

            $this->dispatch('loadInitial', $this->contenido);

        }

        $this->categorias = Constantes::CATEGORIAS;

    }

    public function render()
    {
        return view('livewire.consultas.preguntas.nueva-pregunta')->extends('layouts.admin');
    }

}
