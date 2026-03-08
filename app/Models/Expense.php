<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'project_id',
        'amount',
        'date',
        'description',
        'category',
        'invoice',
    ];

    /**
     * Relationship: Expense belongs to an Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Optional relationship: expense may belong to a project
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}