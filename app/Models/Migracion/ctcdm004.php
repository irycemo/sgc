<?php

namespace App\Models\Migracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ctcdm004 extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';

    protected $table = 'ctcdm004';
}
