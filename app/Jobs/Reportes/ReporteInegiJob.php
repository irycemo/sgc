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

class ReporteInegiJob implements ShouldQueue
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

        $key = 'sgc/reportes/inegi/REPORTE_INEGI_' . now()->format('d_m_Y') . '.csv';

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
                'CLAVE_CATASTRAL',
                'ESTADO',
                'LOCALIDAD',
                'NUMERO_EXTERIOR',
                'NIVEL',
                'TIPO_TENENCIA',
                'USO_DE_SUELO',
                'SUPERFICIE_CONSTRUCCION',
                'VALOR_DEL_ULTIMO_AVALUO',
                'TIPO_VIALIDAD',
                'FOLIO_REAL',
                'MUNICIPIO',
                'ASENTAMIENTO_HUMANO',
                'NUMERO_INTERIOR',
                'CURT',
                'AMBITO',
                'SUPERFICIE_TERRENO',
                'VALOR_CATASTRAL',
                'TIPO_INSTITUCION',
                'VIALIDAD'
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

                                    /* $avaluos = $this->getAvaluos($predioIds); */

                                    foreach ($rows as $row) {

                                        /* $avaluo = $avaluos->get($row->predio_id); */

                                        $this->writeCsvRow($stream, [
                                                                        "16" . '-' . $row->region_catastral . '-' . $row->municipio . '-' . $row->zona_catastral . '-' . $row->localidad . '-' . $row->sector . '-' . $row->manzana . '-' . $row->predio . '-' . $row->edificio . '-' . $row->departamento,
                                                                        'MICHOACÁN',
                                                                        $row->localidad ?? '',
                                                                        $row->numero_exterior ?? '',
                                                                        '',
                                                                        '',
                                                                        $row->uso_1 ?? '',
                                                                        $row->superficie_total_construccion ?? '',
                                                                        $row->valor_catastral ?? '',
                                                                        $row->tipo_vialidad ?? '',
                                                                        $row->folio_real ?? '',
                                                                        $row->municipio ?? '',
                                                                        '',
                                                                        $row->numero_interior ?? '',
                                                                        $row->curt ?? '',
                                                                        '',
                                                                        $row->superficie_total_terreno ?? '',
                                                                        $row->valor_catastral ?? '',
                                                                        '',
                                                                        $row->nombre_vialidad ?? '',
                                                                        ]
                                                            );

                                        if( ftell($stream) >= self::PART_SIZE){

                                            $parts[] = $this->uploadPart($client, $bucket, $key, $upload_id, $part_number, $stream);

                                            $part_number ++;

                                        }

                                    }

                                    $exportacion = Cache::get("reporte_inegi");

                                    $exportacion['procesados'] = (int)$exportacion['procesados'] + $rows->count();

                                    Cache::put("reporte_inegi", $exportacion, now()->addMinutes(10));

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

            $exportacion = Cache::get("reporte_inegi");

            $exportacion['status'] = 'completado';

            $exportacion['s3_path'] = $key;

            Cache::put("reporte_inegi", $exportacion, now()->addMinutes(10));

        } catch (\Throwable $e) {

            try {

                $client->abortMultipartUpload([
                    'Bucket' => $bucket,
                    'Key' => $key,
                    'UploadId' => $upload_id,
                    ]);

            } catch (Throwable $th) {

                Cache::forget('reporte_inegi');

                Log::error($th);

            }

            Log::error($e);

            Cache::forget('reporte_inegi');

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
                        'predio.nombre_vialidad',
                        'predio.numero_exterior',
                        'predio.numero_interior',
                        'predio.predio',
                        'predio.localidad',
                        'predio.municipio',
                        'predio.uso_1',
                        'predio.tipo_predio',
                        'predio.superficie_total_terreno',
                        'predio.superficie_total_construccion',
                        'predio.valor_catastral',
                        'predio.region_catastral',
                        'predio.zona_catastral',
                        'predio.sector',
                        'predio.manzana',
                        'predio.predio',
                        'predio.edificio',
                        'predio.departamento',
                        'predio.folio_real',
                        'predio.curt',
                    ]);

    }

    private function getAvaluos(array $predios_ids)
    {

        $ultimos = DB::table('avaluos')
                    ->selectRaw('MAX(id) as avaluo_id')
                    ->whereIn('predio_id', $predios_ids)
                    ->groupBy('predio_id');

        return DB::table('avaluos as avaluo')
                    ->select(['avaluo_id','predio_avaluo'])
                    ->join('predio_avaluos as predio', 'predio.id', '=' , 'avaluo.predio_avaluo')
                    ->joinSub($ultimos, 'ultimo', function($join){
                        $join->on('ultimo.avaluo_id', '=', 'avaluo.id');
                    })
                    ->select([
                        'avaluo.id',
                        'predio.valor_catastral',
                        'persona.curp',
                        'persona.tipo as tipo_persona',
                        'persona.razon_social',
                        'persona.nombre',
                        'persona.ap_paterno as apellido_paterno',
                        'persona.ap_materno as apellido_materno',
                    ])
                    ->get()
                    ->keyBy('avaluo_id');
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
