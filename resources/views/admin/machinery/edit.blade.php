@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Machinery</h1>

    <form action="{{ route('admin.machinery.update', $machinery->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $machinery->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Model</label>
            <input type="text" name="model" value="{{ $machinery->model }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Number Plate</label>
            <input type="text" name="number_plate" value="{{ $machinery->number_plate }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Hourly Rate</label>
            <input type="number" step="0.01" name="hourly_rate" value="{{ $machinery->hourly_rate }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Daily Rate</label>
            <input type="number" step="0.01" name="daily_rate" value="{{ $machinery->daily_rate }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Monthly Rate</label>
            <input type="number" step="0.01" name="monthly_rate" value="{{ $machinery->monthly_rate }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active" {{ $machinery->status=='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ $machinery->status=='inactive'?'selected':'' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection