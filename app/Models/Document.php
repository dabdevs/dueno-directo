<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    const ID_BACK = 'Document ID Back Image';
    const ID_FRONT = 'Document ID Front Image';

    public $fillable = [
        'name',
        'path',
        'verification_request_id'
    ];

    public function verification_request()
    {
        $this->belongsTo(VerificationRequest::class);
    }
}
