<?php

namespace App\Livewire\Comun\Consultas;

use App\Models\Cartografia;
use App\Models\Predio;
use Livewire\Component;

class CartografiaConsulta extends Component
{

    public $predio_id;
    public $cartografia;
    public Predio $predio;

    public function mount(){

        $this->predio = Predio::find($this->predio_id);

        $this->cartografia = Cartografia::where('sector', $this->predio->sector)->where('manzana', $this->predio->manzana)->get();

        if(! $this->cartografia->count()){

            $nombre = str_pad($this->predio->sector, 2, '0', STR_PAD_LEFT) . '-' . str_pad($this->predio->manzana, 3, '0', STR_PAD_LEFT);

            $this->cartografia = Cartografia::where('sector', $this->predio->sector)->where('url', 'like', '%' . $nombre . '%')->get();

        }

    }

    public function render()
    {
        return view('livewire.comun.consultas.cartografia-consulta');
    }
}
