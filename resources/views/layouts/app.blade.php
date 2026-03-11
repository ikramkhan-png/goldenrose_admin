<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Golden Rose Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
    </style>
</head>
<body>
    <div class="d-flex flex-column admin-layout-wrapper">
        <!-- Sidebar -->
        <div class="admin-sidebar bg-dark text-white p-3">
            <h4 class="mb-4">
                <span style="color: #FFD700;">👑</span> Golden Rose
            </h4>

            <!-- User Info -->
            <div class="bg-secondary p-2 rounded mb-4 small">
                <strong>{{ auth()->user()->name }}</strong>
                <br>
                <span class="badge bg-info">
                    @if(auth()->user()->hasRole('super_admin'))
                        Super Admin
                    @elseif(auth()->user()->hasRole('admin'))
                        Admin
                    @elseif(auth()->user()->hasRole('data_entry'))
                        Data Entry
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
                        📊 Dashboard
                    </a>
                </li>

                <!-- CLIENTS MANAGEMENT SECTION -->
                @can('manage_clients')
                    <li class="nav-item mt-3">
                        <span class="text-uppercase text-muted small px-3">Clients</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}" 
                           href="{{ route('admin.clients.index') }}">
                            💼 All Clients
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.client-services.*') ? 'active' : '' }}" 
                           href="{{ route('admin.client-services.index') }}">
                            🛎️ Service Clients
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.projects.index') }}">
                            📁 Project Clients
                        </a>
                    </li>
                @endcan

                <!-- USERS MANAGEMENT -->
                @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                    <li class="nav-item mt-3">
                        <span class="text-uppercase text-muted small px-3">User Management</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                           href="{{ route('admin.users.index') }}">
                            👥 All Users
                        </a>
                    </li>
                @endif

                <!-- PROJECTS & SERVICES -->
                @can('manage_projects')
                    <li class="nav-item mt-3">
                        <span class="text-uppercase text-muted small px-3">Projects & Services</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" 
                           href="{{ route('admin.projects.index') }}">
                            📊 Projects
                        </a>
                    </li>
                @endcan

                @can('manage_services')
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.client-services.index') }}">
                            🛎️ Services
                        </a>
                    </li>
                @endcan

                <!-- EMPLOYEES SECTION -->
                @can('manage_employees')
                    <li class="nav-item mt-3">
                        <span class="text-uppercase text-muted small px-3">HR Management</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}" 
                           href="{{ route('admin.employees.index') }}">
                            👥 Employees
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}" 
                           href="{{ route('admin.attendance.index') }}">
                            ✓ Attendance
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}" 
                           href="{{ route('admin.departments.index') }}">
                            🏢 Departments
                        </a>
                    </li>
                @endcan

                <!-- SERVICES FACILITIES SECTION -->
                <li class="nav-item mt-3">
                    <span class="text-uppercase text-muted small px-3">Facilities</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.machinery.*') ? 'active' : '' }}" 
                       href="{{ route('admin.machinery.index') }}">
                        🔧 Machinery
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.manpower.*') ? 'active' : '' }}" 
                       href="{{ route('admin.manpower.index') }}">
                        👷 Manpower
                    </a>
                </li>

                <!-- SYSTEM MANAGEMENT SECTION -->
                @if(auth()->user()->hasRole('super_admin'))
                    <li class="nav-item mt-3">
                        <span class="text-uppercase text-muted small px-3">System</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" 
                           href="{{ route('admin.roles.index') }}">
                            🔐 Roles & Permissions
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.settings.index') }}">
                            ⚙️ Settings
                        </a>
                    </li>
                @endif

                <!-- REPORTS SECTION -->
                @can('view_reports')
                    <li class="nav-item mt-3">
                        <span class="text-uppercase text-muted small px-3">Reports</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            📈 Financial Reports
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            📋 Client Reports
                        </a>
                    </li>
                @endcan

                <!-- PROFILE & LOGOUT -->
                <li class="nav-item mt-4">
                    <hr class="bg-secondary">
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('profile') }}">
                        👤 My Profile
                    </a>
                </li>

                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link text-white btn btn-link">
                            🚪 Logout
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
                        <strong>Welcome, {{ auth()->user()->name }}!</strong>
                    </span>
                    <div class="ms-auto d-flex gap-3 me-3">
                        <span class="text-muted small">
                            {{ now()->format('M d, Y H:i') }}
                        </span>
                        <a href="{{ route('profile') }}" class="text-decoration-none">
                            👤 Profile
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                Logout
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
</body>
</html>