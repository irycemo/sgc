<?php

namespace App\Models;

use App\Models\Predio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movimiento extends Model
{
    use HasFactory;

    public function predios(){
        return $this->belongsToMany(Predio::class);
    }
}
