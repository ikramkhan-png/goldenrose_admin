<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ClientController extends Controller
{
    // ===================== INDEX =====================
    public function index()
    {
        $clients = User::where('type', 'client')->latest()->get();
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
    public function show(User $client)
    {
        $client->load([
            'services.service',
            'projects' => function($query){
                $query->orderBy('start_date', 'desc');
            }
        ]);

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

        $totalBilled = $projects->flatMap->billings->sum('amount_billed');
        $totalPaid   = $projects->flatMap->billings->sum('amount_paid') ?? 0;
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