<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectBilling;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Machinery;
use App\Models\Manpower;
use App\Models\Attendance;
use App\Models\Department;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total users count
        try {
            $totalUsers = User::count();
        } catch (\Exception $e) {
            $totalUsers = 0;
        }
        
        // Get admin users count (type = 'admin' or 'super_admin')
        try {
            $adminUsers = User::whereIn('type', ['admin', 'super_admin'])->count();
        } catch (\Exception $e) {
            $adminUsers = 0;
        }
        
        // Get total clients count (users with type = 'client')
        try {
            $totalClients = User::where('type', 'client')->count();
        } catch (\Exception $e) {
            $totalClients = 0;
        }
        
        // Get client type breakdown from users table
        try {
            $serviceClients = User::where('type', 'client')
                ->where('client_type', 'service')
                ->count();
        } catch (\Exception $e) {
            $serviceClients = 0;
        }
        
        try {
            $projectClients = User::where('type', 'client')
                ->where('client_type', 'project')
                ->count();
        } catch (\Exception $e) {
            $projectClients = 0;
        }
        
        // Get total projects count
        try {
            $totalProjects = Project::count();
        } catch (\Exception $e) {
            $totalProjects = 0;
        }
        
        // Get projects in progress (no end_date or end_date in future)
        try {
            $projectsInProgress = Project::where(function($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>', Carbon::now());
            })->count();
        } catch (\Exception $e) {
            $projectsInProgress = 0;
        }
        
        // Get total employees count
        try {
            $totalEmployees = Employee::count();
        } catch (\Exception $e) {
            $totalEmployees = 0;
        }
        
        // Get total services count (Machinery + Manpower)
        try {
            $machineryCount = Machinery::count();
            $manpowerCount = Manpower::count();
            $totalServices = $machineryCount + $manpowerCount;
        } catch (\Exception $e) {
            $totalServices = 0;
        }
        
        // Get departments count
        try {
            $departments = Department::count();
        } catch (\Exception $e) {
            $departments = 0;
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
        
        // Calculate total revenue from project billings (amount_paid) + project budgets
        try {
            // Sum of all paid amounts from billings
            $billingRevenue = ProjectBilling::sum('amount_paid') ?? 0;
            // Sum of all project budgets
            $budgetRevenue = Project::sum('budget') ?? 0;
            $totalRevenue = $billingRevenue;
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
