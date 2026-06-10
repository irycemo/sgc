<?php

namespace App\Livewire\Valuacion;

use App\Jobs\Valuacion\FichaTecnicaJobsImportJob;
use App\Models\Import;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class FichaTecnicaJob extends Component
{

    use WithFileUploads;

    public $documento;
    public $batchId;
    public $estado = 'idle'; // idle | validando | procesando | completado | error
    public $errores = [];
    public $total = 0;
    public $procesados = 0;
    public $fallidos = 0;
    public $avaluos_generados = [];

    protected function rules() {
        return ['documento' => 'required|file|mimes:xlsx,xls|max:100000'];
    }

    public function procesar()
    {

        $this->reset('errores');

        $this->validate();

        $this->batchId = (string) Str::uuid();

        $this->estado = 'validando';

        $path = $this->documento->getRealPath();

        FichaTecnicaJobsImportJob::dispatch($this->batchId, $path, auth()->id());

    }

    public function polling()
    {

        if ($this->estado === 'idle' || $this->estado === 'completado') return;

        // Leer estado guardado por el job en cache
        $cache = Cache::get("import:{$this->batchId}");

        if (!$cache) return;

        $this->estado       = $cache['estado'];
        $this->errores      = $cache['errores'] ?? [];
        $this->total        = $cache['total'] ?? 0;
        $this->procesados   = $cache['procesados'] ?? 0;
        $this->fallidos     = $cache['fallidos'] ?? 0;

        if($this->total === $this->procesados){

            Cache::forget("import:{$this->batchId}");

            $this->avaluos_generados = Import::where('batch_id', $this->batchId)->pluck('info');

            Import::where('batch_id', $this->batchId)->delete();

            $this->dispatch('mostrarMensaje', ['success', 'Los avalúos se generaron con éxito.']);

            $this->estado === 'idle';

        }

        if($this->estado === 'error'){

            $this->estado === 'idle';

            Import::where('batch_id', $this->batchId)->delete();

        }

    }

    public function descargarFicha(){

        return response()->download(storage_path('app/public/ficha_tecnica_08-06-2026.xlsx'));

    }

    public function render()
    {
        return view('livewire.valuacion.ficha-tecnica-job')->extends('layouts.admin');
    }
}
