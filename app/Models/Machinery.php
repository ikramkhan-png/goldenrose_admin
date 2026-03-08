<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machinery extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'model',
        'number_plate',
        'hourly_rate',
        'daily_rate',
        'monthly_rate',
        'status',
    ];
}