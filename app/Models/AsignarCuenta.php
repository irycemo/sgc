<?php

namespace App\Models;

use App\Http\Traits\ModelosTrait;
use App\Models\User;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsignarCuenta extends Model implements Auditable
{
    use HasFactory;
    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'asignacion_cuentas';

    public function valuadorAsignado(){
        return $this->belongsTo(User::class, 'valuador');
    }

}
