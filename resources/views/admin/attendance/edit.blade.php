@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Edit Attendance</h2>

    <form action="{{ route('admin.attendance.update', $attendance->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Employee</label>
            <select name="employee_id" class="form-control" required>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ $attendance->employee_id == $emp->id ? 'selected' : '' }}>
                        {{ $emp->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" value="{{ $attendance->date }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Check In</label>
            <input type="time" name="check_in" value="{{ $attendance->check_in }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Check Out</label>
            <input type="time" name="check_out" value="{{ $attendance->check_out }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection