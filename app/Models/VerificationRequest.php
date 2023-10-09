<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationRequest extends Model
{
    use HasFactory;

    public $fillable = [
        'property_id',
        'tenant_id',
        'phone'
    ];

    protected function approve()
    {
        $this->status = 'Approved';
        return $this->save();
    }

    protected function reject()
    {
        $this->status = 'Rejected';
        return $this->save();
    }

    /**
     * Get the user that owns the verification request
     *
     */
    public function owner()
    {
        return $this->type === 'tenant' ? $this->tenant() : $this->property();
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
