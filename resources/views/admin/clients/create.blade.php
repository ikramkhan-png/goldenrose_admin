@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h4>{{ __('clients.add_new_client') }}</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.clients.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">{{ __('clients.name') }}</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('clients.email') }}</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('clients.phone') }}</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('clients.client_type') }}</label>
                <select name="client_type" class="form-control" required>
                    <option value="">{{ __('clients.select_client_type') }}</option>
                    <option value="service" {{ old('client_type') == 'service' ? 'selected' : '' }}>
                        {{ __('clients.service_client') }}
                    </option>
                    <option value="project" {{ old('client_type') == 'project' ? 'selected' : '' }}>
                        {{ __('clients.project_client') }}
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('clients.password') }}</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('clients.confirm_password') }}</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button class="btn btn-primary">{{ __('clients.create_client') }}</button>
            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">{{ __('clients.cancel') }}</a>
        </form>
    </div>
@endsection
