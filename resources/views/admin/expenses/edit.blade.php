@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div class="container-xl mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">{{ __('admin.edit_project_expense_title') }}</h2>
            <p class="text-muted">{{ __('admin.edit_project_expense_description') }}</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4">
        <form action="{{ route('admin.expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- PROJECT ID (HIDDEN if exists) --}}
            @if($expense->project_id)
                <input type="hidden" name="project_id" value="{{ $expense->project_id }}">
            @else
                <div class="mb-3">
                    <label for="project_id" class="form-label">{{ __('admin.project_optional') }}</label>
                    <select name="project_id" id="project_id" class="form-select">
                        <option value="">{{ __('admin.select_project') }}</option>
                        @foreach($projects ?? [] as $proj)
                            <option value="{{ $proj->id }}" {{ $expense->project_id == $proj->id ? 'selected' : '' }}>
                                {{ $proj->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="amount" class="form-label">{{ __('admin.project_expense_amount') }} <span style="color: red;">*</span></label>
                    <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ $expense->amount }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="date" class="form-label">{{ __('admin.project_expense_date') }} <span style="color: red;">*</span></label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ $expense->date }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">{{ __('admin.project_expense_description') }} <span style="color: red;">*</span></label>
                <textarea name="description" id="description" class="form-control" rows="3" required>{{ $expense->description }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">{{ __('admin.project_expense_category') }}</label>
                    <select name="category" id="category" class="form-select">
                        <option value="labor" {{ $expense->category === 'labor' ? 'selected' : '' }}>{{ __('admin.category_labor') }}</option>
                        <option value="material" {{ $expense->category === 'material' ? 'selected' : '' }}>{{ __('admin.category_material') }}</option>
                        <option value="transport" {{ $expense->category === 'transport' ? 'selected' : '' }}>{{ __('admin.category_transport') }}</option>
                        <option value="equipment" {{ $expense->category === 'equipment' ? 'selected' : '' }}>{{ __('admin.category_equipment') }}</option>
                        <option value="utility" {{ $expense->category === 'utility' ? 'selected' : '' }}>{{ __('admin.category_utility') }}</option>
                        <option value="other" {{ $expense->category === 'other' ? 'selected' : '' }}>{{ __('admin.category_other') }}</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="invoice" class="form-label">{{ __('admin.project_expense_invoice') }}</label>
                    <input type="file" name="invoice" id="invoice" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xlsx">
                    <small class="text-muted">{{ __('admin.project_expense_accepted_files') }}</small>
                    @if($expense->invoice)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $expense->invoice) }}" target="_blank" class="btn btn-sm btn-secondary">
                                <i class="bi bi-download"></i> {{ __('admin.view_current_invoice') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> {{ __('admin.update_project_expense') }}
                </button>
                <a href="{{ $expense->project_id ? route('admin.internalDetails.show', $expense->project_id) . '?tab=expenses' : route('admin.expenses.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> {{ __('admin.cancel_project_expense') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection