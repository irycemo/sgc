<?php

namespace App\Models;

use App\Models\User;
use App\Models\Oficina;
use App\Models\Tramite;
use App\Traits\ModelosTrait;
use App\Models\Requerimiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Contracts\Auditable;

class VariacionCatastral extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getEstadoColorAttribute()
    {
        return [
            'nuevo' => 'blue-400',
            'requerimineto' => 'red-400',
            'valuación' => 'purple-400',
            'actualizado' => 'green-400',
            'publicación' => 'orange-400',
            'oposición' => 'yellow-400',
            'concluido' => 'gray-400',
            'firma' => 'indigo-400',
            'revisión' => 'teal-400',
        ][$this->estado] ?? 'gray-400';
    }

    public function valuadorAsignado(){
        return $this->belongsTo(User::class, 'valuador');
    }

    public function oficina(){
        return $this->belongsTo(Oficina::class);
    }

    public function tramite(){
        return $this->belongsTo(Tramite::class);
    }

    public function requerimientos(){
        return $this->morphMany(Requerimiento::class, 'requerimientoable');
    }

    public function archivo(){

        return Storage::disk('variacionescatastrales')->url($this->archivo);

    }

}
