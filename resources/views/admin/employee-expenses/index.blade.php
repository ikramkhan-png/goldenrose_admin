@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div class="salary-container" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; padding: 30px 0;" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    
    {{-- PAGE HEADER --}}
    <div class="container-xl px-4 mb-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h1 class="h2 fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">💰 {{ __('admin.employee_expenses_title') }}</h1>
                        <p class="text-muted mb-0" style="font-size: 14px;">{{ __('admin.employee_expenses_subtitle') }}</p>
                    </div>
                    <a href="{{ route('admin.employee-expenses.create') }}" class="btn fw-semibold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 10px 20px; border-radius: 8px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                        <i class="bi bi-plus-lg"></i> {{ __('admin.add_employee_expense') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- TABS & NAVIGATION --}}
    <div class="container-xl px-4 mb-4">
        <ul class="nav nav-tabs nav-fill gap-2 mb-4" role="tablist" style="background: white; padding: 8px 12px; border-radius: 10px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);">
            <li class="nav-item" role="presentation">
                <a class="nav-link fw-semibold" href="{{ route('admin.salaries.index') }}?tab=salaries" role="tab"
                   style="border-radius: 8px; transition: all 0.2s; color: #666;">
                    <i class="bi bi-wallet2"></i> {{ __('projects.salaries') }}
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link fw-semibold" href="{{ route('admin.salaries.index') }}?tab=attendance" role="tab"
                   style="border-radius: 8px; transition: all 0.2s; color: #666;">
                    <i class="bi bi-calendar-check"></i> {{ __('projects.attendance') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold" href="{{ route('admin.advances.index') }}"
                   style="border-radius: 8px; transition: all 0.2s; color: #666;">
                    <i class="bi bi-cash-coin"></i> {{ __('projects.advances') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold" href="{{ route('admin.overtimes.index') }}"
                   style="border-radius: 8px; transition: all 0.2s; color: #666;">
                    <i class="bi bi-clock-history"></i> {{ __('projects.overtime') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold" href="{{ route('admin.employee-expenses.index') }}"
                   style="border-radius: 8px; transition: all 0.2s; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <i class="bi bi-receipt"></i> {{ __('admin.employee_expenses_title') }}
                </a>
            </li>
        </ul>
    </div>

    {{-- FILTER CARD --}}
    <div class="container-xl px-4 mb-4">
        <div class="card border-0" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
            <div class="card-body p-4">
                <form action="{{ route('admin.employee-expenses.index') }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                    <div style="flex: 1; min-width: 250px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">👤 {{ __('admin.filter_by_employee') }}</label>
                        <select name="employee_id" class="form-select" onchange="this.form.submit()" style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                            <option value="">{{ __('admin.all_employees') }}</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📅 {{ __('admin.month') }}</label>
                        <input type="month" name="month" class="form-control" value="{{ request('month') }}" onchange="this.form.submit()" style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EXPENSES TABLE --}}
    <div class="container-xl px-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px; border: none; box-shadow: 0 4px 15px rgba(39, 174, 96, 0.2);">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08); overflow: hidden;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0" style="font-size: 13px;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <th style="padding: 18px 16px; font-weight: 600; border: none;">#</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none;">{{ __('admin.employee') }}</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: right;">{{ __('admin.amount') }}</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none;">{{ __('admin.date') }}</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none;">{{ __('admin.description') }}</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: center;">{{ __('admin.invoice') }}</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: center;">{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                            <tr style="border-bottom: 1px solid #f0f2f7; transition: all 0.2s;">
                                <td style="padding: 16px; color: #999;">{{ $loop->iteration }}</td>
                                <td style="padding: 16px; color: #2c3e50; font-weight: 600;">{{ $expense->employee->name ?? '-' }}</td>
                                <td style="padding: 16px; text-align: right; color: #f39c12; font-weight: 600;">+{{ number_format($expense->amount, 2) }}</td>
                                <td style="padding: 16px; color: #667eea; font-weight: 600;">{{ $expense->date }}</td>
                                <td style="padding: 16px; color: #555;">{{ Str::limit($expense->description, 50) }}</td>
                                <td style="padding: 16px; text-align: center;">
                                    @if($expense->invoice)
                                        <a href="{{ asset('storage/'.$expense->invoice) }}" target="_blank" class="btn btn-sm" style="background: #e8f4fd; color: #2196f3; border: none; border-radius: 6px; padding: 6px 12px; font-size: 11px;">
                                            <i class="bi bi-eye"></i> {{ __('admin.view') }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td style="padding: 16px; text-align: center;">
                                    <div class="d-flex gap-2 justify-content-center">

                                        <a href="{{ route('admin.employee-expenses.edit', $expense) }}"
                                        class="btn btn-sm btn-warning"
                                        style="padding: 6px 12px; border-radius: 6px;">
                                            <i class="bi bi-pencil"></i> {{ __('admin.edit') }}
                                        </a>

                                        <form action="{{ route('admin.employee-expenses.destroy', $expense) }}"
                                            method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    style="padding: 6px 12px; border-radius: 6px;"
                                                    onclick="return confirm('{{ __('admin.confirm_delete_record') }}');">
                                                <i class="bi bi-trash"></i> {{ __('admin.delete') }}
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5" style="color: #999; font-size: 13px;">{{ __('admin.no_expenses_recorded') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="padding: 12px 16px; background: #f8f9fc; border-top: 1px solid #e8ecf1; font-size: 12px; color: #999;">
                💰 {{ __('admin.total_records') }}: <strong>{{ $expenses->total() }}</strong>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $expenses->links() }}
        </div>
    </div>

</div>

<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }
    .table tbody tr:hover {
        background-color: #f8f9fc !important;
    }
    .table th, .table td {
        font-size: 14px;
        color: #2c3e50;
        font-weight: 500;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection
