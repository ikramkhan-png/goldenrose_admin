@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="fw-bold mb-2"><i class="fas fa-user-plus"></i> {{ __('admin.create_new_user') }}</h1>
        <p class="text-muted">{{ __('admin.add_user_system_description') }}</p>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-exclamation-circle"></i> {{ __('admin.please_fix_following_errors') }}</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <!-- Personal Information Section -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3 pb-3 border-bottom"><i class="fas fa-user-circle"></i> {{ __('admin.personal_information') }}</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-bold">{{ __('admin.full_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                        id="name" name="name" placeholder="John Doe" 
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold">{{ __('admin.email_address') }} <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                        id="email" name="email" placeholder="user@example.com" 
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-bold">{{ __('admin.phone_number') }}</label>
                                    <input type="text" class="form-control form-control-lg @error('phone') is-invalid @enderror" 
                                        id="phone" name="phone" placeholder="+1-234-567-8900" 
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="type" class="form-label fw-bold">{{ __('admin.user_type') }} <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg @error('type') is-invalid @enderror" 
                                        id="type" name="type" required onchange="updateClientTypeVisibility()">
                                        <option value="">{{ __('admin.select_type') }}</option>
                                        <option value="admin" {{ old('type') === 'admin' ? 'selected' : '' }}>👑 Admin User</option>
                                        <option value="client" {{ old('type') === 'client' ? 'selected' : '' }}>👤 Client</option>
                                        <option value="employee" {{ old('type') === 'employee' ? 'selected' : '' }}>👷 Employee</option>
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Client Type Section -->
                        <div id="clientTypeContainer" style="display: {{ old('type') === 'client' ? 'block' : 'none' }}; margin-bottom: 2rem;">
                            <div class="mb-4 pb-3 border-bottom">
                                <label for="client_type" class="form-label fw-bold">{{ __('admin.client_type') }} <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check p-3 border rounded" style="cursor: pointer;">
                                            <input class="form-check-input" type="radio" name="client_type" 
                                                value="service" id="client_service"
                                                {{ old('client_type') === 'service' ? 'checked' : '' }}>
                                            <label class="form-check-label w-100" for="client_service">
                                                🛎️ {{ __('admin.service_client') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check p-3 border rounded" style="cursor: pointer;">
                                            <input class="form-check-input" type="radio" name="client_type" 
                                                value="project" id="client_project"
                                                {{ old('client_type') === 'project' ? 'checked' : '' }}>
                                            <label class="form-check-label w-100" for="client_project">
                                                📊 {{ __('admin.project_client') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('client_type')
                                <span class="text-danger small d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3 pb-3 border-bottom"><i class="fas fa-lock"></i> {{ __('admin.security_section') }}</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-bold">{{ __('admin.password') }} <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                        id="password" name="password" placeholder="At least 8 characters" required>
                                    @error('password')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">{{ __('admin.password_hint') }}</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label fw-bold">{{ __('admin.confirm_password') }} <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" 
                                        id="password_confirmation" name="password_confirmation" 
                                        placeholder="{{ __('admin.confirm_password_placeholder') }}" required>
                                    @error('password_confirmation')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Role Assignment Section -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3 pb-3 border-bottom"><i class="fas fa-shield-alt"></i> {{ __('admin.role_assignment') }}</h5>

                            <label for="role" class="form-label fw-bold">{{ __('admin.assign_role') }} <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg @error('role') is-invalid @enderror" 
                                id="role" name="role" required>
                                <option value="">{{ __('admin.select_role') }}</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }} ({{ $role->users()->count() }} users)
                                </option>
                                @endforeach
                            </select>
                            @error('role')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted d-block mt-2">
                                The role determines what permissions and features this user can access.
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Create User
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-lg border">
                                <i class="fas fa-arrow-left"></i> Back to Users
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateClientTypeVisibility() {
    const type = document.getElementById('type').value;
    const clientTypeContainer = document.getElementById('clientTypeContainer');
    if (type === 'client') {
        clientTypeContainer.style.display = 'block';
    } else {
        clientTypeContainer.style.display = 'none';
    }
}
</script>
@endsection
