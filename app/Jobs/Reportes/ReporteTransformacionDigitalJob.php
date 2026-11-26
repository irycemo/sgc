<?php

namespace App\Jobs\Reportes;

use Illuminate\Contracts\Queue\ShouldQueue;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Predio;
use App\Models\Propietario;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;

class ReporteTransformacionDigitalJob implements ShouldQueue
{

    use Queueable;
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    private const CHUNK_SIZE = 5000;
    private const PART_SIZE = 16 * 1024 * 1024;

    public int $timeout = 36000;

    public function __construct()
    {}

    public function handle(): void
    {

        $disk = Storage::disk('s3');

        $client = $disk->getClient();

        $bucket = config('filesystems.disks.s3.bucket');

        $key = 'sgc/reportes/trasnformacion_digital/AT_DT_' . now()->subMonths(3)->format('Ym') . '_' . now()->format('Ym') . '.csv';

        $multipart = $client->createMultipartUpload([
            'Bucket' => $bucket,
            'Key' => $key,
            'ContentType' => 'txt/csv; charset=UTF-8',
            'ContentDisposition' => 'attachment; filename="trasnformacion_digital.csv"'
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
                'cve_cat_est',
                'cve_cat_ori',
                'cve_ent',
                'cve_mun',
                'cve_sector',
                'cve_zona_cat',
                'cve_ah',
                'clasif_tenencia',
                'tipo_tenencia',
                'cve_prop_pos',
                'tot_prop_pos',
                'no_cuenta_predial',
                'nom_predio',
                'nom_loc',
                'nom_centro_urb',
                'cartog_nom_div',
                'curt',
                'cp',
                'ubic_predio_nivel',
                'pred_ubic_mzna',
                'numextalf',
                'numextnum',
                'numintalf',
                'ambito_predio',
                'anio_construccion',
                'sup_constr_comun',
                'sup_construccion',
                'sup_totalterreno',
                'sup_unidadmedida',
                'pred_fondo',
                'pred_frente',
                'pred_forma',
                'cent_pred_lat',
                'cent_pred_lon',
                'categoria_vial',
                'cve_viacom',
                'cve_vialref1',
                'cve_vialref2',
                'cve_vialref3',
                'nomvial',
                'tipovial',
                'nomasen',
                'tipoasen',
                'tipo_infraestruct',
                'facilidad_comunic',
                'desc_facilcomunic',
                'dist_centro_urb',
                'dist_via_com',
                'tipo_relieve',
                'cond_agrologicas',
                'clase_tierra',
                'uso_suelo',
                'desc_uso_suelo',
                'desc_disp_agua',
                'valor_construccion',
                'valor_terreno',
                'valor_operacion'
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

                                    foreach ($rows as $row) {

                                        $propietarios = Propietario::where('propietarioable_type', Predio::class)->where('propietarioable_id', $row->predio_id)->count();

                                        $this->writeCsvRow($stream, [
                                                                        '',
                                                                        "16" . '-' . $row->region_catastral . '-' . $row->municipio . '-' . $row->zona_catastral . '-' . $row->localidad . '-' . $row->sector . '-' . $row->manzana . '-' . $row->predio . '-' . $row->edificio . '-' . $row->departamento,
                                                                        16,
                                                                        $row->municipio,
                                                                        $row->sector,
                                                                        $row->zona_catastral,
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        $propietarios,
                                                                        $row->localidad . '-' . $row->oficina . '-' . $row->tipo_predio . '-' . $row->numero_registro,
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        $row->codigo_postal,
                                                                        '',
                                                                        $row->ubicacion_en_manzana,
                                                                        $row->numero_exterior,
                                                                        '',
                                                                        $row->numero_interior,
                                                                        $row->tipo_predio == 1 ? 'Urbano' : 'Rural',
                                                                        '',
                                                                        $row->area_comun_construccion,
                                                                        $row->superficie_total_construccion,
                                                                        $row->superficie_total_terreno,
                                                                        $row->tipo_predio == 1 ? 'metros cuadrados' : 'hectareas',
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        $row->lat,
                                                                        $row->lon,
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        $row->nombre_vialidad,
                                                                        $row->tipo_vialidad,
                                                                        $row->nombre_asentamiento,
                                                                        $row->tipo_asentamiento,
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        '',
                                                                        $row->uso_1,
                                                                        '',
                                                                        '',
                                                                        $row->valor_total_construccion,
                                                                        $row->valor_total_terreno,
                                                                        ''
                                                                    ]
                                                            );

                                        if( ftell($stream) >= self::PART_SIZE){

                                            $parts[] = $this->uploadPart($client, $bucket, $key, $upload_id, $part_number, $stream);

                                            $part_number ++;

                                        }

                                    }

                                    $exportacion = Cache::get("reporte_at_dt");

                                    $exportacion['procesados'] = (int)$exportacion['procesados'] + $rows->count();

                                    Cache::put("reporte_at_dt", $exportacion, now()->addMinutes(10));

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

            $exportacion = Cache::get("reporte_at_dt");

            $exportacion['status'] = 'completado';

            $exportacion['s3_path'] = $key;

            Cache::put("reporte_at_dt", $exportacion, now()->addMinutes(10));

        } catch (\Throwable $e) {

            try {

                $client->abortMultipartUpload([
                    'Bucket' => $bucket,
                    'Key' => $key,
                    'UploadId' => $upload_id,
                    ]);

            } catch (Throwable $th) {

                Cache::forget('reporte_at_dt');

                Log::error($th);

            }

            Log::error($e);

            Cache::forget('reporte_at_dt');

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
                        'predio.oficina',
                        'predio.nombre_asentamiento',
                        'predio.localidad',
                        'predio.municipio',
                        'predio.codigo_postal',
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
                        'predio.numero_registro',
                        'predio.departamento',
                        'predio.ubicacion_en_manzana',
                        'predio.area_comun_construccion',
                        'predio.superficie_total_construccion',
                        'predio.lat',
                        'predio.lon',
                        'predio.tipo_vialidad',
                        'predio.nombre_vialidad',
                        'predio.nombre_asentamiento',
                        'predio.tipo_asentamiento'
                    ]);

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
