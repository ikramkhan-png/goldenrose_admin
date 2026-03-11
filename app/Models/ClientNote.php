<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientNote extends Model
{
    protected $fillable = [
        'client_id',
        'subject',
        'message',
        'document',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
