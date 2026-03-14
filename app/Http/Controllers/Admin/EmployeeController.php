<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('department');

        // Filter by hiring date month
        if ($request->filled('month')) {
            $month = Carbon::createFromFormat('Y-m', $request->month);
            $query->whereYear('hiring_date', $month->year)
                  ->whereMonth('hiring_date', $month->month);
        }

        $employees = $query->orderBy('hiring_date', 'desc')->get();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'basic_salary' => 'required|numeric',
            'daily_wage' => 'required|numeric',
        ]);

        Employee::create($request->all());

        return redirect()->route('admin.employees.index')->with('success', 'Employee added successfully.');
    }

    public function show(Employee $employee)
    {
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'basic_salary' => 'required|numeric',
            'daily_wage' => 'required|numeric',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $employee->update($request->all()); // or Employee::create($request->all());

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully.');
    }
    
}