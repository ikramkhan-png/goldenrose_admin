@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h2>{{ __('departments.departments') }}</h2>
        <a href="{{ route('admin.departments.create') }}" class="btn btn-success mb-2">
            {{ __('departments.add_department') }}
        </a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <tr>
                <th>{{ __('departments.name') }}</th>
                <th>{{ __('departments.description') }}</th>
                <th>{{ __('departments.actions') }}</th>
            </tr>
            @foreach ($departments as $dep)
                <tr>
                    <td>{{ $dep->name }}</td>
                    <td>{{ $dep->description }}</td>
                    <td>
                        <a href="{{ route('admin.departments.edit', $dep->id) }}"
                            class="btn btn-primary btn-sm">{{ __('departments.edit') }}</a>
                        <form action="{{ route('admin.departments.destroy', $dep->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('{{ __('departments.confirm_delete') }}')">
                                {{ __('departments.delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection
