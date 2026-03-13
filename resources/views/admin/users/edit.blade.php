@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <h2>
                    <i class="fas fa-edit"></i>
                    {{ __('users.edit_user') }}: <strong>{{ $user->name }}</strong>
                </h2>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ __('users.fix_errors') }}</strong>
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
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow-sm mt-3">
                    <div class="card-body p-4">
                        <form action="{{ route('admin.users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Basic Information -->
                            <h5 class="mb-3 pb-2 border-bottom">
                                <i class="fas fa-user"></i> {{ __('users.basic_information') }}
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-bold">
                                        {{ __('users.full_name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="{{ __('users.full_name_placeholder') }}"
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold">
                                        {{ __('users.email_address') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="{{ __('users.email_placeholder') }}"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-bold">
                                        {{ __('users.phone_number') }}
                                    </label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" placeholder="{{ __('users.phone_placeholder') }}"
                                        value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="type" class="form-label fw-bold">
                                        {{ __('users.user_type') }} <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('type') is-invalid @enderror" id="type"
                                        name="type" required onchange="updateClientTypeVisibility()">
                                        <option value="admin"
                                            {{ old('type', $user->type) === 'admin' ? 'selected' : '' }}>
                                            👑 {{ __('users.type_admin') }}
                                        </option>
                                        <option value="client"
                                            {{ old('type', $user->type) === 'client' ? 'selected' : '' }}>
                                            👤 {{ __('users.type_client') }}
                                        </option>
                                        <option value="employee"
                                            {{ old('type', $user->type) === 'employee' ? 'selected' : '' }}>
                                            👷 {{ __('users.type_employee') }}
                                        </option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Client Type -->
                            <div id="clientTypeContainer"
                                style="display: {{ old('type', $user->type) === 'client' ? 'block' : 'none' }};"
                                class="mb-3">
                                <label class="form-label fw-bold">
                                    {{ __('users.client_type') }} <span class="text-danger">*</span>
                                </label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="client_type"
                                                value="service" id="client_service"
                                                {{ old('client_type', $user->client_type) === 'service' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="client_service">
                                                🛎️ {{ __('users.service_client') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="client_type"
                                                value="project" id="client_project"
                                                {{ old('client_type', $user->client_type) === 'project' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="client_project">
                                                📊 {{ __('users.project_client') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('client_type')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <h5 class="mb-3 pb-2 border-bottom">
                                <i class="fas fa-lock"></i> {{ __('users.password_optional') }}
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-bold">
                                        {{ __('users.new_password') }}
                                    </label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password"
                                        placeholder="{{ __('users.new_password_placeholder') }}">
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">{{ __('users.password_hint') }}</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label fw-bold">
                                        {{ __('users.confirm_new_password') }}
                                    </label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" name="password_confirmation"
                                        placeholder="{{ __('users.confirm_new_password_placeholder') }}">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Role Assignment -->
                            <h5 class="mb-3 pb-2 border-bottom">
                                <i class="fas fa-shield-alt"></i> {{ __('users.role_assignment') }}
                            </h5>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p><strong>{{ __('users.current_role') }}:</strong></p>
                                    @forelse($user->roles as $role)
                                        @if ($role->name === 'super_admin')
                                            <span class="badge bg-danger fs-6">{{ __('users.role_super_admin') }}</span>
                                        @elseif($role->name === 'admin')
                                            <span class="badge bg-warning fs-6">{{ __('users.role_admin') }}</span>
                                        @elseif(strpos($role->name, 'client') !== false)
                                            <span
                                                class="badge bg-info fs-6">{{ str_replace('_', ' ', ucfirst($role->name)) }}</span>
                                        @else
                                            <span
                                                class="badge bg-secondary fs-6">{{ str_replace('_', ' ', ucfirst($role->name)) }}</span>
                                        @endif
                                    @empty
                                        <span class="text-muted">{{ __('users.no_role_assigned') }}</span>
                                    @endforelse
                                </div>
                                <div class="col-md-6">
                                    <label for="role" class="form-label fw-bold">
                                        {{ __('users.change_role') }}
                                    </label>
                                    <select class="form-select @error('role') is-invalid @enderror" id="role"
                                        name="role" required>
                                        <option value="">{{ __('users.select_role') }}</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role', $userRole?->id) == $role->id ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Account Info -->
                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1">
                                                <small>
                                                    <strong>{{ __('users.account_created') }}:</strong>
                                                    {{ $user->created_at->translatedFormat('M d, Y - H:i') }}
                                                </small>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1">
                                                <small>
                                                    <strong>{{ __('users.last_updated') }}:</strong>
                                                    {{ $user->updated_at->translatedFormat('M d, Y - H:i') }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 pt-3 border-top">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> {{ __('users.update_user') }}
                                </button>
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times"></i> {{ __('users.cancel') }}
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
            clientTypeContainer.style.display = (type === 'client') ? 'block' : 'none';
        }
    </script>
@endsection
