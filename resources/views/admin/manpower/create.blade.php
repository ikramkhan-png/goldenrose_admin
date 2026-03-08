@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Add New Manpower</h1>

    <form action="{{ route('admin.manpower.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Hourly Rate</label>
            <input type="number" step="0.01" name="hourly_rate" class="form-control">
        </div>
        <div class="mb-3">
            <label>Daily Rate</label>
            <input type="number" step="0.01" name="daily_rate" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Monthly Rate</label>
            <input type="number" step="0.01" name="monthly_rate" class="form-control">
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection