<?php

namespace App\Models;

use App\Models\Predio;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Movimiento extends Model implements Auditable
{

    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected function casts(): array
    {
        return [
            'fecha' => 'date:d-m-Y'
        ];
    }


    public function predio(){
        return $this->belongsTo(Predio::class);
    }

}
