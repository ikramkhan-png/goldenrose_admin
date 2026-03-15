<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class ClientController extends Controller
{
    // ===================== INDEX =====================
    public function index(Request $request)
    {
        $query = User::where('type', 'client');

        // Filter by creation date month
        if ($request->filled('month')) {
            $month = Carbon::createFromFormat('Y-m', $request->month);
            $query->whereYear('created_at', $month->year)
                  ->whereMonth('created_at', $month->month);
        }

        $clients = $query->latest()->get();
        return view('admin.clients.index', compact('clients'));
    }

    // ===================== CREATE =====================
    public function create()
    {
        return view('admin.clients.create');
    }

    // ===================== STORE =====================
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'phone'       => 'nullable|string|max:20',
            'client_type' => 'required|in:service,project',
            'password'    => 'required|confirmed|min:6',
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'client_type' => $request->client_type,
            'type'        => 'client',
            'password'    => bcrypt($request->password),
        ]);

        return redirect()->route('admin.clients.index')->with('success', 'Client created successfully.');
    }

    // ===================== SHOW =====================
    public function show(User $client, Request $request)
    {
        $client->load([
            'services.service',
            'projects' => function($query) use ($request){
                $query->orderBy('start_date', 'desc');
                // Filter projects by month only if provided
                if ($request->filled('month')) {
                    $month = Carbon::createFromFormat('Y-m', $request->month);
                    $query->whereYear('start_date', $month->year)
                          ->whereMonth('start_date', $month->month);
                }
            },
            'clientNotes' => function($query){
                $query->orderBy('created_at', 'desc');
            },
            'clientQueries' => function($query){
                $query->orderBy('created_at', 'desc');
            }
        ]);

        // Filter services by assigned_date month only if provided
        if ($request->filled('month')) {
            $month = Carbon::createFromFormat('Y-m', $request->month);
            $client->setRelation('services', $client->services->filter(function($service) use ($month) {
                $assignedDate = Carbon::parse($service->assigned_date);
                return $assignedDate->year == $month->year && 
                       $assignedDate->month == $month->month;
            }));
        }

        return view('admin.clients.show', compact('client'));
    }

    // ===================== EDIT =====================
    public function edit(User $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    // ===================== UPDATE =====================
    public function update(Request $request, User $client)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $client->id,
            'phone'       => 'nullable|string|max:20',
            'client_type' => 'required|in:service,project',
        ]);

        $client->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'client_type' => $request->client_type,
        ]);

        return redirect()->route('admin.clients.index')
                         ->with('success', 'Client updated successfully');
    }

    // ===================== FINANCE SUMMARY =====================
    public function projectsFinanceSummary(User $client)
    {
        $client->load('projects.billings');

        $projects = $client->projects;

        // Budget is the base contract value for all projects
        $totalBudget = $projects->sum('budget');
        
        // Additional billings on top of budget
        $additionalBilled = $projects->flatMap->billings->sum('amount_billed');
        
        // Total Contract Value = Budget + Additional Billings
        $totalBilled = $totalBudget + $additionalBilled;
        
        // Total paid from all billing records
        $totalPaid = $projects->flatMap->billings->sum('amount_paid') ?? 0;
        
        // Remaining = Total Contract Value - Total Paid
        $totalRemaining = $totalBilled - $totalPaid;

        // Flatten billings for table display
        $projectsBillings = $projects->map(function($project) {
            return $project->billings->map(function($b) use ($project) {
                return [
                    'project_name'  => $project->name,
                    'amount_billed' => $b->amount_billed,
                    'amount_paid'   => $b->amount_paid ?? 0,
                    'remaining'     => ($b->amount_billed ?? 0) - ($b->amount_paid ?? 0),
                    'status'        => $b->status,
                    'payment_date'  => $b->payment_date,
                    'notes'         => $b->notes,
                    'invoice'       => $b->invoice,
                ];
            });
        })->flatten(1);

        return view('admin.projects.finance_summary', compact(
            'client',
            'projectsBillings',
            'totalBilled',
            'totalPaid',
            'totalRemaining'
        ));
    }

     public function destroy($id)
    {
        $client = User::findOrFail($id);
        $client->delete();

        return redirect()->route('admin.clients.index')
                         ->with('success', 'Client deleted successfully');
    }
}