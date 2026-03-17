@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('admin.edit_attendance') }}</h4>
            <p class="page-subtitle">{{ __('admin.attendance') }}</p>
        </div>
        <a href="{{ route('admin.salaries.index') }}?tab=attendance" class="btn btn-cancel">
            <i class="fas fa-arrow-left me-1"></i>{{ __('admin.back') }}
        </a>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="form-card">
                <form action="{{ route('admin.attendance.update', $attendance->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label">{{ __('admin.employee') }}</label>
                        <select name="employee_id" class="form-select" required>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ $attendance->employee_id == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">{{ __('admin.date') }}</label>
                        <input type="date" name="date" value="{{ $attendance->date }}" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">{{ __('admin.check_in') }}</label>
                        <input type="time" name="check_in" value="{{ $attendance->check_in }}" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">{{ __('admin.check_out') }}</label>
                        <input type="time" name="check_out" value="{{ $attendance->check_out }}" class="form-control">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>{{ __('admin.update') }}
                        </button>
                        <a href="{{ route('admin.salaries.index') }}?tab=attendance" class="btn btn-cancel">
                            {{ __('admin.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
