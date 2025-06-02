<?php

namespace App\Livewire\Valuacion;

use Livewire\Component;
use App\Imports\AvaluoImport;
use Livewire\WithFileUploads;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ValoresUnitariosRusticos;
use App\Models\ValoresUnitariosConstruccion;

class FichaTecnica extends Component
{

    use WithFileUploads;

    public $documento;
    public $data;
    public $vientos;
    public $valoresConstruccion;
    public $valoresRusticos;

    public function procesar(){

        $this->validate([
            'documento' => 'required'
        ]);

        $import = new AvaluoImport($this->valoresConstruccion, $this->valoresRusticos);

        try {

            Excel::import($import, $this->documento);

            $this->data = $import->data;

            $this->dispatch('mostrarMensaje', ['success', "Los avaluos se generaron con éxito"]);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            $failures = $e->failures();

            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.

                $this->dispatch('mostrarMensaje', ['error', "Error en la fila: " . $failure->row() . ", campo: " . $failure->attribute() ." ".$failure->errors()[0] ]);

                break;

            }

        }catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['error', $ex->getMessage()]);

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
