<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('client')->latest()->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create(Request $request)
    {
        $clients = User::where('type', 'client')->get();
        $selectedClientId = $request->client_id ?? null;
        return view('admin.projects.create', compact('clients', 'selectedClientId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'client_id'  => 'required|exists:users,id',
            'type'       => 'required|in:monthly,yearly,one-time',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'notes'      => 'nullable|string',
            'budget'     => 'nullable|numeric|min:0',
        ]);

        $project = Project::create($request->only(['name','client_id','type','start_date','end_date','notes','budget']));

        return redirect()->route('admin.clients.show', $request->client_id)
                         ->with('success', 'Project assigned successfully');
    }

    public function show(Project $project)
    {
        $project->load('client');
        return view('admin.Internal_Details.project_show', compact('project'));
    }

    public function edit(Project $project)
    {
        $clients = User::where('type', 'client')->get();
        return view('admin.projects.edit', compact('project', 'clients'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'client_id'  => 'required|exists:users,id',
            'type'       => 'required|in:monthly,yearly,one-time',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'notes'      => 'nullable|string',
            'budget'     => 'nullable|numeric|min:0',
        ]);

        $project->update($request->only(['name','client_id','type','start_date','end_date','notes','budget']));

        return redirect()->route('admin.clients.show', $project->client_id)
                         ->with('success', 'Project updated successfully');
    }

    public function destroy(Project $project)
    {
        $client_id = $project->client_id;
        $project->delete();

        return redirect()->route('admin.clients.show', $client_id)
                         ->with('success', 'Project deleted successfully');
    }

    // View project with tabs (optional)
    public function view($id)
    {
        $project = Project::with(['billings', 'client', 'assignedServices', 'documents'])->findOrFail($id);
        $tab = request('tab', 'details');

        return view('admin.projects.show', compact('project', 'tab'));
    }

    // Finance summary for single project
    public function financeSummary($id)
    {
        $project = Project::with(['billings'])->findOrFail($id);
        $billings = $project->billings;

        $totalBilled = $billings->sum('amount_billed');
        $totalPaid   = $billings->sum('amount_paid') ?? 0;
        $totalRemaining = $totalBilled - $totalPaid;

        $billingsByType = [
            [
                'type' => 'General',
                'billings' => $billings->map(function($b) {
                    return [
                        'amount_billed' => $b->amount_billed,
                        'amount_paid'   => $b->amount_paid ?? 0,
                        'remaining'     => ($b->amount_billed ?? 0) - ($b->amount_paid ?? 0),
                        'status'        => $b->status,
                        'payment_date'  => $b->payment_date,
                        'notes'         => $b->notes,
                        'invoice'       => $b->invoice,
                    ];
                })->toArray()
            ]
        ];

        return view('admin.projects.finance_summary', compact(
            'project',
            'billingsByType',
            'totalBilled',
            'totalPaid',
            'totalRemaining'
        ));
    }

    // Project internal details from client page
    public function internalShowFromClient($projectId)
    {
        $project = Project::with(['client', 'assignedServices', 'documents', 'billings', 'expenses'])->findOrFail($projectId);
        return view('admin.Internal_Details.project_show', compact('project'));
    }

    // ✅ NEW: Internal show for billing redirect
    public function internalShow($projectId)
    {
        $project = Project::with(['client', 'assignedServices', 'documents', 'billings', 'expenses'])->findOrFail($projectId);
        return view('admin.Internal_Details.project_show', compact('project'));
    }
}