<?php

namespace App\Models;

use App\Http\Traits\ModelosTrait;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsignarCuenta extends Model
{
    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'asignacion_cuentas';

    public function valuadorAsignado(){
        return $this->belongsTo(User::class, 'valuador');
    }

}
