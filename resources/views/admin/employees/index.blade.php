@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('employees.employees') }}</h4>
            <p class="page-subtitle">{{ __('employees.employees_description') }}</p>
        </div>
        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>{{ __('employees.add_employee') }}
        </a>
    </div>

    {{-- MONTH FILTER --}}
    <div class="card mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.employees.index') }}" method="GET" class="d-flex align-items-end gap-3 flex-wrap">
                <div style="flex: 1; min-width: 220px;">
                    <label class="form-label">
                        <i class="fas fa-calendar-alt me-1" style="color: #4f46e5;"></i>{{ __('admin.filter_by_month') }}
                    </label>
                    <input type="month" name="month" class="form-control"
                           value="{{ request('month', now()->format('Y-m')) }}"
                           onchange="this.form.submit()">
                </div>
                <div style="flex: 1; min-width: 180px;">
                    <label class="form-label">
                        <i class="fas fa-filter me-1" style="color: #4f46e5;"></i>{{ __('admin.filter') }}
                    </label>
                    <div class="filter-display">
                        {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('All Data') }}
                    </div>
                </div>
                @if(request('month'))
                <div style="min-width: 110px;">
                    <label class="form-label">&nbsp;</label>
                    <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-times me-1"></i>{{ __('Show All') }}
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="p-3 mb-4" style="background: #f0fdf4; color: #166534; border-left: 4px solid #22c55e; border-radius: 8px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if ($employees->count())
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-styled mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('employees.name') }}</th>
                                <th>{{ __('employees.phone') }}</th>
                                <th class="td-right">{{ __('employees.basic_salary') }}</th>
                                <th class="td-right">{{ __('employees.daily_wage') }}</th>
                                <th>{{ __('employees.department') }}</th>
                                <th>{{ __('admin.hiring_date') }}</th>
                                <th class="td-center">{{ __('employees.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $emp)
                                <tr>
                                    <td class="td-name">{{ $emp->name }}</td>
                                    <td>{{ $emp->phone }}</td>
                                    <td class="td-right">{{ number_format($emp->basic_salary, 0) }}</td>
                                    <td class="td-right td-muted">{{ number_format($emp->daily_wage, 2) }}</td>
                                    <td>{{ $emp->department?->name ?? '-' }}</td>
                                    <td class="td-muted">{{ $emp->hiring_date ?? '-' }}</td>
                                    <td class="td-center">
                                        <a href="{{ route('admin.employees.edit', $emp->id) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit me-1"></i>{{ __('employees.edit') }}
                                        </a>
                                        <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('{{ __('employees.confirm_delete') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash me-1"></i>{{ __('employees.delete') }}
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
    @else
        <div class="info-box">
            <i class="fas fa-info-circle me-2"></i>{{ __('employees.no_employees') }}
        </div>
    @endif

</div>
@endsection
