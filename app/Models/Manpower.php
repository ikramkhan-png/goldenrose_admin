<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manpower extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hourly_rate',
        'daily_rate',
        'monthly_rate',
        'status',
    ];
}