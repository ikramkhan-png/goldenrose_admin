@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('admin.advances') }}</h4>
            <p class="page-subtitle">{{ __('admin.salary_management_subtitle') }}</p>
        </div>
        <a href="{{ route('admin.advances.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>{{ __('admin.add_advance') }}
        </a>
    </div>

    {{-- TABS --}}
    <div class="payroll-tabs">
        <a href="{{ route('admin.salaries.index') }}" class="payroll-tab">
            <i class="fas fa-money-check-alt me-1"></i>{{ __('admin.salaries') }}
        </a>
        <a href="{{ route('admin.salaries.index') }}?tab=attendance" class="payroll-tab">
            <i class="fas fa-calendar-check me-1"></i>{{ __('admin.attendance') }}
        </a>
        <a href="{{ route('admin.advances.index') }}" class="payroll-tab active">
            <i class="fas fa-hand-holding-usd me-1"></i>{{ __('admin.advances') }}
        </a>
        <a href="{{ route('admin.overtimes.index') }}" class="payroll-tab">
            <i class="fas fa-clock me-1"></i>{{ __('admin.overtime') }}
        </a>
        <a href="{{ route('admin.employee-expenses.index') }}" class="payroll-tab">
            <i class="fas fa-receipt me-1"></i>{{ __('admin.employee_expenses') }}
        </a>
    </div>

    {{-- FILTERS --}}
    <div class="card mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.advances.index') }}" class="d-flex align-items-end gap-3 flex-wrap">
                <div style="flex: 1; min-width: 200px;">
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
                <div style="flex: 1; min-width: 180px;">
                    <label class="form-label">{{ __('admin.month') }}</label>
                    <input type="month" name="month" value="{{ request('month') }}" class="form-control">
                </div>
                <div class="d-flex gap-2 align-items-end" style="padding-bottom: 0;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>{{ __('admin.filter') }}
                    </button>
                    <a href="{{ route('admin.advances.index') }}" class="btn btn-secondary">
                        {{ __('admin.reset') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert p-3 mb-4" style="background: #f0fdf4; color: #166534; border: none; border-left: 4px solid #22c55e; border-radius: 8px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if($advances->count())
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-styled mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('admin.employee') }}</th>
                                <th>{{ __('admin.amount') }}</th>
                                <th>{{ __('admin.date') }}</th>
                                <th>{{ __('admin.notes') }}</th>
                                <th class="td-center">{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($advances as $adv)
                            <tr>
                                <td class="td-name">{{ $adv->employee?->name ?? '-' }}</td>
                                <td class="td-neg">{{ number_format($adv->amount, 2) }}</td>
                                <td class="td-accent">{{ $adv->date }}</td>
                                <td class="td-muted">{{ $adv->notes ?? '-' }}</td>
                                <td class="td-center">
                                    <a href="{{ route('admin.advances.edit', $adv->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit me-1"></i>{{ __('admin.edit') }}
                                    </a>
                                    <form action="{{ route('admin.advances.destroy', $adv->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('{{ __('admin.confirm_delete') }}')">
                                            <i class="fas fa-trash me-1"></i>{{ __('admin.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-3">{{ $advances->links() }}</div>
    @else
        <div class="info-box">
            <i class="fas fa-info-circle me-2"></i>
            <strong>{{ __('admin.no_data_available') }}</strong>
        </div>
    @endif

</div>
@endsection
