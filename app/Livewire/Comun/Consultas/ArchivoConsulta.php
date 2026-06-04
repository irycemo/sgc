<?php

namespace App\Livewire\Comun\Consultas;

use App\Models\File;
use App\Models\Predio;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class ArchivoConsulta extends Component
{

    public $predio_id;
    public $predio;
    public $archivos = [];
    public $fotos;
    public $archivos_anteriores;
    public $flag_borrar = true;

    public function placeholder()
    {
        return view('livewire.comun.consultas.archivo-consulta-placeholder');
    }

    #[On('refresh')]
    public function refresh(){

        if($this->predio)
            $this->predio->refresh();

    }

    #[On('actualizarPredio')]
    public function actualizarPredio($id){

        $this->predio = Predio::find($id);

        $this->cargarArchivosAnteriores();

    }

    public function borrarArchivo(File $archivo){

        try {

            if(app()->isProduction()){

                if (Storage::disk('s3')->exists(config('services.ses.ruta_predios') . $archivo->url)) {

                    Storage::disk('s3')->delete(config('services.ses.ruta_predios') . $archivo->url);

                }

            }else{

                if (Storage::disk('predios_archivo')->exists($archivo->url)) {

                    Storage::disk('predios_archivo')->delete($archivo->url);

                }

            }

            $archivo->delete();

        } catch (\Throwable $th) {
            Log::error("Error al borrar archivo en captura al padron por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function cargarArchivosAnteriores(){

        $this->archivos_anteriores = File::where('fileable_id', $this->predio->id)
                                        ->where('fileable_type', 'App\Models\Predio')
                                        ->where(function($q){
                                            $q->where('descripcion', 'LIKE' , '%archivo_anterior%')
                                                ->orWhere('descripcion', 'LIKE' , '%traslado_anterior%')
                                                ->orWhere('descripcion', 'LIKE' , '%avaluo_anterior%')
                                                ->orWhere('descripcion', 'LIKE' , '%foto_anterior%');
                                        })
                                        ->first();

        if(!$this->archivos_anteriores){

            $municipio = 'morelia';

            $localidad = $this->predio->localidad;

            $numero_registro = str_pad($this->predio->numero_registro, 6, '0', STR_PAD_LEFT);

            $cuenta_predial = $this->predio->localidad . '-' . $this->predio->oficina . '-' . $this->predio->tipo_predio . '-' . $numero_registro;

            $ruta_avaluos = '223/wwwroot/sgc/digi/' . $municipio . '/' . $localidad . '/a';

            $ruta_archivos = '223/wwwroot/sgc/digi/' . $municipio . '/' . $localidad . '/arch';

            $ruta_fotos = '223/wwwroot/sgc/digi/' . $municipio . '/' . $localidad . '/fotos';

            $ruta_traslados = '223/wwwroot/sgc/digi/' . $municipio . '/' . $localidad . '/td';

            $avaluos = $this->getFileUrls($ruta_avaluos, $cuenta_predial);

            $archivos = $this->getFileUrls($ruta_archivos, $cuenta_predial);

            $fotos = $this->getFileUrls($ruta_fotos, $cuenta_predial);

            $traslados = $this->getFileUrls($ruta_traslados, $cuenta_predial);

            $this->archivos = [
                'avaluos' => $avaluos,
                'archivos' => $archivos,
                'fotos' => $fotos,
                'traslados' => $traslados,
            ];

        }

    }

    public function getFileUrls(string $folder, string $prefix): array
    {

        $disk = Storage::disk('s3_documental');

        $client = $disk->getClient(); // S3Client de AWS SDK

        $bucket = config('filesystems.disks.s3_documental.bucket');

        // S3 filtra por prefijo directamente en el servidor
        $fullPrefix = ltrim("{$folder}/{$prefix}", '/');

        $urls = [];

        $params = [
            'Bucket' => $bucket,
            'Prefix' => $fullPrefix,
        ];

        // Paginación automática: maneja internamente los 1000 resultados por página
        $paginator = $client->getPaginator('ListObjectsV2', $params);

        foreach ($paginator as $page) {

            foreach ($page['Contents'] ?? [] as $object) {

                $urls[] = $disk->temporaryUrl($object['Key'], now()->addMinutes(60));

            }

        }

        return $urls;

    }

    public function mount(){

        $this->predio = Predio::find($this->predio_id);

        if(!$this->predio){

            $this->dispatch('mostrarMensaje', ['warning', "Debe cargar primero el predio."]);

            return;

        }

        $this->cargarArchivosAnteriores();

        $this->flag_borrar = url()->previous() == route('captura_padron');

    }

    public function render()
    {
        return view('livewire.comun.consultas.archivo-consulta');
    }

}
