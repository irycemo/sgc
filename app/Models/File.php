<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class File extends Model implements Auditable
{

    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['fileable_id', 'fileable_type', 'url', 'descripcion'];

    public function fileable(){
        return $this->morphTo();
    }

}
