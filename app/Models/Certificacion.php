<?php

namespace App\Models;

use App\Models\Predio;
use App\Models\Oficina;
use App\Models\Tramite;
use App\Http\Traits\Uuid;
use App\Http\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificacion extends Model implements Auditable
{

    use Uuid;
    use HasFactory;
    use ModelosTrait;
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

}
