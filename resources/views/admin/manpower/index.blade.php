@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h1 class="mb-4">{{ __('manpower.manpower_list') }}</h1>
        <a href="{{ route('admin.manpower.create') }}" class="btn btn-primary mb-3">
            {{ __('manpower.add_manpower') }}
        </a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('manpower.id') }}</th>
                    <th>{{ __('manpower.name') }}</th>
                    <th>{{ __('manpower.hourly_rate') }}</th>
                    <th>{{ __('manpower.daily_rate') }}</th>
                    <th>{{ __('manpower.monthly_rate') }}</th>
                    <th>{{ __('manpower.status') }}</th>
                    <th>{{ __('manpower.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($manpowers as $manpower)
                    <tr>
                        <td>{{ $manpower->id }}</td>
                        <td>{{ $manpower->name }}</td>
                        <td>{{ $manpower->hourly_rate }}</td>
                        <td>{{ $manpower->daily_rate }}</td>
                        <td>{{ $manpower->monthly_rate }}</td>
                        <td>
                            @if ($manpower->status === 'active')
                                {{ __('manpower.status_active') }}
                            @else
                                {{ __('manpower.status_inactive') }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.manpower.edit', $manpower->id) }}"
                                class="btn btn-sm btn-warning">{{ __('manpower.edit') }}</a>
                            <form action="{{ route('admin.manpower.destroy', $manpower->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('{{ __('manpower.confirm_delete') }}');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">{{ __('manpower.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">{{ __('manpower.no_manpower') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
