<?php

namespace App\Livewire\Consultas\Reportes;

use App\Models\Oficina;
use Livewire\Component;
use App\Models\Certificacion;
use App\Constantes\Constantes;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CertificacionesExport;
use Livewire\WithPagination;

class ReporteCertificaciones extends Component
{

    use WithPagination;

    public $fecha1;
    public $fecha2;
    public $pagination = 10;

    public $estado;
    public $oficinas;
    public $oficina;
    public $años;
    public $año;
    public $documentos;
    public $documento;

    public function descargarExcel(){

        $this->fecha1 = $this->fecha1 . ' 00:00:00';
        $this->fecha2 = $this->fecha2 . ' 23:59:59';


        try {

            return Excel::download(new CertificacionesExport($this->estado, $this->oficina, $this->año, $this->documento, $this->fecha1, $this->fecha2), 'Reporte_de_certificaciones_' . now()->format('d-m-Y') . '.xlsx');

        } catch (\Throwable $th) {

            Log::error("Error generar archivo de reporte de certificaciones por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    #[Computed]
    public function certificaciones(){

        return Certificacion::with('oficina:id,nombre', 'tramite:id,año,folio,usuario')
                                ->when (isset($this->año) && $this->año != "", function($q){
                                    $q->where('año', $this->año);
                                })
                                ->when (isset($this->documento) && $this->documento != "", function($q){
                                    $q->where('documento', $this->documento);
                                })
                                ->when (isset($this->estado) && $this->estado != "", function($q){
                                    $q->where('estado', $this->estado);
                                })
                                ->when(isset($this->oficina) && $this->oficina != "", function($q){
                                    return $q->where('oficina_id', $this->oficina);
                                })
                                ->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2 . ' 23:59:59'])
                                ->paginate($this->pagination);

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('y');

        $this->documentos = Constantes::CERTIFICACIONES;

        $this->oficinas = Oficina::select('id', 'nombre')->orderBy('nombre')->get();

    }

    public function render()
    {
        return view('livewire.consultas.reportes.reporte-certificaciones');
    }
}
