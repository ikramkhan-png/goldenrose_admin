<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'slug', 'status'];

    public function machineries()
    {
        return $this->hasMany(Machinery::class);
    }

    public function manpowers()
    {
        return $this->hasMany(Manpower::class);
    }
}

