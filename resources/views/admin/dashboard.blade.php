@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Welcome Header -->
    <div class="mb-4">
        <h2 class="mb-2">Welcome back, <strong>{{ auth()->user()->name }}</strong>! 👋</h2>
        <p class="text-muted">Here's your dashboard overview</p>
    </div>

    <!-- Statistics Cards Row -->
    <div class="row mb-4 g-3">
        <!-- Total Users Card -->
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.users.index') }}" style="text-decoration: none; color: inherit;">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="text-muted small">Total Users</span>
                                <h3 class="mb-0 mt-1" style="color: #4A90E2;">{{ $totalUsers ?? 0 }}</h3>
                            </div>
                            <div style="font-size: 2.5rem;">👥</div>
                        </div>
                        <div class="small text-success mt-2">
                            ↑ {{ $newUsersThisMonth ?? 0 }} this month
                        </div>
                    </div>
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: linear-gradient(to right, #4A90E2, #50E3C2);"></div>
                </div>
            </a>
        </div>

        <!-- Active Clients Card -->
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.clients.index') }}" style="text-decoration: none; color: inherit;">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="text-muted small">Active Clients</span>
                                <h3 class="mb-0 mt-1" style="color: #7B68EE;">{{ $totalClients ?? 0 }}</h3>
                            </div>
                            <div style="font-size: 2.5rem;">💼</div>
                        </div>
                        <div class="small text-info mt-2">
                            Service: {{ $serviceClients ?? 0 }} | Project: {{ $projectClients ?? 0 }}
                        </div>
                    </div>
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: linear-gradient(to right, #7B68EE, #E94B3C);"></div>
                </div>
            </a>
        </div>

        <!-- Active Projects Card -->
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.projects.index') }}" style="text-decoration: none; color: inherit;">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="text-muted small">Active Projects</span>
                                <h3 class="mb-0 mt-1" style="color: #F5A623;">{{ $totalProjects ?? 0 }}</h3>
                            </div>
                            <div style="font-size: 2.5rem;">📊</div>
                        </div>
                        <div class="small text-warning mt-2">
                            In Progress: {{ $projectsInProgress ?? 0 }}
                        </div>
                    </div>
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: linear-gradient(to right, #F5A623, #B8E986);"></div>
                </div>
            </a>
        </div>

        <!-- Team Members Card -->
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.employees.index') }}" style="text-decoration: none; color: inherit;">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="text-muted small">Employee Size</span>
                                <h3 class="mb-0 mt-1" style="color: #50E3C2;">{{ $totalEmployees ?? 0 }}</h3>
                            </div>
                            <div style="font-size: 2.5rem;">👷</div>
                        </div>
                        <div class="small text-info mt-2">
                            Department: {{ $departments ?? 0 }}
                        </div>
                    </div>
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: linear-gradient(to right, #50E3C2, #4A90E2);"></div>
                </div>
            </a>
        </div>
    </div>

    <!-- Secondary Statistics Row -->
    <div class="row mb-4 g-3">
        <!-- Revenue Card -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small">Total Revenue</span>
                            <h3 class="mb-0 mt-1" style="color: #2DBA4E;">${{ number_format($totalRevenue ?? 0, 2) }}</h3>
                        </div>
                        <div style="font-size: 2rem;">💰</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Card -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small">Services</span>
                            <h3 class="mb-0 mt-1" style="color: #9013FE;">{{ $totalServices ?? 0 }}</h3>
                        </div>
                        <div style="font-size: 2rem;">🛎️</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Card -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small">Today's Attendance</span>
                            <h3 class="mb-0 mt-1" style="color: #417505;">{{ $presentToday ?? 0 }}/{{ $totalEmployees ?? 0 }}</h3>
                        </div>
                        <div style="font-size: 2rem;">✓</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Users Card -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small">Admin Users</span>
                            <h3 class="mb-0 mt-1" style="color: #E74C3C;">{{ $adminUsers ?? 0 }}</h3>
                        </div>
                        <div style="font-size: 2rem;">🔐</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4 g-3">
        <!-- User Growth Chart -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">User Growth (Last 6 Months)</h5>
                </div>
                <div class="card-body p-4">
                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 250px; border-radius: 8px; display: flex; align-items: flex-end; padding: 20px; gap: 10px;" class="position-relative">
                        @php
                            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                            $data = [65, 80, 95, 110, 125, 140];
                        @endphp
                        @foreach($data as $value)
                            <div style="flex: 1; background: rgba(255,255,255,0.3); height: {{ ($value/150)*100 }}%; border-radius: 4px; transition: all 0.3s; cursor: pointer;" class="chart-bar" onmouseover="this.style.background='rgba(255,255,255,0.6)'" onmouseout="this.style.background='rgba(255,255,255,0.3)'"></div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-around mt-3 small text-muted">
                        @foreach($months as $month)
                            <div>{{ $month }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Client Type Distribution -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">Client Distribution</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-center" style="gap: 30px;">
                        <!-- Pie Chart representation -->
                        <div style="width: 150px; height: 150px; border-radius: 50%; background: conic-gradient(#4A90E2 0deg 144deg, #7B68EE 144deg 288deg, #F5A623 288deg 360deg); position: relative;">
                            <div style="width: 100px; height: 100px; border-radius: 50%; background: white; position: absolute; top: 25px; left: 25px; display: flex; align-items: center; justify-content: center; font-size: 24px;">👥</div>
                        </div>
                        <div style="gap: 15px;" class="d-flex flex-column">
                            <div class="d-flex align-items-center" style="gap: 10px;">
                                <div style="width: 20px; height: 20px; background: #4A90E2; border-radius: 4px;"></div>
                                <span class="small">Service Clients: {{ $serviceClients ?? 0 }}</span>
                            </div>
                            <div class="d-flex align-items-center" style="gap: 10px;">
                                <div style="width: 20px; height: 20px; background: #7B68EE; border-radius: 4px;"></div>
                                <span class="small">Project Clients: {{ $projectClients ?? 0 }}</span>
                            </div>
                            <div class="d-flex align-items-center" style="gap: 10px;">
                                <div style="width: 20px; height: 20px; background: #F5A623; border-radius: 4px;"></div>
                                <span class="small">Other: {{ ($totalClients - $serviceClients - $projectClients) ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3">
                        @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Create New User
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-info">
                                <i class="fas fa-users"></i> Manage Users
                            </a>
                        @endif
                        
                        @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.clients.index') }}" class="btn btn-success">
                                <i class="fas fa-building"></i> View Clients
                            </a>
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-warning">
                                <i class="fas fa-chart-bar"></i> View Projects
                            </a>
                        @endif
                        
                        <a href="{{ route('profile') }}" class="btn btn-secondary">
                            <i class="fas fa-user-circle"></i> My Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">System Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <small class="text-muted d-block">Last Backup</small>
                            <span>{{ now()->format('M d, Y @ h:i A') }}</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">System Status</small>
                            <span class="badge bg-success">🟢 Online & Operational</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Current Time</small>
                            <span class="text-info">{{ now()->format('M d, Y @ h:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
    }
</style>

@endsection