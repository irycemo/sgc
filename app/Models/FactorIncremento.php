<?php

namespace App\Models;

use App\Http\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactorIncremento extends Model
{
    use HasFactory;
    use ModelosTrait;

    protected $fillable = ['factor'];

}
