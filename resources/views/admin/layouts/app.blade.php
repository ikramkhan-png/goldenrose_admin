<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Golden Rose Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .sidebar {
            width: 100%;
            min-height: auto;
        }
        @media (min-width: 768px) {
            .sidebar {
                width: 260px;
                min-height: 100vh;
            }
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #fff !important;
            border-radius: 4px;
        }
        .sidebar-section {
            font-size: 12px;
            letter-spacing: 1px;
            color: #adb5bd;
            margin-top: 20px;
            margin-bottom: 6px;
            padding-left: 10px;
        }
        /* global theme overrides used across project */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 0;
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
        .form-control,
        .form-select {
            border-color: #e8ecf1 !important;
            background: #f8f9fc;
            font-size: 14px;
            font-weight: 500;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: #667eea !important;
            background: white;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1) !important;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        }
        h1, h2, h4 {
            color: #2c3e50;
        }
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        /* ensure action buttons fit in one line */
        .actions-cell {
            white-space: nowrap;
        }
        .actions-cell .btn {
            font-size: 10px;
            padding: 2px 4px;
        }
        /* additionally target any small buttons inside table cells */
        .table td .btn-sm {
            font-size: 10px !important;
            padding: 2px 4px !important;
            transition: transform 0.15s ease;
        }
        .table td .btn-sm:hover {
            transform: scale(1.3);
        }
        @media (max-width: 767.98px) {
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

<div class="d-flex flex-column flex-md-row min-vh-100">

    <!-- =========================
         SIDEBAR
    ========================== -->
    <aside class="sidebar bg-dark text-white p-3 flex-shrink-0">

        <h4 class="text-center mb-4">Golden Rose</h4>

        <ul class="nav flex-column">

            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>
            </li>

            <!-- ===============================
                 EXTERNAL OPERATIONS
            ================================ -->
            <div class="sidebar-section">EXTERNAL OPERATIONS</div>

            <!-- Clients -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}"
                   href="{{ route('admin.clients.index') }}">
                    Clients
                </a>
            </li>

            <!-- Users Management -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                   href="{{ route('admin.users.index') }}">
                    Users Management
                </a>
            </li>

            <!-- Client Services -->
             <!--
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.client-services.*') ? 'active' : '' }}"
                   href="{{ route('admin.client-services.index') }}">
                    Services assigned
                </a>
            </li>

            // Projects 
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}"
                   href="{{ route('admin.projects.index') }}">
                    Projects assigned
                </a>
            </li>

           // Project Services 
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.project-services.*') ? 'active' : '' }}"
                   href="{{ route('admin.project-services.index') }}">
                    Project Services
                </a>
            </li>

             //Project Documents 
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.project-documents.*') ? 'active' : '' }}"
                   href="{{ route('admin.project-documents.index') }}">
                    Project Documents
                </a>
            </li>
            -->

            <!-- ===============================
                 INTERNAL OPERATIONS
            ================================ -->
            <div class="sidebar-section">INTERNAL OPERATIONS</div>

            <!-- Employees -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}"
                   href="{{ route('admin.employees.index') }}">
                    Employees
                </a>
            </li>

            <!-- Departments -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}"
                   href="{{ route('admin.departments.index') }}">
                    Departments
                </a>
            </li>

            <!-- Attendance -->
             <!--
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}"
                   href="{{ route('admin.attendance.index') }}">
                    Attendance
                </a>
            </li>
            -->
            <!-- ===============================
                 SERVICES & RESOURCES
            ================================ -->
            <div class="sidebar-section">SERVICES & RESOURCES</div>

            <!-- Machinery -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.machinery.*') ? 'active' : '' }}"
                   href="{{ route('admin.machinery.index') }}">
                    Machinery
                </a>
            </li>

            <!-- Manpower -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.manpower.*') ? 'active' : '' }}"
                   href="{{ route('admin.manpower.index') }}">
                    Manpower
                </a>
            </li>

            <!-- ===============================
                 PAYROLL & FINANCE
            ================================ -->
            <div class="sidebar-section">PAYROLL & FINANCE</div>
            <!--  
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.advances.*') ? 'active' : '' }}"
                   href="{{ route('admin.advances.index') }}">
                    Advances
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.overtimes.*') ? 'active' : '' }}"
                   href="{{ route('admin.overtimes.index') }}">
                    Overtime
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}"
                   href="{{ route('admin.expenses.index') }}">
                    Expenses
                </a>
            </li>
            -->

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.salaries.*') ? 'active' : '' }}"
                   href="{{ route('admin.salaries.index') }}">
                    Salaries
                </a>
            </li>
            

            <!-- ===============================
                 SYSTEM
            ================================ -->
            <div class="sidebar-section">SYSTEM</div>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"
                   href="{{ route('admin.roles.index') }}">
                    Roles & Permissions
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                   href="{{ route('admin.settings.index') }}">
                    Settings
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="btn btn-outline-light w-100">
                        Logout
                    </button>
                </form>
            </li>

        </ul>
    </aside>

    <!-- =========================
         MAIN CONTENT
    ========================== -->
    <main class="flex-fill" style="overflow-x: hidden;">
        @yield('content')
    </main>

</div>

</body>
</html>