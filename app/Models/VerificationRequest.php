<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationRequest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

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

    protected function pending()
    {
        $this->status = 'Pending';
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
