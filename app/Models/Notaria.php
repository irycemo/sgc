<?php

namespace App\Models;

use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;

class Notaria extends Model
{
     use ModelosTrait;

     protected $guarded = ['id', 'created_at', 'updated_at'];

}
