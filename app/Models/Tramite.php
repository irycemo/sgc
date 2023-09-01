<?php

namespace App\Models;

use App\Models\Servicio;
use App\Models\Seguimiento;
use App\Http\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tramite extends Model implements Auditable
{
    use HasFactory;
    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'fecha_pago' => 'date',
        'fecha_entrega' => 'date',
        'fecha_vencimiento' => 'date'
    ];

    public function getEstadoColorAttribute()
    {
        return [
            'nuevo' => 'blue-400',
            'pagado' => 'green-400',
            'activo' => 'yellow-400',
            'concluido' => 'gray-400',
            'expirado' => 'red-400',
        ][$this->estado] ?? 'gray-400';
    }

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

    protected $auditEvents = [
        'updated',
    ];
}
