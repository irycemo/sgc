<?php

namespace App\Services\Predio;

use App\Models\File;
use App\Models\Predio;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class ArchivoPredioService{

    public function __construct(public Predio $predio, public $documento){}

    public function validaciones(){

        if(!$this->predio){

            throw new GeneralException('El predio es obligatorio para guardar el documento.');

        }

        if(!$this->documento){

            throw new GeneralException('El documento es obligatorio.');

        }

    }

    public function guardar(){

        $this->validaciones();

        DB::transaction(function (){

            if(app()->isProduction()){

                $archivo_nuevo = $this->documento->store('sgc/predios_archivo', 's3');

            }else{

                $archivo_nuevo = $this->documento->store('/', 'predios_archivo');

            }

            if($this->predio->archivos->where('descripcion', 'archivo')->first()){

                $nombre_final = $this->anexarArchivoExistente($archivo_nuevo);

                $this->predio->archivos->where('descripcion', 'archivo')->first()->delete();

            }else{

                $nombre_final = $this->anexarArchivosAnteriores($archivo_nuevo);

            }

            File::create([
                'fileable_id' => $this->predio->id,
                'fileable_type' => 'App\Models\Predio',
                'descripcion' => 'archivo',
                'url' => $nombre_final ?? $archivo_nuevo
            ]);

        });

    }

    public function guardarConUrl($archivo_nuevo){

        if(!$this->predio->getKey()){

            throw new GeneralException('El predio es obligatorio para guardar el documento.');

        }

        DB::transaction(function () use ($archivo_nuevo){

            if($this->predio->archivos->where('descripcion', 'archivo')->first()){

                $nombre_final = $this->anexarArchivoExistenteConUrl($archivo_nuevo);

                $this->predio->archivos->where('descripcion', 'archivo')->first()->delete();

            }else{

                $nombre_final = $this->anexarArchivosAnterioresConUrl($archivo_nuevo);

            }

            File::create([
                'fileable_id' => $this->predio->id,
                'fileable_type' => 'App\Models\Predio',
                'descripcion' => 'archivo',
                'url' => $nombre_final ?? $archivo_nuevo
            ]);

        });

    }

    public function anexarArchivoExistente($archivo_nuevo){

        $oMerger = PDFMerger::init();

        if(app()->isProduction()){

            $archivo_preexistente = config('services.ses.ruta_predios') . $this->predio->archivos->where('descripcion', 'archivo')->first()->url;

            $pdfContent = Storage::disk('s3')->get($archivo_preexistente);

            $nombre_temp = Str::random(40) . '.pdf';

            Storage::put('livewire-tmp/'. $nombre_temp, $pdfContent);

            $oMerger->addPDF(Storage::path('livewire-tmp/'. $nombre_temp), 'all');

            $nombre_temp = null;

        }else{

            $archivo_preexistente = $this->predio->archivos->where('descripcion', 'archivo')->first()->url;

            if(Storage::exists('predios_archivo/'. $archivo_preexistente)){

                $oMerger->addPDF(Storage::path('predios_archivo/'. $archivo_preexistente), 'all');

            }

        }

        $nombre_final = Str::random(40) . '.pdf';

        if(app()->isProduction()){

            $pdfContent = Storage::disk('s3')->get($archivo_nuevo);

            $nombre_temp = Str::random(40) . '.pdf';

            Storage::put('livewire-tmp/'. $nombre_temp, $pdfContent);

            $oMerger->addPDF(Storage::path('livewire-tmp/'. $nombre_temp), 'all');

            $nombre_temp = null;

            $oMerger->merge();

            Storage::disk('s3')->delete($archivo_preexistente);

            Storage::disk('s3')->delete($archivo_nuevo);

            Storage::disk('s3')->put('sgc/predios_archivo/' . $nombre_final, $oMerger->output());

        }else{

            $oMerger->addPDF(Storage::path('predios_archivo/'. $archivo_nuevo), 'all');

            $oMerger->merge();

            Storage::disk('predios_archivo')->delete($archivo_nuevo);

            Storage::disk('predios_archivo')->delete($archivo_preexistente);

            Storage::put('predios_archivo/' . $nombre_final, $oMerger->output());

        }

        return $nombre_final;

    }

    public function anexarArchivosAnteriores($archivo_nuevo){

        $response = Http::accept('application/json')
                                ->get(
                                    config('services.consulta_archivos_anterior.archivos_url') .
                                    $this->predio->localidad .
                                    '&ofna=' . $this->predio->oficina .
                                    '&tpre=' . $this->predio->tipo_predio .
                                    '&nreg=' . $this->predio->numero_registro
                                );

        if($response->status() !== 200){

            throw new GeneralException('Error al consultar archivos anteriores.');

        }else{

            $oMerger = PDFMerger::init();

            $archivos = json_decode($response, true);

            if(!isset($archivos['status'])) {

                foreach ($archivos['archivos'] as $archivo) {

                    $pdfContent = file_get_contents($archivo['url']);

                    $nombre_temp = Str::random(40) . '.pdf';

                    Storage::put('livewire-tmp/'. $nombre_temp, $pdfContent);

                    $oMerger->addPDF(Storage::path('livewire-tmp/'. $nombre_temp), 'all');

                    $nombre_temp = null;

                }

                foreach ($archivos['traslados'] as $archivo) {

                    $pdfContent = file_get_contents($archivo['url']);

                    $nombre_temp = Str::random(40) . '.pdf';

                    Storage::put('livewire-tmp/'. $nombre_temp, $pdfContent);

                    $oMerger->addPDF(Storage::path('livewire-tmp/'. $nombre_temp), 'all');

                    $nombre_temp = null;

                }

                foreach ($archivos['avaluos'] as $archivo) {

                    $pdfContent = file_get_contents($archivo['url']);

                    $nombre_temp = Str::random(40) . '.pdf';

                    Storage::put('livewire-tmp/'. $nombre_temp, $pdfContent);

                    $oMerger->addPDF(Storage::path('livewire-tmp/'. $nombre_temp), 'all');

                    $nombre_temp = null;

                }

            }

            $nombre_final = Str::random(40) . '.pdf';

            if(app()->isProduction()){

                $pdfContent = Storage::disk('s3')->get($archivo_nuevo);

                $nombre_temp = Str::random(40) . '.pdf';

                Storage::put('livewire-tmp/'. $nombre_temp, $pdfContent);

                $oMerger->addPDF(Storage::path('livewire-tmp/'. $nombre_temp), 'all');

                $nombre_temp = null;

                $oMerger->merge();

                Storage::disk('s3')->delete($archivo_nuevo);

                Storage::disk('s3')->put('sgc/predios_archivo/' . $nombre_final, $oMerger->output());

            }else{

                $oMerger->addPDF(Storage::path('predios_archivo/'. $archivo_nuevo), 'all');

                $oMerger->merge();

                Storage::disk('predios_archivo')->delete($archivo_nuevo);

                Storage::put('predios_archivo/' . $nombre_final, $oMerger->output());

            }

            return $nombre_final;

        }

    }

    public function anexarArchivoExistenteConUrl($archivo_nuevo){

        $oMerger = PDFMerger::init();

        if(app()->isProduction()){

            $archivo_preexistente = config('services.ses.ruta_predios') . $this->predio->archivos->where('descripcion', 'archivo')->first()->url;

            $pdfContent = Storage::disk('s3')->get($archivo_preexistente);

            $nombre_temp = Str::random(40) . '.pdf';

            Storage::put('livewire-tmp/'. $nombre_temp, $pdfContent);

            $oMerger->addPDF(Storage::path('livewire-tmp/'. $nombre_temp), 'all');

            $nombre_temp = null;

        }else{

            $archivo_preexistente = $this->predio->archivos->where('descripcion', 'archivo')->first()?->url;

            if(Storage::exists('predios_archivo/'. $archivo_preexistente)){

                $oMerger->addPDF(Storage::path('predios_archivo/'. $archivo_preexistente), 'all');

            }

        }

        $oMerger->addPDF(Storage::path($archivo_nuevo), 'all');

        $oMerger->merge();

        $nombre_final = Str::random(40) . '.pdf';

        if(app()->isProduction()){

            Storage::disk('s3')->delete($archivo_preexistente);

            Storage::disk('s3')->put('sgc/predios_archivo/' . $nombre_final, $oMerger->output());

        }else{

            Storage::disk('predios_archivo')->delete($archivo_preexistente);

            Storage::put('predios_archivo/' . $nombre_final, $oMerger->output());

        }

        return $nombre_final;

    }

    public function anexarArchivosAnterioresConUrl($archivo_nuevo){

        $response = Http::accept('application/json')
                                ->get(
                                    config('services.consulta_archivos_anterior.archivos_url') .
                                    $this->predio->localidad .
                                    '&ofna=' . $this->predio->oficina .
                                    '&tpre=' . $this->predio->tipo_predio .
                                    '&nreg=' . $this->predio->numero_registro
                                );

        if($response->status() !== 200){

            throw new GeneralException('Error al consultar archivos anteriores.');

        }else{

            $oMerger = PDFMerger::init();

            $archivos = json_decode($response, true);

            if(!isset($archivos['status'])) {

                foreach ($archivos['archivos'] as $archivo) {

                    $pdfContent = file_get_contents($archivo['url']);

                    $nombre_temp = Str::random(40) . '.pdf';

                    Storage::put('livewire-tmp/'. $nombre_temp, $pdfContent);

                    $oMerger->addPDF(Storage::path('livewire-tmp/'. $nombre_temp), 'all');

                    $nombre_temp = null;

                }

                foreach ($archivos['traslados'] as $archivo) {

                    $pdfContent = file_get_contents($archivo['url']);

                    $nombre_temp = Str::random(40) . '.pdf';

                    Storage::put('livewire-tmp/'. $nombre_temp, $pdfContent);

                    $oMerger->addPDF(Storage::path('livewire-tmp/'. $nombre_temp), 'all');

                    $nombre_temp = null;

                }

                foreach ($archivos['avaluos'] as $archivo) {

                    $pdfContent = file_get_contents($archivo['url']);

                    $nombre_temp = Str::random(40) . '.pdf';

                    Storage::put('livewire-tmp/'. $nombre_temp, $pdfContent);

                    $oMerger->addPDF(Storage::path('livewire-tmp/'. $nombre_temp), 'all');

                    $nombre_temp = null;

                }

            }

            $oMerger->addPDF(Storage::path($archivo_nuevo), 'all');

            $oMerger->merge();

            $nombre_final = Str::random(40) . '.pdf';

            if(app()->isProduction()){

                Storage::disk('s3')->put('sgc/predios_archivo/' . $nombre_final, $oMerger->output());

            }else{

                Storage::put('predios_archivo/' . $nombre_final, $oMerger->output());

            }

            return $nombre_final;

        }

    }

    public function anexarFotosAlPredio($urls){

        foreach ($urls as $key => $value) {

            $image_contents = file_get_contents($value);

            $extension = pathinfo(parse_url($value, PHP_URL_PATH), PATHINFO_EXTENSION);

            $nombre_temp = Str::random(40) . '.' .$extension;

            if(app()->isProduction()){

                Storage::disk('s3')->put('sgc/predios_fotos/' . $nombre_temp, $image_contents);

            }else{

                Storage::put('predios_fotos/'. $nombre_temp, $image_contents);

            }

            File::create([
                'fileable_type' => 'App\Models\Predio',
                'fileable_id' => $this->predio->id,
                'url' => $nombre_temp,
                'descripcion' => $key
            ]);

            $nombre_temp = null;

            $$extension = null;

        }

    }

}