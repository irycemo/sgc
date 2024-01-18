<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Audit;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\ComponentesTrait;

class Auditoria extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public $usuarios;

    public $usuario;
    public $evento;
    public $modelo;
    public $selecetedAudit;
    public $modelos = [
        'App\Models\User',
        'App\Models\Tramite',
        'App\Models\Avaluo',
        'App\Models\AsignarCuenta',
        'App\Models\CategoriaServicio',
        'App\Models\Certificacion',
        'App\Models\Colindancia',
        'App\Models\Condominioconstruccion',
        'App\Models\Condominioterreno',
        'App\Models\Construccion',
        'App\Models\Efirma',
        'App\Models\FactorIncremento',
        'App\Models\Oficina',
        'App\Models\Permission',
        'App\Models\Persona',
        'App\Models\Predio',
        'App\Models\PredioAvaluo',
        'App\Models\Propietario',
        'App\Models\Role',
        'App\Models\Servicio',
        'App\Models\Terreno',
        'App\Models\Tramite',
        'App\Models\Uma',
        'App\Models\User',
    ];

    public function ver($audit){

        $old =json_decode($audit['old_values']);

        /* dd($old->roles[0]->id); */

        $this->selecetedAudit = $audit;

        $this->modal = true;

    }

    public function mount(){

        $this->usuarios = User::orderBy('name')->get();

        $this->modelos = collect($this->modelos)->sort();

    }

    public function render()
    {

        $audits = Audit::with('user')
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


        return view('livewire.Admin.auditoria', compact('audits'))->extends('layouts.admin');
    }

}
