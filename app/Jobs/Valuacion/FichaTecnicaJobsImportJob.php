<?php

namespace App\Jobs\Valuacion;

use App\Imports\FichaTecnicaJobs;
use App\Models\Import;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class FichaTecnicaJobsImportJob implements ShouldQueue
{
    use Queueable;
    use Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $batch_id, public string $path, public int$userId)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {

            $import = new FichaTecnicaJobs($this->batch_id, $this->userId);

            Excel::import($import, $this->path);

            $imports = Import::where('batch_id', $this->batch_id)->get();

            $errores = $this->recopilarErrores($imports);

            if (! empty($errores)) {

                Import::where('batch_id', $this->batch_id)->delete();

                $this->publicarEstado(['estado' => 'error', 'errores' => $errores]);

                return;

            }

            $errorGlobal = $this->validarReglasCruzadas($imports);

            if ($errorGlobal) {

                Import::where('batch_id', $this->batch_id)->delete();

                $this->publicarEstado(['estado' => 'error', 'errores' => [$errorGlobal]]);

                return;

            }

            $total = $imports->count();

            $this->publicarEstado(['estado' => 'procesando', 'total' => $total, 'procesados' => 0]);

            $jobs = $imports->map(fn($row) => new CrearAvaluoJob(
                                                                    $row->id,
                                                                    json_decode($row->data, true),
                                                                    $this->userId,
                                                                    $this->batch_id
                                                                ))
                                                                ->all();
            $batch_id = $this->batchId;

            Bus::chain($jobs)
                ->catch(function (Throwable $e) use($batch_id){

                    Log::error("Error en batch {$batch_id}: " . $e->getMessage());

                })
                ->dispatch();

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            Import::where('batch_id', $this->batch_id)->delete();

            $errores = $this->formatearErroresExcel($e->failures());

            $this->publicarEstado(['estado' => 'error', 'errores' => $errores]);

        } catch (Throwable $th) {

            Import::where('batch_id', $this->batch_id)->delete();

            Log::error("Error en FichaTecnicaJobsImportJob [{$this->batch_id}]: " . $th);

            $this->publicarEstado(['estado' => 'error', 'errores' => ['Ocurrió un error inesperado al procesar el archivo.']]);

        }

    }

    private function recopilarErrores($imports): array
    {

        $errores = [];

        foreach ($imports->where('errores', '!=', null) as $import) {

            foreach (json_decode($import->errores) as $error) {

                $errores[] = $error;

            }

        }

        return $errores;

    }

    private function publicarEstado(array $data): void
    {

        Cache::put("import:{$this->batch_id}", $data, now()->addMinutes(20));

    }

    private function validarReglasCruzadas($imports): ?string
    {

        $predio_origen = $imports->whereNotNull('predio_origen')->count();

        if ($predio_origen > 1) {

            return "Solo puede haber un predio origen.";

        }

        if ($predio_origen === 1 && $imports->sum('predios_nuevos') == 0) {

            return "Debe haber al menos un predio nuevo si hay un predio origen.";

        }

        if ($imports->sum('predios_nuevos') > 0 && $predio_origen != 1) {

            return "Debe haber un predio origen si hay predios nuevos.";

        }

        return null;

    }

    private function formatearErroresExcel(array $failures): array
    {

        return array_map(fn($f) =>
            "Fila {$f->row()}, campo '{$f->attribute()}': {$f->errors()[0]}",
            $failures
        );

    }


}
