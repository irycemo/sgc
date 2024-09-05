<?php

namespace App\Http\Traits;
use Illuminate\Support\Str;

trait Uuid
{

    protected static function boot()
    {

        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string)Str::uuid();
        });

    }

}
