<aside class="sidebar">
    <ul class="menu">

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
</aside>