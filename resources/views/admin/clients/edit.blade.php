@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Edit Client</h4>

    <form action="{{ route('admin.clients.update', $client) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $client->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Client Type</label>
            <select name="client_type" class="form-control" required>
                <option value="">Select Client Type</option>
                <option value="service" {{ old('client_type', $client->client_type) == 'service' ? 'selected' : '' }}>Service Client</option>
                <option value="project" {{ old('client_type', $client->client_type) == 'project' ? 'selected' : '' }}>Project Client</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">New Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button class="btn btn-primary">Update Client</button>
        <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection