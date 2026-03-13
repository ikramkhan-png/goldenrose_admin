<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('employee');

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('month')) {
            $month = Carbon::createFromFormat('Y-m', $request->month);
            $query->whereYear('date', $month->year)
                  ->whereMonth('date', $month->month);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(20);
        $employees   = Employee::orderBy('name')->get();

        return view('admin.attendance.index', compact('attendances', 'employees'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('admin.attendance.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
        ]);

        Attendance::create($request->all());

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance added.');
    }

    public function edit(Attendance $attendance)
    {
        $employees = Employee::all();
        return view('admin.attendance.edit', compact('attendance', 'employees'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
        ]);

        $attendance->update($request->all());

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance updated.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('admin.attendance.index')->with('success', 'Attendance deleted.');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month'       => 'required|date_format:Y-m',
            'num_days'    => 'required|integer|min:1|max:31',
            'check_in'    => 'required|date_format:H:i',
            'check_out'   => 'required|date_format:H:i',
        ]);

        $employeeId = $request->employee_id;
        $month = $request->month;
        $numDays = $request->num_days;
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;

        // Parse month to get year and month number
        $startDate = \Carbon\Carbon::createFromFormat('Y-m', $month)->startOfMonth();

        // Create attendance records for the specified number of consecutive days
        for ($i = 0; $i < $numDays; $i++) {
            $date = $startDate->clone()->addDays($i);
            
            // Skip weekends if needed (optional - comment out if you want to include weekends)
            // if ($date->isWeekend()) continue;

            Attendance::create([
                'employee_id' => $employeeId,
                'date'        => $date->toDateString(),
                'check_in'    => $checkIn,
                'check_out'   => $checkOut,
            ]);
        }

        return redirect()->route('admin.salaries.index', ['tab' => 'attendance', 'month' => $month])
            ->with('success', "$numDays attendance records added successfully for this employee!");
    }
}