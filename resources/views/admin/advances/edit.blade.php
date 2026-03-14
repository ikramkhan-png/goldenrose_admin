@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <h2>{{ __('admin.edit_advance_title') }}</h2>

    <form action="{{ route('admin.advances.update', $advance->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="employee_id" class="form-label">{{ __('admin.select_employee') }}</label>
            <select name="employee_id" id="employee_id" class="form-select" required>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ $advance->employee_id == $emp->id ? 'selected' : '' }}>
                        {{ $emp->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">{{ __('admin.advance_amount') }}</label>
            <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ $advance->amount }}" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">{{ __('admin.advance_date') }}</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $advance->date }}" required>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">{{ __('admin.advance_notes') }}</label>
            <input type="text" name="notes" id="notes" class="form-control" value="{{ $advance->notes }}">
        </div>

        <button type="submit" class="btn btn-primary">{{ __('admin.update_advance') }}</button>
    </form>
</div>
@endsection