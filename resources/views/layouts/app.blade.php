<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Golden Rose Admin Panel</title>
    @if(app()->getLocale() == 'ar')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
@else
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .mobile-topbar {
            display: none;
        }
        .admin-layout-wrapper {
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 100%;
        }
        @media (min-width: 768px) {
            .admin-layout-wrapper {
                flex-direction: row;
            }
            .admin-sidebar {
                width: 250px;
                min-height: 100vh;
                overflow-y: auto;
            }
        }
        .table tbody tr:hover {
            background-color: #f8f9fc !important;
        }
        .table th,
        .table td {
            font-size: 15px;
            color: #2c3e50;
            font-weight: 600;
            padding: 18px 16px !important;
        }
        @media (max-width: 767.98px) {
            .mobile-topbar {
                display: flex;
            }
            .admin-sidebar {
                display: none;
            }
            .admin-sidebar.sidebar-visible {
                display: block;
            }
            .table {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .table thead,
            .table tbody,
            .table tr,
            .table th,
            .table td {
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
    <div class="mobile-topbar d-md-none bg-dark text-white d-flex align-items-center justify-content-between px-3 py-2">
        <span class="fw-semibold">Golden Rose Admin</span>
        <button class="btn btn-outline-light btn-sm" id="globalSidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="d-flex flex-column admin-layout-wrapper">
        <!-- Sidebar -->
        <div class="admin-sidebar bg-dark text-white p-3">
            <h4 class="mb-4">
                <span style="color: #FFD700;">👑</span> {{ __('admin.golden_rose') }}
            </h4>

            <!-- Language Switcher -->
            <div class="dropdown mb-3">
                <button class="btn btn-outline-light btn-sm dropdown-toggle w-100" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-globe me-1"></i> {{ __('admin.language') }}: {{ app()->getLocale() == 'ar' ? __('admin.arabic') : __('admin.english') }}
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="languageDropdown">
                    <li><a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('language.switch', 'en') }}">🇺🇸 {{ __('admin.english') }}</a></li>
                    <li><a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}" href="{{ route('language.switch', 'ar') }}">🇸🇦 {{ __('admin.arabic') }}</a></li>
                </ul>
            </div>

            <!-- User Info -->
            <div class="bg-secondary p-2 rounded mb-4 small">
                <strong>{{ auth()->user()->name }}</strong>
                <br>
                <span class="badge bg-info">
                    @if(auth()->user()->hasRole('super_admin'))
                        {{ __('admin.super_admin') }}
                    @elseif(auth()->user()->hasRole('admin'))
                        {{ __('admin.admin') }}
                    @elseif(auth()->user()->hasRole('data_entry'))
                        {{ __('admin.data_entry') }}
                    @else
                        {{ auth()->user()->type }}
                    @endif
                </span>
            </div>

            <ul class="nav flex-column">
                <!-- DASHBOARD -->
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        📊 {{ __('admin.dashboard') }}
                    </a>
                </li>

                <!-- CLIENTS MANAGEMENT SECTION -->
                @can('manage_clients')
                    <li class="nav-item mt-3">
                        <span class="text-uppercase text-muted small px-3">{{ __('admin.clients') }}</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}" 
                           href="{{ route('admin.clients.index') }}">
                            💼 {{ __('admin.all_clients') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.client-services.*') ? 'active' : '' }}" 
                           href="{{ route('admin.client-services.index') }}">
                            🛎️ {{ __('admin.service_clients') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.projects.index') }}">
                            📁 {{ __('admin.project_clients') }}
                        </a>
                    </li>
                @endcan

                <!-- USERS MANAGEMENT -->
                @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                    <li class="nav-item mt-3">
                        <span class="text-uppercase text-muted small px-3">{{ __('admin.user_management') }}</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                           href="{{ route('admin.users.index') }}">
                            👥 {{ __('admin.all_users') }}
                        </a>
                    </li>
                @endif

                <!-- PROJECTS & SERVICES -->
                @can('manage_projects')
                    <li class="nav-item mt-3">
                        <span class="text-uppercase text-muted small px-3">{{ __('admin.projects_services') }}</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" 
                           href="{{ route('admin.projects.index') }}">
                            📊 {{ __('admin.projects') }}
                        </a>
                    </li>
                @endcan

                @can('manage_services')
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.client-services.index') }}">
                            🛎️ {{ __('admin.services') }}
                        </a>
                    </li>
                @endcan

                <!-- EMPLOYEES SECTION -->
                @can('manage_employees')
                    <li class="nav-item mt-3">
                        <span class="text-uppercase text-muted small px-3">{{ __('admin.hr_management') }}</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}" 
                           href="{{ route('admin.employees.index') }}">
                            👥 {{ __('admin.employees') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}" 
                           href="{{ route('admin.attendance.index') }}">
                            ✓ {{ __('admin.attendance') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}" 
                           href="{{ route('admin.departments.index') }}">
                            🏢 {{ __('admin.departments') }}
                        </a>
                    </li>
                @endcan

                <!-- SERVICES FACILITIES SECTION -->
                <li class="nav-item mt-3">
                    <span class="text-uppercase text-muted small px-3">{{ __('admin.facilities') }}</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.machinery.*') ? 'active' : '' }}" 
                       href="{{ route('admin.machinery.index') }}">
                        🔧 {{ __('admin.machinery') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.manpower.*') ? 'active' : '' }}" 
                       href="{{ route('admin.manpower.index') }}">
                        👷 {{ __('admin.manpower') }}
                    </a>
                </li>

                <!-- SYSTEM MANAGEMENT SECTION -->
                @if(auth()->user()->hasRole('super_admin'))
                    <li class="nav-item mt-3">
                        <span class="text-uppercase text-muted small px-3">{{ __('admin.system') }}</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" 
                           href="{{ route('admin.roles.index') }}">
                            🔐 {{ __('admin.roles_permissions') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.settings.index') }}">
                            ⚙️ {{ __('admin.settings') }}
                        </a>
                    </li>
                @endif

                <!-- REPORTS SECTION -->
                @can('view_reports')
                    <li class="nav-item mt-3">
                        <span class="text-uppercase text-muted small px-3">{{ __('admin.reports') }}</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            📈 {{ __('admin.financial_reports') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            📋 {{ __('admin.client_reports') }}
                        </a>
                    </li>
                @endcan

                <!-- PROFILE & LOGOUT -->
                <li class="nav-item mt-4">
                    <hr class="bg-secondary">
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('profile') }}">
                        👤 {{ __('admin.my_profile') }}
                    </a>
                </li>

                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link text-white btn btn-link">
                            🚪 {{ __('admin.logout') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div style="flex: 1; display: flex; flex-direction: column;">
            <!-- Top Navigation Bar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <span class="navbar-text ms-3">
                        <strong>{{ __('admin.welcome') }}, {{ auth()->user()->name }}!</strong>
                    </span>
                    <div class="ms-auto d-flex gap-3 me-3">
                        <span class="text-muted small">
                            {{ now()->format('M d, Y H:i') }}
                        </span>
                        <a href="{{ route('profile') }}" class="text-decoration-none">
                            👤 {{ __('admin.profile') }}
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                {{ __('admin.logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Main Content Area -->
            <div class="p-4" style="flex: 1; overflow-y: auto;">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var toggle = document.getElementById('globalSidebarToggle');
        var sidebar = document.querySelector('.admin-sidebar');
        if (toggle && sidebar) {
            toggle.addEventListener('click', function () {
                sidebar.classList.toggle('sidebar-visible');
            });
        }
    });
    </script>
</body>
</html>