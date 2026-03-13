@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ __('admin.advances') }}</h2>
        <a href="{{ route('admin.advances.create') }}" class="btn btn-success">{{ __('admin.add_advance') }}</a>
    </div>
    <!-- 🔹 Header Tabs -->
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.salaries.index') }}">{{ __('admin.salaries') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.advances.index') }}">{{ __('admin.advances') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.overtimes.index') }}">{{ __('admin.overtime') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.expenses.index') }}">{{ __('admin.project_expenses') }}</a>
        </li>
    </ul>

    {{-- FILTERS --}}
    <form method="GET" action="{{ route('admin.advances.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <label class="form-label">{{ __('admin.employee') }}</label>
            <select name="employee_id" class="form-select">
                <option value="">{{ __('admin.all_employees') }}</option>
                @foreach($employees ?? [] as $emp)
                    <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                        {{ $emp->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">{{ __('admin.month') }}</label>
            <input type="month" name="month" value="{{ request('month') }}" class="form-control">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">{{ __('admin.filter') }}</button>
            <a href="{{ route('admin.advances.index') }}" class="btn btn-secondary">{{ __('admin.reset') }}</a>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($advances->count())
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>{{ __('admin.employee') }}</th>
                <th>{{ __('admin.amount') }}</th>
                <th>{{ __('admin.date') }}</th>
                <th>{{ __('admin.notes') }}</th>
                <th>{{ __('admin.actions') }}</th>
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
                    <a href="{{ route('admin.advances.edit', $adv->id) }}" class="btn btn-primary btn-sm">{{ __('admin.edit') }}</a>

                    <form action="{{ route('admin.advances.destroy', $adv->id) }}" method="POST" onsubmit="return confirm('{{ __('admin.confirm_delete_record') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">{{ __('admin.delete') }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $advances->links() }}
    @else
        <p class="text-muted">{{ __('admin.no_advances_found') }}</p>
    @endif
</div>
@endsection