<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'occupation', 
        'income',
        'desired_location',
        'number_of_occupants',
        'has_pets',
        'smoker',
        'employment_status',
        'additional_criteria',
        'additional_notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addresses()
    {
        return $this->belongsToMany(Address::class, 'user_addresses', 'user_id', 'address_id')
        ->wherePivot('type', 'tenant')
        ->withPivot('unit_number', 'is_primary', 'note')
        ->withTimestamps();
    }
}
