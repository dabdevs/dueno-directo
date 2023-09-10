<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    // User roles
    const ROLE_ADMIN = 'admin';
    const ROLE_OWNER = 'owner';
    const ROLE_TENANT = 'tenant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'given_name',
        'family_name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get all the properties for the User
     *
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    /**
     * Get all of the addresses for the User
     *
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get the tenant associated with the User
     *
     */
    public function tenant()
    {
        return $this->hasOne(Tenant::class);
    }

    public function profile()
    {
        if ($this->role != User::ROLE_TENANT) {
            throw new Exception('User is not a tenant.');
        }

        return $this->tenant();
    }

    /**
     * Get the verification request associated with the User
     *
     */
    public function verification_request()
    {
        return $this->hasOne(VerificationRequest::class);
    }
}
