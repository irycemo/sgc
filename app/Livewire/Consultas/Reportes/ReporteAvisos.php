<?php

namespace App\Livewire\Consultas\Reportes;

use App\Constantes\Constantes;
use App\Models\Oficina;
use App\Models\Traslado;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ReporteAvisos extends Component
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
    public $tipo;

    #[Computed]
    public function avisos(){

        return Traslado::with('oficina:id,nombre', 'predio:id,localidad,oficina,tipo_predio,numero_registro', 'asignadoA:id,name')
                                ->when (isset($this->tipo) && $this->tipo != "", function($q){
                                    $q->where('tipo', $this->tipo);
                                })
                                ->when (isset($this->entidad_id) && $this->entidad_id != "", function($q){
                                    $q->where('entidad_stl', $this->entidad_id);
                                })
                                ->when (isset($this->año) && $this->año != "", function($q){
                                    $q->where('año_aviso', $this->año);
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

        $this->oficinas = Oficina::select('id', 'nombre')->orderBy('nombre')->get();

    }

    public function render()
    {
        return view('livewire.consultas.reportes.reporte-avisos');
    }
}
