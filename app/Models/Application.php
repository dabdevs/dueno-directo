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

    /**
     * Get the property that matches the Application
     *
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    protected function accept()
    {
        try {
            $this->status = 'accepted';
            $this->save();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function reject()
    {
        try {
            $this->status = 'rejected';
            $this->save();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
