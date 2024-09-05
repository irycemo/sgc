<?php

namespace App\Models;

use App\Models\Predio;
use App\Models\Oficina;
use App\Models\Tramite;
use App\Http\Traits\Uuid;
use Illuminate\Support\Carbon;
use App\Http\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificacion extends Model implements Auditable
{

    use Uuid;
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getRouteKeyName(){
        return 'uuid';
    }

    public function tramite(){
        return $this->belongsTo(Tramite::class);
    }

    public function oficina(){
        return $this->belongsTo(Oficina::class);
    }

    public function predio(){
        return $this->belongsTo(Predio::class);
    }

    public function creadoPor(){
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function actualizadoPor(){
        return $this->belongsTo(User::class, 'actualizado_por');
    }

    public function getCreatedAtAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('d-m-Y H:i:s');
    }

    public function getUpdatedAtAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['updated_at'])->format('d-m-Y H:i:s');
    }

}
