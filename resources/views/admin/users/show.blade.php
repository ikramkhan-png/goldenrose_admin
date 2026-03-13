@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
        <div class="row">
            <div class="col-md-10 offset-md-1">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-user-circle"></i> {{ $user->name }}</h2>
                    <div>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-edit"></i> {{ __('users.edit_user') }}
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-{{ $isAr ? 'right' : 'left' }}"></i>
                            {{ __('users.back_to_users') }}
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- User Details Cards -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle"></i> {{ __('users.personal_information') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-2">
                                    <strong>{{ __('users.full_name') }}:</strong><br>
                                    {{ $user->name }}
                                </p>
                                <p class="mb-2">
                                    <strong>{{ __('users.email_address') }}:</strong><br>
                                    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                </p>
                                <p class="mb-0">
                                    <strong>{{ __('users.phone_number') }}:</strong><br>
                                    {{ $user->phone ?? __('users.not_provided') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-shield-alt"></i> {{ __('users.account_settings') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-2">
                                    <strong>{{ __('users.user_type') }}:</strong><br>
                                    @if ($user->type === 'admin')
                                        <span class="badge bg-danger fs-6">{{ __('users.type_admin') }}</span>
                                    @elseif($user->type === 'client')
                                        <span class="badge bg-info fs-6">{{ __('users.type_client') }}</span>
                                    @else
                                        <span class="badge bg-secondary fs-6">{{ __('users.type_employee') }}</span>
                                    @endif
                                </p>
                                @if ($user->type === 'client')
                                    <p class="mb-2">
                                        <strong>{{ __('users.client_type') }}:</strong><br>
                                        @if ($user->client_type === 'service')
                                            <span class="badge bg-primary fs-6">🛎️ {{ __('users.service_client') }}</span>
                                        @elseif($user->client_type === 'project')
                                            <span class="badge bg-primary fs-6">📊 {{ __('users.project_client') }}</span>
                                        @else
                                            <span class="text-muted">{{ __('users.not_specified') }}</span>
                                        @endif
                                    </p>
                                @endif
                                <p class="mb-0">
                                    <strong>{{ __('users.account_status') }}:</strong><br>
                                    <span class="badge bg-success fs-6">✓ {{ __('users.active') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-user-tag"></i> {{ __('users.assigned_role') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        @forelse($user->roles as $role)
                            <div class="role-badge mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        @if ($role->name === 'super_admin')
                                            <h6 class="mb-2">
                                                <span class="badge bg-danger fs-6">
                                                    👑 {{ __('users.role_super_admin') }}
                                                </span>
                                            </h6>
                                        @elseif($role->name === 'admin')
                                            <h6 class="mb-2">
                                                <span class="badge bg-warning fs-6">
                                                    ⚙️ {{ __('users.role_admin') }}
                                                </span>
                                            </h6>
                                        @elseif(strpos($role->name, 'client') !== false)
                                            <h6 class="mb-2">
                                                <span class="badge bg-info fs-6">
                                                    🔐 {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                                </span>
                                            </h6>
                                        @else
                                            <h6 class="mb-2">
                                                <span class="badge bg-secondary fs-6">
                                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                                </span>
                                            </h6>
                                        @endif
                                        <p class="text-muted mb-0">
                                            {{ $role->users()->count() }} {{ __('users.users_assigned_role') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Role Permissions -->
                                @if ($role->permissions->isNotEmpty())
                                    <div class="mt-3">
                                        <p class="mb-2">
                                            <strong>
                                                {{ __('users.permissions') }} ({{ count($role->permissions) }})
                                            </strong>
                                        </p>
                                        <div class="row">
                                            @foreach ($role->permissions as $permission)
                                                <div class="col-md-6 mb-2">
                                                    <small>
                                                        <i class="fas fa-check-circle text-success"></i>
                                                        {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                    </small>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted">{{ __('users.no_role_assigned') }}</p>
                        @endforelse
                    </div>
                </div>

                <!-- Account Timeline -->
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-history"></i> {{ __('users.account_timeline') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>{{ __('users.account_created') }}:</strong></p>
                                <p class="text-muted">
                                    {{ $user->created_at->translatedFormat('l, F j, Y') }}
                                    {{ __('users.at') }}
                                    {{ $user->created_at->translatedFormat('g:i A') }}
                                    <br>
                                    <small>({{ $user->created_at->diffForHumans() }})</small>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>{{ __('users.last_updated') }}:</strong></p>
                                <p class="text-muted">
                                    {{ $user->updated_at->translatedFormat('l, F j, Y') }}
                                    {{ __('users.at') }}
                                    {{ $user->updated_at->translatedFormat('g:i A') }}
                                    <br>
                                    <small>({{ $user->updated_at->diffForHumans() }})</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                @if (auth()->user()->id !== $user->id && !$user->hasRole('super_admin'))
                    <div class="card border-danger shadow-sm mt-4">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-exclamation-triangle"></i> {{ __('users.danger_zone') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">{{ __('users.delete_warning') }}</p>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-lg"
                                    onclick="return confirm('{{ __('users.confirm_delete_full') }}');">
                                    <i class="fas fa-trash"></i> {{ __('users.delete_this_user') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
