<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClientProject;
use App\Models\User;
use Carbon\Carbon;

class ClientProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = ClientProject::with('client');

        // Filter by start date month
        if ($request->filled('month')) {
            $month = Carbon::createFromFormat('Y-m', $request->month);
            $query->whereYear('start_date', $month->year)
                  ->whereMonth('start_date', $month->month);
        }

        $projects = $query->latest()->get();
        return view('admin.client_projects.index', compact('projects'));
    }

    public function create()
    {
        $clients = User::where('type', 'client')->get();
        return view('admin.client_projects.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id'   => 'required|exists:users,id',
            'name'        => 'required|string|max:255',
            'status'      => 'required|in:pending,in_progress,completed',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        ClientProject::create($request->all());

        return redirect()->route('admin.client-projects.index')
            ->with('success', 'Project assigned successfully');
    }

    public function edit(ClientProject $clientProject)
    {
        $clients = User::where('type', 'client')->get();
        return view('admin.client_projects.edit', compact('clientProject','clients'));
    }

    public function update(Request $request, ClientProject $clientProject)
    {
        $request->validate([
            'client_id'   => 'required|exists:users,id',
            'name'        => 'required|string|max:255',
            'status'      => 'required|in:pending,in_progress,completed',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $clientProject->update($request->all());

        return redirect()->route('admin.client-projects.index')
            ->with('success', 'Project updated successfully');
    }

    public function destroy(ClientProject $clientProject)
    {
        $clientProject->delete();
        return redirect()->route('admin.client-projects.index')
            ->with('success', 'Project removed successfully');
    }
}