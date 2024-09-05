<?php

namespace App\Models;

use App\Http\Traits\ModelosTrait;
use App\Models\Predio;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movimiento extends Model implements Auditable
{
    use HasFactory;
    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = ['fecha' => 'date'];

    public function predio(){
        return $this->belongsTo(Predio::class);
    }

    protected $auditEvents = [
        'deleted',
        'updated',
    ];
}
