<?php

namespace App\Models;

use App\Traits\ModelosTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class ManzanaAsignada extends Model implements Auditable
{

    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function asignadoA(){
        return $this->belongsTo(User::class, 'asignado_a');
    }

}
