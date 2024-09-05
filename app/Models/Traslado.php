<?php

namespace App\Models;

use App\Models\User;
use App\Http\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Traslado extends Model implements Auditable
{

    use HasFactory;
    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getEstadoColorAttribute()
    {
        return [
            'nuevo' => 'blue-400',
            'cerrado' => 'green-400',
            'autorizado' => 'indigo-400',
            'rechazado' => 'red-400',
        ][$this->estado] ?? 'gray-400';
    }

    public function asignadoA(){
        return $this->belongsTo(User::class, 'asignado_a');
    }

    public function predio(){
        return $this->belongsTo(Predio::class);
    }

}
