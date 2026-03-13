@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h1 class="mb-4">{{ __('machinery.add_machinery') }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.machinery.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">{{ __('machinery.name') }}</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('machinery.model') }}</label>
                <input type="text" class="form-control" name="model" value="{{ old('model') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('machinery.number_plate') }}</label>
                <input type="text" class="form-control" name="number_plate" value="{{ old('number_plate') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('machinery.hourly_rate') }}</label>
                <input type="number" step="0.01" class="form-control" name="hourly_rate"
                    value="{{ old('hourly_rate') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('machinery.daily_rate') }}</label>
                <input type="number" step="0.01" class="form-control" name="daily_rate"
                    value="{{ old('daily_rate') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('machinery.monthly_rate') }}</label>
                <input type="number" step="0.01" class="form-control" name="monthly_rate"
                    value="{{ old('monthly_rate') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('machinery.status') }}</label>
                <select class="form-control" name="status">
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                        {{ __('machinery.status_active') }}
                    </option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                        {{ __('machinery.status_inactive') }}
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">
                {{ __('machinery.add_machinery') }}
            </button>
            <a href="{{ route('admin.machinery.index') }}" class="btn btn-secondary">
                {{ __('machinery.cancel') }}
            </a>
        </form>

    </div>
@endsection
