<?php

namespace App\Models\Migracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ctcop005 extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';

    protected $table = 'ctcop005';

}
