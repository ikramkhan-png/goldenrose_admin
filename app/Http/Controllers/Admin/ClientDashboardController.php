<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClientService;
use App\Models\Project;
use App\Models\ProjectBilling;
use App\Models\ClientServiceBilling;
use App\Models\ProjectDocument;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClientDashboardController extends Controller
{
    /**
     * Show the client dashboard
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $month = $request->get('month', Carbon::now()->format('Y-m'));

        if ($user->client_type === 'service') {
            return $this->serviceClientDashboard($user, $month);
        } elseif ($user->client_type === 'project') {
            return $this->projectClientDashboard($user, $month);
        }

        return redirect('/');
    }

    /**
     * Service Client Dashboard
     */
    private function serviceClientDashboard($user, $month)
    {
        [$startDate, $endDate] = $this->getMonthDateRange($month);

        // Get all services for this client
        $services = ClientService::where('client_id', $user->id)
            ->with('service')
            ->get();

        // Calculate total finance info
        $totalBilling = ClientServiceBilling::whereIn('client_service_id', $services->pluck('id'))
            ->whereBetween('billing_date', [$startDate, $endDate])
            ->sum('amount');

        $servicesBillings = [];
        foreach ($services as $service) {
            $billings = ClientServiceBilling::where('client_service_id', $service->id)
                ->whereBetween('billing_date', [$startDate, $endDate])
                ->get();

            $servicesBillings[$service->id] = [
                'service' => $service,
                'billings' => $billings,
                'total' => $billings->sum('amount'),
                'count' => $billings->count(),
            ];
        }

        return view('client.dashboard.service-dashboard', [
            'services' => $services,
            'servicesBillings' => $servicesBillings,
            'totalBilling' => $totalBilling,
            'month' => $month,
        ]);
    }

    /**
     * Project Client Dashboard
     */
    private function projectClientDashboard($user, $month)
    {
        [$startDate, $endDate] = $this->getMonthDateRange($month);

        // Get all projects for this client
        $projects = Project::where('client_id', $user->id)
            ->get();

        $projectsData = [];
        foreach ($projects as $project) {
            $billings = ProjectBilling::where('project_id', $project->id)
                ->whereBetween('billing_date', [$startDate, $endDate])
                ->get();

            $projectsData[$project->id] = [
                'project' => $project,
                'billings' => $billings,
                'totalBilled' => $billings->sum('amount'),
                'budget' => $project->budget ?? 0,
                'paid' => $project->paid ?? 0,
                'remaining' => ($project->budget ?? 0) - ($project->paid ?? 0),
                'documents' => ProjectDocument::where('project_id', $project->id)->get(),
            ];
        }

        // Calculate overall finance totals
        $totalBudget = $projects->sum('budget');
        $totalPaid = $projects->sum('paid');
        $totalRemaining = $totalBudget - $totalPaid;

        return view('client.dashboard.project-dashboard', [
            'projects' => $projects,
            'projectsData' => $projectsData,
            'totalBudget' => $totalBudget,
            'totalPaid' => $totalPaid,
            'totalRemaining' => $totalRemaining,
            'month' => $month,
        ]);
    }

    /**
     * Get start and end date for a given month
     */
    private function getMonthDateRange($month)
    {
        $date = Carbon::createFromFormat('Y-m', $month);
        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();

        return [$startDate, $endDate];
    }
}
