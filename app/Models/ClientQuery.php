<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientQuery extends Model
{
    protected $fillable = [
        'client_id',
        'subject',
        'message',
        'document',
        'status',
        'admin_reply',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
