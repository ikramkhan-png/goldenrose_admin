@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container-fluid mt-4 px-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="fw-bold mb-2">
                    <i class="fas fa-users"></i> {{ __('users.user_management') }}
                </h1>
                <p class="text-muted">{{ __('users.user_management_description') }}</p>
            </div>
            <div class="col-md-4 {{ $isAr ? 'text-start' : 'text-end' }}">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-user-plus"></i> {{ __('users.create_new_user') }}
                </a>
            </div>
        </div>

        {{-- MONTH FILTER --}}
        <div class="card border-0 mb-4" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
            <div class="card-body p-4">
                <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                    <div style="flex: 1; min-width: 250px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📅 {{ __('admin.filter_by_month') }}</label>
                        <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                               onchange="this.form.submit()" style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📆 {{ __('admin.filter') }}</label>
                        <div style="padding: 12px 14px; border: 2px solid #667eea; border-radius: 8px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); font-weight: 600; color: #667eea; font-size: 14px;">
                            {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : now()->format('F Y') }}
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-circle"></i> {{ __('users.errors') }}:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-2">{{ __('users.total_users') }}</h6>
                        <h2 class="text-primary fw-bold">{{ \App\Models\User::count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-2">{{ __('users.admin_users') }}</h6>
                        <h2 class="text-danger fw-bold">{{ \App\Models\User::where('type', 'admin')->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-2">{{ __('users.client_users') }}</h6>
                        <h2 class="text-info fw-bold">{{ \App\Models\User::where('type', 'client')->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-2">{{ __('users.employees') }}</h6>
                        <h2 class="text-secondary fw-bold">{{ \App\Models\User::where('type', 'employee')->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0">
                    <i class="fas fa-list"></i>
                    {{ __('users.all_users') }} ({{ $users->total() }})
                </h5>
            </div>
            <div class="card-body p-0">
                @if ($users->isEmpty())
                    <div class="p-5 text-center">
                        <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">
                            {{ __('users.no_users') }}
                            <a href="{{ route('admin.users.create') }}">{{ __('users.create_first_user') }}</a>
                        </p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">{{ __('users.name') }}</th>
                                    <th>{{ __('users.email') }}</th>
                                    <th>{{ __('users.phone') }}</th>
                                    <th>{{ __('users.type') }}</th>
                                    <th>{{ __('users.role') }}</th>
                                    <th>{{ __('users.joined') }}</th>
                                    <th class="{{ $isAr ? 'text-start ps-4' : 'text-end pe-4' }}">
                                        {{ __('users.actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="ps-4">
                                            <strong>{{ $user->name }}</strong>
                                            @if (auth()->user()->id === $user->id)
                                                <span class="badge bg-warning ms-2">{{ __('users.you') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </td>
                                        <td>
                                            <small>{{ $user->phone ?? '-' }}</small>
                                        </td>
                                        <td>
                                            @if ($user->type === 'admin')
                                                <span class="badge bg-danger">👑 {{ __('users.type_admin') }}</span>
                                            @elseif($user->type === 'client')
                                                <span class="badge bg-info">👤 {{ __('users.type_client') }}</span>
                                            @else
                                                <span class="badge bg-secondary">👷 {{ __('users.type_employee') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @forelse($user->roles as $role)
                                                @if ($role->name === 'super_admin')
                                                    <span class="badge bg-danger">{{ __('users.role_super_admin') }}</span>
                                                @elseif($role->name === 'admin')
                                                    <span
                                                        class="badge bg-warning text-dark">{{ __('users.role_admin') }}</span>
                                                @elseif(strpos($role->name, 'client') !== false)
                                                    <span
                                                        class="badge bg-info">{{ str_replace('_', ' ', ucfirst($role->name)) }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary">{{ str_replace('_', ' ', ucfirst($role->name)) }}</span>
                                                @endif
                                            @empty
                                                <span class="badge bg-light text-dark">{{ __('users.no_role') }}</span>
                                            @endforelse
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $user->created_at->translatedFormat('M d, Y') }}
                                            </small>
                                        </td>
                                        <td class="{{ $isAr ? 'ps-4 text-start' : 'pe-4 text-end' }}">
                                            <a href="{{ route('admin.users.show', $user) }}"
                                                class="btn btn-sm btn-outline-info" title="{{ __('users.view') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="btn btn-sm btn-outline-warning" title="{{ __('users.edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if (auth()->user()->id !== $user->id && !$user->hasRole('super_admin'))
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                    style="display:inline;"
                                                    onsubmit="return confirm('{{ __('users.confirm_delete') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        title="{{ __('users.delete') }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.01);
        }
    </style>
@endsection
