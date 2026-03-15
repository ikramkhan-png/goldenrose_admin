@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('projects.add_attendance') }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.attendance.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>{{ __('projects.employee') }}</label>
            <select name="employee_id" class="form-control" required>
                <option value="">{{ __('projects.select_employee') }}</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>{{ __('projects.date') }}</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>{{ __('projects.status') }}</label>
            <select name="status" class="form-control" required>
                <option value="">{{ __('projects.select_status') }}</option>
                <option value="present">{{ __('projects.present') }}</option>
                <option value="absent">{{ __('projects.absent') }}</option>
                <option value="leave">{{ __('projects.leave') }}</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">{{ __('projects.add_attendance') }}</button>
    </form>
</div>
@endsection