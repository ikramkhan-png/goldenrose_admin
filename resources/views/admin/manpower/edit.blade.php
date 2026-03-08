@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Manpower</h1>

    <form action="{{ route('admin.manpower.update', $manpower->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $manpower->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Hourly Rate</label>
            <input type="number" step="0.01" name="hourly_rate" value="{{ $manpower->hourly_rate }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Daily Rate</label>
            <input type="number" step="0.01" name="daily_rate" value="{{ $manpower->daily_rate }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Monthly Rate</label>
            <input type="number" step="0.01" name="monthly_rate" value="{{ $manpower->monthly_rate }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active" {{ $manpower->status=='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ $manpower->status=='inactive'?'selected':'' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection