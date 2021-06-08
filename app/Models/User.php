<?php

namespace App\Models;

use App\Traits\EncryptionTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * @package App\Models
 *
 * @property $id
 * @property $username
 * @property $name
 * @property $email
 * @property $online_status
 * @property $email_verified_at
 * @property $password
 * @property $remember_token
 * @property $status
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRoles, EncryptionTrait;

    /**
     * @var string
     */
    protected $guard_name = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'id_hash'
    ];

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * @return string
     */
    function getIdHashAttribute()
    {
        return $this->encrypt($this->id);
    }
}
