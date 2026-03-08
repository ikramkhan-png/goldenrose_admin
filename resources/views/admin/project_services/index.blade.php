@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Project Services</h2>
    <a href="{{ route('admin.project-services.create') }}" class="btn btn-primary mb-3">Add Service</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Project</th>
                <th>Service Type</th>
                <th>Service</th>
                <th>Rate Type</th>
                <th>Duration</th>
                <th>Rate</th>
                <th>Total Cost</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projectServices as $ps)
            <tr>
                <td>{{ $ps->id }}</td>
                <td>{{ $ps->project->name }}</td>
                <td>{{ class_basename($ps->service_type) }}</td>
                <td>{{ $ps->service->name ?? '-' }}</td>
                <td>
                    @if($ps->hours) Hourly
                    @elseif($ps->days) Daily
                    @elseif($ps->months) Monthly
                    @endif
                </td>
                <td>
                    {{ $ps->hours ?? $ps->days ?? $ps->months }}
                </td>
                <td>
                    {{ $ps->hourly_rate ?? $ps->daily_rate ?? $ps->monthly_rate }}
                </td>
                <td>{{ $ps->total_cost }}</td>
                <td>
                    <a href="{{ route('admin.project-services.edit', $ps->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.project-services.destroy', $ps->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection