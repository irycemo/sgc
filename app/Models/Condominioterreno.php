<?php

namespace App\Models;

use App\Http\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Condominioterreno extends Model
{

    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function condominioterrenoable(){
        return $this->morphTo();
    }

}
