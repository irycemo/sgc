<?php

namespace App\Models;

use App\Http\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condominio extends Model
{
    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function condominioable(){
        return $this->morphTo();
    }

}
