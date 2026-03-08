<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectService extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'service_type',
        'service_id',
        'hourly_rate',
        'daily_rate',
        'monthly_rate',
        'hours',
        'days',
        'months',
    ];

    // Polymorphic relation
    public function service()
    {
        return $this->morphTo();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Calculate total cost dynamically
    public function getTotalCostAttribute()
    {
        if ($this->hours) {
            return $this->hours * $this->hourly_rate;
        } elseif ($this->days) {
            return $this->days * $this->daily_rate;
        } elseif ($this->months) {
            return $this->months * $this->monthly_rate;
        }
        return 0;
    }

    // Accessors for displaying in views
    public function getRateTypeAttribute()
    {
        if ($this->hours) return 'Hourly';
        if ($this->days) return 'Daily';
        if ($this->months) return 'Monthly';
        return '-';
    }

    public function getRateAttribute()
    {
        if ($this->hours) return $this->hourly_rate;
        if ($this->days) return $this->daily_rate;
        if ($this->months) return $this->monthly_rate;
        return 0;
    }

    public function getDurationAttribute()
    {
        if ($this->hours) return $this->hours . ' hrs';
        if ($this->days) return $this->days . ' days';
        if ($this->months) return $this->months . ' months';
        return '-';
    }
}