<?php

namespace App\Models;

use App\Models\Predio;
use App\Models\Rechazo;
use App\Models\Tramite;
use App\Traits\ModelosTrait;
use App\Models\Certificacion;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Traslado extends Model implements Auditable
{

    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    public function getEstadoColorAttribute()
    {
        return [
            'nuevo' => 'blue-400',
            'cerrado' => 'green-400',
            'autorizado' => 'indigo-400',
            'rechazado' => 'red-400',
        ][$this->estado] ?? 'gray-400';
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function predio(){
        return $this->belongsTo(Predio::class);
    }

    public function tramite(){
        return $this->belongsTo(Tramite::class, 'tramite_aviso');
    }

    public function certificacion(){
        return $this->belongsTo(Certificacion::class);
    }

    public function asignadoA(){
        return $this->belongsTo(User::class, 'asignado_a');
    }

    public function rechazos(){
        return $this->hasMany(Rechazo::class);
    }

}
