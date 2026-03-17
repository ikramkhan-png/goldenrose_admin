@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('roles.edit_role') }}: {{ ucfirst(str_replace('_', ' ', $role->name)) }}</h4>
            <p class="page-subtitle">{{ __('roles.roles') }}</p>
        </div>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-cancel">
            <i class="fas fa-arrow-left me-1"></i>{{ __('admin.back') }}
        </a>
    </div>

    @if ($errors->any())
        <div class="p-3 mb-4" style="background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; border-radius: 8px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="p-3 mb-4" style="background: #f0fdf4; color: #166534; border-left: 4px solid #22c55e; border-radius: 8px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            <div class="form-card">
                <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="form-label">{{ __('roles.role_name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name"
                            value="{{ old('name', $role->name) }}" required>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        <small class="text-muted">{{ __('roles.role_name_hint') }}</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">{{ __('roles.current_permissions') }}: <strong>{{ count($role->permissions) }}</strong></label>
                        @if(!$role->permissions->isEmpty())
                            <div class="mb-2">
                                @foreach($role->permissions as $permission)
                                    <span class="badge bg-success me-1">{{ ucfirst(str_replace('_', ' ', $permission->name)) }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label">{{ __('roles.manage_permissions') }}</label>
                        <div class="p-3" style="background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                            @if($permissions->isEmpty())
                                <p class="text-muted mb-0">{{ __('roles.no_permissions_available') }}</p>
                            @else
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                                    value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <small class="text-muted d-block mt-2">{{ __('roles.manage_permissions_hint') }}</small>
                    </div>

                    <div class="p-3 mb-4" style="background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-0"><strong>{{ __('roles.users_with_role') }}:</strong> <span class="badge bg-primary">{{ $role->users()->count() }}</span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0"><strong>{{ __('roles.total_permissions') }}:</strong> <span class="badge bg-info">{{ count($role->permissions) }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ __('roles.update_role') }}</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-cancel">{{ __('admin.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
