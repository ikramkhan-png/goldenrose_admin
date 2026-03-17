@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp

    <div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <!-- Page Header -->
        <div class="mb-4">
            <h4 style="font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 4px;">
                {{ __('dashboard.dashboard_overview') }}
            </h4>
            <p style="color: #64748b; font-size: 14px; margin: 0;">
                {{ __('dashboard.welcome_back') }}, <strong>{{ auth()->user()->name }}</strong>
            </p>
        </div>

        <!-- ═══════════════════════════
             PRIMARY STAT CARDS
        ════════════════════════════ -->
        <div class="row g-3 mb-4">

            <!-- Total Users -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.users.index') }}" style="text-decoration: none;">
                    <div class="card h-100" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                        <div class="card-body" style="padding: 20px;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
                                <div style="width: 46px; height: 46px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-users" style="color: #3b82f6; font-size: 18px;"></i>
                                </div>
                            </div>
                            <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px;">{{ __('dashboard.total_users') }}</div>
                            <div style="font-size: 30px; font-weight: 700; color: #1e293b; margin-top: 4px; line-height: 1;">{{ $totalUsers ?? 0 }}</div>
                            <div style="font-size: 12px; color: #10b981; margin-top: 8px;">
                                <i class="fas fa-arrow-up me-1"></i>{{ $newUsersThisMonth ?? 0 }} {{ __('dashboard.this_month') }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Active Clients -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.clients.index') }}" style="text-decoration: none;">
                    <div class="card h-100" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                        <div class="card-body" style="padding: 20px;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
                                <div style="width: 46px; height: 46px; border-radius: 12px; background: #f5f3ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-briefcase" style="color: #6366f1; font-size: 18px;"></i>
                                </div>
                            </div>
                            <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px;">{{ __('dashboard.active_clients') }}</div>
                            <div style="font-size: 30px; font-weight: 700; color: #1e293b; margin-top: 4px; line-height: 1;">{{ $totalClients ?? 0 }}</div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 8px;">
                                {{ __('dashboard.service_clients') }}: {{ $serviceClients ?? 0 }} &nbsp;·&nbsp;
                                {{ __('dashboard.project_clients') }}: {{ $projectClients ?? 0 }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Active Projects -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.projects.index') }}" style="text-decoration: none;">
                    <div class="card h-100" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                        <div class="card-body" style="padding: 20px;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
                                <div style="width: 46px; height: 46px; border-radius: 12px; background: #fffbeb; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-folder-open" style="color: #f59e0b; font-size: 18px;"></i>
                                </div>
                            </div>
                            <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px;">{{ __('dashboard.active_projects') }}</div>
                            <div style="font-size: 30px; font-weight: 700; color: #1e293b; margin-top: 4px; line-height: 1;">{{ $totalProjects ?? 0 }}</div>
                            <div style="font-size: 12px; color: #f59e0b; margin-top: 8px;">
                                <i class="fas fa-spinner me-1"></i>{{ __('dashboard.in_progress') }}: {{ $projectsInProgress ?? 0 }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Employees -->
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.employees.index') }}" style="text-decoration: none;">
                    <div class="card h-100" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                        <div class="card-body" style="padding: 20px;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
                                <div style="width: 46px; height: 46px; border-radius: 12px; background: #f0fdfa; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-user-tie" style="color: #0d9488; font-size: 18px;"></i>
                                </div>
                            </div>
                            <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px;">{{ __('dashboard.employee_size') }}</div>
                            <div style="font-size: 30px; font-weight: 700; color: #1e293b; margin-top: 4px; line-height: 1;">{{ $totalEmployees ?? 0 }}</div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 8px;">
                                <i class="fas fa-building me-1"></i>{{ __('dashboard.department') }}: {{ $departments ?? 0 }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- ═══════════════════════════
             SECONDARY STAT CARDS
        ════════════════════════════ -->
        <div class="row g-3 mb-4">

            <!-- Revenue -->
            <div class="col-md-6 col-lg-3">
                <div class="card" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div class="card-body" style="padding: 20px;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px;">{{ __('dashboard.total_revenue') }}</div>
                                <div style="font-size: 22px; font-weight: 700; color: #059669; margin-top: 6px;">
                                    ${{ number_format($totalRevenue ?? 0, 2) }}
                                </div>
                            </div>
                            <div style="width: 42px; height: 42px; border-radius: 10px; background: #f0fdf4; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-dollar-sign" style="color: #059669; font-size: 16px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services -->
            <div class="col-md-6 col-lg-3">
                <div class="card" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div class="card-body" style="padding: 20px;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px;">{{ __('dashboard.services') }}</div>
                                <div style="font-size: 22px; font-weight: 700; color: #7c3aed; margin-top: 6px;">{{ $totalServices ?? 0 }}</div>
                            </div>
                            <div style="width: 42px; height: 42px; border-radius: 10px; background: #f5f3ff; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-concierge-bell" style="color: #7c3aed; font-size: 16px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance -->
            <div class="col-md-6 col-lg-3">
                <div class="card" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div class="card-body" style="padding: 20px;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px;">{{ __('dashboard.today_attendance') }}</div>
                                <div style="font-size: 22px; font-weight: 700; color: #0284c7; margin-top: 6px;">
                                    {{ $presentToday ?? 0 }}/{{ $totalEmployees ?? 0 }}
                                </div>
                            </div>
                            <div style="width: 42px; height: 42px; border-radius: 10px; background: #f0f9ff; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-calendar-check" style="color: #0284c7; font-size: 16px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Users -->
            <div class="col-md-6 col-lg-3">
                <div class="card" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div class="card-body" style="padding: 20px;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px;">{{ __('dashboard.admin_users') }}</div>
                                <div style="font-size: 22px; font-weight: 700; color: #dc2626; margin-top: 6px;">{{ $adminUsers ?? 0 }}</div>
                            </div>
                            <div style="width: 42px; height: 42px; border-radius: 10px; background: #fef2f2; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-shield-alt" style="color: #dc2626; font-size: 16px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ═══════════════════════════
             CHARTS ROW
        ════════════════════════════ -->
        <div class="row g-3 mb-4">

            <!-- User Growth Chart -->
            <div class="col-lg-6">
                <div class="card" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div class="card-header" style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; background: #fff; border-radius: 12px 12px 0 0;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 8px; height: 8px; border-radius: 50%; background: #4f46e5;"></div>
                            <span style="font-size: 14px; font-weight: 600; color: #1e293b;">{{ __('dashboard.user_growth') }}</span>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 20px 20px 12px;">
                        @php
                            $data = [65, 80, 95, 110, 125, 140];
                            $months = $isAr
                                ? ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو']
                                : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                            $maxVal = max($data);
                        @endphp
                        <div style="display: flex; align-items: flex-end; gap: 8px; height: 180px; padding-bottom: 4px;">
                            @foreach ($data as $i => $value)
                                <div style="flex: 1; display: flex; flex-direction: column; align-items: center; height: 100%; justify-content: flex-end; gap: 4px;">
                                    <span style="font-size: 10px; color: #94a3b8; font-weight: 600;">{{ $value }}</span>
                                    <div style="width: 100%; border-radius: 6px 6px 0 0; background: {{ $i === count($data)-1 ? '#4f46e5' : '#c7d2fe' }}; height: {{ round(($value / $maxVal) * 140) }}px;"></div>
                                </div>
                            @endforeach
                        </div>
                        <div style="display: flex; gap: 8px; margin-top: 10px; border-top: 1px solid #f1f5f9; padding-top: 10px;">
                            @foreach ($months as $month)
                                <div style="flex: 1; text-align: center; font-size: 11px; color: #94a3b8; font-weight: 500;">{{ $month }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client Distribution -->
            <div class="col-lg-6">
                <div class="card" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div class="card-header" style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; background: #fff; border-radius: 12px 12px 0 0;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 8px; height: 8px; border-radius: 50%; background: #6366f1;"></div>
                            <span style="font-size: 14px; font-weight: 600; color: #1e293b;">{{ __('dashboard.client_distribution') }}</span>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 20px;">
                        <div style="display: flex; align-items: center; gap: 32px; justify-content: center;">
                            @php
                                $total = max(($totalClients ?? 0), 1);
                                $svc   = $serviceClients ?? 0;
                                $prj   = $projectClients ?? 0;
                                $oth   = max(0, $total - $svc - $prj);
                                $svcDeg = round(($svc / $total) * 360);
                                $prjDeg = round(($prj / $total) * 360);
                                $othDeg = 360 - $svcDeg - $prjDeg;
                            @endphp
                            <div style="width: 140px; height: 140px; border-radius: 50%; background: conic-gradient(#3b82f6 0deg {{ $svcDeg }}deg, #6366f1 {{ $svcDeg }}deg {{ $svcDeg + $prjDeg }}deg, #e2e8f0 {{ $svcDeg + $prjDeg }}deg 360deg); position: relative; flex-shrink: 0;">
                                <div style="width: 90px; height: 90px; border-radius: 50%; background: white; position: absolute; top: 25px; left: 25px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                    <span style="font-size: 18px; font-weight: 700; color: #1e293b;">{{ $totalClients ?? 0 }}</span>
                                    <span style="font-size: 10px; color: #94a3b8;">total</span>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 14px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 12px; height: 12px; border-radius: 3px; background: #3b82f6; flex-shrink: 0;"></div>
                                    <div>
                                        <div style="font-size: 12px; color: #64748b;">{{ __('dashboard.service_clients') }}</div>
                                        <div style="font-size: 16px; font-weight: 700; color: #1e293b;">{{ $serviceClients ?? 0 }}</div>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 12px; height: 12px; border-radius: 3px; background: #6366f1; flex-shrink: 0;"></div>
                                    <div>
                                        <div style="font-size: 12px; color: #64748b;">{{ __('dashboard.project_clients') }}</div>
                                        <div style="font-size: 16px; font-weight: 700; color: #1e293b;">{{ $projectClients ?? 0 }}</div>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 12px; height: 12px; border-radius: 3px; background: #e2e8f0; flex-shrink: 0;"></div>
                                    <div>
                                        <div style="font-size: 12px; color: #64748b;">{{ __('dashboard.other') }}</div>
                                        <div style="font-size: 16px; font-weight: 700; color: #1e293b;">{{ $oth }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ═══════════════════════════
             QUICK ACTIONS
        ════════════════════════════ -->
        <div class="row g-3 mb-4">
            <div class="col-12">
                <div class="card" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div class="card-header" style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; background: #fff; border-radius: 12px 12px 0 0;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 8px; height: 8px; border-radius: 50%; background: #f59e0b;"></div>
                            <span style="font-size: 14px; font-weight: 600; color: #1e293b;">{{ __('dashboard.quick_actions') }}</span>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 20px;">
                        <div style="display: flex; flex-wrap: wrap; gap: 10px;">

                            @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-user-plus me-1"></i>{{ __('dashboard.create_user') }}
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-sm"
                                    style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;">
                                    <i class="fas fa-users me-1"></i>{{ __('dashboard.manage_users') }}
                                </a>
                                <a href="{{ route('admin.clients.index') }}" class="btn btn-sm"
                                    style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;">
                                    <i class="fas fa-briefcase me-1"></i>{{ __('dashboard.view_clients') }}
                                </a>
                                <a href="{{ route('admin.projects.index') }}" class="btn btn-sm"
                                    style="background: #fffbeb; color: #92400e; border: 1px solid #fde68a;">
                                    <i class="fas fa-folder-open me-1"></i>{{ __('dashboard.view_projects') }}
                                </a>
                            @endif

                            <a href="{{ route('profile') }}" class="btn btn-sm"
                                style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;">
                                <i class="fas fa-user-circle me-1"></i>{{ __('dashboard.my_profile') }}
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════
             SYSTEM INFORMATION
        ════════════════════════════ -->
        <div class="row g-3">
            <div class="col-12">
                <div class="card" style="border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div class="card-header" style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; background: #fff; border-radius: 12px 12px 0 0;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 8px; height: 8px; border-radius: 50%; background: #64748b;"></div>
                            <span style="font-size: 14px; font-weight: 600; color: #1e293b;">{{ __('dashboard.system_information') }}</span>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 20px;">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 6px;">{{ __('dashboard.last_backup') }}</div>
                                <div style="font-size: 14px; color: #374151; font-weight: 500;">{{ now()->translatedFormat('M d, Y @ h:i A') }}</div>
                            </div>
                            <div class="col-md-4">
                                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 6px;">{{ __('dashboard.system_status') }}</div>
                                <span style="display: inline-flex; align-items: center; gap: 6px; background: #f0fdf4; color: #166534; font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 20px; border: 1px solid #bbf7d0;">
                                    <span style="width: 7px; height: 7px; border-radius: 50%; background: #22c55e; display: inline-block;"></span>
                                    {{ __('dashboard.online_operational') }}
                                </span>
                            </div>
                            <div class="col-md-4">
                                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 6px;">{{ __('dashboard.current_time') }}</div>
                                <div style="font-size: 14px; color: #374151; font-weight: 500;">{{ now()->translatedFormat('M d, Y @ h:i A') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- end container -->

    @if ($isAr)
    <style>
        [dir="rtl"] { font-family: 'Segoe UI', Tahoma, 'Arabic Typesetting', Arial, sans-serif; }
    </style>
    @endif

@endsection
