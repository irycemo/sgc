<?php

namespace App\Livewire\Valuacion;

use App\Constantes\Constantes;
use App\Exceptions\GeneralException;
use App\Imports\FichaTecnicaSimple;
use App\Models\ValoresUnitariosConstruccion;
use App\Models\ValoresUnitariosRusticos;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class FichaTecnica extends Component
{

    use WithFileUploads;

    public $documento;
    public $data;
    public $vientos;
    public $valoresConstruccion;
    public $valoresRusticos;
    public $errores;

    public function procesar(){

        $this->reset('errores');

        $this->validate([
            'documento' => 'required'
        ]);

        $import = new FichaTecnicaSimple($this->valoresConstruccion, $this->valoresRusticos);

        try {

            Excel::import($import, $this->documento);

            $this->data = $import->data;

            $this->dispatch('mostrarMensaje', ['success', "Los avaluos se generaron con éxito"]);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            $this->errores = '';

            foreach ($e->failures() as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.

                $this->errores .= "Error en la fila: " . $failure->row() . ". Campo: " . $failure->attribute() . ". " . $failure->errors()[0] . '<br>';

            }

            $this->dispatch('mostrarMensaje', ['warning', "La ficha contiene errores"]);

        }catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al importar ficha técnica por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error"]);

        }

        $this->dispatch('removeFiles');

        $this->reset('documento');

    }

    public function descargarFicha(){

        return response()->download(storage_path('app/public/ficha_tecnica.xlsx'));

    }

    public function mount(){

        $this->vientos = Constantes::VIENTOS;

        $this->valoresConstruccion = ValoresUnitariosConstruccion::all();

        $this->valoresRusticos = ValoresUnitariosRusticos::all();

    }

    public function render()
    {
        return view('livewire.valuacion.ficha-tecnica')->extends('layouts.admin');
    }

}
