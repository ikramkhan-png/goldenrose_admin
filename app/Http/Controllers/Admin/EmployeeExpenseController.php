<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeExpenseController extends Controller
{
    /**
     * Display a listing of employee expenses.
     */
    public function index(Request $request)
    {
        $query = Expense::with('employee')
            ->whereNotNull('employee_id')
            ->whereNull('project_id')
            ->latest();

        if ($request->has('employee_id') && $request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        $expenses = $query->paginate(15);
        $employees = Employee::orderBy('name')->get();

        return view('admin.employee-expenses.index', compact('expenses', 'employees'));
    }

    /**
     * Show the form for creating a new employee expense.
     */
    public function create()
    {
        $employees = Employee::orderBy('name')->get();
        return view('admin.employee-expenses.create', compact('employees'));
    }

    /**
     * Store a newly created employee expense.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'description' => 'required|string|max:500',
            'invoice'     => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xlsx|max:5120',
        ]);

        $data = $request->only(['employee_id', 'amount', 'date', 'description']);
        $data['project_id'] = null; // Ensure this is an employee expense, not project expense
        
        // Handle invoice upload
        if ($request->hasFile('invoice')) {
            $invoicePath = $request->file('invoice')->store('employee-expenses/invoices', 'public');
            $data['invoice'] = $invoicePath;
        }

        Expense::create($data);

        return redirect()
            ->route('admin.employee-expenses.index')
            ->with('success', 'Employee expense added successfully.');
    }

    /**
     * Show the form for editing an employee expense.
     */
    public function edit(Expense $employee_expense)
    {
        $employees = Employee::orderBy('name')->get();
        return view('admin.employee-expenses.edit', compact('employee_expense', 'employees'));
    }

    /**
     * Update the specified employee expense.
     */
    public function update(Request $request, Expense $employee_expense)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'description' => 'required|string|max:500',
            'invoice'     => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xlsx|max:5120',
        ]);

        $data = $request->only(['employee_id', 'amount', 'date', 'description']);
        
        // Handle invoice upload
        if ($request->hasFile('invoice')) {
            $invoicePath = $request->file('invoice')->store('employee-expenses/invoices', 'public');
            $data['invoice'] = $invoicePath;
        }

        $employee_expense->update($data);

        return redirect()
            ->route('admin.employee-expenses.index')
            ->with('success', 'Employee expense updated successfully.');
    }

    /**
     * Remove the specified employee expense.
     */
    public function destroy(Expense $employee_expense)
    {
        $employee_expense->delete();

        return redirect()
            ->route('admin.employee-expenses.index')
            ->with('success', 'Employee expense deleted successfully.');
    }
}
