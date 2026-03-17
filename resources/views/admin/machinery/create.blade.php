@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('machinery.add_machinery') }}</h4>
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
                <form action="{{ route('admin.machinery.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">{{ __('machinery.name') }}</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('machinery.model') }}</label>
                        <input type="text" class="form-control" name="model" value="{{ old('model') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('machinery.number_plate') }}</label>
                        <input type="text" class="form-control" name="number_plate" value="{{ old('number_plate') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('machinery.hourly_rate') }}</label>
                        <input type="number" step="0.01" class="form-control" name="hourly_rate" value="{{ old('hourly_rate') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('machinery.daily_rate') }}</label>
                        <input type="number" step="0.01" class="form-control" name="daily_rate" value="{{ old('daily_rate') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('machinery.monthly_rate') }}</label>
                        <input type="number" step="0.01" class="form-control" name="monthly_rate" value="{{ old('monthly_rate') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('machinery.status') }}</label>
                        <select class="form-select" name="status">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                {{ __('machinery.status_active') }}
                            </option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                {{ __('machinery.status_inactive') }}
                            </option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ __('machinery.add_machinery') }}</button>
                        <a href="{{ route('admin.machinery.index') }}" class="btn btn-cancel">{{ __('machinery.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
