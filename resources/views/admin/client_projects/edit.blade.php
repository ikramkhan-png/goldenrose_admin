@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Edit Project</h4>

    <form action="{{ route('admin.client-projects.update', $clientProject) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Client</label>
            <select name="client_id" class="form-control" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" @selected($clientProject->client_id == $client->id)>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Project Name</label>
            <input type="text" name="name" class="form-control" value="{{ $clientProject->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="pending" @selected($clientProject->status=='pending')>Pending</option>
                <option value="in_progress" @selected($clientProject->status=='in_progress')>In Progress</option>
                <option value="completed" @selected($clientProject->status=='completed')>Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ $clientProject->start_date }}">
        </div>

        <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ $clientProject->end_date }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $clientProject->description }}</textarea>
        </div>

        <button class="btn btn-primary">Update Project</button>
        <a href="{{ route('admin.client-projects.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection