@extends('admin.layouts.app')

@section('content')
<div class="salary-container" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; padding: 30px 0;">
    
    {{-- PAGE HEADER --}}
    <div class="container-xl px-4 mb-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h1 class="h2 fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">💼 Salary Management</h1>
                        <p class="text-muted mb-0" style="font-size: 14px;">Monitor payroll, attendance, and financial records</p>
                    </div>
                    <form action="{{ route('admin.salaries.export-pdf') }}" method="POST">
                        @csrf
                        <input type="hidden" name="month" value="{{ request('month', now()->format('Y-m')) }}">
                        <button type="submit" class="btn fw-semibold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 10px 20px; border-radius: 8px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                            <i class="bi bi-download"></i> Export PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER CARD --}}
    <div class="container-xl px-4 mb-4">
        <div class="card border-0" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
            <div class="card-body p-4">
                <form action="{{ route('admin.salaries.index') }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                    <div style="flex: 1; min-width: 250px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📅 Select Month</label>
                        <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                               onchange="this.form.submit()" style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📆 Period</label>
                        <div style="padding: 12px 14px; border: 2px solid #667eea; border-radius: 8px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); font-weight: 600; color: #667eea; font-size: 14px;">
                            {{ $selectedMonth->format('F Y') }}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- TABS & NAVIGATION --}}
    @php $tab = request('tab', 'salaries'); @endphp
    <div class="container-xl px-4 mb-4">
        <ul class="nav nav-tabs nav-fill gap-2 mb-4" role="tablist" style="background: white; padding: 8px 12px; border-radius: 10px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);">
            <li class="nav-item" role="presentation">
                <a class="nav-link fw-semibold" href="{{ route('admin.salaries.index') }}?tab=salaries" role="tab"
                   style="border-radius: 8px; transition: all 0.2s; {{ $tab === 'salaries' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;' : 'color: #666;' }}">
                    <i class="bi bi-wallet2"></i> Salaries
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link fw-semibold" href="{{ route('admin.salaries.index') }}?tab=attendance" role="tab"
                   style="border-radius: 8px; transition: all 0.2s; {{ $tab === 'attendance' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;' : 'color: #666;' }}">
                    <i class="bi bi-calendar-check"></i> Attendance
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold" href="{{ route('admin.advances.index') }}"
                   style="border-radius: 8px; transition: all 0.2s; color: #666;">
                    <i class="bi bi-cash-coin"></i> Advances
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold" href="{{ route('admin.overtimes.index') }}"
                   style="border-radius: 8px; transition: all 0.2s; color: #666;">
                    <i class="bi bi-clock-history"></i> Overtime
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold" href="{{ route('admin.expenses.index') }}"
                   style="border-radius: 8px; transition: all 0.2s; color: #666;">
                    <i class="bi bi-receipt"></i> Expenses
                </a>
            </li>
        </ul>
    </div>

    {{-- SALARIES TAB --}}
    @if($tab === 'salaries')
    @if($salaries && count($salaries) > 0)
    <div class="container-xl px-4">
        <div class="card border-0" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08); overflow: hidden;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0" style="font-size: 13px;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <th style="padding: 18px 16px; font-weight: 600; border: none;">EMPLOYEE</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: center;">DAYS</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: right;">BASIC</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: right;">DAILY RATE</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: right;">+ OT</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: right;">- ADV</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: right;">+ EXP</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: right;">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalFinal = 0; @endphp
                            @foreach($salaries as $sal)
                            <tr style="border-bottom: 1px solid #f0f2f7; transition: all 0.2s; background: white;">
                                <td style="padding: 16px; color: #2c3e50; font-weight: 600;">{{ $sal['employee_name'] }}</td>
                                <td style="padding: 16px; text-align: center; color: #667eea; font-weight: 600; background: rgba(102, 126, 234, 0.05);">{{ $sal['working_days'] }}</td>
                                <td style="padding: 16px; text-align: right; color: #555;">{{ number_format($sal['basic_salary'], 0) }}</td>
                                <td style="padding: 16px; text-align: right; color: #555;">{{ number_format($sal['daily_wage'], 2) }}</td>
                                <td style="padding: 16px; text-align: right; color: #27ae60; font-weight: 600;">+{{ number_format($sal['overtime_total'], 0) }}</td>
                                <td style="padding: 16px; text-align: right; color: #e74c3c; font-weight: 600;">-{{ number_format($sal['advance_total'], 0) }}</td>
                                <td style="padding: 16px; text-align: right; color: #f39c12; font-weight: 600;">+{{ number_format($sal['expenses_total'], 0) }}</td>
                                <td style="padding: 16px; text-align: right; color: white; font-weight: 700; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px;">{{ number_format($sal['final_salary'], 0) }}</td>
                            </tr>
                            @php $totalFinal += $sal['final_salary']; @endphp
                            @endforeach
                            <tr style="background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%); font-weight: 700;">
                                <td colspan="7" style="padding: 18px 16px; text-align: right; color: #2c3e50;">TOTAL PAYROLL:</td>
                                <td style="padding: 18px 16px; text-align: right; color: #667eea; font-size: 15px;">{{ number_format($totalFinal, 0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="padding: 12px 16px; background: #f8f9fc; border-top: 1px solid #e8ecf1; font-size: 12px; color: #999;">
                📊 Total Employees: <strong>{{ count($salaries) }}</strong> | 📅 Generated: <strong>{{ now()->format('M d, Y') }}</strong>
            </div>
        </div>
    </div>
    @else
        <div class="container-xl px-4">
            <div class="alert border-0" style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); border-radius: 12px; padding: 20px; color: #667eea; border-left: 4px solid #667eea;">
                <i class="bi bi-info-circle"></i> <strong>No data available</strong> for {{ $selectedMonth->format('F Y') }}
            </div>
        </div>
    @endif
    @endif

    {{-- ATTENDANCE TAB --}}
    @if($tab === 'attendance')
    <div class="container-xl px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark mb-0">📋 Attendance Records</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.attendance.create') }}" class="btn fw-semibold" style="background: white; color: #667eea; border: 2px solid #667eea; padding: 8px 16px; border-radius: 8px; font-size: 13px;">
                    <i class="bi bi-plus-lg"></i> Add Single
                </a>
                <button type="button" class="btn fw-semibold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);" onclick="document.getElementById('bulkForm').style.display = document.getElementById('bulkForm').style.display === 'none' ? 'block' : 'none'">
                    <i class="bi bi-plus-lg"></i> Add Bulk
                </button>
            </div>
        </div>

        {{-- BULK ATTENDANCE FORM --}}
        <div id="bulkForm" style="display: none;" class="mb-4">
            <div class="card border-0" style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); border-radius: 15px; border-left: 4px solid #667eea;">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3" style="font-size: 14px;">⚡ Quick Bulk Entry</h6>
                    <form action="{{ route('admin.attendance.bulk-store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="form-label fw-bold" style="font-size: 12px; color: #666;">Employee</label>
                                <select name="employee_id" class="form-select" style="padding: 10px; border: 2px solid #667eea; border-radius: 8px; font-size: 13px;" required>
                                    <option value="">Select</option>
                                    @foreach($employees ?? [] as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-bold" style="font-size: 12px; color: #666;">Month</label>
                                <input type="month" name="month" class="form-control" style="padding: 10px; border: 2px solid #667eea; border-radius: 8px; font-size: 13px;" value="{{ request('month', now()->format('Y-m')) }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-bold" style="font-size: 12px; color: #666;">Days</label>
                                <input type="number" name="num_days" class="form-control" style="padding: 10px; border: 2px solid #667eea; border-radius: 8px; font-size: 13px;" min="1" max="31" placeholder="20" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-bold" style="font-size: 12px; color: #666;">Check In</label>
                                <input type="time" name="check_in" class="form-control" style="padding: 10px; border: 2px solid #667eea; border-radius: 8px; font-size: 13px;" value="09:00" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-bold" style="font-size: 12px; color: #666;">Check Out</label>
                                <input type="time" name="check_out" class="form-control" style="padding: 10px; border: 2px solid #667eea; border-radius: 8px; font-size: 13px;" value="18:00" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn w-100 fw-bold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; padding: 10px; font-size: 13px;">
                                    <i class="bi bi-check"></i> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ATTENDANCE TABLE --}}
        <div class="card border-0" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08); overflow: hidden;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0" style="font-size: 13px;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <th style="padding: 18px 16px; font-weight: 600; border: none;">#</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none;">EMPLOYEE</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none;">DATE</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: center;">CHECK IN</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: center;">CHECK OUT</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: center;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances ?? [] as $attendance)
                            <tr style="border-bottom: 1px solid #f0f2f7; transition: all 0.2s;">
                                <td style="padding: 16px; color: #999;">{{ $loop->iteration }}</td>
                                <td style="padding: 16px; color: #2c3e50; font-weight: 600;">{{ $attendance->employee->name ?? '-' }}</td>
                                <td style="padding: 16px; color: #667eea; font-weight: 600;">{{ $attendance->date }}</td>
                                <td style="padding: 16px; text-align: center; color: #27ae60; font-weight: 600;">{{ $attendance->check_in ?? '-' }}</td>
                                <td style="padding: 16px; text-align: center; color: #e74c3c; font-weight: 600;">{{ $attendance->check_out ?? '-' }}</td>
                                <td style="padding: 16px; text-align: center;">
                                    <a href="{{ route('admin.attendance.edit', $attendance) }}" class="btn btn-sm fw-semibold" style="background: #2196f3; color: white; border: none; border-radius: 6px; padding: 8px 12px; font-size: 12px; box-shadow: 0 2px 8px rgba(33, 150, 243, 0.3); transition: all 0.2s;" title="Edit" onmouseover="this.style.boxShadow='0 4px 12px rgba(33, 150, 243, 0.5)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(33, 150, 243, 0.3)'; this.style.transform='translateY(0)'">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.attendance.destroy', $attendance) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm fw-semibold" style="background: #e74c3c; color: white; border: none; border-radius: 6px; padding: 8px 12px; font-size: 12px; box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3); transition: all 0.2s; margin-left: 4px;" type="submit" title="Delete" onmouseover="this.style.boxShadow='0 4px 12px rgba(231, 76, 60, 0.5)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(231, 76, 60, 0.3)'; this.style.transform='translateY(0)'">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5" style="color: #999; font-size: 13px;">
                                    <i class="bi bi-inbox" style="font-size: 24px; opacity: 0.3;"></i><br><br>No attendance records
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="padding: 12px 16px; background: #f8f9fc; border-top: 1px solid #e8ecf1; font-size: 12px; color: #999;">
                📝 Total Records: <strong>{{ count($attendances ?? []) }}</strong>
            </div>
        </div>
    </div>
    @endif

</div>

<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .table tbody tr:hover {
        background-color: #f8f9fc !important;
    }

    /* emphasize table text */
    .table th, .table td {
        font-size: 15px;
        color: #2c3e50;
        font-weight: 600;
        padding: 18px 16px !important;
    }

    .table td {
        background: white;
    }

    .form-control, .form-select {
        border-color: #e8ecf1 !important;
        background: #f8f9fc;
        font-size: 14px;
        font-weight: 500;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea !important;
        background: white;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1) !important;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }

    h1, h2, h4 {
        color: #2c3e50;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }
</style>
@endsection