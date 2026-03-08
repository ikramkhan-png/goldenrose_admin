@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Projects</h4>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">+ Add Project</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Project Name</th>
                <th>Client</th>
                <th>Type</th>
                <th>Budget</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th width="160">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->client?->name ?? '-' }}</td>
                    <td>{{ ucfirst($project->type) }}</td>
                    <td>{{ $project->budget ? number_format($project->budget, 2) : '-' }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No projects found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection