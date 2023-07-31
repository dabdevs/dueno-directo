<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the Address
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
