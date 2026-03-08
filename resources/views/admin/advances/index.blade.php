@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Advances</h2>
        <a href="{{ route('admin.advances.create') }}" class="btn btn-success">Add Advance</a>
    </div>
    <!-- 🔹 Header Tabs -->
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.salaries.index') }}">Salaries</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.advances.index') }}">Advances</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.overtimes.index') }}">Overtime</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.expenses.index') }}">Expenses</a>
        </li>
    </ul>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($advances->count())
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
            @foreach($advances as $adv)
            <tr>
                <td>{{ $adv->employee?->name ?? '-' }}</td>
                <td>{{ $adv->amount }}</td>
                <td>{{ $adv->date }}</td>
                <td>{{ $adv->notes ?? '-' }}</td>
                <td class="d-flex gap-2">
                    <a href="{{ route('admin.advances.edit', $adv->id) }}" class="btn btn-primary btn-sm">Edit</a>

                    <form action="{{ route('admin.advances.destroy', $adv->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
        <p class="text-muted">No advances found.</p>
    @endif
</div>
@endsection