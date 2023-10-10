<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'type', 'property_id', 'is_primary'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
