@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('admin.add_project_expense_title') }}</h4>
            <p class="page-subtitle">{{ __('admin.add_project_expense_description') }}</p>
        </div>
        <a href="{{ request('project_id') ? route('admin.internalDetails.show', request('project_id')) . '?tab=expenses' : route('admin.expenses.index') }}" class="btn btn-cancel">
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
                <form action="{{ route('admin.expenses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if(request('project_id'))
                        <input type="hidden" name="project_id" value="{{ request('project_id') }}">
                    @else
                        <div class="mb-4">
                            <label for="project_id" class="form-label">{{ __('admin.project_optional') }}</label>
                            <select name="project_id" id="project_id" class="form-select">
                                <option value="">{{ __('admin.select_project') }}</option>
                                @foreach($projects ?? [] as $proj)
                                    <option value="{{ $proj->id }}">{{ $proj->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label for="amount" class="form-label">{{ __('admin.project_expense_amount') }} <span style="color: red;">*</span></label>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" required placeholder="0.00">
                    </div>

                    <div class="mb-4">
                        <label for="date" class="form-label">{{ __('admin.project_expense_date') }} <span style="color: red;">*</span></label>
                        <input type="date" name="date" id="date" class="form-control" required value="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">{{ __('admin.project_expense_description') }} <span style="color: red;">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="3" required placeholder="{{ __('admin.project_expense_description_placeholder') }}"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="category" class="form-label">{{ __('admin.project_expense_category') }}</label>
                        <select name="category" id="category" class="form-select">
                            <option value="labor">{{ __('admin.category_labor') }}</option>
                            <option value="material">{{ __('admin.category_material') }}</option>
                            <option value="transport">{{ __('admin.category_transport') }}</option>
                            <option value="equipment">{{ __('admin.category_equipment') }}</option>
                            <option value="utility">{{ __('admin.category_utility') }}</option>
                            <option value="other">{{ __('admin.category_other') }}</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="invoice" class="form-label">{{ __('admin.project_expense_invoice') }}</label>
                        <input type="file" name="invoice" id="invoice" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xlsx">
                        <small class="text-muted">{{ __('admin.project_expense_accepted_files') }}</small>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ __('admin.save_project_expense') }}</button>
                        <a href="{{ request('project_id') ? route('admin.internalDetails.show', request('project_id')) . '?tab=expenses' : route('admin.expenses.index') }}" class="btn btn-cancel">{{ __('admin.cancel_project_expense') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
