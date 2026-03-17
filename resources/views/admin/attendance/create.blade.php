@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('projects.add_attendance') }}</h4>
            <p class="page-subtitle">{{ __('admin.attendance') }}</p>
        </div>
        <a href="{{ route('admin.salaries.index') }}?tab=attendance" class="btn btn-cancel">
            <i class="fas fa-arrow-left me-1"></i>{{ __('admin.back') }}
        </a>
    </div>

    @if($errors->any())
        <div class="p-3 mb-4" style="background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; border-radius: 8px;">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            <div class="form-card">
                <form action="{{ route('admin.attendance.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">{{ __('projects.employee') }}</label>
                        <select name="employee_id" class="form-select" required>
                            <option value="">{{ __('projects.select_employee') }}</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">{{ __('projects.date') }}</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">{{ __('projects.status') }}</label>
                        <select name="status" class="form-select" required>
                            <option value="">{{ __('projects.select_status') }}</option>
                            <option value="present">{{ __('projects.present') }}</option>
                            <option value="absent">{{ __('projects.absent') }}</option>
                            <option value="leave">{{ __('projects.leave') }}</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>{{ __('projects.add_attendance') }}
                        </button>
                        <a href="{{ route('admin.salaries.index') }}?tab=attendance" class="btn btn-cancel">
                            {{ __('admin.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
