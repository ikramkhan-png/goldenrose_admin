<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Attendance;
use App\Models\Department;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Get total counts
            $totalUsers = User::count();
        } catch (\Exception $e) {
            $totalUsers = 0;
        }
        
        try {
            $adminUsers = User::whereIn('type', ['admin'])->count();
        } catch (\Exception $e) {
            $adminUsers = 0;
        }
        
        try {
            $totalClients = Client::where('status', 'active')->count();
        } catch (\Exception $e) {
            $totalClients = 0;
        }
        
        try {
            $totalProjects = Project::count();
        } catch (\Exception $e) {
            $totalProjects = 0;
        }
        
        try {
            $totalEmployees = Employee::count();
        } catch (\Exception $e) {
            $totalEmployees = 0;
        }
        
        try {
            $totalServices = Service::count();
        } catch (\Exception $e) {
            $totalServices = 0;
        }
        
        try {
            $departments = Department::count();
        } catch (\Exception $e) {
            $departments = 0;
        }
        
        // Get client type breakdown
        try {
            $serviceClients = User::where('client_type', 'service')->count();
        } catch (\Exception $e) {
            $serviceClients = 0;
        }
        
        try {
            $projectClients = User::where('client_type', 'project')->count();
        } catch (\Exception $e) {
            $projectClients = 0;
        }
        
        // Get projects in progress (based on end_date being in future)
        try {
            $projectsInProgress = Project::where('end_date', '>', Carbon::now())->count();
        } catch (\Exception $e) {
            $projectsInProgress = 0;
        }
        
        // Get today's attendance (employees with check-in)
        try {
            $today = Carbon::today();
            $presentToday = Attendance::whereDate('date', $today)
                ->whereNotNull('check_in')
                ->count();
        } catch (\Exception $e) {
            $presentToday = 0;
        }
        
        // Calculate total revenue from project billings
        try {
            $totalRevenue = \DB::table('project_billings')->sum('amount');
            $totalRevenue = $totalRevenue ?? 0;
        } catch (\Exception $e) {
            $totalRevenue = 0;
        }
        
        // Get new users this month
        try {
            $newUsersThisMonth = User::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();
        } catch (\Exception $e) {
            $newUsersThisMonth = 0;
        }
        
        // Pass all data to view
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'adminUsers' => $adminUsers,
            'totalClients' => $totalClients,
            'serviceClients' => $serviceClients,
            'projectClients' => $projectClients,
            'totalProjects' => $totalProjects,
            'projectsInProgress' => $projectsInProgress,
            'totalEmployees' => $totalEmployees,
            'departments' => $departments,
            'presentToday' => $presentToday,
            'totalRevenue' => $totalRevenue,
            'newUsersThisMonth' => $newUsersThisMonth,
            'totalServices' => $totalServices,
        ]);
    }
}
