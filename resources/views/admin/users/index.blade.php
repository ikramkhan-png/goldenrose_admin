@extends('admin.layouts.app')

@section('content')
<div class="container-fluid mt-4 px-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="fw-bold mb-2"><i class="fas fa-users"></i> User Management</h1>
            <p class="text-muted">Manage all system users, roles, and permissions</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-user-plus"></i> Create New User
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-exclamation-circle"></i> Errors:</strong>
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
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Total Users</h6>
                    <h2 class="text-primary fw-bold">{{ \App\Models\User::count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Admin Users</h6>
                    <h2 class="text-danger fw-bold">{{ \App\Models\User::where('type', 'admin')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Client Users</h6>
                    <h2 class="text-info fw-bold">{{ \App\Models\User::where('type', 'client')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Employees</h6>
                    <h2 class="text-secondary fw-bold">{{ \App\Models\User::where('type', 'employee')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0"><i class="fas fa-list"></i> All Users ({{ $users->total() }})</h5>
        </div>
        <div class="card-body p-0">
            @if($users->isEmpty())
            <div class="p-5 text-center">
                <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">No users registered yet. <a href="{{ route('admin.users.create') }}">Create the first user</a></p>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Role</th>
                            <th>Joined</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4">
                                <strong>{{ $user->name }}</strong>
                                @if(auth()->user()->id === $user->id)
                                <span class="badge bg-warning ms-2">You</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $user->email }}</small>
                            </td>
                            <td>
                                <small>{{ $user->phone ?? '-' }}</small>
                            </td>
                            <td>
                                @if($user->type === 'admin')
                                    <span class="badge bg-danger">👑 {{ ucfirst($user->type) }}</span>
                                @elseif($user->type === 'client')
                                    <span class="badge bg-info">👤 {{ ucfirst($user->type) }}</span>
                                @else
                                    <span class="badge bg-secondary">👷 {{ ucfirst($user->type) }}</span>
                                @endif
                            </td>
                            <td>
                                @forelse($user->roles as $role)
                                    @if($role->name === 'super_admin')
                                        <span class="badge bg-danger">{{ str_replace('_', ' ', ucfirst($role->name)) }}</span>
                                    @elseif($role->name === 'admin')
                                        <span class="badge bg-warning text-dark">{{ str_replace('_', ' ', ucfirst($role->name)) }}</span>
                                    @elseif(strpos($role->name, 'client') !== false)
                                        <span class="badge bg-info">{{ str_replace('_', ' ', ucfirst($role->name)) }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ str_replace('_', ' ', ucfirst($role->name)) }}</span>
                                    @endif
                                @empty
                                    <span class="badge bg-light text-dark">No role</span>
                                @endforelse
                            </td>
                            <td>
                                <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(auth()->user()->id !== $user->id && !$user->hasRole('super_admin'))
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
    @endif
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.01);
    }
</style>
@endsection
