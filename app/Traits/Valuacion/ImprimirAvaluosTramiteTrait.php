<?php

namespace App\Traits\Valuacion;

use App\Exceptions\GeneralException;
use App\Jobs\Valuacion\GenerarAvaluoJob;
use App\Models\Avaluo;
use App\Models\Tramite;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use ZipArchive;

trait ImprimirAvaluosTramiteTrait
{

    public $año;
    public $folio;
    public $usuario;
    public $batch_id;
    public $concluido = false;
    public $generando = false;
    public $nombres = [];
    public $modal_imprimir = false;

    public function imprimirAvaluos(){

        $this->validate([
            'año' => 'required',
            'folio' => 'required',
            'usuario' => 'required',
        ]);

        try {

            $tramite = Tramite::where('año', $this->año)
                                    ->where('folio', $this->folio)
                                    ->where('usuario', $this->usuario)
                                    ->first();

            if(! $tramite) throw new GeneralException("El trámite no existe");

            $avaluos = Avaluo::select('id', 'tramite_inspeccion', 'estado', 'año', 'folio', 'usuario')
                                ->where('tramite_inspeccion', $tramite->id)
                                ->where('estado', '!=', 'nuevo')
                                ->get();

            if(! $avaluos->count()) throw new GeneralException(("No hay avalúos asociados a el trámite ingresado."));

            $jobs = [];

            foreach($avaluos as $avaluo){

                $nombre = $avaluo->año . '-' . $avaluo->folio . '-' . $avaluo->usuario . '_' . now()->timestamp;

                array_push($this->nombres, $nombre);

                $jobs[] = new GenerarAvaluoJob($avaluo->id, $nombre, auth()->user());

            }

            if (!empty($jobs)) {

                $bus = Bus::batch($jobs)->dispatch();

                $this->batch_id = $bus->id;

                $this->generando = true;

            }

       } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

       } catch (\Throwable $th) {

            Log::error("Error al imprimir avaluo en mis avaluos por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

       }

    }

    public function getBatchProperty()
    {

        if (!$this->batch_id) {

            return null;

        }

        return Bus::findBatch($this->batch_id);

    }

    public function updateProgress(){

        $this->concluido = $this->batch->finished();

        if ($this->concluido) {

            $this->generando = false;

        }

    }

    public function descargarAvaluos(){

        try {

            $oMerger = PDFMerger::init();

            $disk = Storage::disk('local');

            $zipFileName  = 'archivos_' . now()->timestamp . '.zip';

            $relativeZipPath = 'livewire-tmp/' . $zipFileName;

            $absoluteZipPath = $disk->path($relativeZipPath);

            $zip = new ZipArchive();

            $result = $zip->open(
                $absoluteZipPath,
                ZipArchive::CREATE | ZipArchive::OVERWRITE
            );

            if ($result !== true) {
                throw new \Exception(
                    'No fue posible crear el ZIP. Código: ' . $result
                );
            }

            foreach ($this->nombres as $archivo) {

                $relativePath = 'livewire-tmp/' . $archivo . '.pdf';

                if (! $disk->exists($relativePath)) {
                    continue;
                }

                $oMerger->addPDF(Storage::path($relativePath), 'all');

                $absolutePath = $disk->path($relativePath);

                $zip->addFile(
                    $absolutePath,
                    basename($archivo . '.pdf')
                );

            }

            $oMerger->merge();

            Storage::put('livewire-tmp/completo.pdf', $oMerger->output());

            $relativePath = 'livewire-tmp/completo.pdf';

            $absolutePath = $disk->path($relativePath);

            $zip->addFile(
                $absolutePath,
                basename('completo.pdf')
            );

            $zip->close();

            return response()->download(
                $absoluteZipPath,
                'avaluos.zip'
            )->deleteFileAfterSend(false);

        } catch (\Throwable $th) {
            Log::error("Error al imprimir avaluo en administracion por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

}