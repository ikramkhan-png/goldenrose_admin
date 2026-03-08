@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2><i class="fas fa-user-plus"></i> Create New User</h2>
            
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card shadow-sm mt-3">
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <!-- Basic Information Section -->
                        <h5 class="mb-3 pb-2 border-bottom"><i class="fas fa-user"></i> Basic Information</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" placeholder="John Doe" 
                                    value="{{ old('name') }}" required>
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    id="email" name="email" placeholder="user@example.com" 
                                    value="{{ old('email') }}" required>
                                @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                    id="phone" name="phone" placeholder="+1-234-567-8900" 
                                    value="{{ old('phone') }}">
                                @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label fw-bold">User Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" name="type" required onchange="updateClientTypeVisibility()">
                                    <option value="">-- Select Type --</option>
                                    <option value="admin" {{ old('type') === 'admin' ? 'selected' : '' }}>
                                        👑 Admin User
                                    </option>
                                    <option value="client" {{ old('type') === 'client' ? 'selected' : '' }}>
                                        👤 Client
                                    </option>
                                    <option value="employee" {{ old('type') === 'employee' ? 'selected' : '' }}>
                                        👷 Employee
                                    </option>
                                </select>
                                @error('type')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Client Type (only for clients) -->
                        <div id="clientTypeContainer" style="display: {{ old('type') === 'client' ? 'block' : 'none' }};" class="mb-3">
                            <label for="client_type" class="form-label fw-bold">Client Type <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="client_type" 
                                            value="service" id="client_service"
                                            {{ old('client_type') === 'service' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="client_service">
                                            🛎️ Service Client
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="client_type" 
                                            value="project" id="client_project"
                                            {{ old('client_type') === 'project' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="client_project">
                                            📊 Project Client
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('client_type')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Section -->
                        <h5 class="mb-3 pb-2 border-bottom"><i class="fas fa-lock"></i> Password</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                    id="password" name="password" placeholder="At least 8 characters" required>
                                @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Minimum 8 characters</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-bold">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                    id="password_confirmation" name="password_confirmation" 
                                    placeholder="Repeat password" required>
                                @error('password_confirmation')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Role Assignment Section -->
                        <h5 class="mb-3 pb-2 border-bottom"><i class="fas fa-shield-alt"></i> Role Assignment</h5>

                        <div class="mb-3">
                            <label for="role" class="form-label fw-bold">Assign Role <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" 
                                id="role" name="role" required>
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                    <span class="text-muted">({{ $role->users()->count() }} users)</span>
                                </option>
                                @endforeach
                            </select>
                            @error('role')
                            <span class="invalid-feedback">{{ $message }}</span>
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
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
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
