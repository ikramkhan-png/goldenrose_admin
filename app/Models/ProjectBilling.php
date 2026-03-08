<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectBilling extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'amount_billed',
        'amount_paid',
        'status',
        'payment_date',
        'invoice',
        'notes',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}