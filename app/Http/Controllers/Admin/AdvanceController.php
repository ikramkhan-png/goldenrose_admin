<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AdvanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Advance::with('employee')->latest();

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('month')) {
            $month = \Carbon\Carbon::createFromFormat('Y-m', $request->month);
            $query->whereYear('date', $month->year)
                  ->whereMonth('date', $month->month);
        }

        $advances  = $query->paginate(15);
        $employees = Employee::orderBy('name')->get();

        return view('admin.advances.index', compact('advances', 'employees'));
    }

    public function create()
    {
        $employees = Employee::orderBy('name')->get();

        return view('admin.advances.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'notes'       => 'nullable|string',
        ]);

        Advance::create($request->all());

        return redirect()
            ->route('admin.advances.index')
            ->with('success', 'Advance added successfully.');
    }

    public function edit(Advance $advance)
    {
        $employees = Employee::orderBy('name')->get();

        return view('admin.advances.edit', compact('advance', 'employees'));
    }

    public function update(Request $request, Advance $advance)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'notes'       => 'nullable|string',
        ]);

        $advance->update($request->all());

        return redirect()
            ->route('admin.advances.index')
            ->with('success', 'Advance updated successfully.');
    }

    public function destroy(Advance $advance)
    {
        $advance->delete();

        return redirect()
            ->route('admin.advances.index')
            ->with('success', 'Advance deleted successfully.');
    }
}