@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('admin.edit_advance_title') }}</h4>
            <p class="page-subtitle">{{ __('admin.advances') }}</p>
        </div>
        <a href="{{ route('admin.advances.index') }}" class="btn btn-cancel">
            <i class="fas fa-arrow-left me-1"></i>{{ __('admin.back') }}
        </a>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="form-card">
                <form action="{{ route('admin.advances.update', $advance->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="employee_id" class="form-label">{{ __('admin.select_employee') }}</label>
                        <select name="employee_id" id="employee_id" class="form-select" required>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ $advance->employee_id == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="amount" class="form-label">{{ __('admin.advance_amount') }}</label>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ $advance->amount }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="date" class="form-label">{{ __('admin.advance_date') }}</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ $advance->date }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label">{{ __('admin.advance_notes') }}</label>
                        <input type="text" name="notes" id="notes" class="form-control" value="{{ $advance->notes }}">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>{{ __('admin.update_advance') }}
                        </button>
                        <a href="{{ route('admin.advances.index') }}" class="btn btn-cancel">
                            {{ __('admin.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
