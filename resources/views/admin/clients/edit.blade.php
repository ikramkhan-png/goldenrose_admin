@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('clients.edit_client') }}</h4>
            <p class="page-subtitle">{{ __('clients.clients') }}</p>
        </div>
        <a href="{{ route('admin.clients.index') }}" class="btn btn-cancel">
            <i class="fas fa-arrow-left me-1"></i>{{ __('admin.back') }}
        </a>
    </div>

    @if ($errors->any())
        <div class="p-3 mb-4" style="background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; border-radius: 8px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            <div class="form-card">
                <form action="{{ route('admin.clients.update', $client) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="form-label">{{ __('clients.name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $client->name) }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('clients.email') }}</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('clients.phone') }}</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone) }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('clients.client_type') }}</label>
                        <select name="client_type" class="form-select" required>
                            <option value="">{{ __('clients.select_client_type') }}</option>
                            <option value="service" {{ old('client_type', $client->client_type) == 'service' ? 'selected' : '' }}>
                                {{ __('clients.service_client') }}
                            </option>
                            <option value="project" {{ old('client_type', $client->client_type) == 'project' ? 'selected' : '' }}>
                                {{ __('clients.project_client') }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('clients.new_password_hint') }}</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('clients.confirm_new_password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ __('clients.update_client') }}</button>
                        <a href="{{ route('admin.clients.index') }}" class="btn btn-cancel">{{ __('clients.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
