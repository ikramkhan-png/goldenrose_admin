<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Overtime;
use App\Models\Employee;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    public function index(Request $request)
    {
        $query = Overtime::with('employee')->latest();

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('month')) {
            $month = \Carbon\Carbon::createFromFormat('Y-m', $request->month);
            $query->whereYear('date', $month->year)
                  ->whereMonth('date', $month->month);
        }

        $overtimes = $query->paginate(15);
        $employees = Employee::orderBy('name')->get();

        return view('admin.overtimes.index', compact('overtimes', 'employees'));
    }

    public function create()
    {
        $employees = Employee::orderBy('name')->get();

        return view('admin.overtimes.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'notes'       => 'nullable|string',
        ]);

        Overtime::create($request->all());

        return redirect()
            ->route('admin.overtimes.index')
            ->with('success', 'Overtime added successfully.');
    }

    public function edit(Overtime $overtime)
    {
        $employees = Employee::orderBy('name')->get();

        return view('admin.overtimes.edit', compact('overtime', 'employees'));
    }

    public function update(Request $request, Overtime $overtime)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'notes'       => 'nullable|string',
        ]);

        $overtime->update($request->all());

        return redirect()
            ->route('admin.overtimes.index')
            ->with('success', 'Overtime updated successfully.');
    }

    public function destroy(Overtime $overtime)
    {
        $overtime->delete();

        return redirect()
            ->route('admin.overtimes.index')
            ->with('success', 'Overtime deleted successfully.');
    }
}