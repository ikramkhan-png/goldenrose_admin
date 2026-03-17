@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('manpower.add_manpower') }}</h4>
            <p class="page-subtitle">{{ __('manpower.manpower') }}</p>
        </div>
        <a href="{{ route('admin.manpower.index') }}" class="btn btn-cancel">
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
                <form action="{{ route('admin.manpower.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">{{ __('manpower.name') }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('manpower.hourly_rate') }}</label>
                        <input type="number" step="0.01" name="hourly_rate" value="{{ old('hourly_rate') }}" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('manpower.daily_rate') }}</label>
                        <input type="number" step="0.01" name="daily_rate" value="{{ old('daily_rate') }}" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('manpower.monthly_rate') }}</label>
                        <input type="number" step="0.01" name="monthly_rate" value="{{ old('monthly_rate') }}" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('manpower.status') }}</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                {{ __('manpower.status_active') }}
                            </option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                {{ __('manpower.status_inactive') }}
                            </option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ __('manpower.save') }}</button>
                        <a href="{{ route('admin.manpower.index') }}" class="btn btn-cancel">{{ __('manpower.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
