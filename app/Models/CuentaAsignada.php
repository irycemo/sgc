<?php

namespace App\Models;

use App\Models\User;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;

class CuentaAsignada extends Model
{

    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function asignadoA(){
        return $this->belongsTo(User::class, 'asignado_a');
    }

}
