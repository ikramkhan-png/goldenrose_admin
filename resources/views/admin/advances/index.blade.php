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
                        <h1 class="h2 fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">💰 {{ __('admin.advances') }}</h1>
                        <p class="text-muted mb-0" style="font-size: 14px;">{{ __('admin.salary_management_subtitle') }}</p>
                    </div>
                    <a href="{{ route('admin.advances.create') }}" class="btn fw-semibold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 10px 20px; border-radius: 8px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                        <i class="bi bi-plus-lg"></i> {{ __('admin.add_advance') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- TABS & NAVIGATION --}}
    <div class="container-xl px-4 mb-4">
        <ul class="nav nav-tabs nav-fill gap-2 mb-4" role="tablist" style="background: white; padding: 8px 12px; border-radius: 10px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);">
            <li class="nav-item" role="presentation">
                <a class="nav-link fw-semibold" href="{{ route('admin.salaries.index') }}" role="tab"
                   style="border-radius: 8px; transition: all 0.2s; color: #666;">
                    <i class="bi bi-wallet2"></i> {{ __('admin.salaries') }}
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link fw-semibold" href="{{ route('admin.salaries.index') }}?tab=attendance" role="tab"
                   style="border-radius: 8px; transition: all 0.2s; color: #666;">
                    <i class="bi bi-calendar-check"></i> {{ __('admin.attendance') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold active" href="{{ route('admin.advances.index') }}"
                   style="border-radius: 8px; transition: all 0.2s; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <i class="bi bi-cash-coin"></i> {{ __('admin.advances') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold" href="{{ route('admin.overtimes.index') }}"
                   style="border-radius: 8px; transition: all 0.2s; color: #666;">
                    <i class="bi bi-clock-history"></i> {{ __('admin.overtime') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold" href="{{ route('admin.employee-expenses.index') }}"
                   style="border-radius: 8px; transition: all 0.2s; color: #666;">
                    <i class="bi bi-receipt"></i> {{ __('admin.employee_expenses') }}
                </a>
            </li>
        </ul>
    </div>

    {{-- MAIN CONTENT CONTAINER --}}
    <div class="container-xl px-4">
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
        <div class="card border-0" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08); overflow: hidden;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0" style="font-size: 13px;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <th style="padding: 18px 16px; font-weight: 600; border: none;">{{ __('admin.employee') }}</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none;">{{ __('admin.amount') }}</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none;">{{ __('admin.date') }}</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none;">{{ __('admin.notes') }}</th>
                                <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: center;">{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($advances as $adv)
                            <tr style="border-bottom: 1px solid #f0f2f7; transition: all 0.2s; background: white;">
                                <td style="padding: 16px; color: #2c3e50; font-weight: 600;">{{ $adv->employee?->name ?? '-' }}</td>
                                <td style="padding: 16px; color: #e74c3c; font-weight: 600;">{{ number_format($adv->amount, 2) }}</td>
                                <td style="padding: 16px; color: #667eea;">{{ $adv->date }}</td>
                                <td style="padding: 16px; color: #555;">{{ $adv->notes ?? '-' }}</td>
                                <td style="padding: 16px; text-align: center;">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('admin.advances.edit', $adv->id) }}" class="btn btn-sm btn-warning" style="padding: 6px 12px; border-radius: 6px;">
                                            <i class="bi bi-pencil"></i> {{ __('admin.edit') }}
                                        </a>
                                        <form action="{{ route('admin.advances.destroy', $adv->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" style="padding: 6px 12px; border-radius: 6px;" onclick="return confirm('{{ __('admin.confirm_delete') }}');">
                                                <i class="bi bi-trash"></i> {{ __('admin.delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $advances->links() }}
        @else
            <div class="alert border-0" style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); border-radius: 12px; padding: 20px; color: #667eea; border-left: 4px solid #667eea;">
                <i class="bi bi-info-circle"></i> <strong>{{ __('admin.no_data_available') }}</strong>
            </div>
        @endif
    </div>

</div>
@endsection