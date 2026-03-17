@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('employees.edit_employee') }}</h4>
            <p class="page-subtitle">{{ __('employees.employees') }}</p>
        </div>
        <a href="{{ route('admin.employees.index') }}" class="btn btn-cancel">
            <i class="fas fa-arrow-left me-1"></i>{{ __('admin.back') }}
        </a>
    </div>

    @if ($errors->any())
        <div class="p-3 mb-4" style="background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; border-radius: 8px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            <div class="form-card">
                <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="form-label">{{ __('employees.name') }}</label>
                        <input type="text" name="name" value="{{ old('name', $employee->name) }}" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('employees.phone') }}</label>
                        <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('employees.basic_salary') }}</label>
                        <input type="number" step="0.01" name="basic_salary" value="{{ old('basic_salary', $employee->basic_salary) }}" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('employees.daily_wage') }}</label>
                        <input type="number" step="0.01" name="daily_wage" value="{{ old('daily_wage', $employee->daily_wage) }}" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('employees.department') }}</label>
                        <select name="department_id" class="form-select" required>
                            <option value="">{{ __('employees.select_department') }}</option>
                            @foreach (\App\Models\Department::all() as $dep)
                                <option value="{{ $dep->id }}"
                                    {{ old('department_id', $employee->department_id) == $dep->id ? 'selected' : '' }}>
                                    {{ $dep->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('admin.hiring_date') }}</label>
                        <input type="date" name="hiring_date" class="form-control"
                               value="{{ old('hiring_date', $employee->hiring_date ? \Carbon\Carbon::parse($employee->hiring_date)->format('Y-m-d') : now()->format('Y-m-d')) }}">
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ __('employees.update_employee') }}</button>
                        <a href="{{ route('admin.employees.index') }}" class="btn btn-cancel">{{ __('employees.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
