@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <x-page-header title="Employees" description="Manage company employees and payroll details." />
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Employees</h2>
        <a href="{{ route('admin.employees.create') }}" class="btn btn-success">Add Employee</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($employees->count())
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Basic Salary</th>
                <th>Daily Wage</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $emp)
            <tr>
                <td>{{ $emp->name }}</td>
                <td>{{ $emp->phone }}</td>
                <td>{{ $emp->basic_salary }}</td>
                <td>{{ $emp->daily_wage }}</td>
                <td>{{ $emp->department?->name ?? '-' }}</td>
                <td class="d-flex gap-2">
                    <a href="{{ route('admin.employees.edit', $emp->id) }}" class="btn btn-primary btn-sm">Edit</a>

                    <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p class="text-muted">No employees found.</p>
    @endif
</div>
@endsection