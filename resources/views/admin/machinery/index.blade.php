@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Machinery List</h1>
    <a href="{{ route('admin.machinery.create') }}" class="btn btn-primary mb-3">Add New Machinery</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Model</th>
                <th>Number Plate</th>
                <th>Hourly Rate</th>
                <th>Daily Rate</th>
                <th>Monthly Rate</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($machineries as $machinery)
                <tr>
                    <td>{{ $machinery->id }}</td>
                    <td>{{ $machinery->name }}</td>
                    <td>{{ $machinery->model ?? '-' }}</td>
                    <td>{{ $machinery->number_plate ?? '-' }}</td>
                    <td>{{ $machinery->hourly_rate }}</td>
                    <td>{{ $machinery->daily_rate }}</td>
                    <td>{{ $machinery->monthly_rate }}</td>
                    <td>{{ ucfirst($machinery->status) }}</td>
                    <td>
                        <a href="{{ route('admin.machinery.edit', $machinery->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.machinery.destroy', $machinery->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No machinery found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection