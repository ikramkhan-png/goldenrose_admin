@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Attendance</h2>
    <a href="{{ route('admin.attendance.create') }}" class="btn btn-success mb-2">Add Attendance</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Employee</th>
            <th>Date</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Actions</th>
        </tr>
        @foreach($attendances as $att)
        <tr>
            <td>{{ $att->employee->name }}</td>
            <td>{{ $att->date }}</td>
            <td>{{ $att->check_in ?? '-' }}</td>
            <td>{{ $att->check_out ?? '-' }}</td>
            <td>
                <a href="{{ route('admin.attendance.edit', $att->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('admin.attendance.destroy', $att->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection