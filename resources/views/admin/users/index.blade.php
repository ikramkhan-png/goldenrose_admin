@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('users.user_management') }}</h4>
            <p class="page-subtitle">{{ __('users.user_management_description') }}</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-1"></i>{{ __('users.create_new_user') }}
        </a>
    </div>

    {{-- STATS --}}
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div style="width:44px;height:44px;border-radius:10px;background:#ede9fe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-users" style="color:#4f46e5;"></i>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;">{{ __('users.total_users') }}</div>
                        <div style="font-size:22px;font-weight:700;color:#1e293b;">{{ \App\Models\User::count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div style="width:44px;height:44px;border-radius:10px;background:#fee2e2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-crown" style="color:#dc2626;"></i>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;">{{ __('users.admin_users') }}</div>
                        <div style="font-size:22px;font-weight:700;color:#1e293b;">{{ \App\Models\User::where('type', 'admin')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div style="width:44px;height:44px;border-radius:10px;background:#dbeafe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-user-tie" style="color:#0284c7;"></i>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;">{{ __('users.client_users') }}</div>
                        <div style="font-size:22px;font-weight:700;color:#1e293b;">{{ \App\Models\User::where('type', 'client')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div style="width:44px;height:44px;border-radius:10px;background:#dcfce7;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-hard-hat" style="color:#059669;"></i>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;">{{ __('users.employees') }}</div>
                        <div style="font-size:22px;font-weight:700;color:#1e293b;">{{ \App\Models\User::where('type', 'employee')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MONTH FILTER --}}
    <div class="card mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex align-items-end gap-3 flex-wrap">
                <div style="flex: 1; min-width: 220px;">
                    <label class="form-label">
                        <i class="fas fa-calendar-alt me-1" style="color: #4f46e5;"></i>{{ __('admin.filter_by_month') }}
                    </label>
                    <input type="month" name="month" class="form-control"
                           value="{{ request('month', now()->format('Y-m')) }}"
                           onchange="this.form.submit()">
                </div>
                <div style="flex: 1; min-width: 180px;">
                    <label class="form-label">
                        <i class="fas fa-filter me-1" style="color: #4f46e5;"></i>{{ __('admin.filter') }}
                    </label>
                    <div class="filter-display">
                        {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('All Data') }}
                    </div>
                </div>
                @if(request('month'))
                <div style="min-width: 110px;">
                    <label class="form-label">&nbsp;</label>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-times me-1"></i>{{ __('Show All') }}
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-3 mb-4" style="background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; border-radius: 8px;">
            <strong><i class="fas fa-exclamation-circle me-2"></i>{{ __('users.errors') }}:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="p-3 mb-4" style="background: #f0fdf4; color: #166534; border-left: 4px solid #22c55e; border-radius: 8px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="p-3 mb-4" style="background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; border-radius: 8px;">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            @if ($users->isEmpty())
                <div class="info-box m-4">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ __('users.no_users') }}
                    <a href="{{ route('admin.users.create') }}" style="color: #4f46e5; font-weight: 600;">{{ __('users.create_first_user') }}</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-styled mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('users.name') }}</th>
                                <th>{{ __('users.email') }}</th>
                                <th>{{ __('users.phone') }}</th>
                                <th>{{ __('users.type') }}</th>
                                <th>{{ __('users.role') }}</th>
                                <th>{{ __('users.joined') }}</th>
                                <th class="td-center">{{ __('users.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="td-name">
                                        {{ $user->name }}
                                        @if (auth()->user()->id === $user->id)
                                            <span class="badge ms-1" style="background: #fef3c7; color: #92400e; font-size: 10px; padding: 2px 7px; border-radius: 10px;">{{ __('users.you') }}</span>
                                        @endif
                                    </td>
                                    <td class="td-muted">{{ $user->email }}</td>
                                    <td class="td-muted">{{ $user->phone ?? '-' }}</td>
                                    <td>
                                        @if ($user->type === 'admin')
                                            <span class="badge" style="background: #fee2e2; color: #991b1b; font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600;">{{ __('users.type_admin') }}</span>
                                        @elseif($user->type === 'client')
                                            <span class="badge" style="background: #dbeafe; color: #1e40af; font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600;">{{ __('users.type_client') }}</span>
                                        @else
                                            <span class="badge" style="background: #f1f5f9; color: #475569; font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600;">{{ __('users.type_employee') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @forelse($user->roles as $role)
                                            @if ($role->name === 'super_admin')
                                                <span class="badge" style="background: #fee2e2; color: #991b1b; font-size: 11px; padding: 3px 9px; border-radius: 20px;">{{ __('users.role_super_admin') }}</span>
                                            @elseif($role->name === 'admin')
                                                <span class="badge" style="background: #fef3c7; color: #92400e; font-size: 11px; padding: 3px 9px; border-radius: 20px;">{{ __('users.role_admin') }}</span>
                                            @else
                                                <span class="badge" style="background: #f1f5f9; color: #475569; font-size: 11px; padding: 3px 9px; border-radius: 20px;">{{ str_replace('_', ' ', ucfirst($role->name)) }}</span>
                                            @endif
                                        @empty
                                            <span class="td-muted" style="font-size: 12px;">{{ __('users.no_role') }}</span>
                                        @endforelse
                                    </td>
                                    <td class="td-muted">{{ $user->created_at->translatedFormat('M d, Y') }}</td>
                                    <td class="td-center">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info" title="{{ __('users.view') }}">
                                            <i class="fas fa-eye me-1"></i>{{ __('users.view') }}
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning" title="{{ __('users.edit') }}">
                                            <i class="fas fa-edit me-1"></i>{{ __('users.edit') }}
                                        </a>
                                        @if (auth()->user()->id !== $user->id && !$user->hasRole('super_admin'))
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('{{ __('users.confirm_delete') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="{{ __('users.delete') }}">
                                                    <i class="fas fa-trash me-1"></i>{{ __('users.delete') }}
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

    @if ($users->hasPages())
        <div class="mt-3">{{ $users->links() }}</div>
    @endif

</div>
@endsection
