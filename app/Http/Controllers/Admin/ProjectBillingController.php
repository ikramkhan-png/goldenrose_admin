<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectBilling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectBillingController extends Controller
{
    // Show create form
    public function create(Request $request)
    {
        $project = Project::findOrFail($request->project_id);
        return view('admin.project-billings.create', compact('project'));
    }

    // Store billing
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount_billed' => 'required|numeric|min:0',
            'amount_paid' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,paid',
            'payment_date' => 'nullable|date',
            'invoice' => 'nullable|file|mimes:pdf,jpg,png,jpeg',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();

        // Handle invoice upload
        if ($request->hasFile('invoice')) {
            $data['invoice'] = $request->file('invoice')->store('invoices', 'public');
        }

        ProjectBilling::create($data);

        return redirect()->route('admin.projects.view', $request->project_id.'?tab=finance')
                         ->with('success', 'Billing added successfully.');
    }

    // Edit billing
   public function edit($id)
    {
        $billing = ProjectBilling::findOrFail($id);
        return view('admin.project-billings.edit', compact('billing'));
    }

    // Update billing
    public function update(Request $request, $billingId)
        {
            $billing = \App\Models\ProjectBilling::findOrFail($billingId);

            $request->validate([
                'amount_billed' => 'required|numeric|min:0',
                'amount_paid'   => 'nullable|numeric|min:0',
                'payment_date'  => 'nullable|date',
                'status'        => 'required|in:pending,paid',
                'notes'         => 'nullable|string',
                'invoice'       => 'nullable|file|mimes:pdf,jpg,png',
            ]);

            $data = $request->only(['amount_billed','amount_paid','payment_date','status','notes']);

            if ($request->hasFile('invoice')) {
                $path = $request->file('invoice')->store('invoices', 'public');
                $data['invoice'] = $path;
            }

            $billing->update($data);

            // ✅ Redirect to project_show blade (Internal Details)
            return redirect()->route('admin.projects.internalShowFromClient', $billing->project_id)
                            ->with('success','Billing updated successfully');
        }

        // Delete billing
        public function destroy(ProjectBilling $billing)
        {
            if ($billing->invoice) Storage::disk('public')->delete($billing->invoice);
            $billing->delete();
            return back()->with('success', 'Billing deleted successfully.');
        }
}