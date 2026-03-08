@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Profile Header -->
    <div class="mb-4">
        <h2 class="mb-2">👤 My Profile</h2>
        <p class="text-muted">View and manage your account information</p>
    </div>

    <!-- Profile Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Full Name</label>
                            <p class="form-control-plaintext h5">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Email Address</label>
                            <p class="form-control-plaintext h5">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">User Type</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-primary">{{ ucfirst($user->type ?? 'user') }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Member Since</label>
                            <p class="form-control-plaintext">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    @if ($user->roles && $user->roles->count() > 0)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label text-muted small">Assigned Roles</label>
                            <p class="form-control-plaintext">
                                @foreach ($user->roles as $role)
                                    <span class="badge bg-success me-2">{{ ucfirst($role->name) }}</span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                    @endif

                    <hr>

                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle"></i> <strong>Note:</strong> 
                        To update your profile information or change password, please contact your system administrator.
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0">Account Status</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Status</label>
                        <p class="mb-0"><span class="badge bg-success">Active</span></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Last Login</label>
                        <p class="mb-0">{{ $user->updated_at ? $user->updated_at->diffForHumans() : 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-muted small">Email Status</label>
                        <p class="mb-0">
                            @if ($user->email_verified_at)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-warning">Not Verified</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0">Account Actions</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm w-100 mb-2">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline-block w-100">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
