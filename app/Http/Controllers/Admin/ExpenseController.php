<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Employee;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        // Show only project expenses (expenses with project_id set)
        $query = Expense::with('employee', 'project')
            ->whereNotNull('project_id')
            ->latest();
            
        if ($request->has('project_id') && $request->project_id) {
            $query->where('project_id', $request->project_id);
        }
        $expenses = $query->paginate(15);

        return view('admin.expenses.index', compact('expenses'));
    }

    public function create(Request $request)
    {
        $projects = \App\Models\Project::orderBy('name')->get();

        return view('admin.expenses.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'description' => 'required|string',
            'category'    => 'nullable|string',
            'project_id'  => 'nullable|exists:projects,id',
            'invoice'     => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xlsx',
        ]);

        $data = $request->only(['project_id','amount','date','description','category']);
        
        // Handle invoice upload
        if ($request->hasFile('invoice')) {
            $invoicePath = $request->file('invoice')->store('expenses/invoices', 'public');
            $data['invoice'] = $invoicePath;
        }

        Expense::create($data);

        $redirectRoute = $request->project_id 
            ? route('admin.internalDetails.show', $request->project_id) . '?tab=expenses'
            : route('admin.expenses.index');

        return redirect($redirectRoute)
            ->with('success', 'Expense added successfully.');
    }

    public function edit(Expense $expense)
    {
        $projects = \App\Models\Project::orderBy('name')->get();

        return view('admin.expenses.edit', compact('expense', 'projects'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'description' => 'required|string',
            'category'    => 'nullable|string',
            'project_id'  => 'nullable|exists:projects,id',
            'invoice'     => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xlsx',
        ]);

        $data = $request->only(['project_id','amount','date','description','category']);
        
        // Handle invoice upload
        if ($request->hasFile('invoice')) {
            $invoicePath = $request->file('invoice')->store('expenses/invoices', 'public');
            $data['invoice'] = $invoicePath;
        }

        $expense->update($data);

        $redirectRoute = $expense->project_id 
            ? route('admin.internalDetails.show', $expense->project_id) . '?tab=expenses'
            : route('admin.expenses.index');

        return redirect($redirectRoute)
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()
            ->route('admin.expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }
}