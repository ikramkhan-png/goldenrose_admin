@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <h2>{{ __('admin.add_advance_title') }}</h2>

    <form action="{{ route('admin.advances.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="employee_id" class="form-label">{{ __('admin.select_employee') }}</label>
            <select name="employee_id" id="employee_id" class="form-select" required>
                <option value="">{{ __('admin.select_employee') }}</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">{{ __('admin.advance_amount') }}</label>
            <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">{{ __('admin.advance_date') }}</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="reason" class="form-label">{{ __('admin.advance_reason') }}</label>
            <textarea name="reason" id="reason" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="month" class="form-label">{{ __('admin.month') }}</label>
            <input type="month" name="month" id="month" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">{{ __('admin.save_advance') }}</button>
    </form>
</div>
@endsection