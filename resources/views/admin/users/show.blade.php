@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-user-circle"></i> {{ $user->name }}</h2>
                <div>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-lg">
                        <i class="fas fa-edit"></i> Edit User
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Back to Users
                    </a>
                </div>
            </div>

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- User Details Cards -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-info-circle"></i> Personal Information</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>Full Name:</strong><br>
                                {{ $user->name }}
                            </p>
                            <p class="mb-2">
                                <strong>Email Address:</strong><br>
                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            </p>
                            <p class="mb-0">
                                <strong>Phone Number:</strong><br>
                                {{ $user->phone ?? 'Not provided' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-shield-alt"></i> Account Settings</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>User Type:</strong><br>
                                @if($user->type === 'admin')
                                    <span class="badge bg-danger fs-6">{{ ucfirst($user->type) }}</span>
                                @elseif($user->type === 'client')
                                    <span class="badge bg-info fs-6">{{ ucfirst($user->type) }}</span>
                                @else
                                    <span class="badge bg-secondary fs-6">{{ ucfirst($user->type) }}</span>
                                @endif
                            </p>
                            @if($user->type === 'client')
                            <p class="mb-2">
                                <strong>Client Type:</strong><br>
                                @if($user->client_type === 'service')
                                    <span class="badge bg-primary fs-6">🛎️ Service Client</span>
                                @elseif($user->client_type === 'project')
                                    <span class="badge bg-primary fs-6">📊 Project Client</span>
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </p>
                            @endif
                            <p class="mb-0">
                                <strong>Account Status:</strong><br>
                                <span class="badge bg-success fs-6">✓ Active</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-user-tag"></i> Assigned Role</h5>
                </div>
                <div class="card-body">
                    @forelse($user->roles as $role)
                    <div class="role-badge mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                @if($role->name === 'super_admin')
                                    <h6 class="mb-2"><span class="badge bg-danger fs-6">👑 {{ ucfirst(str_replace('_', ' ', $role->name)) }}</span></h6>
                                @elseif($role->name === 'admin')
                                    <h6 class="mb-2"><span class="badge bg-warning fs-6">⚙️ {{ ucfirst(str_replace('_', ' ', $role->name)) }}</span></h6>
                                @elseif(strpos($role->name, 'client') !== false)
                                    <h6 class="mb-2"><span class="badge bg-info fs-6">🔐 {{ ucfirst(str_replace('_', ' ', $role->name)) }}</span></h6>
                                @else
                                    <h6 class="mb-2"><span class="badge bg-secondary fs-6">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span></h6>
                                @endif
                                <p class="text-muted mb-0">{{ $role->users()->count() }} users assigned to this role</p>
                            </div>
                        </div>

                        <!-- Role Permissions -->
                        @if($role->permissions->isNotEmpty())
                        <div class="mt-3">
                            <p class="mb-2"><strong>Permissions ({{ count($role->permissions) }})</strong></p>
                            <div class="row">
                                @foreach($role->permissions as $permission)
                                <div class="col-md-6 mb-2">
                                    <small>
                                        <i class="fas fa-check-circle text-success"></i>
                                        {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                    </small>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @empty
                    <p class="text-muted">No role assigned to this user yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Account Timeline -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Account Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Account Created:</strong></p>
                            <p class="text-muted">
                                {{ $user->created_at->format('l, F j, Y \a\t g:i A') }}
                                <br>
                                <small>({{ $user->created_at->diffForHumans() }})</small>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Last Updated:</strong></p>
                            <p class="text-muted">
                                {{ $user->updated_at->format('l, F j, Y \a\t g:i A') }}
                                <br>
                                <small>({{ $user->updated_at->diffForHumans() }})</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            @if(auth()->user()->id !== $user->id && !$user->hasRole('super_admin'))
            <div class="card border-danger shadow-sm mt-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Danger Zone</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Deleting this user is a permanent action and cannot be undone.</p>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg" 
                            onclick="return confirm('Are you absolutely sure you want to delete this user?\n\nThis action cannot be undone.');">
                            <i class="fas fa-trash"></i> Delete This User
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
