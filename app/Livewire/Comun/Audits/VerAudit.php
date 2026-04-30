<?php

namespace App\Livewire\Comun\Audits;

use App\Models\Audit;
use Livewire\Component;

class VerAudit extends Component
{

    public Audit $audit;

    public $oldValues;
    public $newValues;

    public $modelo;
    public $modelo_id;

    public $modal = false;

    public function ver(){

        if($this->audit->event === 'attach' || $this->audit->event === 'sync'){

            $this->oldValues = $this->audit->old_values;

            $this->newValues = $this->audit->new_values;

        }



        $this->modal = true;

    }

    public function mount(){

        $this->modelo = str_replace("App\Models\\", "", $this->audit->auditable_type);

        $this->modelo_id = $this->audit->auditable_id;

    }

    public function render()
    {
        return view('livewire.comun.audits.ver-audit');
    }
}
