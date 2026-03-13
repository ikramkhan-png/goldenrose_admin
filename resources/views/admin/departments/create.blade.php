@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h2>{{ __('departments.add_department') }}</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.departments.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('departments.name') }}</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('departments.description') }}</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">
                {{ __('departments.add_department') }}
            </button>
            <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">
                {{ __('departments.cancel') }}
            </a>
        </form>

    </div>
@endsection
