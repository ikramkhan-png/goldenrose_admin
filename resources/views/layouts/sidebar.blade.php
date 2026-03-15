<aside class="sidebar">
    <ul class="menu">

        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">{{ __('Admin Dashboard') }}</a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.employees.index') }}">{{ __('Employees') }}</a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.attendance.index') }}">{{ __('Attendance') }}</a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.departments.index') }}">{{ __('Departments') }}</a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.roles.index') }}">{{ __('Roles & Permissions') }}</a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="#">{{ __('Reports') }}</a> <!-- You can create this route later -->
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.settings.index') }}">{{ __('Settings') }}</a>
        </li>

    </ul>
</aside>
