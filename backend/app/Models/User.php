<?php

namespace App\Models;

use App\Eloquent\Model;
use App\Eloquent\Traits\HasLocation;
use App\Support\Interfaces\CurrentUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use JetBrains\PhpStorm\ArrayShape;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property int area_id
 * @property string name
 * @property string email
 * @property string password
 * @property mixed $location_id
 * @property Location $location
 *
 * @method static User find(int $int)
 */
class User extends Model implements JWTSubject, AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, CurrentUser
{
    use HasFactory;
    use Notifiable;
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use MustVerifyEmail;
    use HasLocation;

    protected $fillable = [
        'location_id',
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    #[ArrayShape(['location_id' => 'int'])]
    public function getJWTCustomClaims(): array
    {
        return [
            'location_id' => $this->location_id,
        ];
    }
}
