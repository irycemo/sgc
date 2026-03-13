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

    public function __construct(public Predio $predio, public $documento, public $descripcion){}

    public function validaciones(){

        if(!$this->predio){

            throw new GeneralException('El predio es obligatorio para guardar el documento.');

        }

        if(!$this->documento){

            throw new GeneralException('El documento es obligatorio.');

        }

        if(!$this->descripcion){

            throw new GeneralException('La descripción es obligatoria.');

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

            $archivos_anteriores = File::where('fileable_id', $this->predio->id)
                                        ->where('fileable_type', 'App\Models\Predio')
                                        ->where(function($q){
                                            $q->where('descripcion', 'LIKE' , '%archivo_anterior%')
                                                ->orWhere('descripcion', 'LIKE' , '%traslado_anterior%')
                                                ->orWhere('descripcion', 'LIKE' , '%avaluo_anterior%')
                                                ->orWhere('descripcion', 'LIKE' , '%foto_anterior%');
                                        })
                                        ->first();

            if(!$archivos_anteriores){

                $this->cargarArchivosAntiguos();

            }

            File::create([
                'fileable_id' => $this->predio->id,
                'fileable_type' => 'App\Models\Predio',
                'descripcion' => $this->descripcion,
                'url' => $archivo_nuevo
            ]);

        });

    }

    public function cargarArchivosAntiguos(){

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

        }

        $archivos = json_decode($response, true);

        if(!isset($archivos['status'])) {

            foreach ($archivos['archivos'] as $key => $archivo) {

                $pdfContent = file_get_contents($archivo['url']);

                $nombre_temp = Str::random(40) . '.pdf';

                if(app()->isProduction()){

                    Storage::disk('s3')->put(config('services.ses.ruta_predios') . $nombre_temp, $pdfContent);

                }else{

                    Storage::put('predios_archivo/' . $nombre_temp, $pdfContent);

                }

                File::create([
                    'fileable_id' => $this->predio->id,
                    'fileable_type' => 'App\Models\Predio',
                    'descripcion' => 'archivo_anterior_' . $key,
                    'url' => $nombre_temp
                ]);

            }

            foreach ($archivos['traslados'] as $key => $archivo) {

                $pdfContent = file_get_contents($archivo['url']);

                $nombre_temp = Str::random(40) . '.pdf';

                if(app()->isProduction()){

                    Storage::disk('s3')->put(config('services.ses.ruta_predios') . $nombre_temp, $pdfContent);

                }else{

                    Storage::put('predios_archivo/' . $nombre_temp, $pdfContent);

                }

                File::create([
                    'fileable_id' => $this->predio->id,
                    'fileable_type' => 'App\Models\Predio',
                    'descripcion' => 'traslado_anterior_' . $key,
                    'url' => $nombre_temp
                ]);

            }

            foreach ($archivos['avaluos'] as $key => $archivo) {

                $pdfContent = file_get_contents($archivo['url']);

                $nombre_temp = Str::random(40) . '.pdf';

                if(app()->isProduction()){

                    Storage::disk('s3')->put(config('services.ses.ruta_predios') . $nombre_temp, $pdfContent);

                }else{

                    Storage::put('predios_archivo/' . $nombre_temp, $pdfContent);

                }

                File::create([
                    'fileable_id' => $this->predio->id,
                    'fileable_type' => 'App\Models\Predio',
                    'descripcion' => 'avaluo_anterior_' . $key,
                    'url' => $nombre_temp
                ]);

            }

            foreach ($archivos['fotos'] as $key => $archivo) {

                $pdfContent = file_get_contents($archivo['url']);

                $extension = pathinfo(parse_url($archivo['url'], PHP_URL_PATH), PATHINFO_EXTENSION);

                $nombre_temp = Str::random(40) . '.' . $extension;

                if(app()->isProduction()){

                    Storage::disk('s3')->put(config('services.ses.ruta_predios_fotos') . $nombre_temp, $pdfContent);

                }else{

                    Storage::put('predios_fotos/' . $nombre_temp, $pdfContent);

                }

                File::create([
                    'fileable_id' => $this->predio->id,
                    'fileable_type' => 'App\Models\Predio',
                    'descripcion' => 'foto_anterior_' . $key,
                    'url' => $nombre_temp
                ]);

            }

        }

    }

    public function guardarConUrl($archivo_nuevo){

        if(!$this->predio->getKey()){

            throw new GeneralException('El predio es obligatorio para guardar el documento.');

        }

        $pdfContent = file_get_contents(Storage::path($archivo_nuevo));

        $nombre_temp = Str::random(40) . '.pdf';

        if(app()->isProduction()){

            Storage::disk('s3')->put(config('services.ses.ruta_predios') . $nombre_temp, $pdfContent);

        }else{

            Storage::put('predios_archivo/' . $nombre_temp, $pdfContent);

        }

        File::create([
            'fileable_id' => $this->predio->id,
            'fileable_type' => 'App\Models\Predio',
            'descripcion' => $this->descripcion,
            'url' => $nombre_temp
        ]);

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

            if(Storage::exists('predios_archivo/'. $archivo_nuevo)){

                $oMerger->addPDF(Storage::path('predios_archivo/'. $archivo_nuevo), 'all');

            }

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

            $nombre_temp = Str::random(40) . '.' . $extension;

            if(app()->isProduction()){

                Storage::disk('s3')->put(config('services.ses.ruta_predios_fotos') . $nombre_temp, $image_contents);

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

            $extension = null;

        }

    }

}