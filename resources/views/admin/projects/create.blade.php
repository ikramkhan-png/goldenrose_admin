@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Create New Project</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.projects.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Project Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label>Client</label>
            <select name="client_id" class="form-control" required>
                <option value="">Select Client</option>
                @foreach($clients as $clientOption)
                    <option value="{{ $clientOption->id }}" {{ ($selectedClientId ?? old('client_id')) == $clientOption->id ? 'selected' : '' }}>
                        {{ $clientOption->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Project Type</label>
            <select name="type" class="form-control" required>
                <option value="">Select Type</option>
                <option value="one-time" {{ old('type') == 'one-time' ? 'selected' : '' }}>One Time</option>
                <option value="monthly" {{ old('type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="yearly" {{ old('type') == 'yearly' ? 'selected' : '' }}>Yearly</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Budget</label>
            <input type="number" name="budget" step="0.01" class="form-control" value="{{ old('budget') }}">
        </div>

        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
        </div>

        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
        </div>

        <button class="btn btn-primary">Create Project</button>
    </form>
</div>
@endsection