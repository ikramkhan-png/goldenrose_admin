@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('admin.add_employee_expense_title') }}</h4>
            <p class="page-subtitle">{{ __('admin.employee_expense_subtitle') }}</p>
        </div>
        <a href="{{ route('admin.employee-expenses.index') }}" class="btn btn-cancel">
            <i class="fas fa-arrow-left me-1"></i>{{ __('admin.back_to_expenses') }}
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
                <form action="{{ route('admin.employee-expenses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="employee_id" class="form-label">{{ __('admin.expense_employee') }} <span class="text-danger">*</span></label>
                        <select name="employee_id" id="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                            <option value="">{{ __('admin.select_employee_expense') }}</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="amount" class="form-label">{{ __('admin.expense_amount') }} <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" id="amount"
                               class="form-control @error('amount') is-invalid @enderror"
                               value="{{ old('amount') }}" required placeholder="{{ __('admin.expense_amount_placeholder') }}">
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="date" class="form-label">{{ __('admin.expense_date') }} <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date"
                               class="form-control @error('date') is-invalid @enderror"
                               value="{{ old('date', now()->format('Y-m-d')) }}" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="invoice" class="form-label">{{ __('admin.invoice_receipt_optional') }}</label>
                        <input type="file" name="invoice" id="invoice"
                               class="form-control @error('invoice') is-invalid @enderror"
                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xlsx">
                        <small class="text-muted">{{ __('admin.accepted_files') }}</small>
                        @error('invoice')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">{{ __('admin.description_notes') }} <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" rows="3"
                                  class="form-control @error('description') is-invalid @enderror" required
                                  placeholder="{{ __('admin.description_placeholder') }}">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="p-3 mb-4" style="background: #f5f3ff; border-left: 4px solid #4f46e5; border-radius: 8px;">
                        <strong>{{ __('admin.note') }}:</strong> {{ __('admin.expense_note_info') }}<br>
                        <small class="text-muted">{{ __('admin.salary_formula') }}</small>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ __('admin.save_expense') }}</button>
                        <a href="{{ route('admin.employee-expenses.index') }}" class="btn btn-cancel">{{ __('admin.cancel_expense') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
