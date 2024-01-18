<?php

namespace App\Models;

use App\Models\Persona;
use App\Http\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Propietario extends Model
{
    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function propietarioable(){
        return $this->morphTo();
    }

    public function persona(){
        return $this->belongsTo(Persona::class);
    }

}
