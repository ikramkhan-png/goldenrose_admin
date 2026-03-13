@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2>📦 {{ __('admin.project_expenses') }}</h2>
            <small class="text-muted">{{ __('admin.project_expenses_subtitle') }}</small>
        </div>
        <a href="{{ route('admin.expenses.create') }}" class="btn btn-success">{{ __('admin.add_project_expense') }}</a>
    </div>

    <div class="alert alert-info mb-3">
        <i class="fas fa-info-circle"></i>
        <strong>{{ __('admin.note') }}:</strong>
        {{ __('admin.project_expenses_note') }}
        <a href="{{ route('admin.employee-expenses.index') }}" class="alert-link">{{ __('admin.employee_expenses') }}</a>.
    </div>

    {{-- FILTERS --}}
    <form method="GET" action="{{ route('admin.expenses.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <label class="form-label">{{ __('admin.project') }}</label>
            <input type="text" name="project_id" value="{{ request('project_id') }}" class="form-control" placeholder="{{ __('admin.project_id_or_empty') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">{{ __('admin.month') }}</label>
            <input type="month" name="month" value="{{ request('month') }}" class="form-control">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">{{ __('admin.filter') }}</button>
            <a href="{{ route('admin.expenses.index') }}" class="btn btn-secondary">{{ __('admin.reset') }}</a>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($expenses->count())
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>{{ __('admin.project') }}</th>
                <th>{{ __('admin.category') }}</th>
                <th>{{ __('admin.amount') }}</th>
                <th>{{ __('admin.date') }}</th>
                <th>{{ __('admin.description') }}</th>
                <th>{{ __('admin.invoice') }}</th>
                <th>{{ __('admin.actions') }}</th>
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
                            <i class="fas fa-eye"></i> {{ __('admin.view') }}
                        </a>
                    @else
                        -
                    @endif
                </td>
                <td class="d-flex gap-2">
                    <a href="{{ route('admin.expenses.edit', $exp->id) }}" class="btn btn-primary btn-sm">{{ __('admin.edit') }}</a>

                    <form action="{{ route('admin.expenses.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_delete_record') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">{{ __('admin.delete') }}</button>
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
        <p class="text-muted">{{ __('admin.no_project_expenses_found') }}</p>
    @endif
</div>
@endsection