<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Golden Rose Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white p-3" style="width: 220px; min-height: 100vh;">
            <h4>Golden Rose</h4>
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
    <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
</li>

<li class="nav-item">
    <a class="nav-link text-white" href="{{ route('admin.employees.index') }}">Employees</a>
</li>

<li class="nav-item">
    <a class="nav-link text-white" href="{{ route('admin.attendance.index') }}">Attendance</a>
</li>

<li class="nav-item">
    <a class="nav-link text-white" href="{{ route('admin.departments.index') }}">Departments</a>
</li>

<li class="nav-item">
    <a class="nav-link text-white" href="{{ route('admin.roles.index') }}">Roles & Permissions</a>
</li>

<li class="nav-item">
    <a class="nav-link text-white" href="#">Reports</a> <!-- You can create this route later -->
</li>

<li class="nav-item">
    <a class="nav-link text-white" href="{{ route('admin.settings.index') }}">Settings</a>
</li>
            </ul>
           
        </div>

        <!-- Main Content -->
        <div class="p-4" style="flex:1;">
            @yield('content')
        </div>
    </div>
</body>
</html>