<?php

namespace App\Models;

use App\Models\Predio;
use App\Models\Tramite;
use Illuminate\Database\Eloquent\Model;

class PredioTramite extends Model
{

    protected $table = 'predio_tramite';

    public function tramite(){
        return $this->belongsTo(Tramite::class);
    }

    public function predio(){
        return $this->belongsTo(Predio::class);
    }

}
