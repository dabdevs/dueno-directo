<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyApplication extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function approve()
    {
        try {
            $this->status = 'Approved';
            $this->approved_at = now();

            return $this->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function reject()
    {
        try {
            $this->status = 'Rejected';
            $this->rejected_at = now();

            return $this->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
