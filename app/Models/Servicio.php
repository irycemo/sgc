<?php

namespace App\Models;

use App\Traits\ModelosTrait;
use App\Models\CategoriaServicio;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Servicio extends Model implements Auditable
{

    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function categoria(){
        return $this->belongsTo(CategoriaServicio::class, 'categoria_servicio_id');
    }

}
