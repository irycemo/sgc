<?php

namespace App\Livewire\Valuacion;

use App\Exceptions\GeneralException;
use App\Imports\FichaTecnicaJobs;
use App\Jobs\Valuacion\CrearAvaluoChain;
use App\Models\Import;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class FichaTecnicaJob extends Component
{

    use WithFileUploads;

    public $documento;
    public $errores = [];

    public $batchId;
    public $concluido = false;
    public $generando = false;
    public $procesando = false;
    public $total;
    public $processed;
    public $progress;
    public $folios_generados;
    public $job_errors;
    public $avaluos_generados = [];

    protected function rules(){
        return [
            'documento' => 'nullable|max:100000',
        ];
    }

    public function procesar(){

        $this->reset('errores');

        $this->validate();

        $this->batchId = (string) Str::uuid();

        try {

            $import = new FichaTecnicaJobs($this->batchId);

            Excel::import($import, $this->documento);

            $this->documento = null;

            $imports = Import::where('batch_id', $this->batchId)->get();

            if($imports->count('predios_existente') === 0){

                throw new GeneralException("Es necesario un predio origen.");

            }

            if($imports->sum('predios_existente') > 1 && $imports->sum('predios_nuevos') > 0){

                throw new GeneralException("Solo puede haber un predio origen si hay predios que no existen en el padron.");

            }

            $errores = $imports->where('errores', '!=', null);

            if($errores->count()){

                foreach($errores as $error){

                    $decoded_errors = json_decode($error->errores);

                    foreach($decoded_errors as $decoded){

                        $this->errores [] = $decoded;

                    }


                }

                $this->eliminarImportRecords($this->batchId);

                return;

            }

            CrearAvaluoChain::dispatch($this->batchId, auth()->id());

            $this->procesando = true;

            $this->estadisticas();

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            $failures = $e->failures();

            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.

                $this->errores [] = "Error en la fila: " . $failure->row() . ". Campo: " . $failure->attribute() . ". " . $failure->errors()[0];

            }

            $this->eliminarImportRecords($this->batchId);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

            $this->eliminarImportRecords($this->batchId);

        } catch (\Throwable $th) {

            Log::error("Error al importar ficha técnica por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error"]);

            $this->eliminarImportRecords($this->batchId);

        }

    }

    public function estadisticas(){

        if($this->procesando){

            $query = DB::table('imports')
                ->where('batch_id', $this->batchId);

            $this->total = (clone $query)->count();

            $this->processed = (clone $query)
                ->where('status', 'processed')
                ->count();

            $this->job_errors = (clone $query)
                ->where('status', 'error')
                ->count();

            $this->progress = $this->total > 0
                ? intval(($this->processed / $this->total) * 100)
                : 0;

            if($this->processed === $this->total){

                $this->procesando = false;

                $this->avaluos_generados = Import::where('batch_id', $this->batchId)->pluck('info');

                $this->eliminarImportRecords($this->batchId);

                $this->dispatch('mostrarMensaje', ['success', 'Los avalúos se generaron con éxito.']);

            }

        }

    }

    public function eliminarImportRecords($batchId){

        Import::where('batch_id', $this->batchId)->delete();

    }

    public function descargarFicha(){

        return response()->download(storage_path('app/public/ficha_tecnica.xlsx'));

    }

    public function render()
    {
        return view('livewire.valuacion.ficha-tecnica-job')->extends('layouts.admin');
    }
}
