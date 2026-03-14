@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h2>{{ __('employees.add_employee') }}</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.employees.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">{{ __('employees.name') }}</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('employees.phone') }}</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('employees.basic_salary') }}</label>
                <input type="number" step="0.01" name="basic_salary" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('employees.daily_wage') }}</label>
                <input type="number" step="0.01" name="daily_wage" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('employees.department') }}</label>
                <select name="department_id" class="form-control">
                    <option value="">{{ __('employees.select_department') }}</option>
                    @foreach (\App\Models\Department::all() as $dep)
                        <option value="{{ $dep->id }}"
                            {{ isset($employee) && $employee->department_id == $dep->id ? 'selected' : '' }}>
                            {{ $dep->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('admin.hiring_date') }}</label>
                <input type="date" name="hiring_date" class="form-control" value="{{ now()->format('Y-m-d') }}">
            </div>

            <button type="submit" class="btn btn-success">
                {{ __('employees.add_employee') }}
            </button>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                {{ __('employees.cancel') }}
            </a>
        </form>

    </div>
@endsection
