<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Efirma;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpCfdi\Credentials\Credential;
use App\Http\Traits\ComponentesTrait;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Efirmas extends Component
{

    use WithPagination;
    use ComponentesTrait;
    use WithFileUploads;

    public $usuarios;

    public $cer;
    public $key;
    public $imagen;

    public Efirma $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.user_id' => 'required',
            'modelo_editar.estado' => 'required',
            'modelo_editar.cer' => 'required',
            'modelo_editar.key' => 'required',
            'modelo_editar.contraseña' => 'required',
            'modelo_editar.imagen' => 'nullable',
         ];
    }

    protected $validationAttributes  = [
        'modelo_editar.user_id' => 'usuario',
    ];

    public function crearModeloVacio(){
        $this->modelo_editar = Efirma::make();
    }

    public function abrirModalEditar(Efirma $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function guardar(){

        $this->validate();

        try {

            DB::transaction(function () {

                if($this->imagen)
                    $this->modelo_editar->imagen = $this->imagen->store('/', 'efirma');

                if($this->cer)
                    $this->modelo_editar->cer = $this->cer->store('/', 'efirma');

                if($this->key)
                    $this->modelo_editar->key = $this->key->store('/', 'efirma');

                $this->modelo_editar->creado_por = auth()->user()->id;
                $this->modelo_editar->save();

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "La efirma se creó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al crear efirma por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function actualizar(){

        $this->validate();

        try{

            DB::transaction(function () {

                if($this->imagen){

                    if($this->modelo_editar->imagen)
                        Storage::disk('efirma')->delete($this->modelo_editar->imagen);

                    $this->modelo_editar->imagen = $this->imagen->store('/', 'efirma');

                }

                if($this->cer){

                    if($this->modelo_editar->cer)
                        Storage::disk('efirma')->delete($this->modelo_editar->cer);

                    $this->modelo_editar->cer = $this->cer->store('/', 'efirma');
                }


                if($this->key){

                    if($this->modelo_editar->key)
                        Storage::disk('efirma')->delete($this->modelo_editar->key);

                    $this->modelo_editar->key = $this->key->store('/', 'efirma');

                }

                $this->modelo_editar->actualizado_por = auth()->user()->id;
                $this->modelo_editar->save();

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "La efirma se actualizó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualzar efirma por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            $efirma = Efirma::find($this->selected_id);

            if($this->modelo_editar->imagen)
                Storage::disk('efirma')->delete($this->modelo_editar->imagen);

            if($this->modelo_editar->cer)
                Storage::disk('efirma')->delete($this->modelo_editar->cer);

            if($this->modelo_editar->key)
                Storage::disk('efirma')->delete($this->modelo_editar->key);

            $efirma->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La efirma se eliminó con exito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar efirma por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function prueba(Efirma $efirma){

        try {


            $fiel = Credential::openFiles(Storage::disk('efirma')->path($efirma->cer), Storage::disk('efirma')->path($efirma->key), $efirma->contraseña);

            $string = "KJBFLSDKJF#HRH#ROHÑOSDUIHSDFHSDUIFHÑSODIUHOEWUBHFUIOE$";

            $firma = $fiel->sign($string);

            dd(base64_encode($firma));


        } catch (\Throwable $th) {
            dd($th);
        }


    }

    public function mount(){

        $this->crearModeloVacio();

        $this->usuarios = User::orderBy('name')->get();

    }

    public function render()
    {

        $efirmas = Efirma::with('creadoPor', 'actualizadoPor', 'user')
                            ->whereHas('user',function($q){
                                $q->where('name', 'LIKE', '%' . $this->search . '%');
                            })
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.admin.efirmas', compact('efirmas'))->extends('layouts.admin');
    }
}
