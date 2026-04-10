<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'fecha_actualizacion' => 'datetime',
        'fecha_escritura' => 'datetime',
        'fecha_movimiento' => 'datetime',
    ];

    public function cuentaPredial(){

        return $this->localidad . '-' . $this->oficina . '-' . $this->tipo_predio . '-' . $this->numero_registro;

    }

}
