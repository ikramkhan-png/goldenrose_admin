@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Add New Client</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.clients.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Client Type</label>
            <select name="client_type" class="form-control" required>
                <option value="">Select Client Type</option>
                <option value="service" {{ old('client_type') == 'service' ? 'selected' : '' }}>Service Client</option>
                <option value="project" {{ old('client_type') == 'project' ? 'selected' : '' }}>Project Client</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-primary">Create Client</button>
        <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection