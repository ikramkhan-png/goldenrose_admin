<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ClientProject extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'status',
        'start_date',
        'end_date',
        'description',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}