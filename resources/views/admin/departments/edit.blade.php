@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h2>{{ __('departments.edit_department') }}</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.departments.update', $department->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">{{ __('departments.name') }}</label>
                <input type="text" name="name" value="{{ old('name', $department->name) }}" class="form-control"
                    required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('departments.description') }}</label>
                <textarea name="description" class="form-control">{{ old('description', $department->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">
                {{ __('departments.update_department') }}
            </button>
            <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">
                {{ __('departments.cancel') }}
            </a>
        </form>

    </div>
@endsection
