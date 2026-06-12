<?php

namespace App\Models;

use App\Models\Oficina;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;

class Cartografia extends Model
{

    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function oficina(){
        return $this->belongsTo(Oficina::class);
    }

}
