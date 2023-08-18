<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
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
        'additional_note',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
