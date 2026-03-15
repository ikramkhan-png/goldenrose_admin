@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>{{ __('projects.create_new_project') }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.projects.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>{{ __('projects.project_name') }}</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label>{{ __('clients.client') }}</label>
            <select name="client_id" class="form-control" required>
                <option value="">{{ __('projects.select_client') }}</option>
                @foreach($clients as $clientOption)
                    <option value="{{ $clientOption->id }}" {{ ($selectedClientId ?? old('client_id')) == $clientOption->id ? 'selected' : '' }}>
                        {{ $clientOption->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>{{ __('projects.project_type') }}</label>
            <select name="type" class="form-control" required>
                <option value="">{{ __('projects.select_type') }}</option>
                <option value="one-time" {{ old('type') == 'one-time' ? 'selected' : '' }}>{{ __('projects.one_time') }}</option>
                <option value="monthly" {{ old('type') == 'monthly' ? 'selected' : '' }}>{{ __('projects.monthly') }}</option>
                <option value="yearly" {{ old('type') == 'yearly' ? 'selected' : '' }}>{{ __('projects.yearly') }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label>{{ __('projects.budget') }}</label>
            <input type="number" name="budget" step="0.01" class="form-control" value="{{ old('budget') }}">
        </div>

        <div class="mb-3">
            <label>{{ __('projects.start_date') }}</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
        </div>

        <div class="mb-3">
            <label>{{ __('projects.end_date') }}</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
        </div>

        <div class="mb-3">
            <label>{{ __('projects.notes') }}</label>
            <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
        </div>

        <button class="btn btn-primary">{{ __('projects.create_project') }}</button>
    </form>
</div>
@endsection