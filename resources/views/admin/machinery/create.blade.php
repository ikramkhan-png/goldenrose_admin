@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Add New Machinery</h1>

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
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" class="form-control" name="model" value="{{ old('model') }}">
        </div>

        <div class="mb-3">
            <label for="number_plate" class="form-label">Number Plate</label>
            <input type="text" class="form-control" name="number_plate" value="{{ old('number_plate') }}">
        </div>

        <div class="mb-3">
            <label for="daily_rate" class="form-label">Daily Rate</label>
            <input type="number" step="0.01" class="form-control" name="daily_rate" value="{{ old('daily_rate') }}">
        </div>

        <div class="mb-3">
            <label for="hourly_rate" class="form-label">Hourly Rate</label>
            <input type="number" step="0.01" class="form-control" name="hourly_rate" value="{{ old('hourly_rate') }}">
        </div>

        <div class="mb-3">
            <label for="monthly_rate" class="form-label">Monthly Rate</label>
            <input type="number" step="0.01" class="form-control" name="monthly_rate" value="{{ old('monthly_rate') }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" name="status">
                <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Add Machinery</button>
    </form>
</div>
@endsection