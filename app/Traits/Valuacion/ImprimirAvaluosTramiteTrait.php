<?php

namespace App\Traits\Valuacion;

use App\Exceptions\GeneralException;
use App\Jobs\Valuacion\GenerarAvaluoJob;
use App\Jobs\Valuacion\MergePdfsJob;
use App\Models\Avaluo;
use App\Models\Tramite;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
    public $merged_name;

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

                $this->merged_name = $this->año . '-' . $this->folio . '-' . $this->usuario . '_' . now()->timestamp . '.pdf';

                $bus = Bus::batch($jobs)
                            ->then(function (Batch $batch){

                                MergePdfsJob::dispatch($batch->id, $this->nombres, $this->merged_name);

                            })
                            ->dispatch();

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

        $this->js('window.open(\' '. route('descargar_avaluos_pdf', $this->merged_name) . '\', \'_blank\');');

    }

}