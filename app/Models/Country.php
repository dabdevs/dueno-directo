<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'code',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
