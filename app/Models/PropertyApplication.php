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

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    protected function approve()
    {
        try {
            $this->status = 'Approved';
            $this->save();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function reject()
    {
        try {
            $this->status = 'Rejected';
            $this->save();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
