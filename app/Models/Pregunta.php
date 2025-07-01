<?php

namespace App\Models;

use App\Models\User;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pregunta extends Model
{

    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_At'];

    public function usuarios(){
        return $this->belongsToMany(User::class);
    }

}
