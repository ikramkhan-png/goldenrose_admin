@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2><i class="fas fa-edit"></i> Edit Role: <strong>{{ ucfirst(str_replace('_', ' ', $role->name)) }}</strong></h2>
            
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Errors:</strong>
                <ul class="mb-0">
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
                <div class="card-body">
                    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Role Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" 
                                value="{{ old('name', $role->name) }}" required>
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Role name will be converted to lowercase with underscores</small>
                        </div>

                        <!-- Current Permissions -->
                        <div class="mb-3">
                            <label class="form-label">Current Permissions: <strong>{{ count($role->permissions) }}</strong></label>
                            @if($role->permissions->isEmpty())
                            <p class="text-muted">No permissions assigned.</p>
                            @else
                            <div class="mb-2">
                                @foreach($role->permissions as $permission)
                                <span class="badge bg-success">{{ ucfirst(str_replace('_', ' ', $permission->name)) }}</span>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <!-- Permissions Management -->
                        <div class="mb-3">
                            <label class="form-label">Manage Permissions</label>
                            <div class="card bg-light">
                                <div class="card-body">
                                    @if($permissions->isEmpty())
                                    <p class="text-muted mb-0">No permissions available.</p>
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
                            </div>
                            <small class="form-text text-muted d-block mt-2">Check/uncheck permissions to update this role's access level.</small>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Role
                            </button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Role Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Users with this role:</strong> <span class="badge bg-primary">{{ $role->users()->count() }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total permissions:</strong> <span class="badge bg-info">{{ count($role->permissions) }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
