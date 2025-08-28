<?php

namespace App\Livewire\GestionCatastral\Captura;

use App\Models\File;
use App\Models\Predio;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class Archivo extends Component
{

    use WithFileUploads;

    public $predio;

    public $documento;

    #[On('cargarPredioPadron')]
    public function cargarPredio($id){

        $this->predio = Predio::find($id);

    }

    public function guardar(){

        $this->validate(['documento' => 'required']);

        try {

            DB::transaction(function () {

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

            $this->dispatch('mostrarMensaje', ['success', "El archivo se guradó con éxito."]);

            $this->predio->refresh();

            $this->dispatch('removeFiles');

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al guardar archivo en captura gestión catastral usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function anexarArchivoExistente($archivo_nuevo){

        $oMerger = PDFMerger::init();

        if(app()->isProduction()){

            $pdfContent = file_get_contents($this->predio->archivos->where('descripcion', 'archivo')->first()->url);

            $nombre_temp = Str::random(40) . '.pdf';

            Storage::put('livewire-tmp/'. $nombre_temp, $pdfContent);

            $oMerger->addPDF(Storage::path('tmp/'. $nombre_temp), 'all');

        }else{

            $archivo_preexistente = $this->predio->archivos->where('descripcion', 'archivo')->first()->url;

            $oMerger->addPDF(Storage::path('predios_archivo/'. $archivo_preexistente), 'all');

        }

        $oMerger->addPDF(Storage::path('predios_archivo/'. $archivo_nuevo), 'all');

        $oMerger->merge();

        $nombre_final = Str::random(40) . '.pdf';

        if(app()->isProduction()){

            Storage::disk('s3')->delete($archivo_preexistente);

            Storage::disk('s3')->delete($archivo_nuevo);

            Storage::disk('s3')->put('sgc/predios_archivo/' . $nombre_final, $oMerger->output());

        }else{

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

            $oMerger->addPDF(Storage::path('predios_archivo/'. $archivo_nuevo), 'all');

            $oMerger->merge();

            $nombre_final = Str::random(40) . '.pdf';

            if(app()->isProduction()){

                Storage::disk('s3')->delete($archivo_nuevo);

                Storage::disk('s3')->put('sgc/predios_archivo/' . $nombre_final, $oMerger->output());

            }else{

                Storage::disk('predios_archivo')->delete($archivo_nuevo);

                Storage::put('predios_archivo/' . $nombre_final, $oMerger->output());

            }

            return $nombre_final;

        }

    }

    public function render()
    {
        return view('livewire.gestion-catastral.captura.archivo');
    }
}
