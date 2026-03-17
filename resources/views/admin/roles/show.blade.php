@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-eye"></i> View Role: 
                    @if($role->name === 'super_admin')
                        <span class="badge bg-danger">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                    @elseif($role->name === 'admin')
                        <span class="badge bg-warning">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                    @elseif(strpos($role->name, 'client') !== false)
                        <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                    @endif
                </h2>
                <div>
                    @if($role->name !== 'super_admin')
                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    @endif
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <!-- Role Details -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Role Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Role Name:</strong> {{ ucfirst(str_replace('_', ' ', $role->name)) }}</p>
                            <p><strong>Guard Name:</strong> <code>{{ $role->guard_name }}</code></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Created:</strong> {{ $role->created_at->format('M d, Y H:i') }}</p>
                            <p><strong>Last Updated:</strong> {{ $role->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-lock"></i> Assigned Permissions ({{ count($role->permissions) }})</h5>
                </div>
                <div class="card-body">
                    @if($role->permissions->isEmpty())
                    <p class="text-muted">No permissions assigned to this role.</p>
                    @else
                    <div class="row">
                        @foreach($role->permissions as $permission)
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">
                                                <i class="fas fa-check-circle text-success"></i>
                                                {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                            </h6>
                                            <small class="text-muted">{{ $permission->description ?? 'No description' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Users with this Role -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-users"></i> Users with this Role ({{ $role->users()->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($role->users()->count() === 0)
                    <p class="text-muted">No users assigned to this role yet.</p>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($role->users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->type === 'admin')
                                            <span class="badge bg-danger">{{ ucfirst($user->type) }}</span>
                                        @elseif($user->type === 'client')
                                            <span class="badge bg-info">
                                                {{ ucfirst($user->type) }} - 
                                                {{ ucfirst($user->client_type ?? 'N/A') }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($user->type) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
