<?php

namespace App\Jobs\Certificaciones;

use App\Http\Controllers\Certificaciones\CertificadoRegistroController;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use App\Enums\Certificaciones\CertificacionesEnum;
use App\Models\Certificacion;
use Illuminate\Support\Facades\Log;
use Throwable;
use Opcodes\LogViewer\Facades\Cache;
use App\Models\Predio;
use App\Models\Tramite;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerarCertificadoRegistroJob implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;
    public int $timeout = 600;

    public function __construct(
        public Tramite $tramite,
        public Predio $predio,
        public User $user,
        public bool|string|null $observaciones = null,
        public ?string $claveProceso = null,
    ){}

    public function handle(): void
    {

        $this->actualizarEstado(['status' => 'procesando']);

        $controller = new CertificadoRegistroController();

        $pdf = DB::transaction(function () use ($controller) {

            $previa = Certificacion::where('tipo', CertificacionesEnum::CERTIFICADO_REGISTRO)
                                        ->where('tramite_id', $this->tramite->id)
                                        ->where('predio_id', $this->predio->id)
                                        ->where('estado', 'activo')
                                        ->first();

            if ($previa) {

                return $controller->reimprimirCertificado($previa);

            }

            $folio = (Certificacion::where('año', now()->format('Y'))->where('tipo', CertificacionesEnum::CERTIFICADO_REGISTRO)->max('folio') ?? 0) + 1;

            Certificacion::where('tipo', CertificacionesEnum::CERTIFICADO_REGISTRO)
                            ->where('año', now()->format('Y'))
                            ->where('folio', $folio)
                            ->lockForUpdate()
                            ->first();

            if ($this->tramite->estado !== 'concluido') {

                $this->tramite->predios()->updateExistingPivot($this->predio->id, ['estado' => 'I']);

                $this->tramite->refresh();

                $pendientes = $this->tramite->predios()->where('predio_tramite.estado', 'A')->count();

                if ($pendientes === 0) {

                    $this->tramite->update(['estado' => 'concluido']);

                    $this->tramite->audits()->latest()->first()?->update(['tags' => 'Finalizó trámite']);
                }

                $usados = $this->tramite->predios()->wherePivot('estado', 'I')->count();

                $this->tramite->update(['usados' => $usados]);

                $this->tramite->audits()->latest()->first()?->update(['tags' => 'Generó certificado del predio ' . $this->predio->cuentaPredial()]);
            }

            return $controller->certificado(
                $this->tramite,
                $this->predio,
                'CERTIFICADO DE REGISTRO CATASTRAL',
                $folio,
                $this->user,
                $this->observaciones
            );

        });

        $this->guardarEnS3($pdf);

    }

    private function guardarEnS3(object $pdf): void
    {

        $certificacion = Certificacion::where('tipo', CertificacionesEnum::CERTIFICADO_REGISTRO)
                                            ->where('tramite_id', $this->tramite->id)
                                            ->where('predio_id', $this->predio->id)
                                            ->latest('id')
                                            ->first();

        $filename = $this->predio->cuentaPredial() . '-' . now()->format('Ymd_His') . '.pdf';

        $clave = config('services.ses.ruta_pdfs_certificaciones') . $filename;

        Storage::disk('s3')->put(
            $clave,
            $pdf->output(),
            [
                'ContentType' => 'application/pdf',
                'ContentDisposition' => 'attachment; filename="' . $filename . '"',
            ]
        );

        $this->procesarRelacionFile($certificacion, $filename);

        $this->actualizarEstado([
            'status' => 'listo',
            's3_path' => $clave,
            'filename' => $filename,
        ]);

    }

    private function procesarRelacionFile(Certificacion $certificacion, string $file_name):void
    {

        if($certificacion->pdf){

            Storage::disk('s3')->delete(config('services.ses.ruta_pdfs_certificaciones') . $certificacion->pdf->url);

            $certificacion->pdf->delete();

        }

        File::create([
                'fileable_type' => Certificacion::class,
                'fileable_id' => $certificacion->id,
                'url' => $file_name,
                'descripcion' => 'pdf',
            ]);

    }

    private function actualizarEstado(array $nuevo): void
    {

        if (! $this->claveProceso) {

            return;

        }

        $actual = Cache::get($this->claveProceso) ?? [];

        Cache::put($this->claveProceso, array_merge($actual, $nuevo), now()->addMinutes(30));

    }

    public function failed(Throwable $exception): void
    {

        Log::error(
            'Fallo GenerarCertificadoRegistroJob tras agotar los intentos.',
            [
                'message' => $exception->getMessage(),
                'tramite_id' => $this->tramite->id,
                'predio_id' => $this->predio->id,
                'usuario_id' => $this->user->id,
                'trace' =>  $exception
            ]
        );

        if (! $this->claveProceso) {

            return;

        }

        Cache::put(
            $this->claveProceso,
            [
                'status' => 'error',
                'mensaje' => 'No fue posible generar el certificado. Intenta de nuevo.',
            ],
            now()->addMinutes(30)
        );

    }

}
