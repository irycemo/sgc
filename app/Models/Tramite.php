<?php

namespace App\Models;

use App\Models\Avaluo;
use App\Models\Servicio;
use App\Models\PredioAvaluo;
use App\Traits\ModelosTrait;
use App\Enums\Tramites\AvaluoPara;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Tramite extends Model implements Auditable
{

    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'limite_de_pago' => 'date',
        'fecha_entrega' => 'date',
        'fecha_pago' => 'date',
        'avaluo_para' => AvaluoPara::class,
    ];

    public function getEstadoColorAttribute()
    {
        return [
            'nuevo' => 'blue-400',
            'pagado' => 'green-400',
            'activo' => 'yellow-400',
            'concluido' => 'gray-400',
            'expirado' => 'red-400',
            'inactivo' => 'red-400',
            'autorizado' => 'indigo-400',
        ][$this->estado] ?? 'gray-400';
    }

    /* public function seguimientos(){
        return $this->hasMany(Seguimiento::class);w
    } */

    public function predios(){
        return $this->belongstoMany(Predio::class)->withPivot('estado')->withTimestamps();
    }

    public function predioAvaluo(){
        return $this->belongsTo(PredioAvaluo::class, 'predio_avaluo');
    }

    public function ligadoA(){
        return $this->belongsTo(Tramite::class, 'ligado_a');
    }

    public function servicio(){
        return $this->belongsTo(Servicio::class);
    }

    public function avaluos(){
        return $this->hasMany(Avaluo::class, 'tramite_id');
    }

    public function numeroControl(){

        return $this->año . '-' . $this->folio . '-' . $this->usuario;

    }

}
