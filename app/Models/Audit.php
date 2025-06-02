<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tramite;
use OwenIt\Auditing\Models\Audit as ModelsAudit;

class Audit extends ModelsAudit
{

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tramite(){
        return $this->belongsTo(Tramite::class);
    }

    public function getCreatedAtAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('d-m-Y H:i:s');
    }

}
