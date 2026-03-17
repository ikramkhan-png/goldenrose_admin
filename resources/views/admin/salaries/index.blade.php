@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('admin.salary_management') }}</h4>
            <p class="page-subtitle">{{ __('admin.salary_management_subtitle') }}</p>
        </div>
        <form action="{{ route('admin.salaries.export-pdf') }}" method="GET">
            <input type="hidden" name="month" value="{{ request('month', now()->format('Y-m')) }}">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-download me-1"></i> {{ __('admin.export_pdf') }}
            </button>
        </form>
    </div>

    {{-- FILTER CARD --}}
    <div class="card mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.salaries.index') }}" method="GET" class="d-flex align-items-end gap-3 flex-wrap">
                <div style="flex: 1; min-width: 220px;">
                    <label class="form-label">
                        <i class="fas fa-calendar-alt me-1" style="color: #4f46e5;"></i>{{ __('admin.select_month') }}
                    </label>
                    <input type="month" name="month" class="form-control"
                           value="{{ request('month', now()->format('Y-m')) }}"
                           onchange="this.form.submit()">
                </div>
                <div style="flex: 1; min-width: 180px;">
                    <label class="form-label">
                        <i class="fas fa-filter me-1" style="color: #4f46e5;"></i>{{ __('admin.period') }}
                    </label>
                    <div class="filter-display">
                        {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('All Data') }}
                    </div>
                </div>
                @if(request('month'))
                <div style="min-width: 110px;">
                    <label class="form-label">&nbsp;</label>
                    <a href="{{ route('admin.salaries.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-times me-1"></i>{{ __('Show All') }}
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- TABS --}}
    @php $tab = request('tab', 'salaries'); @endphp
    <div class="payroll-tabs">
        <a href="{{ route('admin.salaries.index') }}?tab=salaries" class="payroll-tab {{ $tab === 'salaries' ? 'active' : '' }}">
            <i class="fas fa-money-check-alt me-1"></i>{{ __('admin.salaries') }}
        </a>
        <a href="{{ route('admin.salaries.index') }}?tab=attendance" class="payroll-tab {{ $tab === 'attendance' ? 'active' : '' }}">
            <i class="fas fa-calendar-check me-1"></i>{{ __('admin.attendance') }}
        </a>
        <a href="{{ route('admin.advances.index') }}" class="payroll-tab">
            <i class="fas fa-hand-holding-usd me-1"></i>{{ __('admin.advances') }}
        </a>
        <a href="{{ route('admin.overtimes.index') }}" class="payroll-tab">
            <i class="fas fa-clock me-1"></i>{{ __('admin.overtime') }}
        </a>
        <a href="{{ route('admin.employee-expenses.index') }}" class="payroll-tab">
            <i class="fas fa-receipt me-1"></i>{{ __('admin.employee_expenses') }}
        </a>
    </div>

    {{-- ═══ SALARIES TAB ═══ --}}
    @if($tab === 'salaries')
        @if($salaries && count($salaries) > 0)
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-styled mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.employee') }}</th>
                                    <th class="td-center">{{ __('admin.days') }}</th>
                                    <th class="td-right">{{ __('admin.basic_salary_short') }}</th>
                                    <th class="td-right">{{ __('admin.daily_rate') }}</th>
                                    <th class="td-right">+ {{ __('admin.overtime_short') }}</th>
                                    <th class="td-right">- {{ __('admin.advance_short') }}</th>
                                    <th class="td-right">+ {{ __('admin.expense_short') }}</th>
                                    <th class="td-right">{{ __('admin.total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalFinal = 0; @endphp
                                @foreach($salaries as $sal)
                                <tr>
                                    <td class="td-name">{{ $sal['employee_name'] }}</td>
                                    <td class="td-center td-accent">{{ $sal['working_days'] }}</td>
                                    <td class="td-right td-muted">{{ number_format($sal['basic_salary'], 0) }}</td>
                                    <td class="td-right td-muted">{{ number_format($sal['daily_wage'], 2) }}</td>
                                    <td class="td-right td-pos">+{{ number_format($sal['overtime_total'], 0) }}</td>
                                    <td class="td-right td-neg">-{{ number_format($sal['advance_total'], 0) }}</td>
                                    <td class="td-right td-warn">+{{ number_format($sal['expenses_total'], 0) }}</td>
                                    <td class="td-right td-total">{{ number_format($sal['final_salary'], 0) }}</td>
                                </tr>
                                @php $totalFinal += $sal['final_salary']; @endphp
                                @endforeach
                                <tr class="table-totals-row">
                                    <td colspan="7" class="td-right">{{ __('admin.total_payroll') }}:</td>
                                    <td class="td-right td-accent">{{ number_format($totalFinal, 0) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-info-footer">
                    <i class="fas fa-users me-1"></i>{{ __('admin.total_employees') }}: <strong>{{ count($salaries) }}</strong>
                    &nbsp;·&nbsp;
                    <i class="fas fa-calendar me-1"></i>{{ __('admin.generated_at') }}: <strong>{{ now()->format('M d, Y') }}</strong>
                </div>
            </div>
        @else
            <div class="info-box">
                <i class="fas fa-info-circle me-2"></i>
                <strong>{{ __('admin.no_data_available') }}</strong>
                {{ request('month') ? __('admin.for_period', ['period' => $selectedMonth->format('F Y')]) : '' }}
            </div>
        @endif
    @endif

    {{-- ═══ ATTENDANCE TAB ═══ --}}
    @if($tab === 'attendance')
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="page-title mb-0">{{ __('admin.attendance_records') }}</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.attendance.create') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>{{ __('admin.add_single') }}
                </a>
                <button type="button" class="btn btn-primary btn-sm"
                    onclick="var f=document.getElementById('bulkForm'); f.style.display=f.style.display==='none'?'block':'none'">
                    <i class="fas fa-layer-group me-1"></i>{{ __('admin.add_bulk') }}
                </button>
            </div>
        </div>

        {{-- Bulk Form --}}
        <div id="bulkForm" style="display: none;" class="bulk-form-panel mb-4">
            <h6 style="font-size: 14px; font-weight: 700; color: #4f46e5; margin-bottom: 14px;">
                <i class="fas fa-bolt me-1"></i>{{ __('admin.quick_bulk_entry') }}
            </h6>
            <form action="{{ route('admin.attendance.bulk-store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">{{ __('admin.employee') }}</label>
                        <select name="employee_id" class="form-select" required>
                            <option value="">{{ __('admin.select_option') }}</option>
                            @foreach($employees ?? [] as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('admin.month') }}</label>
                        <input type="month" name="month" class="form-control"
                               value="{{ request('month', now()->format('Y-m')) }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('admin.days') }}</label>
                        <input type="number" name="num_days" class="form-control" min="1" max="31" placeholder="20" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('admin.check_in') }}</label>
                        <input type="time" name="check_in" class="form-control" value="09:00" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('admin.check_out') }}</label>
                        <input type="time" name="check_out" class="form-control" value="18:00" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-check me-1"></i>{{ __('admin.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Attendance Table --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-styled mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('admin.employee') }}</th>
                                <th>{{ __('admin.date') }}</th>
                                <th class="td-center">{{ __('admin.check_in') }}</th>
                                <th class="td-center">{{ __('admin.check_out') }}</th>
                                <th class="td-center">{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances ?? [] as $attendance)
                            <tr>
                                <td class="td-muted">{{ $loop->iteration }}</td>
                                <td class="td-name">{{ $attendance->employee->name ?? '-' }}</td>
                                <td class="td-accent">{{ $attendance->date }}</td>
                                <td class="td-center td-pos">{{ $attendance->check_in ?? '-' }}</td>
                                <td class="td-center td-neg">{{ $attendance->check_out ?? '-' }}</td>
                                <td class="td-center">
                                    <a href="{{ route('admin.attendance.edit', $attendance) }}"
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-edit me-1"></i>{{ __('admin.edit') }}
                                    </a>
                                    <form action="{{ route('admin.attendance.destroy', $attendance) }}" method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('{{ __('admin.confirm_delete_record') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">
                                            <i class="fas fa-trash me-1"></i>{{ __('admin.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 td-muted">
                                    <i class="fas fa-inbox" style="font-size: 28px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                                    {{ __('admin.no_attendance_records') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-info-footer">
                <i class="fas fa-list me-1"></i>{{ __('admin.total_records') }}: <strong>{{ count($attendances ?? []) }}</strong>
            </div>
        </div>
    @endif

</div>
@endsection
