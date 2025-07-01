<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Rechazo extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function creadoPor(){
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function getCreatedAtAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('d-m-Y H:i:s');
    }

}
