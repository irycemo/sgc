<?php

namespace App\Models;

use App\Models\Efirma;
use App\Models\Oficina;
use App\Http\Traits\ModelosTrait;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use \OwenIt\Auditing\Auditable;
    use ModelosTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'ap_paterno',
        'ap_materno',
        'email',
        'password',
        'oficina_id',
        'status',
        'area',
        'creado_por',
        'actualizado_por',
        'valuador',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'valuador' => 'boolean'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function oficina(){
        return $this->belongsTo(Oficina::class);
    }

    public function nombreCompleto(){

        return $this->name . ' '. $this->ap_paterno . ' '. $this->ap_materno;

    }

    public function efirma(){
        return $this->hasOne(Efirma::class);
    }

    public function trasladosAsignados(){
        return $this->hasMany(Traslado::class, 'asignado_a');
    }

}
