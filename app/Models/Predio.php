<?php

namespace App\Models;

use App\Models\Bloqueo;
use App\Models\Terreno;
use App\Models\Traslado;
use App\Models\Movimiento;
use App\Models\Colindancia;
use App\Models\Propietario;
use App\Models\Construccion;
use App\Http\Traits\ModelosTrait;
use App\Models\Condominioterreno;
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

   /*  protected $casts = [
        'fecha_efectos' => 'date',
        'fecha_otorgamiento' => 'date'
    ]; */

    public function getEstadoColorAttribute()
    {
        return [
            'nuevo' => 'blue-400',
            'activo' => 'green-400',
            'baja' => 'gray-400',
            'bloqueado' => 'black',
        ][$this->status] ?? 'gray-400';
    }

    public function propietarios(){
        return $this->morphMany(Propietario::class, 'propietarioable');
    }

    public function avaluos(){
        return $this->hasMany(Avaluo::class, 'predio');
    }

    public function ultimoAvaluo(){
        return $this->hasOne(Avaluo::class, 'predio')->where('estado', 'notificado')->latest();
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

    public function movimientos(){
        return $this->hasMany(Movimiento::class)->orderBy('fecha', 'desc');
    }

    public function traslados(){
        return $this->hasMany(Traslado::class);
    }

    public function bloqueos(){
        return $this->hasMany(Bloqueo::class);
    }

    public function bloqueadoActivo(){
        return $this->bloqueos->where('estado', 'activo')->count() > 0 ? true : false;
    }

    public function cuentaPredial(){

        return $this->localidad . '-' . $this->oficina . '-' . $this->tipo_predio . '-' . $this->numero_registro;

    }

    public function claveCatastral(){

        return $this->estado . '-' . $this->region_catastral . '-' . $this->municipio . '-' . $this->zona_catastral . '-' . $this->localidad . '-' . $this->sector . '-' . $this->manzana . '-' . $this->predio . '-' . $this->edificio . '-' . $this->departamento;

    }

    public function propietarioInicial(){

        return $this->morphOne(Propietario::class, 'propietarioable')->with('persona:id,nombre,ap_paterno,ap_materno,razon_social');

    }

    public function primerPropietario(){

        /* return $this->morphOne(Propietario::class, 'propietarioable')->with('persona:id,nombre,ap_paterno,ap_materno,razon_social'); */

        $propietario = Propietario::where('propietarioable_type', 'App\Models\Predio')->where('propietarioable_id', $this->id)->first();

        if(!$propietario) return null;

        return $propietario->persona->nombre . ' ' . $propietario->persona->ap_paterno . ' ' . $propietario->persona->ap_materno . ' ' . $propietario->persona->razon_social;

    }

}
