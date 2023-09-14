<?php

namespace App\Http\Livewire\Admin\Avaluos;

use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\ComponentesTrait;
use App\Models\PredioAvaluo;

class Avaluos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    use WithPagination;
    use ComponentesTrait;

    public PredioAvaluo $modelo_editar;

    public function crearModeloVacio(){
        return PredioAvaluo::make();
    }

    public function render()
    {

        $predios = PredioAvaluo::with('actualizadoPor', 'avaluo.asignadoA')
                            ->whereHas('avaluo.asignadoA', function($q){
                                $q->where('name', 'LIKE', '%' . $this->search . '%')
                                    ->orWhere('ap_paterno', 'LIKE', '%' . $this->search . '%')
                                    ->orWhere('ap_materno', 'LIKE', '%' . $this->search . '%');
                            })
                            ->orWhereHas('avaluo', function($q){
                                $q->where('estado', 'LIKE', '%' . $this->search . '%')
                                        ->orwhere('folio', 'LIKE', '%' . $this->search . '%')
                                        ->orWhereHas('asignadoA', function($q){
                                            $q->where('name', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere('ap_paterno', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere('ap_materno', 'LIKE', '%' . $this->search . '%');
                                        });
                            })
                            ->orWhere('localidad', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('oficina', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('tipo_predio', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('numero_registro', 'LIKE', '%' . $this->search . '%')
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.Admin.avaluos.avaluos', compact('predios'))->extends('layouts.admin');

    }
}
