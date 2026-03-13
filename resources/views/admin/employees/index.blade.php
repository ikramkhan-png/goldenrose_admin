@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <x-page-header :title="__('employees.employees')" :description="__('employees.employees_description')" />

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('employees.employees') }}</h2>
            <a href="{{ route('admin.employees.create') }}" class="btn btn-success">
                {{ __('employees.add_employee') }}
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($employees->count())
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('employees.name') }}</th>
                        <th>{{ __('employees.phone') }}</th>
                        <th>{{ __('employees.basic_salary') }}</th>
                        <th>{{ __('employees.daily_wage') }}</th>
                        <th>{{ __('employees.department') }}</th>
                        <th>{{ __('employees.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $emp)
                        <tr>
                            <td>{{ $emp->name }}</td>
                            <td>{{ $emp->phone }}</td>
                            <td>{{ $emp->basic_salary }}</td>
                            <td>{{ $emp->daily_wage }}</td>
                            <td>{{ $emp->department?->name ?? '-' }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.employees.edit', $emp->id) }}"
                                    class="btn btn-primary btn-sm">{{ __('employees.edit') }}</a>
                                <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST"
                                    onsubmit="return confirm('{{ __('employees.confirm_delete') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        {{ __('employees.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">{{ __('employees.no_employees') }}</p>
        @endif

    </div>
@endsection
