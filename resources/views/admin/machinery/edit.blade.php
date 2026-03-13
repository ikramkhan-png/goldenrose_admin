@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h1 class="mb-4">{{ __('machinery.edit_machinery') }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.machinery.update', $machinery->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">{{ __('machinery.name') }}</label>
                <input type="text" name="name" value="{{ old('name', $machinery->name) }}" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('machinery.model') }}</label>
                <input type="text" name="model" value="{{ old('model', $machinery->model) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('machinery.number_plate') }}</label>
                <input type="text" name="number_plate" value="{{ old('number_plate', $machinery->number_plate) }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('machinery.hourly_rate') }}</label>
                <input type="number" step="0.01" name="hourly_rate"
                    value="{{ old('hourly_rate', $machinery->hourly_rate) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('machinery.daily_rate') }}</label>
                <input type="number" step="0.01" name="daily_rate"
                    value="{{ old('daily_rate', $machinery->daily_rate) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('machinery.monthly_rate') }}</label>
                <input type="number" step="0.01" name="monthly_rate"
                    value="{{ old('monthly_rate', $machinery->monthly_rate) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('machinery.status') }}</label>
                <select name="status" class="form-control">
                    <option value="active" {{ old('status', $machinery->status) == 'active' ? 'selected' : '' }}>
                        {{ __('machinery.status_active') }}
                    </option>
                    <option value="inactive" {{ old('status', $machinery->status) == 'inactive' ? 'selected' : '' }}>
                        {{ __('machinery.status_inactive') }}
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">
                {{ __('machinery.update_machinery') }}
            </button>
            <a href="{{ route('admin.machinery.index') }}" class="btn btn-secondary">
                {{ __('machinery.cancel') }}
            </a>
        </form>

    </div>
@endsection
