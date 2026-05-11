<?php

namespace App\Models;

use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Persona extends Model implements Auditable
{

    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function nombreCompleto(){
        return $this->nombre . ' ' . $this->ap_paterno . ' ' . $this->ap_materno . ' ' . $this->razon_social;
    }

}
