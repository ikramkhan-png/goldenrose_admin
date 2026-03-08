@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Project</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Project Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $project->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Client</label>
            <select name="client_id" class="form-control" required>
                <option value="">Select Client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id', $project->client_id) == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Project Type</label>
            <select name="type" class="form-control" required>
                <option value="one-time" {{ old('type', $project->type) == 'one-time' ? 'selected' : '' }}>One Time</option>
                <option value="monthly"  {{ old('type', $project->type) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="yearly"   {{ old('type', $project->type) == 'yearly' ? 'selected' : '' }}>Yearly</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Budget</label>
            <input type="number" name="budget" step="0.01" class="form-control" value="{{ old('budget', $project->budget) }}" placeholder="Enter project budget">
        </div>

        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $project->start_date) }}" required>
        </div>

        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $project->end_date) }}">
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control">{{ old('notes', $project->notes) }}</textarea>
        </div>

        <button class="btn btn-primary">Update Project</button>
    </form>
</div>
@endsection