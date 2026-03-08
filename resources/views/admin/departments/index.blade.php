@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Departments</h2>
    <a href="{{ route('admin.departments.create') }}" class="btn btn-success mb-2">Add Department</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        @foreach($departments as $dep)
        <tr>
            <td>{{ $dep->name }}</td>
            <td>{{ $dep->description }}</td>
            <td>
                <a href="{{ route('admin.departments.edit', $dep->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('admin.departments.destroy', $dep->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection