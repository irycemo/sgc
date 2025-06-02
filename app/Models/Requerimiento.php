<?php

namespace App\Models;

use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;

class Requerimiento extends Model
{

    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function requerimientoable(){
        return $this->morphTo();
    }

}
