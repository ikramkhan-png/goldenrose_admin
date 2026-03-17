@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('users.edit_user') }}: {{ $user->name }}</h4>
            <p class="page-subtitle">{{ __('users.users') }}</p>
        </div>
        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-cancel">
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
        <div class="col-lg-8">
            <div class="form-card">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="mb-3 pb-2 border-bottom">
                        <i class="fas fa-user me-1"></i>{{ __('users.basic_information') }}
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name" class="form-label">{{ __('users.full_name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" placeholder="{{ __('users.full_name_placeholder') }}"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="email" class="form-label">{{ __('users.email_address') }} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" placeholder="{{ __('users.email_placeholder') }}"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="phone" class="form-label">{{ __('users.phone_number') }}</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" name="phone" placeholder="{{ __('users.phone_placeholder') }}"
                                value="{{ old('phone', $user->phone) }}">
                            @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="type" class="form-label">{{ __('users.user_type') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type"
                                name="type" required onchange="updateClientTypeVisibility()">
                                <option value="admin" {{ old('type', $user->type) === 'admin' ? 'selected' : '' }}>{{ __('users.type_admin') }}</option>
                                <option value="client" {{ old('type', $user->type) === 'client' ? 'selected' : '' }}>{{ __('users.type_client') }}</option>
                                <option value="employee" {{ old('type', $user->type) === 'employee' ? 'selected' : '' }}>{{ __('users.type_employee') }}</option>
                            </select>
                            @error('type')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div id="clientTypeContainer"
                        style="display: {{ old('type', $user->type) === 'client' ? 'block' : 'none' }};"
                        class="mb-4">
                        <label class="form-label">{{ __('users.client_type') }} <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="client_type" value="service" id="client_service"
                                        {{ old('client_type', $user->client_type) === 'service' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="client_service">{{ __('users.service_client') }}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="client_type" value="project" id="client_project"
                                        {{ old('client_type', $user->client_type) === 'project' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="client_project">{{ __('users.project_client') }}</label>
                                </div>
                            </div>
                        </div>
                        @error('client_type')<span class="text-danger small">{{ $message }}</span>@enderror
                    </div>

                    <h5 class="mb-3 pb-2 border-bottom">
                        <i class="fas fa-lock me-1"></i>{{ __('users.password_optional') }}
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="password" class="form-label">{{ __('users.new_password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="{{ __('users.new_password_placeholder') }}">
                            @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            <small class="form-text text-muted">{{ __('users.password_hint') }}</small>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="password_confirmation" class="form-label">{{ __('users.confirm_new_password') }}</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation"
                                placeholder="{{ __('users.confirm_new_password_placeholder') }}">
                            @error('password_confirmation')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <h5 class="mb-3 pb-2 border-bottom">
                        <i class="fas fa-shield-alt me-1"></i>{{ __('users.role_assignment') }}
                    </h5>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="form-label"><strong>{{ __('users.current_role') }}:</strong></p>
                            @forelse($user->roles as $role)
                                @if ($role->name === 'super_admin')
                                    <span class="badge bg-danger fs-6">{{ __('users.role_super_admin') }}</span>
                                @elseif($role->name === 'admin')
                                    <span class="badge bg-warning fs-6">{{ __('users.role_admin') }}</span>
                                @elseif(strpos($role->name, 'client') !== false)
                                    <span class="badge bg-info fs-6">{{ str_replace('_', ' ', ucfirst($role->name)) }}</span>
                                @else
                                    <span class="badge bg-secondary fs-6">{{ str_replace('_', ' ', ucfirst($role->name)) }}</span>
                                @endif
                            @empty
                                <span class="text-muted">{{ __('users.no_role_assigned') }}</span>
                            @endforelse
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label">{{ __('users.change_role') }}</label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="">{{ __('users.select_role') }}</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role', $userRole?->id) == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="p-3 mb-4" style="background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div class="row">
                            <div class="col-md-6">
                                <small><strong>{{ __('users.account_created') }}:</strong> {{ $user->created_at->translatedFormat('M d, Y - H:i') }}</small>
                            </div>
                            <div class="col-md-6">
                                <small><strong>{{ __('users.last_updated') }}:</strong> {{ $user->updated_at->translatedFormat('M d, Y - H:i') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ __('users.update_user') }}</button>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-cancel">{{ __('users.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function updateClientTypeVisibility() {
        const type = document.getElementById('type').value;
        const clientTypeContainer = document.getElementById('clientTypeContainer');
        clientTypeContainer.style.display = (type === 'client') ? 'block' : 'none';
    }
</script>
@endsection
