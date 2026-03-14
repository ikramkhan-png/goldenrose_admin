<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProjectDocumentController extends Controller
{
    // List all project documents
    public function index(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $selectedMonth = Carbon::createFromFormat('Y-m', $month);
        
        // Filter project documents by month based on update_date
        $projectDocuments = ProjectDocument::with('project')
            ->whereYear('update_date', $selectedMonth->year)
            ->whereMonth('update_date', $selectedMonth->month)
            ->latest('update_date')
            ->get();
            
        return view('admin.Project_Documents.index', compact('projectDocuments', 'selectedMonth'));
    }

    // Show create form
    public function create()
    {
        $projects = Project::all();
        $selectedProjectId = request('project_id') ?? null;
        
        return view('admin.Project_Documents.create', compact('projects', 'selectedProjectId'));
    }

    // Store new document
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
            'update_date' => 'nullable|date',
            'status' => 'required',
        ]);

        $filePath = null;
        $fileType = null;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('project_documents', 'public');
            $fileType = $request->file('file')->getClientOriginalExtension();
        }

        ProjectDocument::create([
            'project_id' => $request->project_id,
            'title' => $request->title,
            'description' => $request->description,
            'file' => $filePath,
            'file_type' => $fileType,
            'uploaded_by' => Auth::id(),
            'update_date' => $request->update_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.internalDetails.show', $request->project_id)
            ->with('tab', 'documents')
            ->with('success', 'Document added successfully.');
    }

    // Show edit form
    public function edit(ProjectDocument $projectDocument)
    {
        $projects = Project::all();
        $selectedProjectId = $projectDocument->project_id;
        return view('admin.Project_Documents.edit', compact('projectDocument', 'projects', 'selectedProjectId'));
    }

    // Update existing document
    public function update(Request $request, ProjectDocument $projectDocument)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
            'update_date' => 'nullable|date',
            'status' => 'required',
        ]);

        if ($request->hasFile('file')) {
            if ($projectDocument->file) {
                Storage::disk('public')->delete($projectDocument->file);
            }

            $projectDocument->file = $request->file('file')->store('project_documents', 'public');
            $projectDocument->file_type = $request->file('file')->getClientOriginalExtension();
        }

        $projectDocument->update([
            'project_id' => $request->project_id,
            'title' => $request->title,
            'description' => $request->description,
            'update_date' => $request->update_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.internalDetails.show', $projectDocument->project_id)
            ->with('tab', 'documents')
            ->with('success', 'Document updated successfully.');
    }

    // Optional: delete document
    public function destroy(ProjectDocument $projectDocument)
    {
        $projectId = $projectDocument->project_id;
        if ($projectDocument->file) {
            Storage::disk('public')->delete($projectDocument->file);
        }
        $projectDocument->delete();

        return redirect()->route('admin.internalDetails.show', $projectId)
            ->with('tab', 'documents')
            ->with('success', 'Document deleted successfully.');
    }
}