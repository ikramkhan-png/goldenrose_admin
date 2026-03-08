@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Manpower List</h1>
    <a href="{{ route('admin.manpower.create') }}" class="btn btn-primary mb-3">Add New Manpower</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Hourly Rate</th>
                <th>Daily Rate</th>
                <th>Monthly Rate</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($manpowers as $manpower)
                <tr>
                    <td>{{ $manpower->id }}</td>
                    <td>{{ $manpower->name }}</td>
                    <td>{{ $manpower->hourly_rate }}</td>
                    <td>{{ $manpower->daily_rate }}</td>
                    <td>{{ $manpower->monthly_rate }}</td>
                    <td>{{ ucfirst($manpower->status) }}</td>
                    <td>
                        <a href="{{ route('admin.manpower.edit', $manpower->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.manpower.destroy', $manpower->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No manpower found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection