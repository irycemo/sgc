<?php

namespace App\Models;

use App\Models\Construccion;
use App\Models\ConstruccionesComun;
use App\Models\Terreno;
use App\Models\TerrenosComun;
use Illuminate\Database\Eloquent\Model;

class OldAvaluo extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function terrenosComun(){
        return $this->morphMany(TerrenosComun::class, 'terrenos_comunsable');
    }

    public function construccionesComun(){
        return $this->morphMany(ConstruccionesComun::class, 'construcciones_comunsable');
    }

    public function terrenos(){
        return $this->morphMany(Terreno::class, 'terrenoable');
    }

    public function construcciones(){
        return $this->morphMany(Construccion::class, 'construccionable');
    }

}
