<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'bedrooms',
        'bathrooms',
        'area',
        'location',
        'phone_number',
        'property_type',
        'property_address',
        'property_description',
        'rental_price',
        'lease_term',
        'availability',
        'rent_payment_method',
        'security_deposit',
        'rental_agreement',
        'preferred_tenant_profile',
        'additional_note',
        'user_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the applications for the Property
     *
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
