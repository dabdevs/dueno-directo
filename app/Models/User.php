<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    // User roles
    const ROLE_ADMIN = 'admin';
    const ROLE_RENTER = 'renter';
    const ROLE_OWNER = 'owner';
    const ROLE_TENANT = 'tenant';
    const ROLE_AGENT = 'agent';
    const ROLE_LAWYER = 'lawyer';

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
        'telephone',
        'country_id',
        'city_id',
        'number',
        'appartment',
        'avatar',
        'zip_code'
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

    public function preferences()
    {
        return $this->hasOne(PropertyPreference::class);
    }

    public function isOwner()
    {
        return $this->role == self::ROLE_OWNER;
    }

    public function isTenant()
    {
        return $this->role == self::ROLE_TENANT;
    }

    public function isRenter()
    {
        return $this->role == self::ROLE_RENTER;
    }

    public function isAdmin()
    {
        return $this->role == self::ROLE_ADMIN;
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function propertyApplications()
    {
        return $this->hasMany(PropertyApplication::class);
    }

    public function hasRole($role)
    {
        return in_array($role, $this->getRoleNames()->toArray());
    }


}
