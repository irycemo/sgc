<?php

namespace App\Livewire\Comun\Consultas;

use Livewire\Component;
use App\Models\Traslado;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Services\SistemaPeritosExternos\SistemaPeritosExternosService;
use App\Services\SistemaTramitesLinea\SistemaTramitesLineaService;

class TrasladosConsulta extends Component
{

    public $traslados;
    public $predio_id;

    public function imprimirAviso(Traslado $traslado){

        try {

            $data = (new SistemaTramitesLineaService())->generarAvisoPdf($traslado->aviso_stl);

            $pdf = base64_decode($data['data']['pdf']);

            /* $this->js('window.open(\' '. $pdf . '\', \'_blank\');'); */

            return response()->streamDownload(
                fn () => print($pdf),
                'aviso.pdf'
            );

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al generar pdf del aviso en consulta de predios por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function imprimirAvaluo(Traslado $traslado){

        try {

            $data = (new SistemaPeritosExternosService())->generarAvaluoPdf($traslado->avaluo_spe);

            $pdf = base64_decode($data['data']['pdf']);

            return response()->streamDownload(
                fn () => print($pdf),
                'avaluo.pdf'
            );

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al generar pdf del avalúo en consulta de predios por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function mount(){

        $this->traslados = Traslado::where('predio_id', $this->predio_id)->get();

    }

    public function render()
    {
        return view('livewire.comun.consultas.traslados-consulta');
    }
}
