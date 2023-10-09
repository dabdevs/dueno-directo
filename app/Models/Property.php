<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

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
        'phone_number',
        'lease_term',
        'security_deposit',
        'type',
        'note',
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

    private function assignTenant(Tenant $tenant)
    {
        $this->tenant_id = $tenant->id;
        return $this->save();
    }

    private function assignAgent(Agent $agent)
    {
        $this->agent_id = $agent->id;
        return $this->save();
    }

    private function assignLawyer(Lawyer $lawyer)
    {
        $this->lawyer_id = $lawyer->id;
        return $this->save();
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
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
