<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Overtime;
use App\Models\Advance;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    private function calculateSalaries($month = null)
    {
        // Set month to current month if not provided
        if (!$month) {
            $month = now()->format('Y-m');
        }

        // Parse month string to get year and month
        $carbonMonth = Carbon::createFromFormat('Y-m', $month);
        $year = $carbonMonth->year;
        $monthNum = $carbonMonth->month;

        $employees = Employee::all();
        $salaries = [];

        foreach ($employees as $emp) {
            // Filter attendance by month
            $working_days = Attendance::where('employee_id', $emp->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $monthNum)
                ->count();

            // Filter overtime by month
            $overtime_total = Overtime::where('employee_id', $emp->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $monthNum)
                ->sum('amount');

            // Filter advances by month
            $advance_total = Advance::where('employee_id', $emp->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $monthNum)
                ->sum('amount');

            // Filter expenses by month (only employee expenses, not project expenses)
            $expenses_total = Expense::where('employee_id', $emp->id)
                ->whereNull('project_id')
                ->whereYear('date', $year)
                ->whereMonth('date', $monthNum)
                ->sum('amount');

            $basic_salary = $emp->basic_salary ?? 0;
            $daily_rate = $emp->daily_wage ?? 0;

            $final_salary =
                $basic_salary +
                ($working_days * $daily_rate) +
                $overtime_total +
                $expenses_total -
                $advance_total;

            $salaries[] = [
                'employee_name'  => $emp->name,
                'working_days'   => $working_days,
                'basic_salary'   => $basic_salary,
                'daily_wage'     => $daily_rate,
                'overtime_total' => $overtime_total,
                'advance_total'  => $advance_total,
                'expenses_total' => $expenses_total,
                'final_salary'   => $final_salary,
            ];
        }

        return $salaries;
    }

    public function index(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $selectedMonth = Carbon::createFromFormat('Y-m', $month);
        $salaries = $this->calculateSalaries($month);
        
        // Get attendance records for the attendance tab
        $attendances = Attendance::with('employee')
            ->whereYear('date', $selectedMonth->year)
            ->whereMonth('date', $selectedMonth->month)
            ->orderBy('date', 'desc')
            ->get();
        
        // Get all employees for the bulk attendance modal
        $employees = Employee::orderBy('name')->get();

        return view('admin.salaries.index', compact('salaries', 'selectedMonth', 'attendances', 'employees'));
    }

    public function exportPdf(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $selectedMonth = Carbon::createFromFormat('Y-m', $month);
        $salaries = $this->calculateSalaries($month);

        $monthDisplay = $selectedMonth->format('F Y');

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.salaries.pdf', compact('salaries', 'monthDisplay'));
        $pdf->setPaper('A4', 'landscape');

        $fileName = 'salaries_' . $month . '.pdf';
        return $pdf->download($fileName);
    }
}

