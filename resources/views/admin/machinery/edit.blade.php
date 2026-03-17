@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('machinery.edit_machinery') }}</h4>
            <p class="page-subtitle">{{ __('machinery.machinery') }}</p>
        </div>
        <a href="{{ route('admin.machinery.index') }}" class="btn btn-cancel">
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
                <form action="{{ route('admin.machinery.update', $machinery->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="form-label">{{ __('machinery.name') }}</label>
                        <input type="text" name="name" value="{{ old('name', $machinery->name) }}" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('machinery.model') }}</label>
                        <input type="text" name="model" value="{{ old('model', $machinery->model) }}" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('machinery.number_plate') }}</label>
                        <input type="text" name="number_plate" value="{{ old('number_plate', $machinery->number_plate) }}" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('machinery.hourly_rate') }}</label>
                        <input type="number" step="0.01" name="hourly_rate" value="{{ old('hourly_rate', $machinery->hourly_rate) }}" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('machinery.daily_rate') }}</label>
                        <input type="number" step="0.01" name="daily_rate" value="{{ old('daily_rate', $machinery->daily_rate) }}" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('machinery.monthly_rate') }}</label>
                        <input type="number" step="0.01" name="monthly_rate" value="{{ old('monthly_rate', $machinery->monthly_rate) }}" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('machinery.status') }}</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status', $machinery->status) == 'active' ? 'selected' : '' }}>
                                {{ __('machinery.status_active') }}
                            </option>
                            <option value="inactive" {{ old('status', $machinery->status) == 'inactive' ? 'selected' : '' }}>
                                {{ __('machinery.status_inactive') }}
                            </option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ __('machinery.update_machinery') }}</button>
                        <a href="{{ route('admin.machinery.index') }}" class="btn btn-cancel">{{ __('machinery.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
