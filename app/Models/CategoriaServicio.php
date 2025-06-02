<?php

namespace App\Models;

use App\Models\Servicio;
use App\Traits\ModelosTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class CategoriaServicio extends Model implements Auditable
{

    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function servicios(){
        return $this->hasMany(Servicio::class);
    }

}
