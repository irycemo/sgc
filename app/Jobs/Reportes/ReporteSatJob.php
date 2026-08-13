<?php

namespace App\Jobs\Reportes;

use Aws\S3\S3Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ReporteSatJob implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    private const CHUNK_SIZE = 5000;
    private const PART_SIZE = 16 * 1024 * 1024;

    public int $timeout = 3600;


    public function __construct()
    {}

    public function handle(): void
    {

        $disk = Storage::disk('s3');

        $client = $disk->getClient();

        $bucket = config('filesystems.disks.s3.bucket');

        $key = 'sgc/reportes/sat/C_MICH_SU_' . now()->subMonths(3)->format('Ym') . '_' . now()->format('Ym') . '.csv';

        $multipart = $client->createMultipartUpload([
            'Bucket' => $bucket,
            'Key' => $key,
            'ContentType' => 'txt/csv; charset=UTF-8',
            'ContentDisposition' => 'attachment; filename="sat.csv"'
        ]);

        $upload_id = $multipart['UploadId'];

        $parts = [];

        $part_number = 1;

        $stream = fopen(
                'php://temp/maxmemory:' . self::PART_SIZE,
                'w+b'
            );

        if($stream === false){

            throw new \RuntimeException('No se pudo crear el stream temporal.');

        }

        try {

            fwrite(
                $stream,
                "\xEF\xBB\xBF"
            );

            $this->writeCsvRow($stream, [
                'RFC',
                'CURP',
                'Tipo_persona',
                'razon_social',
                'nombre',
                'apellido_paterno',
                'apellido_materno',
                'nombre_completo',
                'calle',
                'numero_exterior',
                'numero_interior',
                'colonia',
                'localidad',
                'municipio',
                'codigo_postal',
                'domicilio_completo',
                'telefono',
                'correo_electronico',
                'año_o_ejercicio',
                'uso_1',
                'tipo_predio',
                'monto_de_rentas',
                'superficie_total_terreno',
                'valor_total_terreno',
                'superficie_total_construccion',
                'valor_total_construccion',
                'fecha_del_ultimo_movimiento',
                'tipo_movimiento',
                'clave_catastral',
                'valor_catastral',
            ]);

            $query = $this->buildPrediosQuery();

            $query->chunkById(self::CHUNK_SIZE,
                function($rows) use (
                                    &$parts,
                                    &$part_number,
                                    $stream,
                                    $client,
                                    $bucket,
                                    $key,
                                    $upload_id,
                                ){

                                    $predioIds = $rows->pluck('predio_id')->all();

                                    $propietarios = $this->getPropietarios($predioIds);

                                    $movimientos = $this->getMovimientos($predioIds);

                                    foreach ($rows as $row) {

                                        $propietario = $propietarios->get($row->predio_id);

                                        $movimiento = $movimientos->get($row->predio_id);

                                        $this->writeCsvRow($stream, [
                                                                        $propietario?->rfc ?? '',
                                                                        $propietario?->curp ?? '',
                                                                        $propietario?->tipo_persona ?? '',
                                                                        $propietario?->razon_social ?? '',
                                                                        $propietario?->nombre ?? '',
                                                                        $propietario?->apellido_paterno ?? '',
                                                                        $propietario?->apellido_materno ?? '',
                                                                        '',
                                                                        $row->calle_predio ?? '',
                                                                        $row->numero_exterior_predio ?? '',
                                                                        $row->numero_interior ?? '',
                                                                        $row->colonia_predio ?? '',
                                                                        $row->localidad_predio ?? '',
                                                                        $row->municipio_predio ?? '',
                                                                        $row->codigo_postal_predio ?? '',
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        now()->format('Y'),
                                                                        $row->uso_1 ?? '',
                                                                        $row->tipo_predio ?? '',
                                                                        '',
                                                                        $row->superficie_total_terreno ?? '',
                                                                        $row->valor_total_terreno ?? '',
                                                                        $row->superficie_total_construccion ?? '',
                                                                        $row->valor_total_construccion ?? '',
                                                                        $movimiento->fecha ?? '',
                                                                        $movimiento->nombre ?? '',
                                                                        "16" . '-' . $row->region_catastral . '-' . $row->municipio_predio . '-' . $row->zona_catastral . '-' . $row->localidad_predio . '-' . $row->sector . '-' . $row->manzana . '-' . $row->predio . '-' . $row->edificio . '-' . $row->departamento,
                                                                        $row->valor_catastral ?? '',
                                                                        ]
                                                            );

                                        if( ftell($stream) >= self::PART_SIZE){

                                            $parts[] = $this->uploadPart($client, $bucket, $key, $upload_id, $part_number, $stream);

                                            $part_number ++;

                                        }

                                    }

                                    $exportacion = Cache::get("reporte_sat");

                                    $exportacion['procesados'] = (int)$exportacion['procesados'] + $rows->count();

                                    Cache::put("reporte_sat", $exportacion, now()->addMinutes(10));

                                    unset($propietarios);

                                    unset($rows);

                                },
                                'predio.id', 'predio_id'
            );

            if (ftell($stream) > 0) {

                $parts[] = $this->uploadPart( $client, $bucket, $key, $upload_id, $part_number, $stream );

            }

            $client->completeMultipartUpload([
                'Bucket' => $bucket,
                'Key' => $key,
                'UploadId' => $upload_id,
                'MultipartUpload' => [ 'Parts' => $parts, ],
                ]);

            $exportacion = Cache::get("reporte_sat");

            $exportacion['status'] = 'completado';

            $exportacion['s3_path'] = $key;

            Cache::put("reporte_sat", $exportacion, now()->addMinutes(10));

        } catch (\Throwable $e) {

            try {

                $client->abortMultipartUpload([
                    'Bucket' => $bucket,
                    'Key' => $key,
                    'UploadId' => $upload_id,
                    ]);

            } catch (Throwable $th) {

                Cache::forget('reporte_sat');

                Log::error($th);

            }

            Log::error($e);

            Cache::forget('reporte_sat');

            throw $e;

        } finally {

            fclose($stream);

        }

    }

    private function buildPrediosQuery()
    {

        return DB::table('predios as predio')
                    ->select([
                        'predio.id as predio_id',
                        'predio.nombre_vialidad as calle_predio',
                        'predio.numero_exterior as numero_exterior_predio',
                        'predio.numero_interior',
                        'predio.predio',
                        'predio.nombre_asentamiento as colonia_predio',
                        'predio.localidad as localidad_predio',
                        'predio.municipio as municipio_predio',
                        'predio.codigo_postal as codigo_postal_predio',
                        'predio.uso_1',
                        'predio.tipo_predio',
                        'predio.superficie_total_terreno',
                        'predio.valor_total_terreno',
                        'predio.valor_total_construccion',
                        'predio.valor_catastral',
                        'predio.region_catastral',
                        'predio.zona_catastral',
                        'predio.sector',
                        'predio.manzana',
                        'predio.predio',
                        'predio.edificio',
                        'predio.departamento',
                    ]);

    }

    private function getPropietarios(array $predios_ids)
    {

        $primeros = DB::table('propietarios')
                        ->select(['propietarioable_id'])
                        ->selectRaw('MIN(id) AS propietario_id')
                        ->where('propietarioable_type', 'App\Models\Predio')
                        ->whereIn('propietarioable_id', $predios_ids)
                        ->groupBy('propietarioable_id');

        return DB::table('propietarios as propietario')
                    ->select(['propietarioable_id','persona_id'])
                    ->join('personas as persona', 'persona.id', '=' , 'propietario.persona_id')
                    ->joinSub($primeros, 'primer', function($join){
                        $join->on('primer.propietario_id', '=', 'propietario.id');
                    })
                    ->select([
                        'propietario.propietarioable_id',
                        'persona.rfc',
                        'persona.curp',
                        'persona.tipo as tipo_persona',
                        'persona.razon_social',
                        'persona.nombre',
                        'persona.ap_paterno as apellido_paterno',
                        'persona.ap_materno as apellido_materno',
                    ])
                    ->get()
                    ->keyBy('propietarioable_id');

    }

    private function getMovimientos(array $predios_ids)
    {

        $ultimos = DB::table('movimientos')
                    ->selectRaw('MAX(id) as movimiento_id')
                    ->whereIn('predio_id', $predios_ids)
                    ->groupBy('predio_id');

        return DB::table('movimientos as movimiento')
                    ->joinSub($ultimos, 'ultimo', function($join){
                        $join->on('ultimo.movimiento_id', '=', 'movimiento.id');
                    })
                    ->select(['movimiento.predio_id', 'movimiento.fecha', 'movimiento.descripcion', 'movimiento.nombre'])
                    ->get()
                    ->keyBy('predio_id');

    }

    private function writeCsvRow($stream, array $values): void
    {

        fputcsv($stream, $values, ',', '"', '', "\r\n");

    }

    private function uploadPart(S3Client $client, string $bucket, string $key, string $upload_id, int $part_number, $stream): array
    {

        fflush($stream);

        $size = ftell($stream);

        if($size === false || $size == 0){

            throw new \RuntimeException('Se intento subir una parte vacia al CSV.');

        }

        rewind($stream);

        $result = $client->uploadPart([
            'Bucket' => $bucket,
            'Key' => $key,
            'UploadId' => $upload_id,
            'PartNumber' => $part_number,
            'Body' => $stream,
            'ContentLength' => $size,
            ]);

        ftruncate($stream, 0);

        rewind($stream);

        return [
            'ETag' => $result['ETag'],
            'PartNumber' => $part_number
        ];

    }

}
