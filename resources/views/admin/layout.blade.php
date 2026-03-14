<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('admin.golden_rose_admin_panel') }}</title>
    @if (app()->getLocale() == 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white p-3" style="width: 220px; min-height: 100vh;">
            <h4>{{ __('admin.golden_rose') }}</h4>
            <ul class="nav flex-column mt-4">
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
           
        </div>

        <!-- Main Content -->
        <div class="p-4" style="flex:1;">
            @yield('content')
        </div>
    </div>
</body>
</html>