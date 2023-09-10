<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationRequest extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'phone',
        'status',
        'front_id',
        'back_id'
    ];

    protected function approve()
    {
        $this->status = 'approved';
        return $this->save();
    }

    protected function deny()
    {
        $this->status = 'denied';
        return $this->save();
    }

    /**
     * Get the user that owns the verification request
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
