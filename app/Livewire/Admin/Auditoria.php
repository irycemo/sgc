<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Audit;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;

class Auditoria extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public $usuarios;

    public $pagination = 10;

    public $usuario;
    public $evento;
    public $modelo;
    public $modelo_id;
    public $selecetedAudit;
    public $oldValues;
    public $newValues;
    public $modelos = [
        'User' => 'App\Models\User',
        'Avalúo' => 'App\Models\Avaluo',
        'Certificacion' => 'App\Models\Certificacion',
        'Rol' => 'App\Models\Rol',
        'Permiso' => 'App\Models\Permiso',
        'Cuenta Asignada' => 'App\Models\CuentaAsignada',
        'Efirma' => 'App\Models\Efirma',
        'Movimiento' => 'App\Models\Movimiento',
        'Oficina' => 'App\Models\Oficina',
        'Predio' => 'App\Models\Predio',
        'PredioAvaluo' => 'App\Models\PredioAvaluo',
        'Pregunta' => 'App\Models\Pregunta',
        'Propietario' => 'App\Models\Propietario',
        'Servicio' => 'App\Models\Servicio',
        'Tramite' => 'App\Models\Tramite',
        'Servicio' => 'App\Models\Servicio',
        'Traslado' => 'App\Models\Traslado',
        'Uma' => 'App\Models\Uma',
        'Variación Catastral' => 'App\Models\VariacionCatastral',
        'Predio Ignorado' => 'App\Models\PredioIgnorado',
    ];

    public function ver(Audit $audit){

        $this->selecetedAudit = $audit;

        if($this->selecetedAudit->event === 'attach' || $this->selecetedAudit->event === 'sync'){

            $this->oldValues = $this->selecetedAudit->old_values;

            $this->newValues = $this->selecetedAudit->new_values;

            /* dd($this->oldValues['roles'][0]); */

        }

        $this->modal = true;

    }

    public function mount(){

        $this->usuarios = User::orderBy('name')->get();

        if(request()->query('modelo')) $this->modelo = $this->modelos[request()->query('modelo')];

        $this->modelo_id = request()->query('modelo_id');

    }

    #[Computed]
    public function audits(){

        return Audit::select('id', 'user_id', 'event', 'auditable_type', 'auditable_id', 'ip_address', 'created_at', 'updated_at', 'tags')
                        ->with('user')
                        ->when(isset($this->usuario) && $this->usuario != "", function($q){
                            return $q->where('user_id', $this->usuario);

                        })
                        ->when(isset($this->evento) && $this->evento != "", function($q){
                            return $q->where('event', $this->evento);

                        })
                        ->when(isset($this->modelo) && $this->modelo != "", function($q){
                            return $q->where('auditable_type', $this->modelo);

                        })
                        ->when(isset($this->modelo_id) && $this->modelo_id != "", function($q){
                            return $q->where('auditable_id', $this->modelo_id);

                        })
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.admin.auditoria')->extends('layouts.admin');
    }

}
