<?php

namespace App\Models;

use App\Http\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oficina extends Model
{
    use HasFactory;
    use ModelosTrait;

    protected $casts = [
        'sectores' => 'array'
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function cabeceraMunicipal(){
        return $this->belongsTo(Oficina::class, 'cabecera');
    }

    public function localidades(){
        return $this->hasMany(Oficina::class, 'cabecera');
    }

}
