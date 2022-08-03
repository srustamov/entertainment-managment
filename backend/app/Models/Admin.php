<?php

namespace App\Models;

use App\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int area_id
 * @property string name
 * @property string email
 * @property string password
 */
class Admin extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use HasFactory;
    use Notifiable;
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use MustVerifyEmail;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
