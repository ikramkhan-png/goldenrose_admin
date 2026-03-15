@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <x-page-header :title="__('employees.employees')" :description="__('employees.employees_description')" />

        {{-- MONTH FILTER --}}
        <div class="card border-0 mb-4" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
            <div class="card-body p-4">
                <form action="{{ route('admin.employees.index') }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                    <div style="flex: 1; min-width: 250px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📅 {{ __('admin.filter_by_month') }}</label>
                        <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                               onchange="this.form.submit()" style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📆 {{ __('admin.filter') }}</label>
                        <div style="padding: 12px 14px; border: 2px solid #667eea; border-radius: 8px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); font-weight: 600; color: #667eea; font-size: 14px;">
                            {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('All Data') }}
                        </div>
                    </div>
                    @if(request('month'))
                    <div style="min-width: 120px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">&nbsp;</label>
                        <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary w-100" style="padding: 12px 14px; border: 2px solid #6c757d; border-radius: 8px; font-weight: 500; font-size: 14px;">
                            <i class="fas fa-times"></i> {{ __('Show All') }}
                        </a>
                    </div>
                    @endif
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('employees.employees') }}</h2>
            <a href="{{ route('admin.employees.create') }}" class="btn btn-success">
                {{ __('employees.add_employee') }}
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($employees->count())
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('employees.name') }}</th>
                        <th>{{ __('employees.phone') }}</th>
                        <th>{{ __('employees.basic_salary') }}</th>
                        <th>{{ __('employees.daily_wage') }}</th>
                        <th>{{ __('employees.department') }}</th>
                        <th>{{ __('admin.hiring_date') }}</th>
                        <th>{{ __('employees.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $emp)
                        <tr>
                            <td>{{ $emp->name }}</td>
                            <td>{{ $emp->phone }}</td>
                            <td>{{ $emp->basic_salary }}</td>
                            <td>{{ $emp->daily_wage }}</td>
                            <td>{{ $emp->department?->name ?? '-' }}</td>
                            <td>{{ $emp->hiring_date ?? '-' }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.employees.edit', $emp->id) }}"
                                    class="btn btn-primary btn-sm">{{ __('employees.edit') }}</a>
                                <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST"
                                    onsubmit="return confirm('{{ __('employees.confirm_delete') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        {{ __('employees.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">{{ __('employees.no_employees') }}</p>
        @endif

    </div>
@endsection
