<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{

    protected $fillable = ['fileable_id', 'fileable_type', 'url', 'descripcion'];

    public function fileable(){
        return $this->morphTo();
    }

    public function getLinkArchivo(){

        if(app()->isProduction()){

            return Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_predios') . $this->url, now()->addMinutes(10));

        }else{

            return Storage::disk('predios_archivo')->url($this->url);

        }

    }

    public function getLinkFoto(){

        if(app()->isProduction()){

            return Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_predios_fotos') . $this->url, now()->addMinutes(10));

        }else{

            return Storage::disk('predios_fotos')->url($this->url);

        }

    }

    public function getLinkFotoAvaluo(){

        if(app()->isProduction()){

            return Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_avaluos_fotos') . $this->url, now()->addMinutes(10));

        }else{

            return Storage::disk('avaluos')->url($this->url);

        }

    }

}
