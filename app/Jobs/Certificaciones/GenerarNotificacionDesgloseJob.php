<?php

namespace App\Jobs\Certificaciones;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Predio;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Facades\Cache;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Avaluo;
use App\Enums\Certificaciones\CertificacionesEnum;
use App\Models\Certificacion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Certificaciones\NotificacionValorCatastralController;
use App\Models\User;
use App\Models\Tramite;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;

class GenerarNotificacionDesgloseJob implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;
    public int $timeout = 600;

    public function __construct(
        public array $avaluos_ids,
        public Tramite $tramite_inspeccion,
        public Tramite $tramite_desglose,
        public Predio $predio_padre,
        public User $user,
        public ?string $claveProceso = null,
    ){}

    public function handle(): void
    {

        $this->actualizarEstado(['status' => 'procesando']);

        $controller = new NotificacionValorCatastralController();

        $año = now()->format('Y');

        $pdf = DB::transaction(function () use ($controller, $año) {

            Certificacion::where('tipo', CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL)
                            ->where('año', $año)
                            ->lockForUpdate()
                            ->first();

            $previa = Certificacion::where('tipo', CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL)
                                        ->where('tramite_id', $this->tramite_inspeccion->id)
                                        ->where('estado', 'activo')
                                        ->first();

            if ($previa) {

                return $controller->reimprimirNotifiacionValorCatastral($previa);

            }

            $folio = (Certificacion::where('año', now()->format('Y'))->where('tipo', CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL)->max('folio') ?? 0) + 1;

            Certificacion::where('tipo', CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL)
                            ->where('año', now()->format('Y'))
                            ->where('folio', $folio)
                            ->lockForUpdate()
                            ->first();

            $avaluos = Avaluo::with('predioAvaluo')->whereIn('id', $this->avaluos_ids)->get();

            foreach ($avaluos as $avaluo) {

                $avaluo->update([
                            'tramite_inspeccion' => $this->tramite_inspeccion?->id,
                            'tramite_desglose' => $this->tramite_desglose->id,
                            'actualizado_por' => $this->user->id,
                            'estado' => 'impreso'
                        ]);

                $avaluo->predioAvaluo->update(['status' => 'impreso']);

                $avaluo->audits()->latest()->first()?->update(['tags' => 'Imprimió avalúo', 'tramite_id' => $this->tramite_inspeccion->id]);

            }

            $this->tramite_inspeccion->predios()->detach();

            $this->tramite_inspeccion->predios()->attach($this->predio_padre->id);

            $this->actualizarTramiteInspeccion();

            $this->actualizarTramiteDesglose();

            return $controller->desglose(
                $this->avaluos_ids,
                $this->tramite_inspeccion,
                $this->tramite_desglose,
                $this->predio_padre->id,
                $this->user
            );

        });

        $this->guardarEnS3($pdf);

        $certificacion = Certificacion::where('tramite_id', $this->tramite_inspeccion->id)->where('estado', 'activo')->first();

        GenerarImagenVerificacionJob::dispatch($certificacion->id);

    }

    private function guardarEnS3(object $pdf): void
    {

        $certificacion = Certificacion::where('tipo', CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL)
                                            ->where('tramite_id', $this->tramite_inspeccion->id)
                                            ->latest('id')
                                            ->first();

        $filename = 'Notificacion_valor_catastral-' . $this->tramite_inspeccion->folioTramite() . '_' . now()->format('Ymd_His') . '.pdf';

        $clave = config('services.ses.ruta_pdfs_certificaciones') . $filename;

        if(app()->isProduction()){

            Storage::disk('s3')->put(
                $clave,
                $pdf->output(),
                [
                    'ContentType' => 'application/pdf',
                    'ContentDisposition' => 'attachment; filename="' . $filename . '"',
                ]
            );

        }else{

            Storage::put('certificaciones/' . $filename, $pdf->output());

        }

        $this->procesarRelacionFile($certificacion, $filename);

        $this->actualizarEstado([
            'status' => 'listo',
            's3_path' => $clave,
            'filename' => $filename,
        ]);

    }

    private function procesarRelacionFile(Certificacion $certificacion, string $file_name):void
    {

        DB::transaction(function () use($certificacion, $file_name){

            $certificacion = Certificacion::whereKey($certificacion->id)->lockForUpdate()->first();

            File::where('fileable_type', Certificacion::class)
                    ->where('fileable_id', $certificacion->id)
                    ->where('descripcion', 'pdf')
                    ->get()
                    ->each(function(File $anterior){

                        Storage::disk('s3')->delete(config('services.ses.ruta_pdfs_certificaciones'). $anterior->url);

                        $anterior->delete();

                    });

            File::create([
                'fileable_type' => Certificacion::class,
                'fileable_id' => $certificacion->id,
                'url' => $file_name,
                'descripcion' => 'pdf',
            ]);

        });

    }

    private function actualizarEstado(array $nuevo): void
    {

        if (! $this->claveProceso) {

            return;

        }

        $actual = Cache::get($this->claveProceso) ?? [];

        Cache::put($this->claveProceso, array_merge($actual, $nuevo), now()->addMinutes(30));

    }

    private function actualizarTramiteInspeccion(){

        $this->tramite_inspeccion->update([
            'usados' => count($this->avaluos_ids) + $this->tramite_inspeccion->usados,
            'ligado_a' => $this->tramite_desglose->id
        ]);

        if($this->tramite_inspeccion->usados >= $this->tramite_inspeccion->cantidad){

            $this->tramite_inspeccion->update(['estado' => 'concluido']);

        }

    }

    public function actualizarTramiteDesglose(){

        $this->tramite_desglose->update([
            'usados' => count($this->avaluos_ids) + $this->tramite_desglose->usados,
            'ligado_a' => $this->tramite_inspeccion->id
        ]);

        if($this->tramite_desglose->cantidad <= $this->tramite_desglose->usados)
            $this->tramite_desglose->update(['estado' => 'concluido']);

    }

    public function failed(Throwable $exception): void
    {

        Log::error(
            'Fallo GenerarNotificacionGeneralJob tras agotar los intentos.',
            [
                'message' => $exception->getMessage(),
                'tramite_id' => $this->tramite_inspeccion->id,
                'tramite' => $this->tramite_inspeccion->folioTramite(),
                'usuario_id' => $this->user->id,
                'usuario' => $this->user->name,
                'trace' =>  $exception->getTraceAsString()
            ]
        );

        if (! $this->claveProceso) {

            return;

        }

        Cache::put(
            $this->claveProceso,
            [
                'status' => 'error',
                'mensaje' => 'No fue posible generar la notificación de valor catastral. Intenta de nuevo.',
            ],
            now()->addMinutes(30)
        );

    }

}
