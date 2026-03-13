@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h1 class="mb-4">{{ __('machinery.machinery_list') }}</h1>
        <a href="{{ route('admin.machinery.create') }}" class="btn btn-primary mb-3">
            {{ __('machinery.add_machinery') }}
        </a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('machinery.id') }}</th>
                    <th>{{ __('machinery.name') }}</th>
                    <th>{{ __('machinery.model') }}</th>
                    <th>{{ __('machinery.number_plate') }}</th>
                    <th>{{ __('machinery.hourly_rate') }}</th>
                    <th>{{ __('machinery.daily_rate') }}</th>
                    <th>{{ __('machinery.monthly_rate') }}</th>
                    <th>{{ __('machinery.status') }}</th>
                    <th>{{ __('machinery.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($machineries as $machinery)
                    <tr>
                        <td>{{ $machinery->id }}</td>
                        <td>{{ $machinery->name }}</td>
                        <td>{{ $machinery->model ?? '-' }}</td>
                        <td>{{ $machinery->number_plate ?? '-' }}</td>
                        <td>{{ $machinery->hourly_rate }}</td>
                        <td>{{ $machinery->daily_rate }}</td>
                        <td>{{ $machinery->monthly_rate }}</td>
                        <td>
                            @if ($machinery->status === 'active')
                                {{ __('machinery.status_active') }}
                            @else
                                {{ __('machinery.status_inactive') }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.machinery.edit', $machinery->id) }}"
                                class="btn btn-sm btn-warning">{{ __('machinery.edit') }}</a>
                            <form action="{{ route('admin.machinery.destroy', $machinery->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('{{ __('machinery.confirm_delete') }}');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">{{ __('machinery.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">{{ __('machinery.no_machinery') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
