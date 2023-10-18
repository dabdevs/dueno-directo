<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'endpoint',
        'allowed_roles'
    ];

    protected $casts = [
        'allowed_roles' => 'array'
    ];
}
