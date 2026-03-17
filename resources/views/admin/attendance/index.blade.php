@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('admin.attendance') }}</h2>
    <a href="{{ route('admin.attendance.create') }}" class="btn btn-success mb-2">{{ __('admin.add_attendance') }}</a>

    {{-- FILTERS --}}
    <form method="GET" action="{{ route('admin.attendance.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <label class="form-label">{{ __('admin.employee') }}</label>
            <select name="employee_id" class="form-control">
                <option value="">{{ __('admin.all_employees') }}</option>
                @foreach($employees ?? [] as $employee)
                    <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">{{ __('admin.month') }}</label>
            <input type="month" name="month" value="{{ request('month') }}" class="form-control">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">{{ __('admin.filter') }}</button>
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">{{ __('admin.reset') }}</a>
        </div>
    </form>

    @if(session('success'))
        <div class="p-3 mb-3" style="background: #f0fdf4; color: #166534; border-left: 4px solid #22c55e; border-radius: 8px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-styled mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('admin.employee') }}</th>
                            <th>{{ __('admin.date') }}</th>
                            <th>{{ __('admin.check_in') }}</th>
                            <th>{{ __('admin.check_out') }}</th>
                            <th class="td-center">{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $att)
                        <tr>
                            <td class="td-name">{{ $att->employee->name }}</td>
                            <td>{{ $att->date }}</td>
                            <td>{{ $att->check_in ?? '-' }}</td>
                            <td>{{ $att->check_out ?? '-' }}</td>
                            <td class="td-center">
                                <a href="{{ route('admin.attendance.edit', $att->id) }}" class="btn btn-warning btn-sm">{{ __('admin.edit') }}</a>
                                <form action="{{ route('admin.attendance.destroy', $att->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('admin.confirm_delete_record') }}')">
                                        {{ __('admin.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{ $attendances->links() }}
</div>
@endsection