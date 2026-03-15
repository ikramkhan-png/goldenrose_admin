<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('client');
        
        // Filter projects by month based on start_date only if month is provided
        if ($request->filled('month')) {
            $month = Carbon::createFromFormat('Y-m', $request->month);
            $query->whereYear('start_date', $month->year)
                  ->whereMonth('start_date', $month->month);
        }
        
        $projects = $query->latest('start_date')->get();
        
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

        // Budget is the base contract value
        $budget = $project->budget ?? 0;
        
        // Additional billings on top of budget
        $additionalBilled = $billings->sum('amount_billed');
        
        // Total Contract Value = Budget + Additional Billings
        $totalBilled = $budget + $additionalBilled;
        
        // Total paid from all billing records
        $totalPaid = $billings->sum('amount_paid') ?? 0;
        
        // Remaining = Total Contract Value - Total Paid
        $totalRemaining = $totalBilled - $totalPaid;

        // Prepare billings data for the view
        $projectsBillings = $billings->map(function($b) {
            return [
                'amount_billed' => $b->amount_billed,
                'amount_paid'   => $b->amount_paid ?? 0,
                'remaining'     => ($b->amount_billed ?? 0) - ($b->amount_paid ?? 0),
                'status'        => $b->status,
                'payment_date'  => $b->payment_date,
                'notes'         => $b->notes,
                'invoice'       => $b->invoice,
            ];
        })->toArray();

        return view('admin.projects.finance_summary', compact(
            'project',
            'projectsBillings',
            'totalBilled',
            'totalPaid',
            'totalRemaining',
            'budget',
            'additionalBilled'
        ));
    }

    // Project internal details from client page
    public function internalShowFromClient($projectId, Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $selectedMonth = Carbon::createFromFormat('Y-m', $month);

        $project = Project::with(['client', 'assignedServices', 'documents', 'billings', 'expenses'])->findOrFail($projectId);

        // Filter related data by month if requested
        if ($selectedMonth) {
            // Filter assigned services by assigned_date
            $project->setRelation('assignedServices', $project->assignedServices->filter(function($service) use ($selectedMonth) {
                $assignedDate = Carbon::parse($service->assigned_date);
                return $assignedDate->year == $selectedMonth->year && 
                       $assignedDate->month == $selectedMonth->month;
            }));

            // Filter documents by update_date
            $project->setRelation('documents', $project->documents->filter(function($document) use ($selectedMonth) {
                $updateDate = Carbon::parse($document->update_date);
                return $updateDate->year == $selectedMonth->year && 
                       $updateDate->month == $selectedMonth->month;
            }));

            // Filter billings by payment_date
            $project->setRelation('billings', $project->billings->filter(function($billing) use ($selectedMonth) {
                if ($billing->payment_date) {
                    $paymentDate = Carbon::parse($billing->payment_date);
                    return $paymentDate->year == $selectedMonth->year && 
                           $paymentDate->month == $selectedMonth->month;
                }
                return false;
            }));

            // Filter expenses by date
            $project->setRelation('expenses', $project->expenses->filter(function($expense) use ($selectedMonth) {
                $expenseDate = Carbon::parse($expense->date);
                return $expenseDate->year == $selectedMonth->year && 
                       $expenseDate->month == $selectedMonth->month;
            }));
        }

        return view('admin.Internal_Details.project_show', compact('project', 'selectedMonth'));
    }

    // ✅ NEW: Internal show for billing redirect
    public function internalShow($projectId, Request $request)
    {
        $project = Project::with(['client', 'assignedServices', 'documents', 'billings', 'expenses'])->findOrFail($projectId);

        // Filter related data by month only if provided
        if ($request->filled('month')) {
            $month = Carbon::createFromFormat('Y-m', $request->month);
            
            // Filter assigned services by assigned_date
            $project->setRelation('assignedServices', $project->assignedServices->filter(function($service) use ($month) {
                $assignedDate = Carbon::parse($service->assigned_date);
                return $assignedDate->year == $month->year && 
                       $assignedDate->month == $month->month;
            }));

            // Filter documents by update_date
            $project->setRelation('documents', $project->documents->filter(function($document) use ($month) {
                $updateDate = Carbon::parse($document->update_date);
                return $updateDate->year == $month->year && 
                       $updateDate->month == $month->month;
            }));

            // Filter billings by payment_date
            $project->setRelation('billings', $project->billings->filter(function($billing) use ($month) {
                if ($billing->payment_date) {
                    $paymentDate = Carbon::parse($billing->payment_date);
                    return $paymentDate->year == $month->year && 
                           $paymentDate->month == $month->month;
                }
                return false;
            }));

            // Filter expenses by date
            $project->setRelation('expenses', $project->expenses->filter(function($expense) use ($month) {
                $expenseDate = Carbon::parse($expense->date);
                return $expenseDate->year == $month->year && 
                       $expenseDate->month == $month->month;
            }));
        }

        return view('admin.Internal_Details.project_show', compact('project'));
    }
}