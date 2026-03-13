<?php

namespace App\Models;

use App\Models\Avaluo;
use App\Models\Terreno;
use App\Models\Colindancia;
use App\Models\Propietario;
use App\Models\Construccion;
use App\Traits\ModelosTrait;
use App\Models\TerrenosComun;
use App\Models\ConstruccionesComun;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PredioAvaluo extends Model implements Auditable
{

    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function propietarios(){
        return $this->morphMany(Propietario::class, 'propietarioable');
    }

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

    public function colindancias(){
        return $this->morphMany(Colindancia::class, 'colindanciaable');
    }

    public function avaluo(){
        return $this->hasOne(Avaluo::class, 'predio_avaluo');
    }

    public function cuentaPredial(){

        return $this->localidad . '-' . $this->oficina . '-' . $this->tipo_predio . '-' . $this->numero_registro;

    }

    public function claveCatastral(){

        return $this->estado . '-' . $this->region_catastral . '-' . $this->municipio . '-' . $this->zona_catastral . '-' . $this->localidad . '-' . $this->sector . '-' . $this->manzana . '-' . $this->predio . '-' . $this->edificio . '-' . $this->departamento;

    }

    public function primerPropietario(){

        $propietario = Propietario::with('persona')->where('propietarioable_type', 'App\Models\PredioAvaluo')->where('propietarioable_id', $this->id)->first();

        return $propietario->persona->nombre . ' ' . $propietario->persona->ap_paterno . ' ' . $propietario->persona->ap_materno . ' ' . $propietario->persona->razon_social;

    }

}
