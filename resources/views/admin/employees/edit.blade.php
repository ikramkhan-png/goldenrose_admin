@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h2>{{ __('employees.edit_employee') }}</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">{{ __('employees.name') }}</label>
                <input type="text" name="name" value="{{ old('name', $employee->name) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('employees.phone') }}</label>
                <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('employees.basic_salary') }}</label>
                <input type="number" step="0.01" name="basic_salary"
                    value="{{ old('basic_salary', $employee->basic_salary) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('employees.daily_wage') }}</label>
                <input type="number" step="0.01" name="daily_wage"
                    value="{{ old('daily_wage', $employee->daily_wage) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('employees.department') }}</label>
                <select name="department_id" class="form-control" required>
                    <option value="">{{ __('employees.select_department') }}</option>
                    @foreach (\App\Models\Department::all() as $dep)
                        <option value="{{ $dep->id }}"
                            {{ old('department_id', $employee->department_id) == $dep->id ? 'selected' : '' }}>
                            {{ $dep->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                {{ __('employees.update_employee') }}
            </button>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                {{ __('employees.cancel') }}
            </a>
        </form>

    </div>
@endsection
