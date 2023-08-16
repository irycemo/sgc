<?php

namespace App\Http\Livewire\Valuacion;

use App\Imports\AvaluoImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class FichaTecnica extends Component
{

    use WithFileUploads;

    public $file;

    public function procesar(){

        $import = new AvaluoImport;

        try {
            Excel::import($import, $this->file);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Error en la fila: " . $failure->row() . ", campo: " . $failure->attribute()]);

                break;
            }
       }


    }

    public function render()
    {
        return view('livewire.valuacion.ficha-tecnica')->extends('layouts.admin');
    }
}
