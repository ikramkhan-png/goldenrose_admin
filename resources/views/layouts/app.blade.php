<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Golden Rose Admin Panel — {{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}</title>

    @if (app()->getLocale() == 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #1e293b;
        }

        /* ── SIDEBAR ─────────────────────────────── */
        .admin-sidebar {
            width: 260px;
            min-height: 100vh;
            background: #1a2535;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-logo-icon {
            width: 40px;
            height: 40px;
            background: #4f46e5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-logo-text {
            color: #f1f5f9;
            font-weight: 700;
            font-size: 15px;
            line-height: 1.2;
        }

        .sidebar-logo-sub {
            color: #64748b;
            font-size: 11px;
            margin-top: 1px;
        }

        .sidebar-user {
            padding: 12px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #4f46e5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: white;
            font-weight: 700;
            flex-shrink: 0;
        }

        .sidebar-user-name {
            color: #cbd5e1;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-badge {
            display: inline-block;
            color: #a78bfa;
            background: rgba(167,139,250,0.12);
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            margin-top: 2px;
        }

        .sidebar-lang {
            padding: 10px 12px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 8px 0;
        }

        .sidebar-nav::-webkit-scrollbar { width: 3px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }

        .sidebar-section-title {
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #475569;
            font-weight: 700;
            padding: 18px 20px 6px;
        }

        .admin-sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 16px;
            color: #94a3b8;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 6px;
            margin: 1px 8px;
            text-decoration: none;
        }

        .admin-sidebar .nav-link:hover {
            color: #f1f5f9;
            background: rgba(255,255,255,0.07);
        }

        .admin-sidebar .nav-link.active {
            color: #fff;
            background: #4f46e5;
        }

        .admin-sidebar .nav-link i {
            width: 16px;
            text-align: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-footer-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 6px;
            color: #94a3b8;
            font-size: 13px;
            text-decoration: none;
            width: 100%;
        }

        .sidebar-footer-link:hover { background: rgba(255,255,255,0.07); color: #f1f5f9; }

        .sidebar-logout-btn {
            width: 100%;
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.15);
            color: #f87171;
            font-size: 13px;
            padding: 8px 10px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 4px;
            text-align: left;
        }

        .sidebar-logout-btn:hover {
            background: rgba(239,68,68,0.14);
            color: #fca5a5;
        }

        /* ── MOBILE TOPBAR ───────────────────────── */
        .mobile-topbar {
            display: none;
            background: #1a2535;
            color: white;
            padding: 12px 16px;
            align-items: center;
            justify-content: space-between;
        }

        /* ── ADMIN TOP BAR ───────────────────────── */
        .admin-topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            flex-shrink: 0;
        }

        .admin-topbar-welcome {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .admin-topbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .admin-topbar-time {
            font-size: 12px;
            color: #94a3b8;
        }

        .topbar-nav-link {
            font-size: 13px;
            color: #64748b;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .topbar-nav-link:hover { color: #4f46e5; }

        .topbar-logout-btn {
            background: transparent;
            border: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 12px;
            padding: 5px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .topbar-logout-btn:hover {
            border-color: #ef4444;
            color: #ef4444;
            background: #fef2f2;
        }

        /* ── CONTENT ─────────────────────────────── */
        .admin-main-content {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
        }

        /* ── TABLES ──────────────────────────────── */
        .table { background: white; }

        .table th {
            font-size: 11.5px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            background: #f8fafc;
            padding: 12px 16px !important;
            border-bottom: 2px solid #e2e8f0;
        }

        .table td {
            font-size: 14px;
            color: #374151;
            font-weight: 400;
            padding: 12px 16px !important;
            vertical-align: middle;
        }

        .table tbody tr:hover { background-color: #f8fafc !important; }

        /* ── FORMS ───────────────────────────────── */
        .form-control, .form-select {
            border-color: #e2e8f0 !important;
            background: #fff !important;
            font-size: 14px;
            border-radius: 8px;
            padding: 10px 14px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1) !important;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        /* ── BUTTONS ─────────────────────────────── */
        .btn-primary { background: #4f46e5 !important; border-color: #4f46e5 !important; color: #fff !important; }
        .btn-primary:hover { background: #4338ca !important; border-color: #4338ca !important; }

        .btn-success { background: #059669 !important; border-color: #059669 !important; color: #fff !important; }
        .btn-success:hover { background: #047857 !important; border-color: #047857 !important; }

        .btn-warning { background: #d97706 !important; border-color: #d97706 !important; color: #fff !important; }
        .btn-warning:hover { background: #b45309 !important; border-color: #b45309 !important; color: #fff !important; }

        .btn-danger { background: #dc2626 !important; border-color: #dc2626 !important; color: #fff !important; }
        .btn-danger:hover { background: #b91c1c !important; border-color: #b91c1c !important; }

        .btn-info { background: #0284c7 !important; border-color: #0284c7 !important; color: #fff !important; }
        .btn-info:hover { background: #0369a1 !important; border-color: #0369a1 !important; }

        .btn-secondary { background: #64748b !important; border-color: #64748b !important; color: #fff !important; }
        .btn-secondary:hover { background: #475569 !important; border-color: #475569 !important; }

        /* ── CARDS ───────────────────────────────── */
        .card {
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;
        }

        .card-header {
            background: #fff !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 14px 20px !important;
            font-weight: 600;
            color: #1e293b;
            border-radius: 12px 12px 0 0 !important;
        }

        h1, h2, h4 { color: #1e293b; }

        .actions-cell { white-space: nowrap; }

        .actions-cell .btn, .table td .btn-sm {
            font-size: 11px !important;
            padding: 4px 10px !important;
            border-radius: 5px !important;
        }

        /* ── PAYROLL TABS ────────────────────────── */
        .payroll-tabs { display: flex; flex-wrap: wrap; gap: 4px; background: #fff; padding: 6px; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 20px; }
        .payroll-tab { padding: 8px 16px; border-radius: 7px; font-size: 13px; font-weight: 500; color: #64748b; text-decoration: none; background: transparent; white-space: nowrap; }
        .payroll-tab:hover { color: #4f46e5; background: #f5f3ff; }
        .payroll-tab.active { background: #4f46e5; color: #fff; }

        /* ── STYLED TABLE ────────────────────────── */
        .table-styled thead tr { background: #334155; }
        .table-styled thead th { padding: 13px 16px !important; font-size: 11.5px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; border: none !important; color: #e2e8f0; }
        .table-styled tbody td { padding: 13px 16px !important; border-bottom: 1px solid #f1f5f9; }
        .table-styled tbody tr:hover { background: #f8fafc !important; }
        .td-name { color: #1e293b; font-weight: 600; }
        .td-pos  { color: #059669; font-weight: 600; }
        .td-neg  { color: #dc2626; font-weight: 600; }
        .td-warn { color: #d97706; font-weight: 600; }
        .td-muted{ color: #94a3b8; }
        .td-accent{ color: #4f46e5; font-weight: 600; }
        .td-right { text-align: right; }
        .td-center{ text-align: center; }
        .td-total { background: #4f46e5 !important; color: white !important; font-weight: 700; border-radius: 6px; }
        .table-totals-row { background: #f8fafc !important; font-weight: 700; border-top: 2px solid #e2e8f0; }
        .table-totals-row td { color: #1e293b; padding: 14px 16px !important; }

        /* ── FILTER DISPLAY & INFO ───────────────── */
        .filter-display { padding: 10px 14px; border: 1px solid #c7d2fe; border-radius: 8px; background: #f5f3ff; font-weight: 600; color: #4f46e5; font-size: 14px; line-height: 1.5; }
        .info-box { background: #f5f3ff; border-left: 4px solid #4f46e5; border-radius: 8px; padding: 16px 20px; color: #4f46e5; font-size: 14px; }
        .card-info-footer { padding: 10px 16px; background: #f8fafc; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8; }
        .bulk-form-panel { background: #f5f3ff; border-radius: 10px; border-left: 4px solid #4f46e5; padding: 20px; margin-bottom: 20px; }
        .page-title { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .page-subtitle { color: #64748b; font-size: 14px; margin: 0; }
        .btn-outline-primary { border-color: #4f46e5 !important; color: #4f46e5 !important; }
        .btn-outline-primary:hover { background: #4f46e5 !important; color: #fff !important; }
        .btn-outline-secondary { border-color: #94a3b8 !important; color: #64748b !important; }
        .btn-outline-secondary:hover { background: #64748b !important; color: #fff !important; }

        /* ── RESPONSIVE ──────────────────────────── */
        @media (max-width: 767.98px) {
            .mobile-topbar { display: flex; }

            .admin-sidebar {
                display: none;
                width: 100%;
                min-height: auto;
            }

            .admin-sidebar.sidebar-visible { display: flex; }
            .admin-topbar { display: none; }

            .table {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table thead, .table tbody, .table tr, .table th, .table td {
                white-space: nowrap;
            }
        }
    </style>
</head>

<body>

    <!-- Mobile Topbar -->
    <div class="mobile-topbar">
        <span style="font-weight: 700; font-size: 14px;">
            <i class="fas fa-crown" style="color: #fbbf24; margin-right: 8px;"></i>Golden Rose
        </span>
        <button class="btn btn-sm" id="globalSidebarToggle"
            style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white;">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="d-flex flex-column flex-md-row min-vh-100">

        <!-- ═══════════════════════════
             SIDEBAR
        ════════════════════════════ -->
        <aside class="admin-sidebar" id="globalSidebar">

            <!-- Logo -->
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon">
                    <i class="fas fa-crown" style="color: #fbbf24; font-size: 17px;"></i>
                </div>
                <div>
                    <div class="sidebar-logo-text">{{ __('admin.golden_rose') }}</div>
                    <div class="sidebar-logo-sub">Admin Panel</div>
                </div>
            </div>

            <!-- User Info -->
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div style="min-width: 0; flex: 1;">
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-badge">
                        @if (auth()->user()->hasRole('super_admin'))
                            {{ __('admin.super_admin') }}
                        @elseif(auth()->user()->hasRole('admin'))
                            {{ __('admin.admin') }}
                        @elseif(auth()->user()->hasRole('data_entry'))
                            {{ __('admin.data_entry') }}
                        @else
                            {{ auth()->user()->type }}
                        @endif
                    </div>
                </div>
            </div>

            <!-- Language Switcher -->
            <div class="sidebar-lang">
                <div class="dropdown">
                    <button class="btn btn-sm w-100 dropdown-toggle"
                        style="background: rgba(255,255,255,0.07); color: #94a3b8; border: 1px solid rgba(255,255,255,0.1); font-size: 12px; text-align: left; display: flex; align-items: center; gap: 6px;"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-globe"></i>
                        {{ app()->getLocale() == 'ar' ? __('admin.arabic') : __('admin.english') }}
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="languageDropdown">
                        <li>
                            <a class="dropdown-item small {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                                href="{{ route('language.switch', 'en') }}">🇺🇸 {{ __('admin.english') }}</a>
                        </li>
                        <li>
                            <a class="dropdown-item small {{ app()->getLocale() == 'ar' ? 'active' : '' }}"
                                href="{{ route('language.switch', 'ar') }}">🇸🇦 {{ __('admin.arabic') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                <ul class="nav flex-column">

                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-chart-pie"></i>
                            {{ __('admin.dashboard') }}
                        </a>
                    </li>

                    <!-- CLIENTS MANAGEMENT -->
                    @can('manage_clients')
                        <div class="sidebar-section-title">{{ __('admin.clients') }}</div>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}"
                                href="{{ route('admin.clients.index') }}">
                                <i class="fas fa-briefcase"></i>
                                {{ __('admin.all_clients') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.client-services.*') ? 'active' : '' }}"
                                href="{{ route('admin.client-services.index') }}">
                                <i class="fas fa-headset"></i>
                                {{ __('admin.service_clients') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}"
                                href="{{ route('admin.projects.index') }}">
                                <i class="fas fa-folder-open"></i>
                                {{ __('admin.project_clients') }}
                            </a>
                        </li>
                    @endcan

                    <!-- USER MANAGEMENT -->
                    @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                        <div class="sidebar-section-title">{{ __('admin.user_management') }}</div>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                                href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users"></i>
                                {{ __('admin.all_users') }}
                            </a>
                        </li>
                    @endif

                    <!-- PROJECTS & SERVICES -->
                    @can('manage_projects')
                        <div class="sidebar-section-title">{{ __('admin.projects_services') }}</div>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}"
                                href="{{ route('admin.projects.index') }}">
                                <i class="fas fa-project-diagram"></i>
                                {{ __('admin.projects') }}
                            </a>
                        </li>
                    @endcan

                    @can('manage_services')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.client-services.index') }}">
                                <i class="fas fa-concierge-bell"></i>
                                {{ __('admin.services') }}
                            </a>
                        </li>
                    @endcan

                    <!-- HR MANAGEMENT -->
                    @can('manage_employees')
                        <div class="sidebar-section-title">{{ __('admin.hr_management') }}</div>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}"
                                href="{{ route('admin.employees.index') }}">
                                <i class="fas fa-user-tie"></i>
                                {{ __('admin.employees') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}"
                                href="{{ route('admin.attendance.index') }}">
                                <i class="fas fa-calendar-check"></i>
                                {{ __('admin.attendance') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}"
                                href="{{ route('admin.departments.index') }}">
                                <i class="fas fa-building"></i>
                                {{ __('admin.departments') }}
                            </a>
                        </li>
                    @endcan

                    <!-- FACILITIES -->
                    <div class="sidebar-section-title">{{ __('admin.facilities') }}</div>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.machinery.*') ? 'active' : '' }}"
                            href="{{ route('admin.machinery.index') }}">
                            <i class="fas fa-wrench"></i>
                            {{ __('admin.machinery') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.manpower.*') ? 'active' : '' }}"
                            href="{{ route('admin.manpower.index') }}">
                            <i class="fas fa-hard-hat"></i>
                            {{ __('admin.manpower') }}
                        </a>
                    </li>

                    <!-- SYSTEM -->
                    @if (auth()->user()->hasRole('super_admin'))
                        <div class="sidebar-section-title">{{ __('admin.system') }}</div>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"
                                href="{{ route('admin.roles.index') }}">
                                <i class="fas fa-shield-alt"></i>
                                {{ __('admin.roles_permissions') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.settings.index') }}">
                                <i class="fas fa-cog"></i>
                                {{ __('admin.settings') }}
                            </a>
                        </li>
                    @endif

                    <!-- REPORTS -->
                    @can('view_reports')
                        <div class="sidebar-section-title">{{ __('admin.reports') }}</div>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-line"></i>
                                {{ __('admin.financial_reports') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-file-alt"></i>
                                {{ __('admin.client_reports') }}
                            </a>
                        </li>
                    @endcan

                </ul>
            </nav>

            <!-- Footer -->
            <div class="sidebar-footer">
                <a href="{{ route('profile') }}" class="sidebar-footer-link">
                    <i class="fas fa-user-circle"></i>
                    {{ __('admin.my_profile') }}
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        {{ __('admin.logout') }}
                    </button>
                </form>
            </div>
        </aside>

        <!-- ═══════════════════════════
             MAIN CONTENT
        ════════════════════════════ -->
        <div style="flex: 1; display: flex; flex-direction: column; overflow-x: hidden;">

            <!-- Top Bar -->
            <div class="admin-topbar">
                <div class="admin-topbar-welcome">
                    {{ __('admin.welcome') }}, <strong>{{ auth()->user()->name }}</strong>
                </div>
                <div class="admin-topbar-right">
                    <span class="admin-topbar-time">
                        <i class="fas fa-clock me-1"></i>{{ now()->format('M d, Y · H:i') }}
                    </span>
                    <a href="{{ route('profile') }}" class="topbar-nav-link">
                        <i class="fas fa-user-circle"></i> {{ __('admin.profile') }}
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="topbar-logout-btn">
                            <i class="fas fa-sign-out-alt me-1"></i>{{ __('admin.logout') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Content -->
            <div class="admin-main-content">

                @if ($errors->any())
                    <div class="mb-4 p-3" style="background: #fef2f2; color: #991b1b; border: none; border-left: 4px solid #ef4444; border-radius: 8px;">
                        <div style="font-weight: 600; margin-bottom: 6px;"><i class="fas fa-exclamation-circle me-2"></i>Please fix the errors below:</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li style="font-size: 13px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-dismissible fade show p-3 mb-4" role="alert"
                        style="background: #f0fdf4; color: #166534; border: none; border-left: 4px solid #22c55e; border-radius: 8px;">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-dismissible fade show p-3 mb-4" role="alert"
                        style="background: #fef2f2; color: #991b1b; border: none; border-left: 4px solid #ef4444; border-radius: 8px;">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggle = document.getElementById('globalSidebarToggle');
            var sidebar = document.getElementById('globalSidebar');
            if (toggle && sidebar) {
                toggle.addEventListener('click', function() {
                    sidebar.classList.toggle('sidebar-visible');
                });
            }
        });
    </script>
</body>

</html>
