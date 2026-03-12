@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2>📦 Project Expenses</h2>
            <small class="text-muted">Track project-related costs (labor, materials, equipment)</small>
        </div>
        <a href="{{ route('admin.expenses.create') }}" class="btn btn-success">Add Project Expense</a>
    </div>

    <div class="alert alert-info mb-3">
        <i class="fas fa-info-circle"></i> <strong>Note:</strong> These are project expenses. For employee expenses (salary-related), go to 
        <a href="{{ route('admin.employee-expenses.index') }}" class="alert-link">Employee Expenses</a>.
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($expenses->count())
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Project</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Description</th>
                <th>Invoice</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $exp)
            <tr>
                <td>{{ $exp->project?->name ?? '-' }}</td>
                <td><span class="badge bg-secondary">{{ ucfirst($exp->category ?? 'Other') }}</span></td>
                <td>{{ number_format($exp->amount, 2) }}</td>
                <td>{{ $exp->date }}</td>
                <td>{{ Str::limit($exp->description, 40) ?? '-' }}</td>
                <td>
                    @if($exp->invoice)
                        <a href="{{ asset('storage/'.$exp->invoice) }}" target="_blank" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-eye"></i> View
                        </a>
                    @else
                        -
                    @endif
                </td>
                <td class="d-flex gap-2">
                    <a href="{{ route('admin.expenses.edit', $exp->id) }}" class="btn btn-primary btn-sm">Edit</a>

                    <form action="{{ route('admin.expenses.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="d-flex justify-content-center">
        {{ $expenses->links() }}
    </div>
    @else
        <p class="text-muted">No project expenses found.</p>
    @endif
</div>
@endsection