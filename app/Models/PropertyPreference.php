<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyPreference extends Model
{
    use HasFactory;

    public $fillable = [
        'occupation',
        'min_income',
        'max_income',
        'number_of_occupants',
        'has_pets',
        'smoker',
        'employment_status',
        'property_id',
        'user_id'
    ];

    protected $casts = [
        'occupation' => 'array',
    ];

    /**
     * Get the property that owns the Preference
     *
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the user that owns the Preference
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
