<?php

namespace App\Http\Livewire\Valuacion;

use Livewire\Component;
use App\Imports\AvaluoImport;
use Livewire\WithFileUploads;
use App\Http\Constantes\Constantes;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ValoresUnitariosRusticos;
use App\Models\ValoresUnitariosConstruccion;
use App\Exceptions\ErrorAlValidarLineaDeCaptura;
use App\Exceptions\ErrorALValidarSectorException;
use App\Exceptions\ErrorAlProcesarTerrenosException;
use App\Exceptions\ErrorAlProcesarCoordenadasException;
use App\Exceptions\ErrorAlProcesarColindanciasException;
use App\Exceptions\ErrorAlProcesarConstruccionesException;

class FichaTecnica extends Component
{

    use WithFileUploads;

    public $documento;
    public $data;
    public $vientos;
    public $valoresConstruccion;
    public $valoresRusticos;

    public function updatingDocumeto(){

        $this->reset('data');

    }

    public function procesar(){

        $this->validate([
            'documento' => 'required'
        ]);

        $import = new AvaluoImport;

        try {

            Excel::import($import, $this->documento);

            $this->data = $import->data;

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "Los avaluos se generaron con éxito"]);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            $failures = $e->failures();

            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Error en la fila: " . $failure->row() . ", campo: " . $failure->attribute() ." ".$failure->errors()[0] ]);

                break;

            }

       }catch (ErrorAlValidarLineaDeCaptura $e) {

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', $e->getMessage()]);

       }catch (ErrorAlProcesarCoordenadasException $e) {

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', $e->getMessage()]);

        }catch (ErrorAlProcesarColindanciasException $e) {

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', $e->getMessage()]);

        }catch (ErrorAlProcesarTerrenosException $e) {

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', $e->getMessage()]);

        }catch (ErrorAlProcesarConstruccionesException $e) {

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', $e->getMessage()]);

        }catch (ErrorALValidarSectorException $e) {

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', $e->getMessage()]);

        }

        $this->dispatchBrowserEvent('removeFiles');

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
