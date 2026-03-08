<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\Advance;
use App\Models\Overtime;
use App\Models\Expense;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'basic_salary',
        'daily_wage',
        'department_id',
    ];

    /**
     * Employee belongs to a Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Employee has many Advances
     */
    public function advances()
    {
        return $this->hasMany(Advance::class);
    }

    /**
     * Employee has many Overtimes
     */
    public function overtimes()
    {
        return $this->hasMany(Overtime::class);
    }

    /**
     * Employee has many Expenses
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}