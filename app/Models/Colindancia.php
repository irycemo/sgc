<?php

namespace App\Models;

use App\Http\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colindancia extends Model
{
    use HasFactory;
    use ModelosTrait;

    protected $fillable = ['predio_id', 'viento', 'longitud', 'descripcion', 'creado_por', 'actualizado_por'];

    public function colindanciaable(){
        return $this->morphTo();
    }

}
