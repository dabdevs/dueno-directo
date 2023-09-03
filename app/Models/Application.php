<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    public $fillable = ['status', 'note', 'tenant_id', 'property_id'];

    /**
     * Get the user that owns the Application
     *
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
