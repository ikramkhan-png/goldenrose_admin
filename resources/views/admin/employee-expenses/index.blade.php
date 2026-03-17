@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('admin.employee_expenses_title') }}</h4>
            <p class="page-subtitle">{{ __('admin.employee_expenses_subtitle') }}</p>
        </div>
        <a href="{{ route('admin.employee-expenses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>{{ __('admin.add_employee_expense') }}
        </a>
    </div>

    {{-- TABS --}}
    <div class="payroll-tabs">
        <a href="{{ route('admin.salaries.index') }}" class="payroll-tab">
            <i class="fas fa-money-check-alt me-1"></i>{{ __('projects.salaries') }}
        </a>
        <a href="{{ route('admin.salaries.index') }}?tab=attendance" class="payroll-tab">
            <i class="fas fa-calendar-check me-1"></i>{{ __('projects.attendance') }}
        </a>
        <a href="{{ route('admin.advances.index') }}" class="payroll-tab">
            <i class="fas fa-hand-holding-usd me-1"></i>{{ __('projects.advances') }}
        </a>
        <a href="{{ route('admin.overtimes.index') }}" class="payroll-tab">
            <i class="fas fa-clock me-1"></i>{{ __('projects.overtime') }}
        </a>
        <a href="{{ route('admin.employee-expenses.index') }}" class="payroll-tab active">
            <i class="fas fa-receipt me-1"></i>{{ __('admin.employee_expenses_title') }}
        </a>
    </div>

    {{-- FILTER CARD --}}
    <div class="card mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.employee-expenses.index') }}" method="GET" class="d-flex align-items-end gap-3 flex-wrap">
                <div style="flex: 1; min-width: 220px;">
                    <label class="form-label">
                        <i class="fas fa-user me-1" style="color: #4f46e5;"></i>{{ __('admin.filter_by_employee') }}
                    </label>
                    <select name="employee_id" class="form-select" onchange="this.form.submit()">
                        <option value="">{{ __('admin.all_employees') }}</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="flex: 1; min-width: 180px;">
                    <label class="form-label">
                        <i class="fas fa-calendar-alt me-1" style="color: #4f46e5;"></i>{{ __('admin.month') }}
                    </label>
                    <input type="month" name="month" class="form-control"
                           value="{{ request('month') }}" onchange="this.form.submit()">
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-dismissible fade show p-3 mb-4" role="alert"
            style="background: #f0fdf4; color: #166534; border: none; border-left: 4px solid #22c55e; border-radius: 8px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-styled mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('admin.employee') }}</th>
                            <th class="td-right">{{ __('admin.amount') }}</th>
                            <th>{{ __('admin.date') }}</th>
                            <th>{{ __('admin.description') }}</th>
                            <th class="td-center">{{ __('admin.invoice') }}</th>
                            <th class="td-center">{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                        <tr>
                            <td class="td-muted">{{ $loop->iteration }}</td>
                            <td class="td-name">{{ $expense->employee->name ?? '-' }}</td>
                            <td class="td-right td-warn">+{{ number_format($expense->amount, 2) }}</td>
                            <td class="td-accent">{{ $expense->date }}</td>
                            <td class="td-muted">{{ Str::limit($expense->description, 50) }}</td>
                            <td class="td-center">
                                @if($expense->invoice)
                                    <a href="{{ asset('storage/'.$expense->invoice) }}" target="_blank"
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye me-1"></i>{{ __('admin.view') }}
                                    </a>
                                @else
                                    <span class="td-muted">-</span>
                                @endif
                            </td>
                            <td class="td-center">
                                <a href="{{ route('admin.employee-expenses.edit', $expense) }}"
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit me-1"></i>{{ __('admin.edit') }}
                                </a>
                                <form action="{{ route('admin.employee-expenses.destroy', $expense) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('{{ __('admin.confirm_delete_record') }}')">
                                        <i class="fas fa-trash me-1"></i>{{ __('admin.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 td-muted">
                                <i class="fas fa-inbox" style="font-size: 28px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                                {{ __('admin.no_expenses_recorded') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-info-footer">
            <i class="fas fa-list me-1"></i>{{ __('admin.total_records') }}: <strong>{{ $expenses->total() }}</strong>
        </div>
    </div>

    <div class="mt-3">{{ $expenses->links() }}</div>

</div>
@endsection
