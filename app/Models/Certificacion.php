<?php

namespace App\Models;

use App\Models\Predio;
use App\Models\Oficina;
use App\Models\Tramite;
use Illuminate\Support\Str;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Enums\Certificaciones\CertificacionesEnum;

class Certificacion extends Model implements Auditable
{

    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'tipo' => CertificacionesEnum::class
    ];

    public static function boot() {

        parent::boot();

        static::creating(function($model){

            foreach ($model->attributes as $key => $value) {

                if(is_null($value)) continue;

                $model->{$key} = trim($value);

                $model->{$key} = $value === '' ? null : $value;
            }

            $model->uuid = (string)Str::uuid();

        });

        static::updating(function($model){

            foreach ($model->attributes as $key => $value) {

                if(is_null($value)) continue;

                $model->{$key} = trim($value);

                $model->{$key} = $value === '' ? null : $value;
            }

        });

    }

    public function getRouteKeyName(){
        return 'uuid';
    }

    public function oficina(){
        return $this->belongsTo(Oficina::class);
    }

    public function tramite(){
        return $this->belongsTo(Tramite::class);
    }

    public function predio(){
        return $this->belongsTo(Predio::class);
    }

}
