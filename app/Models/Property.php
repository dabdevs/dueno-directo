<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the owner of the Property
     *
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id')->where(['role' => 'owner']);
    }

    /**
     * Get the tenant of the Property
     *
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get all of the applications for the Property
     *
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * 
     * Get the preferences of the property
     *
     */
    public function preferences()
    {
        return $this->hasOne(Preference::class);
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
        $this->status($status);
        return $this->save();
    }

    public function assignTenant(Tenant $tenant)
    {
        $this->tenant_id = $tenant->id;
        return $this->save();
    }
}
