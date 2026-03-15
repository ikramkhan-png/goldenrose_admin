<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'client_id',
        'type',
        'start_date',
        'end_date',
        'notes',
        'budget',
    ];

    public function client()
    {
        return $this->belongsTo(\App\Models\User::class, 'client_id');
    }

    public function assignedServices()
    {
        return $this->hasMany(\App\Models\ProjectService::class);
    }

    public function documents()
    {
        return $this->hasMany(\App\Models\ProjectDocument::class, 'project_id', 'id');
    }

    public function services()
    {
        return $this->hasMany(ProjectService::class);
    }

    // ✅ Ensure correct foreign key
    public function billings()
    {
        return $this->hasMany(\App\Models\ProjectBilling::class, 'project_id', 'id');
    }

    public function expenses()
    {
        return $this->hasMany(\App\Models\Expense::class, 'project_id', 'id');
    }
}