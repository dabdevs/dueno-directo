<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'note'
    ];

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

    public function archive()
    {
        try {
            $this->status = 'Archived';
            $this->archived_at = now();

            if (auth()->user()->role == User::ROLE_OWNER) {
                $this->archived_by_propertys_owner = 1;
            } elseif (auth()->user()->role == User::ROLE_TENANT) {
                $this->archived_by_applicant = 1;
            } else {
                $this->archived_by_admin = auth()->user();
            }

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
