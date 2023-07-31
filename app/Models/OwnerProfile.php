<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'additional_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addresses()
    {
        return $this->belongsToMany(Address::class, 'user_addresses', 'user_id', 'address_id')
        ->wherePivot('type', 'owner')
        ->withPivot('unit_number', 'is_primary', 'note')
        ->withTimestamps();
    }
}
