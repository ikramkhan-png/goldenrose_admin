@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Client Projects</h4>
        <a href="{{ route('admin.client-projects.create') }}" class="btn btn-primary">+ Assign Project</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Project Name</th>
                <th>Status</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th width="140">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $project->client->name ?? '-' }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ ucfirst(str_replace('_',' ',$project->status)) }}</td>
                    <td>{{ $project->start_date ?? '-' }}</td>
                    <td>{{ $project->end_date ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.client-projects.edit', $project) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.client-projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No projects assigned yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection