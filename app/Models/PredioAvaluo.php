<?php

namespace App\Models;

use App\Models\Terreno;
use App\Http\Traits\ModelosTrait;
use App\Models\Condominioconstruccion;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PredioAvaluo extends Model implements Auditable
{

    use HasFactory;
    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function propietarios(){
        return $this->morphMany(Propietario::class, 'propietarioable');
    }

    public function condominio(){
        return $this->morphMany(Condominio::class, 'condominioable');
    }

    public function condominioConstrucciones(){
        return $this->morphMany(Condominioconstruccion::class, 'condominioconstruccionable');
    }

    public function terrenos(){
        return $this->morphMany(Terreno::class, 'terrenoable');
    }

    public function construcciones(){
        return $this->morphMany(Referencia::class, 'referenciaable');
    }

    public function colindancias(){
        return $this->morphMany(Colindancia::class, 'colindanciaable');
    }

    public function avaluo(){
        return $this->hasOne(Avaluo::class, 'predio_id');
    }

}
