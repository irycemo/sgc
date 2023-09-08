<?php

namespace App\Models;

use App\Models\Avaluo;
use App\Models\Terreno;
use App\Models\Colindancia;
use App\Models\Propietario;
use App\Models\Construccion;
use App\Http\Traits\ModelosTrait;
use App\Models\Condominioterreno;
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

    public function condominioTerrenos(){
        return $this->morphMany(Condominioterreno::class, 'condominioterrenoable');
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

    public function avaluo(){
        return $this->hasOne(Avaluo::class, 'predio_id');
    }

    public function cuentaPredial(){

        return $this->localidad . '-' . $this->oficina . '-' . $this->tipo_predio . '-' . $this->numero_registro;

    }

    public function claveCatastral(){

        return $this->estado . '-' . $this->region_catastral . '-' . $this->municipio . '-' . $this->zona_catastral . '-' . $this->localidad . '-' . $this->sector . '-' . $this->manzana . '-' . $this->predio . '-' . $this->edificio . '-' . $this->departamento;

    }

    public function primerPropietario(){
        return $this->propietarios()->first()->persona->nombre . ' ' . $this->propietarios()->first()->persona->ap_paterno . ' ' . $this->propietarios()->first()->persona->ap_materno;
    }

}
