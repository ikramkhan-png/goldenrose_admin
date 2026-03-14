@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div class="container-fluid px-4 py-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <!-- Header -->
    <div class="mb-4">
        <h2 class="mb-2">⚙️ {{ __('admin.system_settings') }}</h2>
        <p class="text-muted">{{ __('admin.system_settings_subtitle') }}</p>
    </div>

    <!-- Alerts -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ __('admin.error') }}</strong>
            <ul class="mb-0 {{ $isAr ? 'me-3' : 'ms-3' }}">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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

    <!-- Tabs Navigation -->
    <div class="nav-tabs-wrapper mb-4">
        <ul class="nav nav-tabs" role="tablist" style="border-bottom: 2px solid #e9ecef;">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" 
                    type="button" role="tab" aria-controls="general" aria-selected="true">
                    🏢 {{ __('admin.general') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="system-tab" data-bs-toggle="tab" data-bs-target="#system" 
                    type="button" role="tab" aria-controls="system" aria-selected="false">
                    ⚙️ {{ __('admin.system') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" 
                    type="button" role="tab" aria-controls="email" aria-selected="false">
                    📧 {{ __('admin.email') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" 
                    type="button" role="tab" aria-controls="notifications" aria-selected="false">
                    🔔 {{ __('admin.notifications') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" 
                    type="button" role="tab" aria-controls="security" aria-selected="false">
                    🔐 {{ __('admin.security') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="backup-tab" data-bs-toggle="tab" data-bs-target="#backup" 
                    type="button" role="tab" aria-controls="backup" aria-selected="false">
                    💾 {{ __('admin.backup') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="maintenance-tab" data-bs-toggle="tab" data-bs-target="#maintenance" 
                    type="button" role="tab" aria-controls="maintenance" aria-selected="false">
                    🛠️ {{ __('admin.maintenance') }}
                </button>
            </li>
        </ul>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        
        <!-- GENERAL SETTINGS TAB -->
        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>{{ __('admin.company_name') }}</strong></label>
                                <input type="text" class="form-control" name="company_name" 
                                    value="{{ $settings['company_name'] ?? '' }}" required>
                                <small class="text-muted">{{ __('admin.your_company_or_organization_name') }}</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>{{ __('admin.company_email') }}</strong></label>
                                <input type="email" class="form-control" name="company_email" 
                                    value="{{ $settings['company_email'] ?? '' }}" required>
                                <small class="text-muted">{{ __('admin.main_contact_email_address') }}</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>{{ __('admin.company_phone') }}</strong></label>
                                <input type="text" class="form-control" name="company_phone" 
                                    value="{{ $settings['company_phone'] ?? '' }}" required>
                                <small class="text-muted">{{ __('admin.main_phone_number') }}</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>{{ __('admin.company_address') }}</strong></label>
                                <input type="text" class="form-control" name="company_address" 
                                    value="{{ $settings['company_address'] ?? '' }}" required>
                                <small class="text-muted">{{ __('admin.physical_address') }}</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>{{ __('admin.currency') }}</strong></label>
                                <select class="form-select" name="currency" required>
                                    <option value="USD" {{ isset($settings['currency']) && $settings['currency'] === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                    <option value="EUR" {{ isset($settings['currency']) && $settings['currency'] === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                    <option value="GBP" {{ isset($settings['currency']) && $settings['currency'] === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                    <option value="AED" {{ isset($settings['currency']) && $settings['currency'] === 'AED' ? 'selected' : '' }}>AED - UAE Dirham</option>
                                    <option value="SAR" {{ isset($settings['currency']) && $settings['currency'] === 'SAR' ? 'selected' : '' }}>SAR - Saudi Riyal</option>
                                </select>
                                <small class="text-muted">{{ __('admin.default_currency_for_transactions') }}</small>
                            </div>
                        </div>

                        <div class="border-top pt-3 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('admin.save_general_settings') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- SYSTEM SETTINGS TAB -->
        <div class="tab-pane fade" id="system" role="tabpanel" aria-labelledby="system-tab">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>{{ __('admin.timezone') }}</strong></label>
                                <select class="form-select" name="app_timezone" required>
                                    <option value="America/New_York" {{ isset($settings['app_timezone']) && $settings['app_timezone'] === 'America/New_York' ? 'selected' : '' }}>{{ __('admin.eastern_time') }}</option>
                                    <option value="America/Chicago" {{ isset($settings['app_timezone']) && $settings['app_timezone'] === 'America/Chicago' ? 'selected' : '' }}>{{ __('admin.central_time') }}</option>
                                    <option value="America/Los_Angeles" {{ isset($settings['app_timezone']) && $settings['app_timezone'] === 'America/Los_Angeles' ? 'selected' : '' }}>{{ __('admin.pacific_time') }}</option>
                                    <option value="Europe/London" {{ isset($settings['app_timezone']) && $settings['app_timezone'] === 'Europe/London' ? 'selected' : '' }}>{{ __('admin.london') }}</option>
                                    <option value="Asia/Dubai" {{ isset($settings['app_timezone']) && $settings['app_timezone'] === 'Asia/Dubai' ? 'selected' : '' }}>{{ __('admin.dubai_gst') }}</option>
                                </select>
                                <small class="text-muted">{{ __('admin.system_timezone_for_all_timestamps') }}</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>{{ __('admin.language') }}</strong></label>
                                <select class="form-select" name="app_locale" required>
                                    <option value="en" {{ isset($settings['app_locale']) && $settings['app_locale'] === 'en' ? 'selected' : '' }}>{{ __('admin.english') }}</option>
                                    <option value="es" {{ isset($settings['app_locale']) && $settings['app_locale'] === 'es' ? 'selected' : '' }}>{{ __('admin.spanish') }}</option>
                                    <option value="fr" {{ isset($settings['app_locale']) && $settings['app_locale'] === 'fr' ? 'selected' : '' }}>{{ __('admin.french') }}</option>
                                    <option value="de" {{ isset($settings['app_locale']) && $settings['app_locale'] === 'de' ? 'selected' : '' }}>{{ __('admin.german') }}</option>
                                </select>
                                <small class="text-muted">{{ __('admin.default_system_language') }}</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>{{ __('admin.items_per_page') }}</strong></label>
                                <input type="number" class="form-control" name="items_per_page" 
                                    value="{{ $settings['items_per_page'] ?? 15 }}" min="5" max="100" required>
                                <small class="text-muted">{{ __('admin.default_pagination_size') }}</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>Dashboard Refresh (seconds)</strong></label>
                                <input type="number" class="form-control" name="dashboard_refresh_interval" 
                                    value="{{ $settings['dashboard_refresh_interval'] ?? 60 }}" min="15" max="300" required>
                                <small class="text-muted">Auto-refresh interval in seconds</small>
                            </div>
                        </div>

                        <div class="border-top pt-3 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('admin.save_system_settings') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- EMAIL SETTINGS TAB -->
        <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">📧 Email Configuration</h5>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Email settings are configured in your <code>.env</code> file.
                        Contact your system administrator to change mail driver or credentials.
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Mail Driver</strong></label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-info">{{ $settings['mail_driver'] }}</span>
                            </div>
                            <small class="text-muted">{{ __('admin.mail_driver_current') }}</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ __('admin.from_address') }}</strong></label>
                            <div class="form-control-plaintext">{{ $settings['mail_from_address'] }}</div>
                            <small class="text-muted">{{ __('admin.default_sender_email') }}</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ __('admin.from_name') }}</strong></label>
                            <div class="form-control-plaintext">{{ $settings['mail_from_name'] }}</div>
                            <small class="text-muted">{{ __('admin.default_sender_name') }}</small>
                        </div>
                    </div>

                    <div class="border-top pt-3 mt-3">
                        <form action="{{ route('admin.settings.testEmail') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-envelope"></i> {{ __('admin.send_test_email') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- NOTIFICATIONS SETTINGS TAB -->
        <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-4">🔔 Notification Preferences</h5>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="enable_email_notifications" 
                                        id="email_notif" value="1" 
                                        {{ $settings['enable_email_notifications'] ? 'checked' : '' }}>
                                    <label class="form-check-label" for="email_notif">
                                        <strong>Email Notifications</strong>
                                        <br>
                                        <small class="text-muted">{{ __('admin.send_email_notifications') }}</small>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="enable_dashboard_alerts" 
                                        id="dashboard_alerts" value="1" 
                                        {{ $settings['enable_dashboard_alerts'] ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dashboard_alerts">
                                        <strong>Dashboard Alerts</strong>
                                        <br>
                                        <small class="text-muted">{{ __('admin.show_dashboard_alerts') }}</small>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>{{ __('admin.notification_email') }}</strong></label>
                                <input type="email" class="form-control" name="notification_email" 
                                    value="{{ $settings['notification_email'] ?? '' }}" required>
                                <small class="text-muted">{{ __('admin.email_for_notifications') }}</small>
                            </div>
                        </div>

                        <div class="border-top pt-3 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('admin.save_notification_settings') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- SECURITY SETTINGS TAB -->
        <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-4">🔐 Security Settings</h5>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="enable_two_factor" 
                                        id="two_factor" value="1" 
                                        {{ $settings['enable_two_factor'] ? 'checked' : '' }}>
                                    <label class="form-check-label" for="two_factor">
                                        <strong>Two-Factor Authentication</strong>
                                        <br>
                                        <small class="text-muted">{{ __('admin.require_two_factor') }}</small>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>{{ __('admin.session_timeout') }}</strong></label>
                                <input type="number" class="form-control" name="session_timeout" 
                                    value="{{ $settings['session_timeout'] ?? 120 }}" min="15" max="480" required>
                                <small class="text-muted">{{ __('admin.auto_logout_after_inactivity') }}</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>{{ __('admin.password_expiry') }}</strong></label>
                                <input type="number" class="form-control" name="password_expiry_days" 
                                    value="{{ $settings['password_expiry_days'] ?? 90 }}" min="7" max="365" required>
                                <small class="text-muted">{{ __('admin.force_password_change_after') }}</small>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-shield-alt"></i> <strong>Security Tip:</strong> 
                            Make sure all admin users have strong passwords and use unique accounts.
                        </div>

                        <div class="border-top pt-3 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('admin.save_security_settings') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- BACKUP SETTINGS TAB -->
        <div class="tab-pane fade" id="backup" role="tabpanel" aria-labelledby="backup-tab">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-4">💾 Backup Configuration</h5>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="enable_auto_backup" 
                                        id="auto_backup" value="1" 
                                        {{ $settings['enable_auto_backup'] ? 'checked' : '' }}>
                                    <label class="form-check-label" for="auto_backup">
                                        <strong>Automatic Backups</strong>
                                        <br>
                                        <small class="text-muted">{{ __('admin.backup_database_automatically') }}</small>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>{{ __('admin.backup_frequency') }}</strong></label>
                                <select class="form-select" name="backup_frequency" required>
                                    <option value="daily" {{ isset($settings['backup_frequency']) && $settings['backup_frequency'] === 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ isset($settings['backup_frequency']) && $settings['backup_frequency'] === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ isset($settings['backup_frequency']) && $settings['backup_frequency'] === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                </select>
                                <small class="text-muted">{{ __('admin.schedule_for_backups') }}</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>{{ __('admin.backup_retention') }}</strong></label>
                                <input type="number" class="form-control" name="backup_retention_days" 
                                    value="{{ $settings['backup_retention_days'] ?? 30 }}" min="7" max="365" required>
                                <small class="text-muted">{{ __('admin.keep_backups_for') }}</small>
                            </div>
                        </div>

                        <div class="border-top pt-3 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Backup Settings
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <h6 class="mb-3">🔧 Manual Backup</h6>
                    <form action="{{ route('admin.settings.backup') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success" onclick="return confirm('Create backup now?')">
                            <i class="fas fa-database"></i> Create Backup Now
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- MAINTENANCE TAB -->
        <div class="tab-pane fade" id="maintenance" role="tabpanel" aria-labelledby="maintenance-tab">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-4">🛠️ Maintenance Tools</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card border">
                                <div class="card-body">
                                    <h6 class="card-title"><i class="fas fa-trash"></i> Clear Cache</h6>
                                    <p class="card-text small text-muted">Remove all cached data to free up space and force refresh</p>
                                    <form action="{{ route('admin.settings.clearCache') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            Clear Cache
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card border">
                                <div class="card-body">
                                    <h6 class="card-title"><i class="fas fa-rocket"></i> Optimize</h6>
                                    <p class="card-text small text-muted">Optimize application performance and autoloader</p>
                                    <form action="{{ route('admin.settings.optimize') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-sm">
                                            Optimize Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card border bg-light">
                                <div class="card-body">
                                    <h6 class="card-title"><i class="fas fa-info-circle"></i> System Status</h6>
                                    <p class="card-text small">
                                        <strong>Status:</strong> <span class="badge bg-success">🟢 Online</span><br>
                                        <strong>Version:</strong> <span class="">Laravel 12.0</span><br>
                                        <strong>PHP:</strong> <span class="">{{ phpversion() }}</span><br>
                                        <strong>Current Time:</strong> <span class="text-info">{{ now()->format('M d, Y @ h:i A') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card border bg-light">
                                <div class="card-body">
                                    <h6 class="card-title"><i class="fas fa-info-circle"></i> Database Info</h6>
                                    <p class="card-text small">
                                        <strong>Connection:</strong> <span class="">{{ config('database.default') }}</span><br>
                                        <strong>Host:</strong> <span class="">{{ env('DB_HOST', 'localhost') }}</span><br>
                                        <strong>Database:</strong> <span class="">{{ env('DB_DATABASE', 'N/A') }}</span><br>
                                        <strong>Driver:</strong> <span class="">{{ config('database.connections.' . config('database.default') . '.driver') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle"></i> <strong>Note:</strong> 
                        These tools should be used with caution. Make sure to backup your database before running maintenance operations.
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        border-bottom: 3px solid transparent;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        color: #0d6efd;
        border-bottom-color: #0d6efd;
    }

    .nav-tabs .nav-link.active {
        color: #0d6efd;
        background: transparent;
        border-bottom-color: #0d6efd;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .form-check-label {
        cursor: pointer;
        user-select: none;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
