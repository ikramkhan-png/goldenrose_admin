<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Machinery;
use App\Models\Manpower;
use App\Models\Project;

class ClientService extends Model
{
    protected $fillable = [
        'client_id',
        'project_id', // added project link
        'service_type',
        'service_id',
        'hours',
        'days',
        'months',
        'hourly_rate',
        'daily_rate',
        'monthly_rate',
        'assigned_date', // new field for monthly filtering
    ];

    // Client relationship
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Polymorphic service relationship (Machinery / Manpower)
    public function service()
    {
        return $this->morphTo(__FUNCTION__, 'service_type', 'service_id');
    }

    // Link to project (optional, for internal tracking)
    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id');
    }

    // Helper to get rate type
    public function getRateTypeAttribute()
    {
        if($this->hours !== null) return __('Hourly');
        if($this->days !== null) return __('Daily');
        return __('Monthly');
    }

    // Helper to get duration
    public function getDurationAttribute()
    {
        return $this->hours ?? $this->days ?? $this->months;
    }

    // Helper to get rate
    public function getRateAttribute()
    {
        if($this->hours !== null) return $this->hourly_rate;
        if($this->days !== null) return $this->daily_rate;
        return $this->monthly_rate;
    }
    public function billings()
    {
        return $this->hasMany(ClientServiceBilling::class);
    }
}