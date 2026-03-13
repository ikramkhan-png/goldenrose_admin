@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h1 class="mb-4">{{ __('manpower.add_manpower') }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.manpower.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">{{ __('manpower.name') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('manpower.hourly_rate') }}</label>
                <input type="number" step="0.01" name="hourly_rate" value="{{ old('hourly_rate') }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('manpower.daily_rate') }}</label>
                <input type="number" step="0.01" name="daily_rate" value="{{ old('daily_rate') }}" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('manpower.monthly_rate') }}</label>
                <input type="number" step="0.01" name="monthly_rate" value="{{ old('monthly_rate') }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('manpower.status') }}</label>
                <select name="status" class="form-control">
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                        {{ __('manpower.status_active') }}
                    </option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                        {{ __('manpower.status_inactive') }}
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">
                {{ __('manpower.save') }}
            </button>
            <a href="{{ route('admin.manpower.index') }}" class="btn btn-secondary">
                {{ __('manpower.cancel') }}
            </a>
        </form>

    </div>
@endsection
