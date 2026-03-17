@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('admin.roles_permissions') }}</h4>
            <p class="page-subtitle">{{ __('admin.roles_permissions_subtitle') }}</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>{{ __('admin.create_role') }}
        </a>
    </div>

    {{-- SYSTEM INFO CARDS --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div style="width:44px;height:44px;border-radius:10px;background:#ede9fe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-shield-alt" style="color:#4f46e5;"></i>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;">Total Roles</div>
                        <div style="font-size:22px;font-weight:700;color:#1e293b;">{{ count($roles) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div style="width:44px;height:44px;border-radius:10px;background:#dbeafe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-key" style="color:#0284c7;"></i>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;">Total Permissions</div>
                        <div style="font-size:22px;font-weight:700;color:#1e293b;">{{ count($permissions) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div style="width:44px;height:44px;border-radius:10px;background:#dcfce7;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-users" style="color:#059669;"></i>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;">Users with Roles</div>
                        <div style="font-size:22px;font-weight:700;color:#1e293b;">{{ \App\Models\User::whereHas('roles')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div style="width:44px;height:44px;border-radius:10px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-lock" style="color:#64748b;"></i>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;">Guard</div>
                        <div style="font-size:22px;font-weight:700;color:#1e293b;">web</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-3 mb-4" style="background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; border-radius: 8px;">
            <strong><i class="fas fa-exclamation-circle me-2"></i>Errors:</strong>
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
            @if($roles->isEmpty())
                <div class="info-box m-4">
                    <i class="fas fa-info-circle me-2"></i>No roles found.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-styled mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('admin.role_name') }}</th>
                                <th>{{ __('admin.permissions') }}</th>
                                <th>{{ __('admin.users_count') }}</th>
                                <th class="td-center">{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>
                                        @if($role->name === 'super_admin')
                                            <span class="badge" style="background: #fee2e2; color: #991b1b; font-size: 12px; padding: 5px 12px; border-radius: 20px; font-weight: 600;">
                                                <i class="fas fa-crown me-1"></i>{{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                            </span>
                                        @elseif($role->name === 'admin')
                                            <span class="badge" style="background: #fef3c7; color: #92400e; font-size: 12px; padding: 5px 12px; border-radius: 20px; font-weight: 600;">
                                                <i class="fas fa-shield-alt me-1"></i>{{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                            </span>
                                        @elseif(strpos($role->name, 'client') !== false)
                                            <span class="badge" style="background: #dbeafe; color: #1e40af; font-size: 12px; padding: 5px 12px; border-radius: 20px; font-weight: 600;">
                                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                            </span>
                                        @else
                                            <span class="badge" style="background: #f1f5f9; color: #475569; font-size: 12px; padding: 5px 12px; border-radius: 20px; font-weight: 600;">
                                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge" style="background: #f5f3ff; color: #4f46e5; font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600;">
                                            {{ count($role->permissions) }} {{ __('admin.permissions') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="td-muted">{{ $role->users()->count() }} {{ __('admin.users') }}</span>
                                    </td>
                                    <td class="td-center">
                                        <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye me-1"></i>{{ __('admin.view') }}
                                        </a>
                                        @if(!in_array($role->name, ['super_admin']))
                                            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit me-1"></i>{{ __('admin.edit') }}
                                            </a>
                                        @endif
                                        @if(!in_array($role->name, ['super_admin', 'admin']) && $role->users()->count() === 0)
                                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('{{ __('admin.confirm_delete') }}');">
                                                    <i class="fas fa-trash me-1"></i>{{ __('admin.delete') }}
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

</div>
@endsection
