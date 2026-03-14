<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectService;
use App\Models\Project;
use App\Models\Machinery;
use App\Models\Manpower;
use Carbon\Carbon;

class ProjectServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = ProjectService::with('project', 'service');

        // Filter by creation date month
        if ($request->filled('month')) {
            $month = Carbon::createFromFormat('Y-m', $request->month);
            $query->whereYear('created_at', $month->year)
                  ->whereMonth('created_at', $month->month);
        }

        $projectServices = $query->latest()->get();
        return view('admin.project_services.index', compact('projectServices'));
    }

    public function create()
    {
        $projects = Project::all();
        $machineries = Machinery::all();
        $manpowers = Manpower::all();
        $selectedProjectId = request('project_id') ?? null;
        
        return view('admin.project_services.create', compact('projects','machineries','manpowers','selectedProjectId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id'   => 'required|exists:projects,id',
            'service_type' => 'required|in:App\\Models\\Machinery,App\\Models\\Manpower',
            'service_id'   => 'required|integer',
            'rate_type'    => 'required|in:hourly,daily,monthly',
            'duration'     => 'required|integer|min:1',
            'rate'         => 'required|numeric|min:0',
        ]);

        // Prepare data based on rate type
        $data = [
            'project_id'   => $request->project_id,
            'service_type' => $request->service_type,
            'service_id'   => $request->service_id,
        ];

        if ($request->rate_type === 'hourly') {
            $data['hours'] = $request->duration;
            $data['hourly_rate'] = $request->rate;
        } elseif ($request->rate_type === 'daily') {
            $data['days'] = $request->duration;
            $data['daily_rate'] = $request->rate;
        } elseif ($request->rate_type === 'monthly') {
            $data['months'] = $request->duration;
            $data['monthly_rate'] = $request->rate;
        }

        ProjectService::create($data);

        return redirect(route('admin.internalDetails.show', $request->project_id) . '?tab=services')
                         ->with('success','Service added successfully');
    }

    public function edit(ProjectService $projectService)
    {
        $projects = Project::all();
        $machineries = Machinery::all();
        $manpowers = Manpower::all();
        $selectedProjectId = $projectService->project_id;
        
        return view('admin.project_services.edit', compact('projectService','projects','machineries','manpowers','selectedProjectId'));
    }

    public function update(Request $request, ProjectService $projectService)
    {
        $request->validate([
            'project_id'   => 'required|exists:projects,id',
            'service_type' => 'required|in:App\\Models\\Machinery,App\\Models\\Manpower',
            'service_id'   => 'required|integer',
            'rate_type'    => 'required|in:hourly,daily,monthly',
            'duration'     => 'required|integer|min:1',
            'rate'         => 'required|numeric|min:0',
        ]);

        $data = [
            'project_id'   => $request->project_id,
            'service_type' => $request->service_type,
            'service_id'   => $request->service_id,
            'hours'        => null,
            'days'         => null,
            'months'       => null,
            'hourly_rate'  => null,
            'daily_rate'   => null,
            'monthly_rate' => null,
        ];

        if ($request->rate_type === 'hourly') {
            $data['hours'] = $request->duration;
            $data['hourly_rate'] = $request->rate;
        } elseif ($request->rate_type === 'daily') {
            $data['days'] = $request->duration;
            $data['daily_rate'] = $request->rate;
        } elseif ($request->rate_type === 'monthly') {
            $data['months'] = $request->duration;
            $data['monthly_rate'] = $request->rate;
        }

        $projectService->update($data);

        return redirect(route('admin.internalDetails.show', $projectService->project_id) . '?tab=services')
                         ->with('success','Service updated successfully');
    }

    public function destroy(ProjectService $projectService)
    {
        $projectId = $projectService->project_id;
        $projectService->delete();
        return redirect()->route('admin.internalDetails.show', $projectId)
                         ->with('tab', 'services')
                         ->with('success','Service deleted successfully');
    }
}