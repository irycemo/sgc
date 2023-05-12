<?php

namespace App\Models;

use App\Http\Traits\ModelosTrait;
use App\Models\Predio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movimiento extends Model
{
    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function predios(){
        return $this->belongsToMany(Predio::class);
    }
}
