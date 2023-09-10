<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;

    public $guarded = ['id'];

    /**
     * Get the property that owns the Preference
     *
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
