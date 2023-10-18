<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    // Property status
    const STATUS_PUBLISHED = 'Published';
    const STATUS_UNLISTED = 'Unlisted';
    const STATUS_BOOKED = 'Booked';
    const STATUS_RENTED = 'Rented';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'bedrooms',
        'bathrooms',
        'balcony',
        'negotiable',
        'patio',
        'area',
        'country_id',
        'city_id',
        'tenant_id',
        'agent_id',
        'payment_method',
        'state',
        'neighborhood',
        'get_notified_by',
        'telephone',
        'lease_term',
        'security_deposit',
        'type',
        'email',
        'user_id',
        'status',
        'preferred_tenant_profile',
    ];

    /**
     * Get the owner of the Property
     *
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the tenant of the Property
     *
     */
    public function tenant()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the applications for the Property
     *
     */
    public function applications()
    {
        return $this->hasMany(PropertyApplication::class);
    }

    /**
     * 
     * Get the preferences of the property
     *
     */
    public function preferences()
    {
        return $this->hasOne(PropertyPreference::class);
    }

    public function verify()
    {
        $this->verified_at = now();
        return $this->save();
    }

    public function isVerified()
    {
        return $this->is_verified != null;
    }

    public function verification_request()
    {
        return $this->hasOne(VerificationRequest::class);
    }

    public function changeStatus(string $status)
    {
        if ($status === self::STATUS_PUBLISHED) {
            $this->date_published = now();
            $this->date_expires = now()->addDays(env('PUBLICATION_LIFETIME'));
        }

        return $this->save();
    }

    public function assignTenant(User $user)
    {
        if ($user->role != User::ROLE_TENANT) {
            throw new Exception("User is not a tenant", 1);
        }

        $this->tenant_id = $user->id;
        return $this->save();
    }

    public function assignAgent(User $user)
    {
        if ($user->role != User::ROLE_AGENT) {
            throw new Exception("User is not an agent", 1);
        }

        $this->agent_id = $user->id;
        return $this->save();
    }

    public function assignLawyer(User $user)
    {
        if ($user->role != User::ROLE_LAWYER) {
            throw new Exception("User is not a lawyer", 1);
        }

        $this->lawyer_id = $user->id;
        return $this->save();
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function requirements()
    {
        return $this->hasMany(PropertyRequirement::class);
    }

    public function isPublished()
    {
        return $this->status == 'Published';
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
