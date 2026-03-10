<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClientService;
use App\Models\Project;
use App\Models\ProjectBilling;
use App\Models\ProjectDocument;
use App\Models\ClientNote;
use App\Models\ClientQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientDashboardController extends Controller
{
    /**
     * Show the unified client dashboard
     */
    public function index()
    {
        $user = auth()->user();

        // Get assigned services with service details and billings
        $services = ClientService::where('client_id', $user->id)
            ->with(['service', 'billings'])
            ->get();

        // Get assigned projects with billings and documents
        $projects = Project::where('client_id', $user->id)
            ->with(['billings', 'documents'])
            ->get();

        // Calculate finance totals for services
        $totalServiceAmount = 0;
        $totalServicePaid = 0;
        foreach ($services as $service) {
            if ($service->hours > 0) {
                $totalServiceAmount += $service->hours * $service->hourly_rate;
            } elseif ($service->days > 0) {
                $totalServiceAmount += $service->days * $service->daily_rate;
            } else {
                $totalServiceAmount += $service->months * $service->monthly_rate;
            }
            // Sum all payments for this service
            $totalServicePaid += $service->billings->sum('amount_paid');
        }
        $totalServiceRemaining = $totalServiceAmount - $totalServicePaid;

        // Calculate finance totals for projects (Budget + Billings)
        $totalProjectBudget = $projects->sum('budget');
        $totalProjectBilled = 0;
        $totalProjectPaid = 0;
        
        foreach ($projects as $project) {
            $totalProjectBilled += $project->billings->sum('amount_billed');
            $totalProjectPaid += $project->billings->sum('amount_paid');
        }
        
        $totalContractValue = $totalProjectBudget + $totalProjectBilled;
        $totalRemaining = $totalContractValue - $totalProjectPaid;

        // Get all project documents (as project updates)
        $projectUpdates = ProjectDocument::whereIn('project_id', $projects->pluck('id'))
            ->with('project')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get important notes from admin
        $importantNotes = ClientNote::where('client_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get client's queries
        $myQueries = ClientQuery::where('client_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.dashboard.index', compact(
            'user',
            'services',
            'projects',
            'totalServiceAmount',
            'totalServicePaid',
            'totalServiceRemaining',
            'totalProjectBudget',
            'totalProjectBilled',
            'totalProjectPaid',
            'totalContractValue',
            'totalRemaining',
            'projectUpdates',
            'importantNotes',
            'myQueries'
        ));
    }

    /**
     * Store a new query from client
     */
    public function storeQuery(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('client_queries', 'public');
        }

        ClientQuery::create([
            'client_id' => auth()->id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'document' => $documentPath,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your query has been submitted successfully. We will get back to you soon.');
    }

    /**
     * Mark a note as read
     */
    public function markNoteRead($id)
    {
        $note = ClientNote::where('client_id', auth()->id())->findOrFail($id);
        $note->update(['is_read' => true]);
        
        return back();
    }

    /**
     * Show project details for client
     */
    public function showProject($id)
    {
        $user = auth()->user();
        
        // Get project only if it belongs to this client
        $project = Project::where('client_id', $user->id)
            ->with(['billings', 'documents'])
            ->findOrFail($id);

        return view('client.dashboard.project-show', compact('project'));
    }
}
