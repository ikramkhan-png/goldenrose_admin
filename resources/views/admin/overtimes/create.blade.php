@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('admin.add_overtime_title') }}</h4>
            <p class="page-subtitle">{{ __('admin.overtimes') }}</p>
        </div>
        <a href="{{ route('admin.overtimes.index') }}" class="btn btn-cancel">
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
                <form action="{{ route('admin.overtimes.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="employee_id" class="form-label">{{ __('admin.select_employee') }}</label>
                        <select name="employee_id" id="employee_id" class="form-select" required>
                            <option value="">{{ __('admin.select_employee') }}</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="amount" class="form-label">{{ __('admin.overtime_amount') }}</label>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label for="date" class="form-label">{{ __('admin.overtime_date') }}</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label for="notes" class="form-label">{{ __('admin.overtime_notes') }}</label>
                        <input type="text" name="notes" id="notes" class="form-control">
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ __('admin.save_overtime') }}</button>
                        <a href="{{ route('admin.overtimes.index') }}" class="btn btn-cancel">{{ __('admin.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
