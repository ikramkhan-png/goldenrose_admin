@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('departments.edit_department') }}</h4>
            <p class="page-subtitle">{{ __('departments.departments') }}</p>
        </div>
        <a href="{{ route('admin.departments.index') }}" class="btn btn-cancel">
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
                <form action="{{ route('admin.departments.update', $department->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="form-label">{{ __('departments.name') }}</label>
                        <input type="text" name="name" value="{{ old('name', $department->name) }}" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('departments.description') }}</label>
                        <textarea name="description" class="form-control">{{ old('description', $department->description) }}</textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ __('departments.update_department') }}</button>
                        <a href="{{ route('admin.departments.index') }}" class="btn btn-cancel">{{ __('departments.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
