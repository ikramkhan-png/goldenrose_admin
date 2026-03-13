@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp

    <div class="container-fluid px-4 py-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <!-- Welcome Header -->
        <div class="mb-4">
            <h2 class="mb-2">
                {{ __('dashboard.welcome_back') }},
                <strong>{{ auth()->user()->name }}</strong>! 👋
            </h2>
            <p class="text-muted">{{ __('dashboard.dashboard_overview') }}</p>
        </div>

        <!-- Statistics Cards Row -->
        <div class="row mb-4 g-3">

            <!-- Total Users Card -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.users.index') }}" style="text-decoration: none; color: inherit;">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-muted small">{{ __('dashboard.total_users') }}</span>
                                    <h3 class="mb-0 mt-1" style="color: #4A90E2;">{{ $totalUsers ?? 0 }}</h3>
                                </div>
                                <div style="font-size: 2.5rem;">👥</div>
                            </div>
                            <div class="small text-success mt-2">
                                ↑ {{ $newUsersThisMonth ?? 0 }} {{ __('dashboard.this_month') }}
                            </div>
                        </div>
                        <div class="card-top-bar" style="background: linear-gradient(to right, #4A90E2, #50E3C2);"></div>
                    </div>
                </a>
            </div>

            <!-- Active Clients Card -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.clients.index') }}" style="text-decoration: none; color: inherit;">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-muted small">{{ __('dashboard.active_clients') }}</span>
                                    <h3 class="mb-0 mt-1" style="color: #7B68EE;">{{ $totalClients ?? 0 }}</h3>
                                </div>
                                <div style="font-size: 2.5rem;">💼</div>
                            </div>
                            <div class="small text-info mt-2">
                                {{ __('dashboard.service_clients') }}: {{ $serviceClients ?? 0 }} |
                                {{ __('dashboard.project_clients') }}: {{ $projectClients ?? 0 }}
                            </div>
                        </div>
                        <div class="card-top-bar" style="background: linear-gradient(to right, #7B68EE, #E94B3C);"></div>
                    </div>
                </a>
            </div>

            <!-- Active Projects Card -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.projects.index') }}" style="text-decoration: none; color: inherit;">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-muted small">{{ __('dashboard.active_projects') }}</span>
                                    <h3 class="mb-0 mt-1" style="color: #F5A623;">{{ $totalProjects ?? 0 }}</h3>
                                </div>
                                <div style="font-size: 2.5rem;">📊</div>
                            </div>
                            <div class="small text-warning mt-2">
                                {{ __('dashboard.in_progress') }}: {{ $projectsInProgress ?? 0 }}
                            </div>
                        </div>
                        <div class="card-top-bar" style="background: linear-gradient(to right, #F5A623, #B8E986);"></div>
                    </div>
                </a>
            </div>

            <!-- Team Members Card -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.employees.index') }}" style="text-decoration: none; color: inherit;">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-muted small">{{ __('dashboard.employee_size') }}</span>
                                    <h3 class="mb-0 mt-1" style="color: #50E3C2;">{{ $totalEmployees ?? 0 }}</h3>
                                </div>
                                <div style="font-size: 2.5rem;">👷</div>
                            </div>
                            <div class="small text-info mt-2">
                                {{ __('dashboard.department') }}: {{ $departments ?? 0 }}
                            </div>
                        </div>
                        <div class="card-top-bar" style="background: linear-gradient(to right, #50E3C2, #4A90E2);"></div>
                    </div>
                </a>
            </div>

        </div>

        <!-- Secondary Statistics Row -->
        <div class="row mb-4 g-3">

            <!-- Total Revenue -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="text-muted small">{{ __('dashboard.total_revenue') }}</span>
                                <h3 class="mb-0 mt-1" style="color: #2DBA4E;">
                                    ${{ number_format($totalRevenue ?? 0, 2) }}
                                </h3>
                            </div>
                            <div style="font-size: 2rem;">💰</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="text-muted small">{{ __('dashboard.services') }}</span>
                                <h3 class="mb-0 mt-1" style="color: #9013FE;">{{ $totalServices ?? 0 }}</h3>
                            </div>
                            <div style="font-size: 2rem;">🛎️</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Attendance -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="text-muted small">{{ __('dashboard.today_attendance') }}</span>
                                <h3 class="mb-0 mt-1" style="color: #417505;">
                                    {{ $presentToday ?? 0 }}/{{ $totalEmployees ?? 0 }}
                                </h3>
                            </div>
                            <div style="font-size: 2rem;">✓</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Users -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="text-muted small">{{ __('dashboard.admin_users') }}</span>
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
                        <h5 class="mb-0">{{ __('dashboard.user_growth') }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <div
                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 250px; border-radius: 8px; display: flex; align-items: flex-end; padding: 20px; gap: 10px;">
                            @php
                                $data = [65, 80, 95, 110, 125, 140];

                                // Months in English or Arabic depending on locale
                                $months = $isAr
                                    ? ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو']
                                    : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                            @endphp
                            @foreach ($data as $value)
                                <div class="chart-bar"
                                    style="flex: 1; background: rgba(255,255,255,0.3); height: {{ ($value / 150) * 100 }}%; border-radius: 4px; transition: all 0.3s; cursor: pointer;"
                                    onmouseover="this.style.background='rgba(255,255,255,0.6)'"
                                    onmouseout="this.style.background='rgba(255,255,255,0.3)'">
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-around mt-3 small text-muted">
                            @foreach ($months as $month)
                                <div>{{ $month }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client Distribution -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0">{{ __('dashboard.client_distribution') }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-center" style="gap: 30px;">
                            <div
                                style="width: 150px; height: 150px; border-radius: 50%; background: conic-gradient(#4A90E2 0deg 144deg, #7B68EE 144deg 288deg, #F5A623 288deg 360deg); position: relative; flex-shrink: 0;">
                                <div
                                    style="width: 100px; height: 100px; border-radius: 50%; background: white; position: absolute; top: 25px; left: 25px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                                    👥
                                </div>
                            </div>
                            <div class="d-flex flex-column" style="gap: 15px;">
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <div
                                        style="width: 20px; height: 20px; background: #4A90E2; border-radius: 4px; flex-shrink: 0;">
                                    </div>
                                    <span class="small">{{ __('dashboard.service_clients') }}:
                                        {{ $serviceClients ?? 0 }}</span>
                                </div>
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <div
                                        style="width: 20px; height: 20px; background: #7B68EE; border-radius: 4px; flex-shrink: 0;">
                                    </div>
                                    <span class="small">{{ __('dashboard.project_clients') }}:
                                        {{ $projectClients ?? 0 }}</span>
                                </div>
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <div
                                        style="width: 20px; height: 20px; background: #F5A623; border-radius: 4px; flex-shrink: 0;">
                                    </div>
                                    <span class="small">
                                        {{ __('dashboard.other') }}:
                                        {{ ($totalClients ?? 0) - ($serviceClients ?? 0) - ($projectClients ?? 0) }}
                                    </span>
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
                        <h5 class="mb-0">{{ __('dashboard.quick_actions') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-3">

                            @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                    <i class="fas fa-user-plus"></i>
                                    {{ __('dashboard.create_user') }}
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-info">
                                    <i class="fas fa-users"></i>
                                    {{ __('dashboard.manage_users') }}
                                </a>
                            @endif

                            @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.clients.index') }}" class="btn btn-success">
                                    <i class="fas fa-building"></i>
                                    {{ __('dashboard.view_clients') }}
                                </a>
                                <a href="{{ route('admin.projects.index') }}" class="btn btn-warning">
                                    <i class="fas fa-chart-bar"></i>
                                    {{ __('dashboard.view_projects') }}
                                </a>
                            @endif

                            <a href="{{ route('profile') }}" class="btn btn-secondary">
                                <i class="fas fa-user-circle"></i>
                                {{ __('dashboard.my_profile') }}
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information Section -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0">{{ __('dashboard.system_information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <small class="text-muted d-block">{{ __('dashboard.last_backup') }}</small>
                                <span>{{ now()->translatedFormat('M d, Y @ h:i A') }}</span>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">{{ __('dashboard.system_status') }}</small>
                                <span class="badge bg-success">
                                    🟢 {{ __('dashboard.online_operational') }}
                                </span>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">{{ __('dashboard.current_time') }}</small>
                                <span class="text-info">{{ now()->translatedFormat('M d, Y @ h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- end container-fluid -->

    <style>
        /* Shared card hover effect */
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        /* Top colour bar on stat cards */
        .card-top-bar {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        /* RTL tweaks — only applied when the page is Arabic */
        [dir="rtl"] .d-flex.gap-3 {
            flex-direction: row-reverse;
        }

        [dir="rtl"] .card-top-bar {
            left: auto;
            right: 0;
        }

        [dir="rtl"] .text-muted.small,
        [dir="rtl"] .small {
            text-align: right;
        }

        /* Arabic font for better rendering */
        [dir="rtl"] {
            font-family: 'Segoe UI', Tahoma, 'Arabic Typesetting', Arial, sans-serif;
        }
    </style>
@endsection
