@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <h2>{{ __('admin.edit_overtime_title') }}</h2>

    <form action="{{ route('admin.overtimes.update', $overtime->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="employee_id" class="form-label">{{ __('admin.select_employee') }}</label>
            <select name="employee_id" id="employee_id" class="form-select" required>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ $overtime->employee_id == $emp->id ? 'selected' : '' }}>
                        {{ $emp->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">{{ __('admin.overtime_amount') }}</label>
            <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ $overtime->amount }}" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">{{ __('admin.overtime_date') }}</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $overtime->date }}" required>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">{{ __('admin.overtime_notes') }}</label>
            <input type="text" name="notes" id="notes" class="form-control" value="{{ $overtime->notes }}">
        </div>

        <button type="submit" class="btn btn-primary">{{ __('admin.update_overtime') }}</button>
    </form>
</div>
@endsection