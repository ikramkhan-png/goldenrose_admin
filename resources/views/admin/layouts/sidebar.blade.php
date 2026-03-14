<aside class="sidebar">
    <ul class="menu">

        <li class="nav-item">
    <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">{{ __('admin.admin_dashboard') }}</a>
</li>

<li class="nav-item">
    <a class="nav-link text-white" href="{{ route('admin.employees.index') }}">{{ __('admin.employees_nav') }}</a>
</li>

<li class="nav-item">
    <a class="nav-link text-white" href="{{ route('admin.attendance.index') }}">{{ __('admin.attendance_nav') }}</a>
</li>

<li class="nav-item">
    <a class="nav-link text-white" href="{{ route('admin.departments.index') }}">{{ __('admin.departments_nav') }}</a>
</li>

<li class="nav-item">
    <a class="nav-link text-white" href="{{ route('admin.roles.index') }}">{{ __('admin.roles_permissions') }}</a>
</li>

<li class="nav-item">
    <a class="nav-link text-white" href="#">{{ __('admin.reports_nav') }}</a> <!-- You can create this route later -->
</li>

<li class="nav-item">
    <a class="nav-link text-white" href="{{ route('admin.settings.index') }}">{{ __('admin.settings_nav') }}</a>
</li>

    </ul>
</aside>