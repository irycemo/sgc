<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Tramite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificacion extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function certificacionable(){
        return $this->morphTo();
    }

    public function tramite(){
        return $this->belongsTo(Tramite::class);
    }

    public function getCreatedAtAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('d-m-Y H:i:s');
    }

}
