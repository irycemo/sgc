<?php

namespace App\Models;

use App\Models\Oficina;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Cartografia extends Model
{

    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function oficina(){
        return $this->belongsTo(Oficina::class);
    }

    public function getLink(){

        return Storage::disk('s3')->temporaryUrl($this->url, now()->addMinutes(60));

    }

}
