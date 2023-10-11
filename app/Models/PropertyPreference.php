<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyPreference extends Model
{
    use HasFactory;

    public $guarded = ['id'];

    protected $casts = [
        'occupations' => 'array',
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
