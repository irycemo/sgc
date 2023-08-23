<?php

namespace App\Models;

use App\Models\Terreno;
use App\Models\Colindancia;
use App\Models\Propietario;
use App\Models\Construccion;
use App\Http\Traits\ModelosTrait;
use App\Models\CondominioTerreno;
use App\Models\Condominioconstruccion;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Predio extends Model implements Auditable
{
    use HasFactory;
    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function propietarios(){
        return $this->morphMany(Propietario::class, 'propietarioable');
    }

    public function condominioTerrenos(){
        return $this->morphMany(CondominioTerreno::class, 'condominioterrenoable');
    }

    public function condominioConstrucciones(){
        return $this->morphMany(Condominioconstruccion::class, 'condominioconstruccionable');
    }

    public function terrenos(){
        return $this->morphMany(Terreno::class, 'terrenoable');
    }

    public function construcciones(){
        return $this->morphMany(Construccion::class, 'construccionable');
    }

    public function colindancias(){
        return $this->morphMany(Colindancia::class, 'colindanciaable');
    }

    public function movimientos(){
        return $this->belongsToMany(Movimineto::class)->withPivot('descripcion')->withTimestamps();
    }

}
