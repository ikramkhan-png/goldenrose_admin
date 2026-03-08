@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Overtime</h2>
        <a href="{{ route('admin.overtimes.create') }}" class="btn btn-success">Add Overtime</a>
    </div>
     <!-- 🔹 Header Tabs -->
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.salaries.index') }}">Salaries</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.advances.index') }}">Advances</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.overtimes.index') }}">Overtime</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.expenses.index') }}">Expenses</a>
        </li>
    </ul>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($overtimes->count())
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Employee</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($overtimes as $ot)
            <tr>
                <td>{{ $ot->employee?->name ?? '-' }}</td>
                <td>{{ $ot->amount }}</td>
                <td>{{ $ot->date }}</td>
                <td>{{ $ot->notes ?? '-' }}</td>
                <td class="d-flex gap-2">
                    <a href="{{ route('admin.overtimes.edit', $ot->id) }}" class="btn btn-primary btn-sm">Edit</a>

                    <form action="{{ route('admin.overtimes.destroy', $ot->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
        <p class="text-muted">No overtime records found.</p>
    @endif
</div>
@endsection