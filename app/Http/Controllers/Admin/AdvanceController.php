<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AdvanceController extends Controller
{
    public function index()
    {
        $advances = Advance::with('employee')
            ->latest()
            ->paginate(15);

        return view('admin.advances.index', compact('advances'));
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