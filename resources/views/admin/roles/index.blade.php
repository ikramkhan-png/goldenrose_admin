@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-shield-alt"></i> Roles & Permissions Management</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Role
            </a>
        </div>
    </div>

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

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Roles Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-list"></i> All Roles ({{ count($roles) }})</h5>
        </div>
        <div class="card-body">
            @if($roles->isEmpty())
            <p class="text-muted">No roles found.</p>
            @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            <th>Users Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>
                                <strong>
                                    @if($role->name === 'super_admin')
                                        <span class="badge bg-danger">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                                    @elseif($role->name === 'admin')
                                        <span class="badge bg-warning">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                                    @elseif(strpos($role->name, 'client') !== false)
                                        <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                                    @endif
                                </strong>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ count($role->permissions) }} permissions</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $role->users()->count() }} users</span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-info" title="View">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @if(!in_array($role->name, ['super_admin']))
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @endif
                                    @if(!in_array($role->name, ['super_admin', 'admin']) && $role->users()->count() === 0)
                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Delete" 
                                            onclick="return confirm('Are you sure?');">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <!-- System Status -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> System Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted">Total Roles</h6>
                                <h3 class="text-primary">{{ count($roles) }}</h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted">Total Permissions</h6>
                                <h3 class="text-info">{{ count($permissions) }}</h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted">Users with Roles</h6>
                                <h3 class="text-success">
                                    {{ \App\Models\User::whereHas('roles')->count() }}
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted">Guard Name</h6>
                                <h3 class="text-warning">web</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection