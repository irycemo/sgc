<?php

namespace App\Models;

use App\Models\Bloque;
use App\Models\File;
use App\Models\PredioAvaluo;
use App\Models\PredioIgnorado;
use App\Models\Tramite;
use App\Models\User;
use App\Models\VariacionCatastral;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class Avaluo extends Model implements Auditable
{

    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'notificado_en' => 'date'
    ];

    public static function boot() {

        parent::boot();

        static::creating(function($model){

            foreach ($model->attributes as $key => $value) {

                if(is_null($value)) continue;

                if(is_string($value)){

                    if($value === ''){

                        $model->{$key} = null;

                    }else{

                        $model->{$key} = trim($value);

                    }

                }
            }

            $model->uuid = (string)Str::uuid();

        });

        static::updating(function($model){

            foreach ($model->attributes as $key => $value) {

                if(is_null($value)) continue;

                if(is_string($value)){

                    if($value === ''){

                        $model->{$key} = null;

                    }else{

                        $model->{$key} = trim($value);

                    }

                }

            }

            if(! $model->uuid){

                $model->uuid = (string)Str::uuid();

            }

        });

    }

    public function getEstadoColorAttribute()
    {
        return [
            'nuevo' => 'blue-400',
            'impreso' => 'green-400',
            'concluido' => 'yellow-400',
            'notificado' => 'gray-400',
        ][$this->estado] ?? 'gray-400';
    }

    public function predioAvaluo(){
        return $this->belongsTo(PredioAvaluo::class, 'predio_avaluo');
    }

    public function asignadoA(){
        return $this->belongsTo(User::class, 'asignado_a');
    }

    public function notificador(){
        return $this->belongsTo(User::class, 'notificado_por');
    }

    public function tramiteInspeccion(){
        return $this->belongsTo(Tramite::class, 'tramite_inspeccion');
    }

    public function tramiteDesglose(){
        return $this->belongsTo(Tramite::class, 'tramite_desglose');
    }

    public function predioIgnorado(){
        return $this->belongsTo(PredioIgnorado::class, 'predio_ignorado_id');
    }

    public function variacionCatastral(){
        return $this->belongsTo(VariacionCatastral::class, 'variacion_catastral_id');
    }

    public function imagenes(){
        return $this->morphMany(File::class, 'fileable');
    }

    public function bloques(){
        return $this->hasMany(Bloque::class);
    }

    public function fachada(){

        $fachada = $this->imagenes()->where('descripcion', 'fachada')->first();

        return $fachada
            ? $fachada->getLinkFotoAvaluo()
            : Storage::disk('public')->url('img/ico.png');

    }

    public function foto2(){

        $foto2 = $this->imagenes()->where('descripcion', 'foto2')->first();

        return $foto2
            ? $foto2->getLinkFotoAvaluo()
            : Storage::disk('public')->url('img/ico.png');

    }

    public function foto3(){

        $foto3 = $this->imagenes()->where('descripcion', 'foto3')->first();

        return $foto3
            ? $foto3->getLinkFotoAvaluo()
            : Storage::disk('public')->url('img/ico.png');

    }

    public function foto4(){

        $foto4 = $this->imagenes()->where('descripcion', 'foto4')->first();

        return $foto4
            ? $foto4->getLinkFotoAvaluo()
            : Storage::disk('public')->url('img/ico.png');

    }

    public function macrolocalizacion(){

        $macrolocalizacion = $this->imagenes()->where('descripcion', 'macrolocalizacion')->first();

        return $macrolocalizacion
            ? $macrolocalizacion->getLinkFotoAvaluo()
            : Storage::disk('public')->url('img/ico.png');

    }

    public function microlocalizacion(){

        $microlocalizacion = $this->imagenes()->where('descripcion', 'microlocalizacion')->first();

        return $microlocalizacion
            ? $microlocalizacion->getLinkFotoAvaluo()
            : Storage::disk('public')->url('img/ico.png');

    }

    public function poligonoImagen(){

        $poligonoImagen = $this->imagenes()->where('descripcion', 'poligonoImagen')->first();

        return $poligonoImagen
            ? $poligonoImagen->getLinkFotoAvaluo()
            : Storage::disk('public')->url('img/ico.png');

    }

    public function poligonoDwg(){

        $poligonoDwg = $this->imagenes()->where('descripcion', 'poligonoDwg')->first();

        return $poligonoDwg
            ? $poligonoDwg->getLinkFotoAvaluo()
            : null;

    }

}
