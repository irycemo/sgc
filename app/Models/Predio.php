<?php

namespace App\Models;

use App\Models\Condominio;
use App\Models\Referencia;
use App\Models\Colindancia;
use App\Models\Propietario;
use App\Http\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Predio extends Model
{
    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function propietarios(){
        return $this->hasMany(Propietario::class);
    }

    public function condominio(){
        return $this->hasOne(Condominio::class);
    }

    public function movimientos(){
        return $this->belongsToMany(Movimineto::class)->withPivot('fecha', 'descripcion')->withTimestamps();
    }

    public function referencias_construccion(){
        return $this->hasOne(Referencia::class);
    }

    public function colindancias(){
        return $this->hasMany(Colindancia::class);
    }
}
