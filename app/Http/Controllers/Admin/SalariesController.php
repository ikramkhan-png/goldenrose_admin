<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Advance;
use App\Models\Overtime;
use App\Models\Expense;
use Illuminate\Http\Request;

class SalariesController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $salaries = [];

        foreach ($employees as $emp) {
            $working_days = Attendance::where('employee_id', $emp->id)
                ->whereMonth('date', now()->month)
                ->count();

            $advance_total = Advance::where('employee_id', $emp->id)
                ->whereMonth('date', now()->month)
                ->sum('amount');

            $overtime_total = Overtime::where('employee_id', $emp->id)
                ->whereMonth('date', now()->month)
                ->sum('amount');

            $expenses_total = Expense::where('employee_id', $emp->id)
                ->whereMonth('date', now()->month)
                ->sum('amount');

            $final_salary = $emp->basic_salary + ($emp->daily_wage * $working_days) + $overtime_total - $advance_total + $expenses_total;

            $salaries[] = [
                'employee_name' => $emp->name,
                'working_days' => $working_days,
                'basic_salary' => $emp->basic_salary,
                'daily_wage' => $emp->daily_wage,
                'advance_total' => $advance_total,
                'overtime_total' => $overtime_total,
                'expenses_total' => $expenses_total,
                'final_salary' => $final_salary,
            ];
        }

        return view('admin.salaries.index', compact('salaries'));
    }
}