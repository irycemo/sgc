<?php

namespace App\Models;

use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Oficina extends Model implements Auditable
{

    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'sectores' => 'array'
    ];

    public function cabeceraMunicipal(){
        return $this->belongsTo(Oficina::class, 'cabecera');
    }

    public function localidades(){
        return $this->hasMany(Oficina::class, 'cabecera');
    }

}
