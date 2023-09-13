<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'name',
        'quantity',
        'negotiable',
        'note',
        'active'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
