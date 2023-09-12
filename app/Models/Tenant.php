<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'occupation',
        'income',
        'desired_location',
        'number_of_occupants',
        'has_pets',
        'smoker',
        'employment_status',
        'additional_note'
    ];

    /**
     * Get the user that owns the Tenant account
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the applications for the tenant
     *
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     *  Get the property of the tenant
     */

    public function property()
    {
        return $this->hasOne(Property::class); 
    }

    public function verify()
    {
        $this->verified_at = now();
        return $this->save();
    }

    public function is_verified()
    {
        return $this->is_verified != null;
    }

    public function verification_request()
    {
        return $this->hasOne(VerificationRequest::class);
    }
}
