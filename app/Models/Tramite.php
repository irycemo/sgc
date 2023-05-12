<?php

namespace App\Models;

use App\Models\Servicio;
use App\Models\Seguimiento;
use App\Http\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tramite extends Model
{
    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'fecha_pago' => 'date',
        'fecha_entrega' => 'date'
    ];

    public function seguimientos(){
        return $this->hasMany(Seguimiento::class);
    }

    public function predios(){
        return $this->belongstoMany(Predio::class)->withPivot('estado')->withTimestamps();
    }

    public function adicionaA(){
        return $this->belongsTo(Tramite::class, 'adiciona');
    }

    public function servicio(){
        return $this->belongsTo(Servicio::class);
    }
}
